<?php
require('conf.php');
require ('funktsioonid.php');
global $yhendus;

// funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt'])){
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if(isset($_REQUEST['miinus1punkt'])){
    miinus1punkt($_REQUEST['miinus1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if(isset($_REQUEST['nullpunkt'])){
    nullpunkt($_REQUEST['nullpunkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if(isset($_REQUEST['delete'])){
    delete($_REQUEST['delete']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if (
    isset($_REQUEST['lauluNimi'], $_REQUEST['laulja']) &&
    !empty($_REQUEST['lauluNimi']) &&
    !empty($_REQUEST['laulja'])
) {
    lauluLisamine($_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if(isset($_REQUEST['peida_id'])){
    peida_id($_REQUEST['peida_id']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if(isset($_REQUEST['naita_id'])){
    naita_id($_REQUEST['naita_id']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if(isset($_REQUEST['deletekomment'])){
    deletekomment($_REQUEST['deletekomment']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <link rel="stylesheet" href="haalStyle.css">
</head>
<body>

<h1>Admini Paneel (Funktsioonidega)</h1>
<nav>
    <ul>
        <li><a href="haaletamineFunktsioonidega.php">Kasutaja</a></li>
        <li><a href="haaletamineAdminFunktsioonidega.php">Admin</a></li>
    </ul>
</nav>

<table>
    <tr>
        <th>Lisamisaeg</th>
        <th>Laulja</th>
        <th>Laulu nimi</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Kommentaarid</th>
        <th>Nähtavus</th>
        <th>Null Punkt</th>
        <th>Kustuta Kommentaar</th>
        <th>Kustuta Laul</th>
    </tr>
    <?php
    kuvaTabeliLauludAdmin();
    ?>
</table>
</body>
</html>
