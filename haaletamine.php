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
$paring = $yhendus->prepare(
    "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, kommentaarid
     FROM laulud
     WHERE avalik = 1"
);
$paring->bind_result(
    $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $kommentaarid
);
$paring->execute();

while ($paring->fetch()) {
    echo "<tr>";
    echo "<td>$lisamisaeg</td>";
    echo "<td>" . htmlspecialchars($laulja) . "</td>";
    echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
    echo "<td><img alt='albumi pilt' src='" . htmlspecialchars($pilt) . "'></td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
    echo "<td><a href='?eemalda1punkt=$id'>-1 punkt</a></td>";
    echo "<td>".nl2br(htmlspecialchars($kommentaarid))  ."</td>";
    echo "<td>
<form action='?' method='post'>
<input type='hidden' name='uus_kommentaar_id' value='$id'>
<input type='text' name='uus_kommentaar' id='uus_kommentaar'>
<input type='submit' value='OK'>
</form>

</td>";
    echo "</tr>";
}
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
