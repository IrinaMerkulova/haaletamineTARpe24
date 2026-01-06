<?php
require ('funktsioonid.php');
//kutsume laulukustutamine
if (isset($_REQUEST['kustuta'])) {
    laulukustutamine($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
//funktsiooni kutsumine
if (isset($_REQUEST['lisa1punkt'])) {
    lisa1puntk($_REQUEST['lisa1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

//kutsume lisamis funktsiooni
if (!empty($_REQUEST['lauluNimi'])) {
    laululisamine(
        $_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
            header("Location: " . $_SERVER['PHP_SELF']);
    exit();

}
if (isset($_REQUEST['eemalda1puntk'])) {
    eemalda1puntk($_REQUEST['eemalda1puntk']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if (isset($_REQUEST['nullpunkt'])) {
    nullpunkt($_REQUEST['nullpunkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>

</head>
<body>

<h1>🎵 Laulude hääletus</h1>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>kustuta</th>
        <th>-1 punkt</th>
        <th>punktid 0</th>

    </tr>
    <?php
    kuvaTabeliLaulud();
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
</body>
</html>
