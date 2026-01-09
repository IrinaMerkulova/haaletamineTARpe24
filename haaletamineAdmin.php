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
        <th>Peida/Näita</th>
    </tr>

<?php
$paring = $yhendus->prepare(
    "SELECT id, lauluNimi, laulja, pilt, lisamisaeg, avalik
     FROM laulud
     "
);
$paring->bind_result(
    $id, $lauluNimi, $laulja, $pilt, $lisamisaeg, $avalik
);
$paring->execute();

while ($paring->fetch()) {
    echo "<tr>";
    echo "<td>$lisamisaeg</td>";
    echo "<td>" . htmlspecialchars($laulja) . "</td>";
    echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
    echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
    $tekst = "Näita";
    $seisund = "naita_id";
    $tekstLehel = "Peidetud";
    if ($avalik == 1) {
        $tekst = "Peida";
        $seisund = "peida_id";
        $tekstLehel = "Nähtav";
    }
    echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstLehel</td>";
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
