<?php
/* =========================
Name: Riley C. Taylor
Date: 2026-04-06
File: delete-appointment.php
Purpose: Deletes one appointment based on the id in the query string.
========================= */

$host = 'localhost';
$dbname = 'forge_fender_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die('Database connection failed.');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die('Invalid appointment ID.');
}

$stmt = $pdo->prepare("DELETE FROM appointments WHERE id = :id");
$stmt->execute([':id' => $id]);

header('Location: admin-appointment.php');
exit;