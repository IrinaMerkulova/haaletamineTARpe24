<?php
require('conf.php');
global $yhendus;
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
        echo "</tr>";
    }
    ?>

</table>

</body>
</html>
