<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $author_id = $_GET['id'];
    $sql = "DELETE FROM authors WHERE id = $author_id";
    if ($conn->query($sql) === TRUE) {
        echo "Author deleted successfully";
        header("Refresh:1; url=index.php");
    } else {
        echo "Error deleting author: " . $conn->error;
    }
}