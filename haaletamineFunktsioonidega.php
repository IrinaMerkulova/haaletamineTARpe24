
<?php

require ('funktsioonid.php');

//funktsiooni kutsumine
if (isset($_REQUEST['lisa1punkt'])) {
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if (isset($_REQUEST['vota1punkt'])) {
    vota1punkt($_REQUEST['vota1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if (isset($_REQUEST['kustuta'])) {
    laulukustutamine($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if (isset($_REQUEST['nullid'])) {
    nullipunktid($_REQUEST['nullid']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// kutsume lisamisfunktsiooni
if (!empty($_REQUEST['lauluNimi'])){
     lauluLisamine(['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();

}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <link rel="stylesheet" href="Haalfunk.css">
    <meta charset="UTF-8">
    <title>Laulude leht</title>

</head>
<body>

<h1>🎵 Laulude hääletus (funktsioonid on eraldi php failis</h1>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>


    </tr>
    <?php
    kuvaTabeliLauld();

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

