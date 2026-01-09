<?php
require ('funktsioonid.php');

/* laulu peitmine */
if (isset($_REQUEST['peida_id'])) {
    lauluPeitmine();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* 0 punkt */
if (isset($_REQUEST['nullidaPunktid'])) {
    nullidaPunktid();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* laulu näitamine */
if (isset($_REQUEST['naita_id'])) {
    lauluNäitamine();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* Kommentaaride kustutamine */
if (isset($_REQUEST['Kustuta'])) {
    kommentaarideKustutamine();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
/* Laulude kustutamine */
if (isset($_REQUEST['KustutaLaul'])) {
    lauludeKustutamine();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <link rel="stylesheet" href="haalStyle.css">
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
        <th>Kommentaarid</th>
        <th>Nullida punktid</th>
        <th>Kustuta kommentaarid</th>
        <th>Peida/Näita</th>
        <th>Kustuta laul</th>
    </tr>

<?php
$paring = $yhendus->prepare(
    "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, avalik, kommentaarid
     FROM laulud
     "
);
$paring->bind_result(
    $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $avalik, $kommentaarid
);
$paring->execute();

while ($paring->fetch()) {
    echo "<tr>";
    echo "<td>$lisamisaeg</td>";
    echo "<td>" . htmlspecialchars($laulja) . "</td>";
    echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
    echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
    echo "<td>$punktid</td>";
    echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";

    echo "<td><a href='?nullidaPunktid=$id'>Nullida punktid</a></td>";

    echo "<td><a href='?Kustuta=$id'>Kustuta</a></td>";

    $tekst = "Näita";
    $seisund = "naita_id";
    $tekstLehel = "Peidetud";
    if ($avalik == 1) {
        $tekst = "Peida";
        $seisund = "peida_id";
        $tekstLehel = "Nähtav";
    }
    echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstLehel</td>";

    echo "<td><a href='?KustutaLaul=$id'>Kustuta laul</a></td>";

    echo "</tr>";
}
?>
</table>

</body>
</html>
