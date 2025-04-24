<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
   
    if ($user['role'] == 'admin') {
        header("Location: home.php");
        exit();
    } else {
        header("Location: user_home.php"); 
        exit();
    }
} else {
    echo "User not found.";
    exit();
}
?>
