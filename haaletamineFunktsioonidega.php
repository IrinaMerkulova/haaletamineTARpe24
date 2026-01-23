<?php
require('funktsioonid.php');
//funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt'])){
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['eemalda1punkt'])){
    kustuta1punkt($_REQUEST['eemalda1punkt']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}


//kutsume lisamisfunktsiooni
if(!empty($_REQUEST['lauluNimi'])){
    lauluLisamine($_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <link rel="stylesheet" href="StyleHaal.css">
    <meta charset="UTF-8">
    <title>Laulude leht</title>
</head>
<body>

<h1>Laulude hääletuse tume turg ////// KASUTAJA PANEEL</h1>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Valikud</th>
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
<div class="binary-wrap">
    <div class="binary-line">1010101010101010010101010101010101010101010101010101010101010101</div>
    <div class="binary-line">0101010101010101101010101010101010101010101010101010101010101010</div>
    <div class="binary-line">1010010101010101010101010101010101010101010101010101010101010101</div>
    <div class="binary-line">0101011010101010101010101010101010101010101010101010101010101010</div>
    <div class="binary-line">1010101010100101010101010101010101010101010101010101010101010101</div>
</div>
</html>
