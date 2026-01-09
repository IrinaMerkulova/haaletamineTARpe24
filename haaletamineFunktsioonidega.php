<?php
require ('conf.php');
require ('funktsioonid.php');
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

/* Kommentaari lisamine */
if (isset($_REQUEST['uus_kommentaar_id'])) {
    kommentaariLisamine($_REQUEST['uus_kommentaar_id'], $_REQUEST['uus_kommentaar']);
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

<h1>🎵 Laulude hääletus (funktsioonid on eraldi failis)</h1>
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

        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kommentaarid</th>
        <th>Kommentaari lisamine</th>
    </tr>
    <?php
    kuvaTabeliLauludTava();
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
</body>
</html>