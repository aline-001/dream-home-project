<?php
session_start();
require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream Home Dashboard</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

   
    <div class="top-navbar">
    <img src="dreamhomelogo.jpg" alt="Dream Home Logo" style="height: 80px; width: auto; margin-right: 200px;">
        <p class="project-name">Dream Home</p>
        <div class="user-section">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="profile.php">Profile (' . $_SESSION['username'] . ')</a>  ';
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="login.php">Login</a>';
            }
            ?>
        </div>
    </div>

    
    <div class="sidebar">
        <ul>
            <li><a href="home.php" class="active">🏠 Home</a></li>
            <li><a href="users.php">👤 Users</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="view_table.php?table=branch">🏢 Branches</a></li>
            <li><a href="view_table.php?table=staff">👨‍💼 Staff</a></li>
            <li><a href="view_table.php?table=propertyforrent">🏠 Property for Rent</a></li>
            <li><a href="view_table.php?table=client">🧑 Clients</a></li>
            <li><a href="view_table.php?table=privateowner">👤 Private Owners</a></li>
            <li><a href="view_table.php?table=viewing">👀 Viewings</a></li>
            <li><a href="view_table.php?table=registration">📋 Registrations</a></li>
        </ul>
    </div>

   
    <div class="main-content">
        <h2>Welcome to Dream Home Dashboard</h2>

        <div class="dashboard-cards">
            <?php
            $tables = [
                'branch' => 'Branches',
                'staff' => 'Staff',
                'privateowner' => 'Private Owners',
                'propertyforrent' => 'Properties for Rent',
                'client' => 'Clients',
                'registration' => 'Registrations',
                'viewing' => 'Viewings'
            ];

            foreach ($tables as $table => $displayName) {
                $query = "SELECT COUNT(*) AS count FROM `$table`";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
                echo "<div class='card'>
                        <h3>$displayName</h3>
                        <p>Total: " . $row['count'] . "</p>
                        <a href='view_table.php?table=$table'>View</a>
                    </div>";
            }
            ?>
        </div>
    </div>

</body>
</html>
