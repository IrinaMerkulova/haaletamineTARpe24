<?php

require('adminFunktsioonid.php');
global $yhendus;

//lauluKustutamine
if(!empty($_REQUEST['kustutalaul'])){
    lauluKustutamine($_REQUEST['kustutalaul']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

//nullimine
if(isset($_REQUEST['nullpunkt'])) {
    nullpunkt($_REQUEST['nullpunkt']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}
//peida/näita
if(isset($_REQUEST['peida_id'])){
    peidaLaul($_REQUEST['peida_id']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if(isset($_REQUEST['naita_id'])){
    naitaLaul($_REQUEST['naita_id']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
//kommentaaride kustutamine
if(!empty($_REQUEST['kustutakommentaar'])){
    kustutaKommentaar($_REQUEST['kustutakommentaar']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="haaletamineStyle.css">
    <title>Laulude leht</title>
    <nav>
        <ul>
            <li><a href="haaletamine.php">Kasutaja leht</a></li>
            <li><a href="adminHaaletamine.php">Admin leht</a></li>
        </ul>
    </nav>
</head>
<body>

<h1>🎵 Laulude hääletus</h1>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>uuenda punktid</th>
        <th>kustuta laul</th>
        <th>kommentaarid</th>
    </tr>

<?php
kuvaTabelilaulud();
?>
</table>
