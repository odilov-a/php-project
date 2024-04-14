<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $sql = "DELETE FROM category WHERE id = $category_id";
    if ($conn->query($sql) === TRUE) {
        echo "Category deleted successfully";
        header("Refresh:1; url=index.php");
    } else {
        echo "Error deleting category: " . $conn->error;
    }
}