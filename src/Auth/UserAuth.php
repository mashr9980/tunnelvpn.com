<?php
namespace App\Auth;

use App\Database\Database;

class UserAuth
{
    private Database $crud;

    public function __construct(?Database $crud = null)
    {
        $this->crud = $crud ?? new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function userRegister(array $data): bool|string
    {
        if ($error = $this->validateData($data)) {
            return $error;
        }
        $existingname = $this->crud->select('users', 'user_id', null, 'username = ?', [$data['username']]);
        if (is_array($existingname) && !empty($existingname['user_id'])) {
            return 'Username already exists';
        }
        $existinguser = $this->crud->select('users', 'user_id', null, 'email = ?', [$data['email']]);
        if (is_array($existinguser) && !empty($existinguser['user_id'])) {
            return 'Email already exists';
        }
        $passwordhash = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['password'] = $passwordhash;
        $data['registration_date'] = date('Y-m-d H:i:s');
        $data['is_verified'] = true;
        $data['verification_token'] = bin2hex(random_bytes(16));
        $saveuser = $this->crud->insert('users', $data);
        if ($saveuser === true) {
            $purchaseData = [
                'user_id' => $this->crud->lastInsertId(),
                'status' => 'true',
                'expiry_date' => date('Y-m-d H:i:s', strtotime('+1 month'))
            ];
            return $this->crud->insert('purchases', $purchaseData) === true
                ? true
                : 'Error: Adding a Free Trial But User Registered Successfully.';
        }
        return $saveuser;
    }

    public function userLogin(array $data, bool $remember = false, bool $Logintoken = false, bool $is_admin = false)
    {
        if ($error = $this->validateData($data, true)) {
            return $error;
        }
        if ($is_admin) {
            if ($data['username'] !== 'admin') {
                return 'Unauthorized Username';
            }
            $checkuser = $this->crud->select('users', 'user_id, password, is_verified', null, 'username = ? OR  email = ?', ['admin', 'admin@gmail.com']);
        } else {
            $checkuser = $this->crud->select('users', 'user_id, password, is_verified', null, 'Username = ? OR  email = ?', [$data['username'], $data['username']]);
        }
        if (is_array($checkuser) && !empty($checkuser['user_id'])) {
            if (password_verify($data['password'], $checkuser['password'])) {
                $user_id = $checkuser['user_id'];
                $last_login = date('Y-m-d H:i:s');
                $this->crud->update('users', ['last_login' => $last_login], "`user_id`=$user_id");
                if ($remember) {
                    $token = bin2hex(random_bytes(6));
                    if ($this->crud->update('users', ['remember_token' => $token], "`user_id`=$user_id")) {
                        if ($Logintoken) {
                            return ['user_id' => $user_id, 'token' => $token];
                        }
                        setcookie('remember_token', $token, time() + (10 * 24 * 60 * 60), '/', '', false, true);
                        return $checkuser['user_id'];
                    }
                    return 'Failed to set remember token';
                }
                return $checkuser['user_id'];
            }
            return 'Incorrect Password';
        }
        return $is_admin ? 'User not Found' : 'User Does not Found';
    }

    public function validateData(array $data, bool $is_login = false): ?string
    {
        $required_fields = $is_login ? ['username', 'password'] : ['username', 'email', 'password'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return "Missing Required Field: $field";
            }
        }
        if (!$is_login) {
            if (strlen($data['username']) > 15) {
                return 'Username must be less than 15 characters';
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return 'Invalid Email';
            }
            if (strlen($data['password']) < 8) {
                return 'Password must be greater than 8 characters';
            }
        }
        return null;
    }
}
