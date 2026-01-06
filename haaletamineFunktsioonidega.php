<?php
require ('funktsioonid.php');
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>

</head>
<body>

<h1>🎵 Laulude hääletus(funktsioond on eraldi ja php failina)</h1>

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
kuvaTabelilaulud();
?>