<?php 
session_start();
require_once('db.php');


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT email FROM users WHERE username = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $username); 
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if (!$user) {
        echo "User not found.";
        exit();
    }
    
    $email = htmlspecialchars($user['email']);
} else {
    echo "Failed to prepare the statement.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Dream Home</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <h2>Profile Information</h2>
        <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
        
        <div class="links">
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>
