<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include database connection
include_once 'config.php';

// Function to log messages
function logMessage($message) {
    $logFile = 'data_usage_api.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate input
    if (!isset($data['user_id']) || !isset($data['data_used'])) {
        logMessage("Error: Missing required fields - " . json_encode($data));
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    $user_id = $data['user_id'];
    $data_used = floatval($data['data_used']); // MB used in the last 60 seconds

    logMessage("Received request - User ID: $user_id, Data Used: $data_used MB");

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        logMessage("Database connection failed: " . $conn->connect_error);
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit;
    }

    logMessage("Database connection successful");

    // Start transaction
    $conn->begin_transaction();

    try {
        // Get current total usage and last reset date
        $stmt = $conn->prepare("SELECT total_data_usage, last_reset_date FROM users WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            throw new Exception("User not found for ID: $user_id");
        }

        logMessage("User data retrieved - Total Usage: {$user['total_data_usage']}, Last Reset: {$user['last_reset_date']}");

        $current_usage = floatval($user['total_data_usage']);
        $last_reset_date = new DateTime($user['last_reset_date']);
        $current_date = new DateTime();

        // Check if a month has passed since the last reset
        if ($last_reset_date->format('Y-m') != $current_date->format('Y-m')) {
            $current_usage = 0;
            $last_reset_date = $current_date;
            logMessage("Monthly data usage reset for user $user_id");
        }

        $new_total_usage = $current_usage + $data_used;

        // Check if new total exceeds 10 GB (10240 MB)
        if ($new_total_usage > 10240) {
            $new_total_usage = 10240; // Cap at 10 GB
            $message = "Monthly data limit exceeded";
        } else {
            $message = "Data usage updated successfully";
        }

        logMessage("New total usage calculated: $new_total_usage MB");

        // Update the total_data_usage and last_reset_date
        $stmt = $conn->prepare("UPDATE users SET total_data_usage = ?, last_reset_date = ? WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed for update: " . $conn->error);
        }
        $last_reset_date_str = $last_reset_date->format('Y-m-d H:i:s');
        $stmt->bind_param("dsi", $new_total_usage, $last_reset_date_str, $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed for update: " . $stmt->error);
        }

        if ($stmt->affected_rows === 0) {
            // This might not be an error if the new values are the same as the old ones
            logMessage("No rows affected. This might be normal if values didn't change.");
        }

        // Commit transaction
        $conn->commit();

        logMessage("Data usage updated for user $user_id: $new_total_usage MB");
        echo json_encode([
            'status' => 'success', 
            'message' => $message,
            'total_usage' => $new_total_usage,
            'last_reset_date' => $last_reset_date_str
        ]);

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        logMessage("Error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    // Close connection
    $conn->close();
    logMessage("Database connection closed");

} else {
    logMessage("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}