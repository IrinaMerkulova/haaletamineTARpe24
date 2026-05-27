<?php
require('conf.php');
global $yhendus;

if (isset($_GET['peida'])) {
    $paring = $yhendus->prepare("UPDATE laulud SET avalik = 0 WHERE id = ?");
    $paring->bind_param("i", $_GET['peida']);
    $paring->execute();
    header("Location: haaletamineAdmin.php");
    exit;
}

if (isset($_GET['naita'])) {
    $paring = $yhendus->prepare("UPDATE laulud SET avalik = 1 WHERE id = ?");
    $paring->bind_param("i", $_GET['naita']);
    $paring->execute();
    header("Location: haaletamineAdmin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
</head>
<body>

<h1>Admin leht</h1>
<a href="haaletamine.php">Tagasi kasutaja lehele</a>

<table border="1">
    <tr>
        <th>Laul</th>
        <th>Laulja</th>
        <th>Punktid</th>
        <th>Avalik</th>
        <th>Tegevus</th>
    </tr>

    <?php
    $paring = $yhendus->prepare("SELECT id, lauluNimi, laulja, punktid, avalik FROM laulud");
    $paring->execute();
    $paring->bind_result($id, $lauluNimi, $laulja, $punktid, $avalik);

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td>$punktid</td>";
        echo "<td>$avalik</td>";
        echo "<td>";

        if ($avalik == 1) {
            echo "<a href='?peida=$id'>Peida</a>";
        } else {
            echo "<a href='?naita=$id'>Näita</a>";
        }

        echo "</td>";
        echo "</tr>";
    }
    ?>

</table>

</body>
</html>
