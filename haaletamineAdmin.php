<?php
require('AdminFunktsioonid.php');
if(isset($_REQUEST['kustuta'])){
    eemaldaLaul($_REQUEST['kustuta']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['nullipunktid'])){
    nullipunktid($_REQUEST['nullipunktid']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}

//kutsume lisamisfunktsiooni
if(!empty($_REQUEST['lauluNimi'])){
    lauluLisamine($_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['peida'])){
    peida($_REQUEST['peida']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['naita'])){
    naita($_REQUEST['naita']);
    header("Location: ". $_SERVER['PHP_SELF']);
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

<h1>🎵 Laulude hääletus (funktsioonid on eraldi php failides)</h1>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>Nulli punktid</th>
        <th>Valikud</th>
        <th>Avalikus</th>
    </tr>
    <?php
    AdminkuvaTabeliLaulud();
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