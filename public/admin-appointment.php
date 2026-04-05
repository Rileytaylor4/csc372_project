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

    $stmt = $pdo->query("SELECT * FROM appointments ORDER BY id DESC");
    $appointments = $stmt->fetchAll();

} catch (PDOException $e) {
    die('Database connection failed.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Appointments</title>
</head>
<body>

<h1>All Appointments</h1>

<?php if (empty($appointments)): ?>
    <p>No appointments found.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Service</th>
            <th>Make</th>
            <th>Model</th>
            <th>Message</th>
            <th>Date Submitted</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($appointments as $appt): ?>
            <tr>
                <td>
                    <a href="appointment-details.php?id=<?php echo $appt['id']; ?>">
                        <?php echo $appt['id']; ?>
                    </a>
                </td>
                <td><?php echo htmlspecialchars($appt['name']); ?></td>
                <td><?php echo htmlspecialchars($appt['email']); ?></td>
                <td><?php echo htmlspecialchars($appt['service']); ?></td>
                <td><?php echo htmlspecialchars($appt['car_make']); ?></td>
                <td><?php echo htmlspecialchars($appt['car_model']); ?></td>
                <td><?php echo htmlspecialchars($appt['message']); ?></td>
                <td><?php echo $appt['appointment_date']; ?></td>
                <td>
                    <a href="edit-appointment.php?id=<?php echo $appt['id']; ?>">Edit</a>
                    |
                    <a href="delete-appointment.php?id=<?php echo $appt['id']; ?>">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>