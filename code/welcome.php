<?php
session_start();

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>CampusConnect 2026 - Welcome</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef2ff;
            text-align: center;
        }

        .box {
            width: 500px;
            max-width: 90%;
            margin: 100px auto;
            background: white;
            padding: 50px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
        }

        h1 {
            color: #1e3a8a;
        }

        .logout {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background: #dc2626;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

    </style>

</head>

<body>

<div class="box">

    <h1>Welcome to CampusConnect!</h1>

    <p>
        Hello,
        <?php echo htmlspecialchars($_SESSION["full_name"]); ?>!
    </p>

    <p>
        You have successfully logged in.
    </p>

    <a class="logout" href="logout.php">
        Logout
    </a>

</div>

</body>
</html>
