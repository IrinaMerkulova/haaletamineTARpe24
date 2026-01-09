<?php
require('conf.php');
global $yhendus;

/* +1 punkt */
if (isset($_REQUEST['lisa1punkt'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['lisa1punkt']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* laulu kustutamine */
if (isset($_REQUEST['kustutaLaul'])) {
    $paring = $yhendus->prepare(
        "DELETE from laulud WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['kustutaLaul']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* kustuta kommentaarid */
if (isset($_REQUEST['kustutaKomment'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '0' WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['kustutaKomment']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_REQUEST['punktNulliks'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['punktNulliks']);
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


/* Laulu lisamine */
if (
    isset($_REQUEST['lauluNimi'], $_REQUEST['laulja']) &&
    !empty($_REQUEST['lauluNimi']) &&
    !empty($_REQUEST['laulja'])
) {
    $paring = $yhendus->prepare(
        "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
    );
    $paring->bind_param(
        'sss',
        $_REQUEST['lauluNimi'],
        $_REQUEST['laulja'],
        $_REQUEST['pilt']
    );
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
    <link rel="stylesheet" href="haaletamineAdminStyle.css">
    
</head>
<body>

<h1>🎵 Laulude hääletus</h1>
<nav>
    <ul>
        <li><a href="haaletamine.php">Kasutaja</a></li>
        <li><a href="haaletamineAdmin.php">Admin</a></li>
    </ul>
</nav>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>Nulli punktid</th>
        <th>Kustuta komment</th>
        <th>Kustuta laul</th>
        <th>Peida/näita</th>
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
    echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
    echo "<td>$punktid</td>";
    echo "<td>$lisamisaeg</td>";
    echo "<td><a href='?punktNulliks=$id'>0 punkt</a></td>";
    echo "<td><a href='?kustutaKomment=$id'>Kustuta komment</a></td>";
    echo "<td><a href='?kustutaLaul=$id'>Kustuta laul</a></td>";
    $tekst = "Näita";
    $seisund="naita_id";
    $tekstlehel="Peidetud";
    if($avalik==1){
        $tekst = "Peida";
        $seisund="peida_id";
        $tekstlehel="Nähtav";
    }
    echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstlehel</td>";
    echo "</tr>";
}
?>
</table>



</body>
</html>
