<?php
require ('funktsioonid.php');
//kutsume lauluKustutamine
if(isset($_REQUEST['kustuta'])){
    lauluKustutamine($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

//funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt'])){
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['eemalda1punkt']))
{
    eemalda1punkt($_REQUEST['eemalda1punkt']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}


//kutsume lisamisfunktsiooni
if(!empty($_REQUEST['lauluNimi'])){
    lauluLisamine(
        $_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
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

<h1>🎵 Laulude hääletus (funktsioonid on eraldi php failis)</h1>

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
    kuvaTabeliLaulud();
    ?>
</table>
</body>
</html>