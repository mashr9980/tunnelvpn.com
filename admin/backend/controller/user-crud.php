<?php
include_once 'config.php';
require_once '../mail/mailer.php';

$crud = new Prepare_crud(DB_HOST, DB_USER, DB_PASS, DB_NAME);

class userAuth
{
    public $crud;

    public function __construct()
    {
        $this->crud = new Prepare_crud(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function userRegister($data)
    {
        $errors = $this->validateData($data);
        if (!empty($errors)) {
            return $errors;
        }

        $existingname = $this->crud->select('users', 'user_id', null, "username = ?", array($data['username']));
        if (is_array($existingname) && !empty($existingname['user_id'])) {
            return "Username already exists";
        }
        $existinguser = $this->crud->select('users', 'user_id', null, "email = ?", array($data['email']));
        if (is_array($existinguser) && !empty($existinguser['user_id'])) {
            return "Email already exists";
        }

        $passwordhash = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['password']);
        $data['password'] = $passwordhash;
        $data['registration_date'] = date('Y-m-d H:i:s');
        $data['is_verified'] = true;
        $data['verification_token'] = bin2hex(random_bytes(16));

        $saveuser = $this->crud->insert('users', $data);
        if ($saveuser) {
            // Add a record in the purchases table
            $purchaseData = array(
                'user_id' => $this->crud->lastInsertId(),
                'status' => "true",
                'expiry_date' => date('Y-m-d H:i:s', strtotime('+1 month'))
            );
            if ($this->crud->insert('purchases', $purchaseData)) {
                return true;
            } else {
                return 'Error: Adding a Free Trial But User Registered Successfully.';
            }
        } else {
            return $saveuser;
        }
    }

    public function userLogin($data, $remember = false, $Logintoken = false, $is_admin = false)
    {
        $errors = $this->validateData($data, true);
        if (!empty($errors)) {
            return $errors;
        }

        if ($is_admin == true) {
            if ($data['username'] != 'admin') {
                return "Unauthorized Username";
            }
            $checkuser = $this->crud->select('users', 'user_id, password, is_verified', null, "username = ? OR  email = ?", array('admin', 'admin@gmail.com'));
        } else {
            $checkuser = $this->crud->select('users', 'user_id, password, is_verified', null, "Username = ? OR  email = ?", array($data['username'], $data['username']));
        }

        if (is_array($checkuser) && !empty($checkuser['user_id'])) {
            if (password_verify($data['password'], $checkuser['password'])) {
                // last login
                $user_id = $checkuser['user_id'];
                $last_login = date('Y-m-d H:i:s');
                $updateLogin = $this->crud->update('users', array("last_login" => $last_login), "`user_id`=$user_id");

                if ($remember == true) {
                    $token = bin2hex(random_bytes(6));
                    $updatetoken = $this->crud->update('users', array("remember_token" => $token), "`user_id`=$user_id");
                    if ($updatetoken) {
                        if ($Logintoken) {
                            return array(
                                'user_id' => $user_id,
                                'token' => $token
                            );
                        } else {
                            setcookie('remember_token', $token, time() + (10 * 24 * 60 * 60), '/', '', false, true);
                            return $checkuser['user_id'];
                        }
                    } else {
                        return "Failed to set remember token";
                    }
                } else {
                    return $checkuser['user_id'];
                }
            } else {
                return "Incorrect Password";
            }
        } else {
            return "User not Found";
        }
    }

    public function validateData($data, $is_login = false)
    {
        $required_fields = $is_login ? array('username', 'password') : array('username', 'email', 'password');

        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return "Missing Required Field: $field";
            }
        }

        if (!$is_login) {
            if (strlen($data['username']) > 15) {
                return "Username must be less than 15 characters";
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return 'Invalid Email';
            }

            if (strlen($data['password']) < 8) {
                return "Password must be greater than 8 characters";
            }
        }
    }
}
