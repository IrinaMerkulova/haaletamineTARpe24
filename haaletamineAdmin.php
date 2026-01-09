<?php
require('conf.php');
global $yhendus;

/* punktide kustutamine */
if (isset($_REQUEST['kustutapunktid'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['kustutapunktid']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* kommentaaride kustutamine */
if (isset($_REQUEST['kustutakommentaar'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '' WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['kustutakommentaar']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* laulu peitmine*/
if (isset($_REQUEST['peida_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik=0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['peida_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* laulu näitamine*/
if (isset($_REQUEST['naita_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik=1 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['naita_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* laulu kustutamine */
if (isset($_REQUEST['kustutalaul'])) {
    $paring = $yhendus->prepare(
        "DELETE FROM laulud WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['kustutalaul']);
    $paring->execute();
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

<h1>🎵 Laulude hääletus</h1>

<nav>
    <ul>
        <li><a href="haaletamine.php">Kasutaja leht</a></li>
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
        <th>Punktide kustutamine</th>
        <th>Kommentaarid</th>
        <th>Kommentaaride kustutamine</th>
        <th>Laulu kustutamine</th>
        <th>Peida/Näita</th>
    </tr>

<?php
$paring = $yhendus->prepare(
    "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, kommentaarid, avalik
     FROM laulud"
);
$paring->bind_result(
    $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $kommentaarid, $avalik
);
$paring->execute();

while ($paring->fetch()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
    echo "<td>" . htmlspecialchars($laulja) . "</td>";
    echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
    echo "<td>$punktid</td>";
    echo "<td>$lisamisaeg</td>";
    echo "<td><a href='?kustutapunktid=$id'>Kustuta punktid</a></td>";
    echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
    echo "<td><a href='?kustutakommentaar=$id'>Kustuta kommentaarid</a></td>";
    echo "<td><a href='?kustutalaul=$id'>Kustuta laul</a></td>";
    $tekst="Näita";
    $seisund="naita_id";
    $tekstlehel="Peidetud";
    if($avalik==1){
        $tekst="Peida";
        $seisund="peida_id";
        $tekstlehel="Nähtav";
    }
    echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstlehel</td>";
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
