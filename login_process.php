<?php
session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Please fill in all fields!";
        header("Location: login.php");
        exit();
    }

    $query = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
           
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "❌ Incorrect password!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "❌ Username not found!";
        header("Location: login.php");
        exit();
    }
}

$conn->close();
?>
