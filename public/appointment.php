<?php
/* =========================
Name: Riley C. Taylor
Date: 2026-03-25
File: appointment.php
Purpose: Collects and validates appointment requests, then uses cookies and sessions.
========================= */

session_start();
require_once __DIR__ . '/../includes/validation.php';

/* initial values for form controls */
$values = [
    'name' => '',
    'email' => '',
    'car_year' => '',
    'service' => ''
];

/* blank error messages for each control */
$errors = [
    'name' => '',
    'email' => '',
    'car_year' => '',
    'service' => ''
];

/* message shown after submit */
$message = '';

/* process form submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['name'] = trim($_POST['name'] ?? '');
    $values['email'] = trim($_POST['email'] ?? '');
    $values['car_year'] = trim($_POST['car_year'] ?? '');
    $values['service'] = trim($_POST['service'] ?? '');

    $errors = validate_appointment_form($values);

    if (implode('', $errors) === '') {
        $_SESSION['name'] = htmlspecialchars($values['name']);
        $_SESSION['service'] = htmlspecialchars($values['service']);

        setcookie('last_service', $values['service'], time() + (86400 * 7));

        $message = 'Appointment request submitted successfully!';
    } else {
        $message = 'Please fix the errors below.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <style>
        nav ul {
            list-style: none;
            display: flex;
            gap: 10px;
            margin: 0;
            padding: 0;
        }

        nav a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.92);
            padding: 10px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 14px;
            transition: 160ms ease;
        }

        nav a:hover {
            background: rgba(255,255,255,0.06);
        }

        .nav {
            max-width: 1100px;
            margin: 0 auto;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header {
            position: sticky;
            top: 0;
            backdrop-filter: blur(10px);
            background: rgba(0,0,0,0.35);
            border-bottom: 1px solid rgba(255,255,255,0.12);
            z-index: 10;
        }

        .brand-title {
            font-weight: 700;
            font-size: 18px;
        }

        .starfield{
            position: fixed;
            inset: 0;
            z-index: -2;
            background:
                radial-gradient(circle at 5% 10%, rgba(255,255,255,0.9) 0 1px, transparent 1.2px),
                radial-gradient(circle at 15% 30%, rgba(255,255,255,0.85) 0 1px, transparent 1.2px),
                radial-gradient(circle at 25% 80%, rgba(255,255,255,0.85) 0 1px, transparent 1.2px),
                radial-gradient(circle at 35% 60%, rgba(255,255,255,0.8) 0 1px, transparent 1.2px),
                radial-gradient(circle at 50% 40%, rgba(255,255,255,0.75) 0 1px, transparent 1.2px),
                radial-gradient(circle at 60% 20%, rgba(255,255,255,0.85) 0 1px, transparent 1.2px),
                radial-gradient(circle at 70% 15%, rgba(255,255,255,0.85) 0 1px, transparent 1.2px),
                radial-gradient(circle at 80% 75%, rgba(255,255,255,0.75) 0 1px, transparent 1.2px),
                radial-gradient(circle at 85% 65%, rgba(255,255,255,0.75) 0 1px, transparent 1.2px),
                radial-gradient(circle at 95% 45%, rgba(255,255,255,0.7) 0 1px, transparent 1.2px),
                radial-gradient(circle at 10% 55%, rgba(255,255,255,0.7) 0 1px, transparent 1.2px),
                radial-gradient(circle at 20% 90%, rgba(255,255,255,0.6) 0 1px, transparent 1.2px),
                radial-gradient(circle at 40% 10%, rgba(255,255,255,0.6) 0 1px, transparent 1.2px),
                radial-gradient(circle at 55% 85%, rgba(255,255,255,0.6) 0 1px, transparent 1.2px),
                radial-gradient(circle at 75% 50%, rgba(255,255,255,0.6) 0 1px, transparent 1.2px),
                radial-gradient(circle at 90% 30%, rgba(255,255,255,0.65) 0 1px, transparent 1.2px),
                linear-gradient(180deg, #050506 0%, #0b0b10 60%, #070708 100%);
        }

        .starfield::before{
            content:"";
            position: absolute;
            inset: -40px;
            background-image:
                radial-gradient(circle, rgba(255,255,255,0.7) 0 1px, transparent 1.2px),
                radial-gradient(circle, rgba(255,255,255,0.5) 0 1px, transparent 1.2px),
                radial-gradient(circle, rgba(255,255,255,0.35) 0 1px, transparent 1.2px),
                radial-gradient(circle, rgba(255,255,255,0.25) 0 1px, transparent 1.2px),
                radial-gradient(circle, rgba(255,255,255,0.15) 0 1px, transparent 1.2px);
            background-size:
                80px 80px,
                120px 120px,
                180px 180px,
                260px 260px,
                360px 360px;
            background-position:
                0 0,
                40px 60px,
                100px 120px,
                180px 200px,
                260px 300px;
            opacity: 0.85;
            animation: drift 18s linear infinite;
        }

        .starfield::after{
            content:"";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 20%, transparent 0%, rgba(0,0,0,0.55) 70%, rgba(0,0,0,0.8) 100%);
        }

        @keyframes drift{
            from { transform: translate3d(0,0,0); }
            to { transform: translate3d(-80px, -60px, 0); }
        }

        .wrap {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 80px 18px 60px;
            display: flex;
            justify-content: center;
        }

        .hero {
            max-width: 820px;
            width: 100%;
            padding: 26px 24px;
            border-radius: 18px;
            background: rgba(16, 16, 20, 0.62);
            border: 1px solid rgba(255,255,255,0.12);
            box-shadow: 0 12px 40px rgba(0,0,0,0.35);
            color: #f4f4f6;
        }

        .hero h1 {
            font-size: clamp(34px, 4vw, 56px);
            margin-bottom: 18px;
            font-weight: 700;
        }

        .hero form div {
            margin-bottom: 18px;
        }

        .hero label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .hero input,
        .hero select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.06);
            color: #f4f4f6;
            font-family: "Recoleta", ui-serif, Georgia, "Times New Roman", Times, serif;
            font-size: 15px;
        }

        .hero select option {
            background: #1a1a22;
            color: #f4f4f6;
        }

        .hero button {
            padding: 12px 18px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #f4f4f6;
            font-family: "Recoleta", ui-serif, Georgia, "Times New Roman", Times, serif;
            font-weight: 700;
            cursor: pointer;
        }

        .hero button:hover {
            background: rgba(255, 255, 255, 0.14);
        }

        footer {
            text-align: center;
            padding: 18px;
            font-size: 13px;
            color: rgba(244,244,246,0.65);
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Request | Forge & Fender Mobile Auto Works</title>
</head>
<body>
    <div class="starfield"></div>

    <div class="wrap">
        <header>
            <div class="nav">
                <div class="brand-title">Forge &amp; Fender Mobile Auto Works</div>
                <nav>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="appointment.php">Schedule Appointment</a></li>
                        <li><a href="./services.php">Services</a></li>
                        <li><a href="vin-checker.html">Recall Checker</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <div class="hero">
                <h1>Schedule an Appointment</h1>

                <?php if ($message !== ''): ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>

                <?php if (!empty($_SESSION['name'])): ?>
                    <p>Welcome back, <?php echo $_SESSION['name']; ?>.</p>
                <?php endif; ?>

                <?php if (!empty($_COOKIE['last_service'])): ?>
                    <p>Last requested service: <?php echo htmlspecialchars($_COOKIE['last_service']); ?></p>
                <?php endif; ?>

                <form method="POST" action="">
                    <div>
                        <label for="name">Name:</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?php echo htmlspecialchars($values['name']); ?>"
                        >
                        <?php if (!empty($errors['name'])): ?>
                            <p><?php echo $errors['name']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="email">Email:</label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($values['email']); ?>"
                        >
                        <?php if (!empty($errors['email'])): ?>
                            <p><?php echo $errors['email']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="car_year">Car Year:</label>
                        <input
                            type="number"
                            id="car_year"
                            name="car_year"
                            value="<?php echo htmlspecialchars($values['car_year']); ?>"
                        >
                        <?php if (!empty($errors['car_year'])): ?>
                            <p><?php echo $errors['car_year']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="service">Service Needed:</label>
                        <select id="service" name="service">
                            <option value="">-- Select a Service --</option>
                            <option value="Oil Change" <?php echo ($values['service'] === 'Oil Change') ? 'selected' : ''; ?>>Oil Change</option>
                            <option value="Brake Service" <?php echo ($values['service'] === 'Brake Service') ? 'selected' : ''; ?>>Brake Service</option>
                            <option value="Tune-Up" <?php echo ($values['service'] === 'Tune-Up') ? 'selected' : ''; ?>>Tune-Up</option>
                            <option value="Detailing" <?php echo ($values['service'] === 'Detailing') ? 'selected' : ''; ?>>Detailing</option>
                        </select>
                        <?php if (!empty($errors['service'])): ?>
                            <p><?php echo $errors['service']; ?></p>
                        <?php endif; ?>
                    </div>

                    <button type="submit">Submit Request</button>
                </form>

                <br>

                <form method="POST" action="logout.php">
                    <button type="submit">End Session</button>
                </form>
            </div>
        </main>

        <footer>
            © <span id="year"></span> Forge &amp; Fender Mobile Auto Works
        </footer>
    </div>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>
</html>