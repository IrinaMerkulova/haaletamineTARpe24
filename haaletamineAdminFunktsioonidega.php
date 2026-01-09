<?php

require('funktsioonidAdmin.php');
global $yhendus;

//kutsume lauluKustutamine
if(!empty($_REQUEST['kustuta'])){
    lauluKustutamine($_REQUEST['kustuta']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

//kutsume nullimine
if(isset($_REQUEST['nullpunkt'])) {
    nullpunkt($_REQUEST['nullpunkt']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}

/* kommentaari lisamine */
if (isset($_REQUEST['uus_kommentaar_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?"
    );
    $kommentaar = $_REQUEST['uus_kommentaar'] . "\n";
    $paring->bind_param('si', $kommentaar, $_REQUEST['uus_kommentaar_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <nav>
        <ul>
            <li><a href="haaletamineFunktsioonidega.php">Kasutaja leht</a></li>
            <li><a href="haaletamineAdminFunktsioonidega.php">Admin leht</a></li>
        </ul>
    </nav>
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
        <th>-1 punkt</th>
        <th>0punkt</th>
        <th>kustuta</th>
        <th>kommentaarid</th>
    </tr>

<?php
kuvaTabelilaulud();
?>
</table>


<h2>Lisa uus laul</h2>
<form action="?" method="post">
    <label>Laulu nimi:</label><br>
    <input type="text" name="lauluNimi"><br><br>

    <label>Laulja:</label><br>
    <input type="text" name="laulja"><br><br>

    <label>Pildi URL:</label><br>
    <textarea name="pilt"></textarea><br><br>

    <input type="submit" value="Lisa laul">
</form>