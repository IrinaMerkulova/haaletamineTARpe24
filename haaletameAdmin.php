<?php
require('conf.php');
require('funktsioonid.php');
global $yhendus;

/* laulu peitmine */
if (isset($_REQUEST['peida_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik=0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['peida_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
//Kutsume Laulukustutamise
if(isset($_REQUEST['kustuta'])){
    lauluKustutamine($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

/* kustuta kõik punktid */
if(isset($_REQUEST['kustutaKoikPunktid'])){
    kustutaKoikPunktid($_REQUEST['kustutaKoikPunktid']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
/* laulu näitamine */
if (isset($_REQUEST['naita_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik=1 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['naita_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
/* kommentaari kustutamine */
if (isset($_REQUEST['uus_kommentaar_id']) && isset($_REQUEST['DELETE'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid='' WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['uus_kommentaar_id']);
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
        <li><a href="haaletameAdmin.php">Admin leht</a></li>
    </ul>
</nav>
<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>Kustuta</th>
        <th>Peida/Näita</th>


    </tr>

<?php
$paring = $yhendus->prepare(
    "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, avalik,kommentaarid
     FROM laulud"

);
//lulu kustutamine

$paring->bind_result(
    $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $avalik,$kommentaarid
);
$paring->execute();

while ($paring->fetch()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
    echo "<td>" . htmlspecialchars($laulja) . "</td>";
    echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?kustutaKoikPunktid=$id'>Kustuta Kõik punktid</a></td>";
    echo "<td>$lisamisaeg</td>";
    $tekst="Näita";
    $seisund="naita_id";
    $tekstlehed="Peidetud";
    if($avalik==1){
        $tekst="Peida";
        $seisund="peida_id";
        $tekstlehed="Nähtav";
    }
    echo "<td><a href='?kustuta=$id'>kustuta</a></td>";
    echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstlehed  </td>";
    echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
    echo "<td>
<form action='?' method='post'>
<input type='hidden' name='uus_kommentaar_id' value='$id'>
<input type='submit' value='DELETE'>
</form>
</td>";

    echo "</tr>";
}
?>
</body>
</html>
