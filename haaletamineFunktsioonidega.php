<?php
require('funktsioonid.php');
//funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt']))
{
    lisa1punkt($_REQUEST['lisa1punkt']);
    header('Location: '.$_SERVER['PHP_SELF']);
    exit();
}

//laulu lisamise funktsiooni kutsumine
if (
    isset($_REQUEST['lauluNimi'], $_REQUEST['laulja']) &&
    !empty($_REQUEST['lauluNimi']) &&
    !empty($_REQUEST['laulja'])
)
{
    lisaLaul($_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
}

//laulu kustutamise funktsiooni kutsumine
if (isset($_REQUEST['kustutaLaul']))
{
    kustutaLaul($_REQUEST['kustutaLaul']);
}

//punktide eemaldamise funktsiooni kutsumine
if (isset($_REQUEST['eemaldaPunktid']))
{
    eemaldaPunktid($_REQUEST['eemaldaPunktid']);
}

//eemalda 1 punkti funktsiooni kutsumine
if (isset($_REQUEST['lahuta1punkt']))
{
    lahuta1Punkt($_REQUEST['lahuta1punkt']);
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>🎵 Laulude hääletus (funktsioonid eraldi .php failis)</h1>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kustuta laul</th>
        <th>Eemalda punktid</th>
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
