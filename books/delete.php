<?php

$mysqli = new mysqli("localhost", "root", "", "library");
if ($mysqli->connect_errno) {
    echo "MySQLga ulana olmadi: " . $mysqli->connect_error;
}

$id = intval($_GET['id']);

$query = "DELETE FROM talaba WHERE id=$id";

if ($result = $mysqli->query($query)) {
    echo "O'chirildi";
    header("Refresh: 3; URL='/baza_list.php'");
}
