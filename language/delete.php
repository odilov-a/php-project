<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $languages_id = $_GET['id'];
    $sql = "DELETE FROM languages WHERE id = $languages_id";
    if ($conn->query($sql) === TRUE) {
        echo "Language deleted successfully";
        header("Refresh:1; url=index.php");
    } else {
        echo "Error deleting languages: " . $conn->error;
    }
}