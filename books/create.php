<?php

$mysqli = new mysqli("localhost", "root", "", "library");
if ($mysqli->connect_errno) {
    echo "error: " . $mysqli->connect_error;
}

$errorlist = [];
if (!empty($_POST)) {
    $familiya = $mysqli->real_escape_string($_POST['familiya']);
    $ism = $mysqli->real_escape_string($_POST['ism']);
    $sharif = $mysqli->real_escape_string($_POST['sharif']);
    $manzil = $mysqli->real_escape_string($_POST['manzil']);
    $guruh = intval($_POST['guruh']);

    $kurs = 1;
    //$kurs = -1; //xato holat uchun
    if ($kurs < 0) {
        $errorlist[] = "Kurs maydonining qiymatini kiritishda xato";
    }

    if (count($errorlist) == 0) {
        $query = "INSERT INTO talaba(familiya, ism, sharifi, manzili, guruh_id)
                VALUES('$familiya', '$ism', '$sharif', '$manzil', $guruh)";
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

    <?php
    if (count($errorlist) > 0) {
        echo "<p>Xatolar:</p><ul>";
        foreach ($errorlist as $xato) {
            echo "<li>$xato</li>";
        }
        echo "</ul>";
    }
    ?>
    <form method="post">
        Familiya <input type="text" name="familiya"> <br>
        Ism <input type="text" name="ism"> <br>
        Sharif <input type="text" name="sharif"> <br>
        Manzil <input type="text" name="manzil"> <br>
        Guruh <select name="guruh">
            <?php
            $result = $mysqli->query("SELECT id, nomi FROM guruh");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['nomi']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Saqlash">
    </form>
</body>

</html>