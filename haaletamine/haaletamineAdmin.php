<?php
require('conf.php');
require('funktsioonid.php');
global $yhendus;


if(isset($_REQUEST['nullpunkt'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['nullpunkt']);
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


//kutsume lauluKustutamine
if(isset($_REQUEST['kustuta'])){
    lauluKustutamine($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
// kommentaari kustutamine
if(isset($_REQUEST['kustuta_kommentaar_id'])){
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '' WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['kustuta_kommentaar_id']);
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
    <link rel="stylesheet" href="Haalfunk.css">
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
        <th>Nulli punktid</th>
        <th>Lisamisaeg</th>
        <th>Peida/näitam</th>
        <th>Laulu kustutamine</th>
        <th>Kommentaari kustutamine</th>
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
        echo "<td>" . htmlspecialchars($lauluNimi ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($laulja ?? '') . "</td>";
        echo "<td><img src='" . htmlspecialchars($pilt ?? '') . "'></td>";
        echo "<td>$punktid</td>";
        echo "<td><a href='?nullpunkt=$id'>Nulli punktid</a></td>";
        echo "<td>$lisamisaeg</td>";
        $tekst="Näita";
        $seisund="naita_id";
        $tekstlehel="Peidetud";
        if($avalik==1){
            $tekst="Peida";
            $seisund="peida_id";
            $tekstlehel="Nähtav";
        }
        echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstlehel</td>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
        echo "<td><a href='?kustuta_kommentaar_id=$id'>Kustuta kommentaar</a></td>";
        echo "</tr>";
    }
    ?>
</table>


</body>
</html>