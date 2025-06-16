<?php
namespace App\Database;

use mysqli;

class Database
{
    private mysqli $conn;
    private array $result = [];

    public function __construct(string $host, string $username, string $password, string $database)
    {
        $this->conn = new mysqli($host, $username, $password, $database);
        if ($this->conn->connect_error) {
            throw new \RuntimeException('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function displayMessage(string $message, string $icon, ?string $location = null): void
    {
        $_SESSION['message'] = $message;
        $_SESSION['icon'] = $icon;
        $_SESSION['status'] = true;
        if ($location !== null) {
            header('Location: ' . $location);
            exit;
        }
    }

    public function insert(string $table, array $data, ?string $location = null, ?string $custom = null): bool|string
    {
        $columns = implode(',', array_keys($data));
        $placeholders = rtrim(str_repeat('?,', count($data)), ',');
        $sql = $custom === null
            ? "INSERT INTO `$table`($columns) VALUES($placeholders)"
            : "INSERT INTO $table ($columns) VALUES ($placeholders) $custom";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return 'Error preparing statement: ' . $this->conn->error;
        }
        $types = $this->getTypes($data);
        $stmt->bind_param($types, ...array_values($data));
        $result = $stmt->execute();
        if ($result) {
            if ($location !== null) {
                header('location: ' . $location);
            }
            $this->result[] = $this->conn->insert_id;
            return true;
        }
        return 'Error executing statement: ' . $stmt->error;
    }

    public function select(string $table, string $columns = '*', ?string $join = null, ?string $where = null, array $params = [], ?string $order = null, ?int $limit = null, ?string $alias = null): array|string
    {
        $sql = "SELECT $columns FROM `$table`";
        if ($alias !== null) {
            $sql .= ' AS ' . $alias;
        }
        if ($join !== null) {
            $sql .= ' ' . $join;
        }
        if ($where !== null) {
            $sql .= ' WHERE ' . $where;
        }
        if ($order !== null) {
            $sql .= ' ORDER BY ' . $order;
        }
        if ($limit !== null) {
            $page = $_GET['page'] ?? 1;
            $start = ($page - 1) * $limit;
            $sql .= ' LIMIT ' . $start . ',' . $limit;
        }
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return 'Error  Preparing SQL: ' . $this->conn->error;
        }
        if (!empty($params)) {
            $types = $this->getTypes($params);
            $stmt->bind_param($types, ...array_values($params));
        }
        if (!$stmt->execute()) {
            return 'Error Executing Query: ' . $stmt->error;
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
        }
        return 'No record Found!';
    }

    public function update(string $table, array $data, string $condition, array $conditionValues = []): bool|string
    {
        $updatecolumn = array_map(fn($k) => "`$k`= ?", array_keys($data));
        $sql = "UPDATE `$table` SET " . implode(',', $updatecolumn) . " WHERE $condition";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return 'Error preparing statement: ' . $this->conn->error;
        }
        $types = $this->getTypes($data);
        $values = array_values($data);
        foreach ($conditionValues as $value) {
            $types .= $this->getType($value);
            $values[] = $value;
        }
        $stmt->bind_param($types, ...$values);
        if ($stmt->execute()) {
            return $stmt->affected_rows === 0 ? 'No rows affected.' : true;
        }
        return 'Error executing query: ' . $stmt->error;
    }

    public function delete(string $table, string $condition, array $params = [], ?string $location = null): bool|string
    {
        $sql = "DELETE FROM `$table` WHERE $condition";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return 'Error preparing statement: ' . $this->conn->error;
        }
        if (!empty($params)) {
            $types = $this->getTypes($params);
            $stmt->bind_param($types, ...array_values($params));
        }
        if ($stmt->execute()) {
            if ($location !== null) {
                header('Location: ' . $location);
            }
            return true;
        }
        return 'Error executing statement: ' . $stmt->error;
    }

    public function updatePrepare(string $table, array $data, string $condition, array $conditionValues = []): bool|string
    {
        $updatecolumn = array_map(fn($k) => "`$k`= ?", array_keys($data));
        $sql = "UPDATE `$table` SET " . implode(',', $updatecolumn) . " WHERE $condition";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return 'Error preparing statement: ' . $this->conn->error;
        }
        $types = $this->getTypes($data);
        $values = array_values($data);
        foreach ($conditionValues as $value) {
            $types .= $this->getType($value);
            $values[] = $value;
        }
        $stmt->bind_param($types, ...$values);
        if ($stmt->execute()) {
            return $stmt->affected_rows === 0 ? 'No rows affected.' : true;
        }
        return 'Error executing query: ' . $stmt->error;
    }

    public function uploadImages(array $file, string $uploadDirectory, int $maxFileSize = 5242880, int $maxUploads = 1): array|string
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return 'Error: No file uploaded.';
        }
        if (is_array($file['tmp_name'])) {
            return 'Error: Only one file can be uploaded.';
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'Error: File upload error.';
        }
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes, true)) {
            return 'Error: Only JPG, PNG, and GIF files are allowed.';
        }
        if ($file['size'] > $maxFileSize) {
            return 'Error: File size exceeds the limit';
        }
        $originalFileName = $file['name'];
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $uniqueIdentifier = uniqid();
        $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $uniqueIdentifier . '.' . $fileExtension;
        if (move_uploaded_file($file['tmp_name'], $uploadDirectory . $newFileName)) {
            return ['newfileName' => $newFileName];
        }
        return 'Error: Failed to move uploaded file.';
    }

    public function validateMissing(array $data, array $required_fields): ?string
    {
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return "Missing Required Field: $field";
            }
        }
        return null;
    }

    public function validateFields(array $data): ?string
    {
        if (strlen($data['username']) > 15) {
            return 'Username must be less than 15 characters';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Invalid Email';
        }
        return null;
    }

    public function anonymizeEmail(string $email): string
    {
        [$username, $domain] = explode('@', $email);
        $usernameLength = strlen($username);
        if ($usernameLength < 3) {
            return $email;
        }
        $anonymizedUsername = $username[0] . str_repeat('*', $usernameLength - 2) . $username[$usernameLength - 1];
        return $anonymizedUsername . '@' . $domain;
    }

    public function lastInsertId(): int
    {
        return $this->conn->insert_id;
    }

    public function getResult(): array
    {
        $val = $this->result;
        $this->result = [];
        return $val;
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    private function getTypes(array $values): string
    {
        $types = '';
        foreach ($values as $value) {
            $types .= $this->getType($value);
        }
        return $types;
    }

    private function getType($value): string
    {
        return match (true) {
            is_int($value) => 'i',
            is_float($value) => 'd',
            is_string($value) => 's',
            default => 's',
        };
    }
}
