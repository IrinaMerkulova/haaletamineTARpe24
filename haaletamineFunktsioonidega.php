<?php
global $yhendus;
require ('funktsioonid.php');

if(isset($_REQUEST['kustuta']))
{
    lauluKustutamine($_REQUEST['kustuta']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit;
}


//funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt']))
{
    $pairing = $yhendus->prepare(
        "UPDATE laulud SET punktid=+1 WHERE ID =?"
    );
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: ". $_SERVER['PHP_SELF']);
}

if(isset($_REQUEST['eemalda1punkt']))
{
    $pairing = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid - 1 WHERE id = ? AND punktid > 0"
    );
    eemalda1punkt($_REQUEST['eemalda1punkt']);
    header("Location: ". $_SERVER['PHP_SELF']);
}



//kutsume lisamisfunktsioonid
if(!empty($_REQUEST['lauluNimi']))
{
    laululisamine($_REQUEST['lauluNimi'],$_REQUEST['laulja'],$_REQUEST['pilt']);
    header("Location: ". $_SERVER['PHP_SELF']);
}

if (isset($_REQUEST['uus_kommentaar_id'])) {
    kommentaariLisamine($_REQUEST['uus_kommentaar_id'], $_REQUEST['uus_kommentaar']);
}
?>








<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <link rel="stylesheet" href="haaleCSS.css">


</head>
<body>

<h1>🎵 Laulude hääletus (funktsioonid on eraldi php-s)</h1>
<nav>
    <ul>
        <li><a href="haaletamineFunktsioonidega.php">Kasutaja leht</a></li>
        <li><a href="haaletamineAdmin.php">Admin leht</a></li>
    </ul>
</nav>
<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kommentaarid</th>
        <th>Kommentaari lisamine</th



    </tr>

    <?php
    kuvaTabelidLaulud();
    ?>
</table>


    <h2>Lisa uus laul</h2>
    <form action="?" method="post" id="one">
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

