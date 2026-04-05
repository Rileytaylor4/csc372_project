<?php
/* =========================
Name: Riley C. Taylor
Date: 2026-04-06
File: appointment-details.php
Purpose: Displays one appointment based on the id in the query string.
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

$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = :id");
$stmt->execute([':id' => $id]);
$appointment = $stmt->fetch();

if (!$appointment) {
    die('Appointment not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
</head>
<body>
    <h1>Appointment Details</h1>

    <p><strong>ID:</strong> <?php echo $appointment['id']; ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($appointment['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($appointment['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($appointment['phone']); ?></p>
    <p><strong>Service:</strong> <?php echo htmlspecialchars($appointment['service']); ?></p>
    <p><strong>Car Make:</strong> <?php echo htmlspecialchars($appointment['car_make']); ?></p>
    <p><strong>Car Model:</strong> <?php echo htmlspecialchars($appointment['car_model']); ?></p>
    <p><strong>Message:</strong> <?php echo htmlspecialchars($appointment['message']); ?></p>
    <p><strong>Date Submitted:</strong> <?php echo htmlspecialchars($appointment['appointment_date']); ?></p>
</body>
</html>