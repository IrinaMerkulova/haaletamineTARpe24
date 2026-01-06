<?php
require('funktsioonid.php');
// funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt']))
{
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// kutsume lisamisfunktsiooni
if(!empty($_REQUEST["lauluNimi"]) && !empty($_REQUEST["laulja"]))
{
    lisaLaul($_REQUEST["lauluNimi"], $_REQUEST["laulja"], $_REQUEST["pilt"]);
    header("Location: ".$_SERVER["PHP_SELF"]);
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
