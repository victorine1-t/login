<?php

session_start();
require_once "db.php";

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } else {

        $sql = "SELECT id, name, email, password
                FROM users
                WHERE email = :email
                LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(["email" => $email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Invalid email or password.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Page</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <form class="login-form" method="POST" action="index.php">

        <div class="logo">LS</div>

        <h1>Welcome Back</h1>

        <p class="subtitle">
            Login to access your account
        </p>

        <?php if (isset($_GET["registered"])): ?>

            <p class="success">
                Account created successfully. Please log in.
            </p>

        <?php endif; ?>

        <?php if ($error !== ""): ?>

            <p class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </p>

        <?php endif; ?>

        <label for="email">Email Address</label>

        <input
            type="email"
            id="email"
            name="email"
            placeholder="Enter your email"
            maxlength="150"
            required
        >

        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        <button type="submit">Login</button>

        <p class="bottom-text">
            Don't have an account?
            <a href="register.php">Create account</a>
        </p>

    </form>

</div>

</body>

</html>