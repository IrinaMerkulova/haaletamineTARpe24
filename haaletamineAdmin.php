<?php
require('conf.php');
global $yhendus;

/* laulu peitmine */
if (isset($_REQUEST['peida_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['peida_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
/* laulu näitamine */
if (isset($_REQUEST['naita_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 1 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['naita_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* Kommentaaride kustutamine */
if (isset($_REQUEST['Kustuta'])) {
    $paring = $yhendus->prepare(
            "UPDATE laulud SET kommentaarid = '' where id = ? "
    );
    $paring->bind_param('i', $_REQUEST['Kustuta']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
/* Laulude kustutamine */
if (isset($_REQUEST['KustutaLaul'])) {
    $paring = $yhendus->prepare(
            "DELETE from laulud where id = ? "
    );
    $paring->bind_param('i', $_REQUEST['KustutaLaul']);
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
        <th>Kommentaarid</th>
        <th>Kustuta kommentaarid</th>
        <th>Peida/Näita</th>
        <th>Kustuta laul</th>
    </tr>

<?php
$paring = $yhendus->prepare(
    "SELECT id, lauluNimi, laulja, pilt, lisamisaeg, avalik, kommentaarid
     FROM laulud
     "
);
$paring->bind_result(
    $id, $lauluNimi, $laulja, $pilt, $lisamisaeg, $avalik, $kommentaarid
);
$paring->execute();

while ($paring->fetch()) {
    echo "<tr>";
    echo "<td>$lisamisaeg</td>";
    echo "<td>" . htmlspecialchars($laulja) . "</td>";
    echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
    echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
    echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";

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
