<?php
require 'conf.php';
global $yhendus;

/* Näita / peida */
if (isset($_GET['peida_id']) || isset($_GET['naita_id'])) {
    $id = isset($_GET['peida_id']) ? $_GET['peida_id'] : $_GET['naita_id'];
    $avalik = isset($_GET['naita_id']) ? 1 : 0;

    $stmt = $yhendus->prepare(
        "UPDATE laulud SET avalik = ? WHERE id = ?"
    );
    $stmt->bind_param('ii', $avalik, $id);
    $stmt->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* Nulli punktid */
if (isset($_GET['nullipunkt'])) {
    $stmt = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $stmt->bind_param('i', $_GET['nullipunkt']);
    $stmt->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* Kustuta kommentaarid */
if (isset($_GET['kustuta_kommentaarid'])) {
    $stmt = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '' WHERE id = ?"
    );
    $stmt->bind_param('i', $_GET['kustuta_kommentaarid']);
    $stmt->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* Kustuta laul */
if (isset($_GET['kustuta_id'])) {
    $stmt = $yhendus->prepare(
        "DELETE FROM laulud WHERE id = ?"
    );
    $stmt->bind_param('i', $_GET['kustuta_id']);
    $stmt->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Admin – Laulude haldus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>🎵 Admin – Laulude haldus</h1>

<nav>
    <ul>
        <li><a href="haaletamine.php">Kasutaja Leht</a></li>
        <li><a href="haaletamineAdmin.php">Admin Leht</a></li>
    </ul>
</nav>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Staatus</th>
        <th>Tegevused</th>
    </tr>

    <?php
    $stmt = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, avalik
     FROM laulud"
    );
    $stmt->execute();
    $stmt->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $avalik
    );

    while ($stmt->fetch()):
        ?>
        <tr>
            <td><?= htmlspecialchars($lauluNimi) ?></td>
            <td><?= htmlspecialchars($laulja) ?></td>
            <td><img src="<?= htmlspecialchars($pilt) ?>" alt="pilt"></td>
            <td><?= $punktid ?></td>
            <td><?= $avalik ? 'Nähtav' : 'Peidetud' ?></td>
            <td>
                <a href="?nullipunkt=<?= $id ?>">Nulli punktid</a> |
                <a href="?kustuta_kommentaarid=<?= $id ?>"
                   onclick="return confirm('Kustutada kõik kommentaarid?')">
                    Kustuta kommentaarid
                </a> |
                <a href="?kustuta_id=<?= $id ?>"
                   onclick="return confirm('Kustutada laul?')">
                    Kustuta laul
                </a> |
                <a href="?<?= $avalik ? 'peida_id' : 'naita_id' ?>=<?= $id ?>">
                    <?= $avalik ? 'Peida' : 'Näita' ?>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
