<?php
require ('funktsioonid.php');

//kutsume lauuluKustutamine
if(!empty($_REQUEST['kustuta'])){
    lauluKustutamine($_REQUEST['kustuta']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

// punkti lisamis funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt'])){
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

//punkti eemaldamis funktsiooni kutsumine
if(isset($_REQUEST['eemalda1punkt'])) {
    eemalda1punkt($_REQUEST['eemalda1punkt']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}

//kutsume lisamisfunktsiooni
    if (
        isset($_REQUEST['lauluNimi'], $_REQUEST['laulja']) &&
        !empty($_REQUEST['lauluNimi']) &&
        !empty($_REQUEST['laulja'])
    ) {
        lauluLisamine($_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
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
        <th>kustuta</th>
    </tr>
</table>
<?php
kuvaTabelilaulud();
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
</form>