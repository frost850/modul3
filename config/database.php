<?php
$host = '127.0.0.1';
$dbname = 'donation_system';
$username = 'root';
$password = ''; // default Laragon tidak pakai password

try {
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    // Untuk debugging sementara:
    // echo json_encode(['error' => $e->getMessage()]);
    exit;
}
