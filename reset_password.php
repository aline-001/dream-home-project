<?php
session_start();
require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Dream Home</title>
    <link rel="stylesheet" href="reset_signup.css">
</head>
<body>
    <div class="reset-password-container">
        <h2>Reset Password</h2>
        <form action="reset_password_process.php" method="post">
            <div class="input-group">
                <label for="email">Enter your email address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="btn">Send Reset Link</button>
            <div class="links">
                <a href="login.php">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>
