<?php
// check_status.php

// Set content type to JSON
header('Content-Type: application/json');

// Connect to the database (replace with your actual credentials)
$host = 'localhost';
$dbname = 'items';
$username = 'root';
$password = ''; // Replace with your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data and sanitize
    $maticId = trim($_POST['maticId'] ?? '');
    $trackingId = trim($_POST['trackingId'] ?? '');
    $session = trim($_POST['session'] ?? '');
    $batch = trim($_POST['batch'] ?? '');

    // Validate all required fields
    if (empty($maticId) || empty($trackingId) || empty($session) || empty($batch)) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields are required.']);
        exit;
    }

    try {
        // Prepare and execute query with all four parameters
        $query = "SELECT status FROM loanapproval WHERE matric = :maticId AND trackingID = :trackingId AND session = :session AND batch = :batch";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'maticId' => $maticId,
            'trackingId' => $trackingId,
            'session' => $session,
            'batch' => $batch
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a record was found
        if ($result) {
            $status = strtolower(trim($result['status']));
            
            // Validate status values
            if (in_array($status, ['approved', 'rejected', 'pending'])) {
                http_response_code(200);
                echo json_encode(['status' => $status]);
            } else {
                // Handle unexpected status values
                http_response_code(200);
                echo json_encode(['status' => 'pending']); // Default to pending for unknown status
            }
        } else {
            // No record found
            http_response_code(404);
            echo json_encode(['error' => 'No record found with the provided details.']);
        }
        
    } catch (PDOException $e) {
        // Database query error
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
    }
    
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use POST request.']);
}
?>