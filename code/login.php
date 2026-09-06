<?php

session_start();
require_once "db.php";

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Check email OR student ID
    $sql = "SELECT * FROM students
            WHERE email = ? OR student_id = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $username, $username);

    $stmt->execute();

    $result = $stmt->get_result();

    // Check if student exists
    if ($result->num_rows === 1) {

        $student = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $student["password"])) {

            $_SESSION["student_id"] = $student["student_id"];
            $_SESSION["full_name"] = $student["full_name"];

            $message = "Login successful! Welcome to CampusConnect!";
            $success = true;

        } else {

            $message = "Invalid username or password.";
            $success = false;

        }

    } else {

        $message = "Invalid username or password.";
        $success = false;

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>CampusConnect 2026 - Login</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef2ff;
        }

        .header {
            background: #1e3a8a;
            color: white;
            text-align: center;
            padding: 25px;
        }

        .login-box {
            width: 400px;
            max-width: 90%;
            margin: 70px auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #162d6b;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #22c55e;
            padding: 12px;
            margin-top: 20px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
            padding: 12px;
            margin-top: 20px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
        }

        .register {
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

        <p>Student Portal</p>

    </div>


    <div class="login-box">

        <h2>STUDENT LOGIN</h2>


        <form method="POST">

            <label>Email / Student ID</label>

            <input
                type="text"
                name="username"
                placeholder="Enter Email or Student ID"
                required
            >


            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter Password"
                required
            >


            <button type="submit">
                LOGIN
            </button>

        </form>


        <?php if ($message): ?>

            <?php if ($success): ?>

                <div class="success">
                    <?php echo htmlspecialchars($message); ?>
                </div>

            <?php else: ?>

                <div class="error">
                    <?php echo htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>

        <?php endif; ?>


        <div class="register">

            New student?

            <a href="register.php">
                Register here
            </a>

        </div>

    </div>

</body>

</html>
