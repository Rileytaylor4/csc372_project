<?php
/* =========================
Name: Riley C. Taylor
Date: 2026-03-25
File: appointment.php
Purpose: Collects and validates appointment requests, then uses cookies and sessions.
========================= */

session_start();
require_once __DIR__ . '/../includes/validation.php';

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

/* initial values for form controls */
$values = [
    'name' => '',
    'email' => '',
    'car_year' => '',
    'car_make' => '',
    'car_model' => '',
    'service' => '',
    'message' => ''
];

/* blank error messages for each control */
$errors = [
    'name' => '',
    'email' => '',
    'car_year' => '',
    'car_make' => '',
    'car_model' => '',
    'service' => ''
];

/* message shown after submit */
$message = '';

/* process form submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['name'] = trim($_POST['name'] ?? '');
    $values['email'] = trim($_POST['email'] ?? '');
    $values['car_year'] = trim($_POST['car_year'] ?? '');
    $values['car_make'] = trim($_POST['car_make'] ?? '');
    $values['car_model'] = trim($_POST['car_model'] ?? '');
    $values['service'] = trim($_POST['service'] ?? '');
    $values['message'] = trim($_POST['message'] ?? '');

    $errors = validate_appointment_form($values);

    if ($values['car_make'] === '') {
        $errors['car_make'] = 'Please enter your car make.';
    }

    if ($values['car_model'] === '') {
        $errors['car_model'] = 'Please enter your car model.';
    }

    if (implode('', $errors) === '') {
        $sql = "INSERT INTO appointments (name, email, phone, service, appointment_date, message, car_make, car_model)
                VALUES (:name, :email, :phone, :service, :appointment_date, :message, :car_make, :car_model)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $values['name'],
            ':email' => $values['email'],
            ':phone' => 'Not Provided',
            ':service' => $values['service'],
            ':appointment_date' => date('Y-m-d'),
            ':message' => $values['message'] . ' (Car Year: ' . $values['car_year'] . ')',
            ':car_make' => $values['car_make'],
            ':car_model' => $values['car_model']
        ]);

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
                radial-gradient(circle at 7% 12%, rgba(255,255,255,0.95) 0 1.2px, transparent 1.3px),
                radial-gradient(circle at 13% 41%, rgba(255,255,255,0.72) 0 0.9px, transparent 1px),
                radial-gradient(circle at 21% 27%, rgba(255,255,255,0.82) 0 1px, transparent 1.1px),
                radial-gradient(circle at 29% 78%, rgba(255,255,255,0.62) 0 0.8px, transparent 0.95px),
                radial-gradient(circle at 34% 19%, rgba(255,255,255,0.88) 0 1.1px, transparent 1.2px),
                radial-gradient(circle at 43% 63%, rgba(255,255,255,0.52) 0 0.75px, transparent 0.9px),
                radial-gradient(circle at 49% 31%, rgba(255,255,255,0.7) 0 0.95px, transparent 1.05px),
                radial-gradient(circle at 58% 14%, rgba(255,255,255,0.9) 0 1.2px, transparent 1.3px),
                radial-gradient(circle at 62% 52%, rgba(255,255,255,0.58) 0 0.85px, transparent 0.95px),
                radial-gradient(circle at 68% 73%, rgba(255,255,255,0.84) 0 1px, transparent 1.1px),
                radial-gradient(circle at 74% 24%, rgba(255,255,255,0.67) 0 0.9px, transparent 1px),
                radial-gradient(circle at 81% 61%, rgba(255,255,255,0.76) 0 1.05px, transparent 1.15px),
                radial-gradient(circle at 87% 18%, rgba(255,255,255,0.55) 0 0.8px, transparent 0.95px),
                radial-gradient(circle at 92% 47%, rgba(255,255,255,0.83) 0 1.1px, transparent 1.2px),
                radial-gradient(circle at 16% 84%, rgba(255,255,255,0.47) 0 0.7px, transparent 0.85px),
                radial-gradient(circle at 53% 87%, rgba(255,255,255,0.63) 0 0.85px, transparent 0.95px),
                linear-gradient(180deg, #050506 0%, #0b0b10 60%, #070708 100%);
        }

        .starfield::before{
            content:"";
            position: absolute;
            inset: -80px;
            background:
                radial-gradient(circle at 3% 8%, rgba(255,255,255,0.38) 0 0.7px, transparent 0.8px),
                radial-gradient(circle at 9% 26%, rgba(255,255,255,0.24) 0 0.6px, transparent 0.7px),
                radial-gradient(circle at 14% 57%, rgba(255,255,255,0.32) 0 0.7px, transparent 0.8px),
                radial-gradient(circle at 19% 16%, rgba(255,255,255,0.27) 0 0.65px, transparent 0.75px),
                radial-gradient(circle at 24% 71%, rgba(255,255,255,0.21) 0 0.55px, transparent 0.65px),
                radial-gradient(circle at 31% 38%, rgba(255,255,255,0.29) 0 0.7px, transparent 0.8px),
                radial-gradient(circle at 37% 9%, rgba(255,255,255,0.2) 0 0.55px, transparent 0.65px),
                radial-gradient(circle at 41% 82%, rgba(255,255,255,0.35) 0 0.75px, transparent 0.85px),
                radial-gradient(circle at 46% 48%, rgba(255,255,255,0.25) 0 0.65px, transparent 0.75px),
                radial-gradient(circle at 52% 22%, rgba(255,255,255,0.3) 0 0.7px, transparent 0.8px),
                radial-gradient(circle at 57% 66%, rgba(255,255,255,0.22) 0 0.6px, transparent 0.7px),
                radial-gradient(circle at 64% 35%, rgba(255,255,255,0.33) 0 0.75px, transparent 0.85px),
                radial-gradient(circle at 69% 11%, rgba(255,255,255,0.19) 0 0.55px, transparent 0.65px),
                radial-gradient(circle at 73% 79%, rgba(255,255,255,0.28) 0 0.65px, transparent 0.75px),
                radial-gradient(circle at 78% 44%, rgba(255,255,255,0.24) 0 0.6px, transparent 0.7px),
                radial-gradient(circle at 83% 6%, rgba(255,255,255,0.34) 0 0.75px, transparent 0.85px),
                radial-gradient(circle at 88% 59%, rgba(255,255,255,0.23) 0 0.6px, transparent 0.7px),
                radial-gradient(circle at 94% 29%, rgba(255,255,255,0.31) 0 0.7px, transparent 0.8px),
                radial-gradient(circle at 97% 73%, rgba(255,255,255,0.2) 0 0.55px, transparent 0.65px);
            opacity: 0.9;
            animation: drift 28s linear infinite;
        }

        .starfield::after{
            content:"";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 20%, transparent 0%, rgba(0,0,0,0.55) 70%, rgba(0,0,0,0.8) 100%);
        }

        @keyframes drift{
            from { transform: translate3d(0,0,0); }
            to { transform: translate3d(-45px, -30px, 0); }
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
        .hero select,
        .hero textarea {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.06);
            color: #f4f4f6;
            font-family: "Recoleta", ui-serif, Georgia, "Times New Roman", Times, serif;
            font-size: 15px;
            box-sizing: border-box;
        }

        .hero textarea {
            resize: vertical;
            min-height: 110px;
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

                <?php if ($message === 'Appointment request submitted successfully!'): ?>

                    <p><strong>Submission received.</strong></p>

                    <br>

                    <form method="GET" action="">
                        <button type="submit">Submit Another Ticket</button>
                    </form>

                    <br>

                    <a href="index.html">
                        <button type="button">Return to Home</button>
                    </a>

                <?php else: ?>

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
                            <label for="car_make">Car Make:</label>
                            <input
                                type="text"
                                id="car_make"
                                name="car_make"
                                value="<?php echo htmlspecialchars($values['car_make']); ?>"
                            >
                            <?php if (!empty($errors['car_make'])): ?>
                                <p><?php echo $errors['car_make']; ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="car_model">Car Model:</label>
                            <input
                                type="text"
                                id="car_model"
                                name="car_model"
                                value="<?php echo htmlspecialchars($values['car_model']); ?>"
                            >
                            <?php if (!empty($errors['car_model'])): ?>
                                <p><?php echo $errors['car_model']; ?></p>
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

                        <div>
                            <label for="message">Describe the Issue:</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="4"
                            ><?php echo htmlspecialchars($values['message']); ?></textarea>
                        </div>

                        <button type="submit">Submit Request</button>
                    </form>

                    <br>

                    <form method="POST" action="logout.php">
                        <button type="submit">End Session</button>
                    </form>

                <?php endif; ?>
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