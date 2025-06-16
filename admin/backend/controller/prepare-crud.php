<?php
class Prepare_crud
{
    private $conn;
    private $result = array();

    public function __construct($host, $username, $password, $database)
    {
        // Establish database connection
        $this->conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function displayMessage($message, $icon, $location = null)
    {
        // session_start();
        $_SESSION['message'] = $message;
        $_SESSION['icon'] = $icon;
        $_SESSION['status'] = true;
        if ($location != null) {
            header("Location: $location");
        }
    }

    public function validateData($data, $is_login = false, $required_fields = array())
    {
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

    public function insert($tablename, $data, $location = null, $custom = null)
    {
        $columns = implode(",", array_keys($data));
        $placeholders = rtrim(str_repeat('?,', count($data)), ',');
        if ($custom != null) {
            $sql = "INSERT INTO $tablename ($columns) VALUES ($placeholders) $custom";
        } else {
            $sql = "INSERT INTO `$tablename`($columns) VALUES($placeholders)";
        }
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return 'Error preparing statement: ' . $this->conn->error;
        }
        $types = '';
        $values = array_values($data);
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i'; // Integer
            } elseif (is_float($value)) {
                $types .= 'd'; // Double
            } elseif (is_string($value)) {
                $types .= 's'; // String
            } else {
                $types .= 's'; // Default to string
            }
        }
        $stmt->bind_param($types, ...$values);
        $query = $stmt->execute();
        if ($query) {
            if ($location != null) {
                header('location: ' . $location);
            }
            array_push($this->result, $this->conn->insert_id);
            return true;
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }

    public function select($tablename, $columns = '*', $join = null, $where = null, $params = array(), $order = null, $limit = null, $alias = null)
    {
        $sql = "SELECT $columns FROM `$tablename`";
        if ($alias != null) {
            $sql .= " AS " . $alias;
        }
        if ($join != null) {
            $sql .= " " . $join;
        }
        if ($where != null) {
            $sql .= " WHERE " . $where;
        }
        if ($order != null) {
            $sql .= ' ORDER BY ' . $order;
        }
        if ($limit != null) {
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
            } else {
                $page = 1;
            }
            $start = ($page - 1) * $limit;

            $sql .= ' LIMIT ' . $start . ',' . $limit;
        }

        // return $sql;
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return 'Error  Preparing SQL: ' . $this->conn->error;
        }

        if (!empty($params)) {
            // Determine the types of parameters
            $types = '';
            $values = array_values($params);
            foreach ($values as $value) {
                if (is_int($value)) {
                    $types .= 'i'; // Integer
                } elseif (is_float($value)) {
                    $types .= 'd'; // Double
                } elseif (is_string($value)) {
                    $types .= 's'; // String
                } else {
                    $types .= 's'; // Default to string
                }
            }
            // Bind parameters to the prepared statement
            $stmt->bind_param($types, ...$values);
        }

        $query = $stmt->execute();
        if ($query === false) {
            return  'Error Executing Query: ' . $stmt->error;
        }
        $results = $stmt->get_result();
        if ($results->num_rows > 0) {
            if ($results->num_rows > 1) {
                while ($row = $results->fetch_assoc()) {
                    $records[] = $row;
                }
            } else {
                $records = $results->fetch_assoc();
            }
            return $records;
        } else {
            return  'No record Found!';
        }
    }

    public function update($tablename, $data, $condition, $location = null)
    {
        $updatecolumn = array();
        foreach ($data as $key => $value) {
            $updatecolumn[] = "`$key`= ?";
        }
        $updatecolstring = implode(",", $updatecolumn);
        $sql = "UPDATE `$tablename` SET $updatecolstring WHERE $condition";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return "Error preparing statement: " . $this->conn->error;
        }
        $types = '';
        $values = array_values($data);
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i'; // Integer
            } elseif (is_float($value)) {
                $types .= 'd'; // Double
            } elseif (is_string($value)) {
                $types .= 's'; // String
            } else {
                $types .= 's'; // Default to string
            }
        }
        $stmt->bind_param($types, ...$values);
        $result = $stmt->execute();
        if ($result) {
            if ($stmt->affected_rows === 0) {
                return 'No rows affected.';
            } else {
                return true;
            }
        } else {
            return "Error executing query: " . $stmt->error;
        }
    }

    public function delete($tablename, $condition, $params = array(), $location = null)
    {
        $sql = "DELETE FROM `$tablename` WHERE $condition";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return "Error preparing statement: " . $this->conn->error;
        }
        if (!empty($params)) {
            // Determine the types of parameters
            $types = '';
            $values = array_values($params);
            foreach ($values as $value) {
                if (is_int($value)) {
                    $types .= 'i'; // Integer
                } elseif (is_float($value)) {
                    $types .= 'd'; // Double
                } elseif (is_string($value)) {
                    $types .= 's'; // String
                } else {
                    $types .= 's'; // Default to string
                }
            }
            // Bind parameters to the prepared statement
            $stmt->bind_param($types, ...$values);
        }
        $query = $stmt->execute();
        if ($query) {
            if ($location != null) {
                header("Location: " . $location);
            }
            return true;
        } else {
            return "Error executing statement: " . $stmt->error;
        }
    }

    function uploadImages($file, $uploadDirectory, $maxFileSize = 5242880 /* 5MB */, $maxUploads = 1)
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return "Error: No file uploaded.";
        }

        // Check if multiple files are uploaded
        if (is_array($file['tmp_name'])) {
            return "Error: Only one file can be uploaded.";
        }

        // Check if file is uploaded without errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return "Error: File upload error.";
        }

        // Check if file type is allowed
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return "Error: Only JPG, PNG, and GIF files are allowed.";
        }

        // Check if file size exceeds the limit
        if ($file['size'] > $maxFileSize) {
            return "Error: File size exceeds the limit";
        }

        // Generate unique file name with original file name
        $originalFileName = $file['name'];
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $uniqueIdentifier = uniqid();
        $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $uniqueIdentifier . '.' . $fileExtension;

        // Move uploaded file to destination directory
        if (move_uploaded_file($file['tmp_name'], $uploadDirectory . $newFileName)) {
            return array("newfileName" => $newFileName); // Return the uploaded file name on success
        } else {
            return "Error: Failed to move uploaded file.";
        }
    }

    public function validateMissing($data, $required_fields)
    {
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return "Missing Required Field: $field";
            }
        }
    }

    public function validateFields($data)
    {
        if (strlen($data['username']) > 15) {
            return "Username must be less than 15 characters";
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Invalid Email';
        }
    }

    public function anonymizeEmail($email)
    {
        // Split the email into username and domain
        list($username, $domain) = explode('@', $email);

        // Determine the length of the username
        $usernameLength = strlen($username);

        // If the username is less than 3 characters, don't anonymize
        if ($usernameLength < 3) {
            return $email;
        }

        // Create the anonymized username
        $anonymizedUsername = $username[0] . str_repeat('*', $usernameLength - 2) . $username[$usernameLength - 1];

        // Return the anonymized email
        return $anonymizedUsername . '@' . $domain;
    }

    public function lastInsertId()
    {
        return $this->conn->insert_id;
    }

    public function getResult()
    {
        $val = $this->result;
        $this->result = array();
        return $val;
    }
    public function __destruct()
    {
        $this->conn->close();
    }
}
