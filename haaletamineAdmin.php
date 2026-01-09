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

/* punktide nulleerimiene */

if(isset($_REQUEST['nulleeripunktid']))
{
    nulleeriPunktid($_REQUEST['nulleeripunktid']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
/* kommentaaride nulleerimiene */

if(isset($_REQUEST['kustutakommentaarid']))
{
    kustutaKommentaarid($_REQUEST['kustutakommentaarid']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
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

// kutsume kustutamisfunktsiooni
if(isset($_REQUEST['kustuta']))
{
    kustuta($_REQUEST['kustuta']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
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
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Nulleeri Punktid</th>
        <th>Kustuta kommentaarid</th>
        <th>Eemalda laul</th>
        <th>Lisamisaeg</th>
        <th>Peida</th>
        <th>Näita</th>
    </tr>

    <?php
    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, avalik
     FROM laulud"
    );
    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $avalik
    );
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td><img alt='albumi pilt' src='" . htmlspecialchars($pilt) . "'></td>";
        echo "<td>$punktid</td>";
        echo "<td><a href='?nulleeripunktid=$id'>Nulleeri punktid</a></td>";
        echo "<td><a href='?kustutakommentaarid=$id'>Kustuta kommentaarid</a></td>";
        echo "<td><a href='?kustuta=$id'>Eemalda laul</a></td>";
        echo "<td>$lisamisaeg</td>";


        $tekst = "Näita";
        $seisund = "naita_id";
        $tekstlehel = "Peidetud";
        if ($avalik == 1) {
            $tekst = "Peida";
            $seisund = "peida_id";
            $tekstlehel = "Nähtav";
        }
        echo "<td><a href='?$seisund=$id'>$tekst</a>";
        echo "<td>$tekstlehel</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
