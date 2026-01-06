<?php
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
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: ". $_SERVER['PHP_SELF']);
}


//kutsume lisamisfunktsioonid
if(!empty($_REQUEST['lauluNimi']))
{
    laululisamine($_REQUEST['lauluNimi'],$_REQUEST['laulja'],$_REQUEST['pilt']);
    header("Location: ". $_SERVER['PHP_SELF']);
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

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>Kustuta</th>


    </tr>

    <?php
    kuvaTabelidLaulud();
    lisa1punkt(0);
    ?>

    <h2>Lisa uus laul</h2>
    <form action="?" method="post">
        <label>Laulu nimi:</label><br>
        <input type="text" name="lauluNimi"><br><br>

        <label>Laulja:</label><br>
        <input type="text" name="laulja"><br><br>

        <label>Pildi URL:</label><br>
        <textarea name="pilt"></textarea><br><br>

        <input type="submit" value="Lisa laul">

</table>
</body>
</html>

