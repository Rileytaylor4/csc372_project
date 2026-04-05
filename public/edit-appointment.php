<?php
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

    if (!isset($_GET['id'])) {
        die('No ID provided.');
    }

    $id = $_GET['id'];

    // Handle form submission 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare("
            UPDATE appointments
            SET name = ?, email = ?, service = ?, car_make = ?, car_model = ?, message = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['service'],
            $_POST['car_make'],
            $_POST['car_model'],
            $_POST['message'],
            $id
        ]);

        header("Location: admin-appointment.php");
        exit;
    }

    // Get current data
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->execute([$id]);
    $appt = $stmt->fetch();

    if (!$appt) {
        die('Appointment not found.');
    }

} catch (PDOException $e) {
    die('Database error.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Appointment</title>
</head>
<body>

<h1>Edit Appointment</h1>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($appt['name']); ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($appt['email']); ?>"><br><br>

    <label>Service:</label><br>
    <input type="text" name="service" value="<?php echo htmlspecialchars($appt['service']); ?>"><br><br>

    <label>Car Make:</label><br>
    <input type="text" name="car_make" value="<?php echo htmlspecialchars($appt['car_make']); ?>"><br><br>

    <label>Car Model:</label><br>
    <input type="text" name="car_model" value="<?php echo htmlspecialchars($appt['car_model']); ?>"><br><br>

    <label>Message:</label><br>
    <textarea name="message"><?php echo htmlspecialchars($appt['message']); ?></textarea><br><br>

    <button type="submit">Update Appointment</button>
</form>

</body>
</html>