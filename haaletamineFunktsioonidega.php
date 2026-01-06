<?php
require ('funktsioonid.php');
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<h1> Laulude hääletus (funktsioonid on realdi php failis)</h1>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
    </tr>
    <?php
    kuvaTabeliLaulud();
    ?>
</table>
</body>
</html>
