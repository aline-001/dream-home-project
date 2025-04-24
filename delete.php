<?php
include('db.php');

if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];

    $sql = "DELETE FROM $table WHERE id = $id";

    if ($conn->query($sql)) {
        header("Location: view_table.php?table=$table");
        exit;
    } else {
        echo "Error deleting record.";
    }
} else {
    die("Invalid request.");
}
?>
