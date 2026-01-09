<?php
require('conf.php');
require('funktsioonid.php');
global $yhendus;

/* +1 punkt */
if(isset($_REQUEST['lisa1punkt']))
{
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

if(isset($_REQUEST['eemalda1punkt']))
{
    eemalda1punkt($_REQUEST['eemalda1punkt']);
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

if (isset($_REQUEST['uus_kommentaar_id']))
{
    lisaKommentaar($_REQUEST['uus_kommentaar_id']);
    /*
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = CONCAT(kommentaarid, ' ', ?) WHERE id = ?"
    );

    $paring->bind_param('si',
        $_REQUEST['uus_kommentaar'],
        $_REQUEST['uus_kommentaar_id']
    );
    $paring->execute();*/
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <link rel="stylesheet" href="haaletamineStyle.css">
</head>
<body>

<h1>🎵 Laulude hääletus</h1>

<nav>
    <ul>
        <li><a href="haaletamine.php">Kasutaja leht</a></li>
        <li><a href="haaletamineAdmin.php">Admin leht</a></li>
    </ul>
</nav>

<table>
    <tr>
        <th>Lisamisaeg</th>
        <th>Laulja</th>
        <th>Laulu nimi</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kommentaarid</th>
        <th>Kommentaari lisamine</th>
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
