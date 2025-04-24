<?php
session_start();
require_once('db.php');


if (!isset($_GET['table']) || !isset($_GET['pk_name']) || !isset($_GET['pk_value'])) {
    echo $_GET['table'];
    die("Invalid request.");
}

$table = $_GET['table'];
$pk_name = $_GET['pk_name'];
$pk_value = $_GET['pk_value'];


$sql = "SELECT * FROM `$table` WHERE `$pk_name` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pk_value);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Record not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updateQuery = "UPDATE `$table` SET ";
    $params = [];
    $types = "";

    foreach ($_POST as $key => $value) {
        if ($key !== $pk_name) {
            $updateQuery .= "`$key` = ?, ";
            $params[] = $value;
            $types .= "s"; 
        }
    }

    $updateQuery = rtrim($updateQuery, ", ") . " WHERE `$pk_name` = ?";
    $params[] = $pk_value;
    $types .= "s"; 

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        header("Location: view_table.php?table=$table");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Record</title>
</head>
<body>
    <h1>Edit <?= ucfirst(htmlspecialchars($table)) ?></h1>
    <form method="post">
        <?php foreach ($data as $key => $value): ?>
            <?php if ($key !== $pk_name): ?>
                <label><?= htmlspecialchars($key) ?>:</label>
                <input type="text" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>" required><br>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
