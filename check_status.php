<?php
// check_status.php

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
    echo "Database connection failed: " . $e->getMessage();
    die("Connection failed");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data and sanitize
    $maticId = trim($_POST['maticId'] ?? '');
    $trackingId = trim($_POST['trackingId'] ?? '');

    if (empty($maticId) || empty($trackingId)) {
        echo "Both fields are required.";
        exit;
    }

    // Prepare and execute query
    $query = "SELECT status FROM loanapproval WHERE matric = :maticId AND trackingID = :trackingId";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['maticId' => $maticId, 'trackingId' => $trackingId]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $status = null;
    // Check if a record was found
    if ($result) {
        // $status = strtolower($result['status']);
        if ($result['status'] == 'approved') {
            $status = 'approved';
        } elseif ($result['status'] == 'rejected') {
            $status = 'rejected';
        } else {
            $status = 'not found';
        }

    } else {
        http_response_code(404);
        echo "error fetching data";
        exit;
    }

    if ($status) {
        http_response_code(200);
        echo json_encode(['status' => $status]);
    }
}
?>