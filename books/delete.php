<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $sql = "DELETE FROM books WHERE id = $book_id";
    if ($conn->query($sql) === TRUE) {
        echo "Book deleted successfully";
        header("Refresh:1; url=index.php");
    } else {
        echo "Error deleting book: " . $conn->error;
    }
}