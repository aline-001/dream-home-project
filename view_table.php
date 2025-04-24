<?php
include 'db.php'; 

$tables = [
    'branch' => ['primary_key' => 'BranchNo'],
    'staff' => ['primary_key' => 'staffNo'],
    'privateowner' => ['primary_key' => 'ownerNo'],
    'propertyforrent' => ['primary_key' => 'propertyNo'],
    'client' => ['primary_key' => 'clientNo'],
    'registration' => ['primary_key' => ['clientNo', 'branchNo']], // Composite key
    'viewing' => ['primary_key' => ['clientNo', 'propertyNo', 'viewDate']] // Composite key
];

if (!isset($_GET['table']) || !array_key_exists($_GET['table'], $tables)) {
    die("Invalid table selected.");
}

$table = $_GET['table'];
$primaryKey = $tables[$table]['primary_key'];

$sql = "SELECT * FROM $table";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View <?php echo ucfirst($table); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<div class="top-navbar">
    <img src="dreamhomelogo.jpg" alt="Dream Home Logo" style="height: 80px; width: auto; margin-right: 200px;">
    <p class="project-name">Dream Home</p>
    <div class="user-section">
        <?php session_start(); ?>
        <div class="user-section">
            <?php if (isset($_SESSION['username'])): ?>
                <a href="profile.php">Profile (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a> | 
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
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
    <h2><?php echo ucfirst($table); ?> Table</h2>
    <table>
        <thead>
            <tr>
                <?php
                $columns = [];
                while ($field = $result->fetch_field()) {
                    echo "<th>{$field->name}</th>";
                    $columns[] = $field->name;
                }
                ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <?php foreach ($columns as $col) : ?>
                        <td><?php echo htmlspecialchars($row[$col]); ?></td>
                    <?php endforeach; ?>
                    <td>
                        <div class="actions">
                            <?php
                            if (is_array($primaryKey)) {
                                $queryParams = [];
                                foreach ($primaryKey as $key) {
                                    $queryParams[] = "{$key}=" . urlencode($row[$key]);
                                }
                                $queryStr = implode("&", $queryParams);
                            } else {
                                $queryStr = "{$primaryKey}=" . urlencode($row[$primaryKey]);
                            }
                            ?>
                            <a href="edit.php?table=<?php echo $table; ?>&<?php echo $queryStr; ?>" class="btn btn-edit">Edit</a>
                            <a href="delete.php?table=<?php echo $table; ?>&<?php echo $queryStr; ?>" 
                               class="btn btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</html>
