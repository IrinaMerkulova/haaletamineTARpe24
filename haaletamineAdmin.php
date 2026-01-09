<?php
require('conf.php');
global $yhendus;

/* 0 punkt */
if (isset($_REQUEST['punktnull'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid =0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['punktnull']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
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
/* kommentaari lisamine */
if (isset($_REQUEST['uus_kommentaar_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id = ?"
    );
    $komment2=$_REQUEST['uus_kommentaar']. "\n";
    $paring->bind_param('si', $_REQUEST['uus_kommentaar'], $_REQUEST['uus_kommentaar_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
//laulu kustutamine
if (isset($_REQUEST['kustuta'])) {
    laulukustutamine($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
function laulukustutamine($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "DELETE From laulud Where id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
/* kustuta kommm */
if (isset($_REQUEST['kommentaarid'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '' WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['kommentaarid']);
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
    <link rel="stylesheet" href="kujndus.css">
    
</head>
<body>

<h1>🎵 Laulude hääletus</h1>
<nav>
    <ul>
        <li><a href="haaletamine.php">kasutaja leht</a></li>
        <li><a href="haaletamineAdmin.php">admin leht</a></li>
    </ul>
</nav>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>0 punkt</th>
        <th>kustuta</th>
        <th>kustuta komm</th>
        <th>kommentaar</th>
        <th>peida/näita</th>


    </tr>

<?php
$paring = $yhendus->prepare(
    "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, avalik, kommentaarid
     FROM laulud"
);
$paring->bind_result(
    $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $avalik, $kommentaarid
);
$paring->execute();

while ($paring->fetch()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
    echo "<td>" . htmlspecialchars($laulja) . "</td>";
    echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
    echo "<td>$punktid</td>";
    echo "<td>$lisamisaeg</td>";
    echo "<td><a href='?punktnull=$id'>0 punkt</a></td>";
    echo "<td><a href='?kustuta=$id'>kustuta</a></td>";
    echo "<td><a href='?kommentaarid=$id'>kustuta kommentaar</a></td>";
    echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
    $tekst='näita';
    $seisund='naita_id';
    $tekstlehel='peidetud';
    if($avalik==1){
        $tekst='peida';
        $seisund="peida_id";
        $tekstlehel="nähtav";
    }

    echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstlehel </td>";
    echo "</tr>";
}
?>
</table>


</form>

</body>
</html>
