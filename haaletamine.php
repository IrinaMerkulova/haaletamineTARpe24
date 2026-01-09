<?php
require 'conf.php';
global $yhendus;

/* +1 punkt */
if (isset($_GET['lisa1punkt'])) {
    $stmt = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
    );
    $stmt->bind_param('i', $_GET['lisa1punkt']);
    $stmt->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* -1 punkt */
if (isset($_GET['vahenda1punkt'])) {
    $stmt = $yhendus->prepare(
        "UPDATE laulud SET punktid = GREATEST(punktid - 1, 0) WHERE id = ?"
    );
    $stmt->bind_param('i', $_GET['vahenda1punkt']);
    $stmt->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* Kommentaari lisamine */
if (isset($_POST['uus_kommentaar_id'], $_POST['uus_kommentaar'])) {
    $stmt = $yhendus->prepare(
        "UPDATE laulud 
         SET kommentaarid = CONCAT(IFNULL(kommentaarid,''), ?) 
         WHERE id = ?"
    );
    $kommentaar = $_POST['uus_kommentaar']."\n";
    $stmt->bind_param('si', $kommentaar, $_POST['uus_kommentaar_id']);
    $stmt->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* Uue laulu lisamine */
if (!empty($_POST['lauluNimi']) && !empty($_POST['laulja'])) {
    $stmt = $yhendus->prepare(
        "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
    );
    $stmt->bind_param(
        'sss',
        $_POST['lauluNimi'],
        $_POST['laulja'],
        $_POST['pilt']
    );
    $stmt->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Kasutaja – Laulude hääletus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>🎵 Laulude hääletus</h1>

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
        <th>Hääletus</th>
        <th>Kommentaarid</th>
        <th>Lisa kommentaar</th>
    </tr>

    <?php
    $stmt = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, kommentaarid
     FROM laulud
     WHERE avalik = 1"
    );
    $stmt->execute();
    $stmt->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $kommentaarid
    );

    while ($stmt->fetch()):
        ?>
        <tr>
            <td><?= htmlspecialchars($lauluNimi) ?></td>
            <td><?= htmlspecialchars($laulja) ?></td>
            <td><img src="<?= htmlspecialchars($pilt) ?>" alt="pilt"></td>
            <td><?= $punktid ?></td>
            <td>
                <a href="?lisa1punkt=<?= $id ?>">+1</a> |
                <a href="?vahenda1punkt=<?= $id ?>">−1</a>
            </td>
            <td><?= nl2br(htmlspecialchars($kommentaarid)) ?></td>
            <td>
                <form method="post" style="box-shadow:none;">
                    <input type="hidden" name="uus_kommentaar_id" value="<?= $id ?>">
                    <input type="text" name="uus_kommentaar">
                    <input type="submit" value="OK">
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Lisa uus laul</h2>

<form method="post">
    <label>Laulu nimi</label>
    <input type="text" name="lauluNimi">

    <label>Laulja</label>
    <input type="text" name="laulja">

    <label>Pildi URL</label>
    <textarea name="pilt"></textarea>

    <input type="submit" value="Lisa laul">
</form>

</body>
</html>
