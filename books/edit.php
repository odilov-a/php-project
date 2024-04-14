<?php

$mysqli = new mysqli("localhost", "root", "", "library");
if ($mysqli->connect_errno) {
  echo "MySQLga ulana olmadi: " . $mysqli->connect_error;
}

$id = intval($_GET['id']);

$query = "SELECT * FROM talaba WHERE id=$id";

if ($result = $mysqli->query($query))
  $talaba = $result->fetch_assoc();

$errorlist = [];
if (!empty($_POST)) {
  $familiya = $mysqli->real_escape_string($_POST['familiya']);
  $ism = $mysqli->real_escape_string($_POST['ism']);
  $sharif = $mysqli->real_escape_string($_POST['sharif']);
  $manzil = $mysqli->real_escape_string($_POST['manzil']);
  $guruh = intval($_POST['guruh']);
  $id = intval($_POST['id']);

  if (count($errorlist) == 0) {
    $query = "UPDATE talaba SET
                    familiya='$familiya',
                    ism='$ism',
                    sharifi='$sharif',
                    manzili='$manzil',
                    guruh_id=$guruh
                  WHERE id=$id
                ";
    echo $query;
    if ($result = $mysqli->query($query)) {
      echo "Saqlandi";
    } else {
      echo "Xatolik";
    }
    header("Refresh: 3; URL='/baza_list.php'");
  }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <form method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    Familiya <input type="text" name="familiya" value="<?= $talaba['familiya'] ?>"> <br>
    Ism <input type="text" name="ism" value="<?= $talaba['ism'] ?>"> <br>
    Sharif <input type="text" name="sharif" value="<?= $talaba['sharifi'] ?>"> <br>
    Manzil <input type="text" name="manzil" value="<?= $talaba['manzili'] ?>"> <br>
    Guruh <select name="guruh">
      <?php
      $result = $mysqli->query("SELECT id, nomi FROM guruh");
      while ($row = $result->fetch_assoc()) {
        if ($row['id'] == $talaba['guruh_id'])
          echo "<option value='{$row['id']}' selected>{$row['nomi']}</option>\n";
        else
          echo "<option value='{$row['id']}'>{$row['nomi']}</option>\n";
      }
      ?>
    </select><br>

    <input type="submit" value="Saqlash">
  </form>
</body>

</html>