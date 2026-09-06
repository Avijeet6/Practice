<?php
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $student_id = trim($_POST["student_id"]);
    $email = trim($_POST["email"]);
    $college_name = trim($_POST["college_name"]);
    $location = trim($_POST["location"]);
    $event = trim($_POST["event"]);
    $password = $_POST["password"];

    if (
        empty($full_name) ||
        empty($student_id) ||
        empty($email) ||
        empty($college_name) ||
        empty($location) ||
        empty($event) ||
        empty($password)
    ) {
        $message = "Please fill all fields.";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO students
                (full_name, student_id, email, college_name, location, event, password)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssssss",
            $full_name,
            $student_id,
            $email,
            $college_name,
            $location,
            $event,
            $hashed_password
        );

        if ($stmt->execute()) {
            $message = "Registration successful! You can now login.";
        } else {
            if ($conn->errno == 1062) {
                $message = "Student ID or Email already registered.";
            } else {
                $message = "Registration failed.";
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CampusConnect 2026 - Registration</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
        }

        .header {
            background: #1e3a8a;
            color: white;
            text-align: center;
            padding: 25px;
        }

        .container {
            width: 450px;
            max-width: 92%;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #162d6b;
        }

        .message {
            text-align: center;
            margin: 15px 0;
            color: #166534;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #1e3a8a;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>CampusConnect 2026</h1>
    <p>Student Registration Portal</p>
</div>

<div class="container">

    <h2>Student Registration</h2>

    <?php if ($message): ?>
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Student ID</label>
        <input type="text" name="student_id" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>College Name</label>
        <input type="text" name="college_name" required>

        <label>Location</label>
        <input type="text" name="location" required>

        <label>Event</label>
        <input type="text" name="event" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">
            REGISTER
        </button>

    </form>

    <div class="login-link">
        Already registered?
        <a href="login.php">Login here</a>
    </div>

</div>

</body>
</html>
