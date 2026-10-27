<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$name = $_SESSION["user_name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <div class="login-form">

        <h1>Dashboard</h1>

        <p class="subtitle">
            Welcome, <?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?>!
        </p>

        <p style="text-align: center; color: #334155;">
            You have successfully logged in to your account.
        </p>

        <a href="logout.php">
            <button type="button">Logout</button>
        </a>

    </div>

</div>

</body>

</html>