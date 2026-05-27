<?php
require('conf.php');
global $yhendus;

if (isset($_GET['lisa1punkt'])) {
    $paring = $yhendus->prepare("UPDATE laulud SET punktid = punktid + 1 WHERE id = ?");
    $paring->bind_param("i", $_GET['lisa1punkt']);
    $paring->execute();
    header("Location: haaletamine.php");
    exit;
}

if (isset($_GET['miinus1punkt'])) {
    $paring = $yhendus->prepare("UPDATE laulud SET punktid = punktid - 1 WHERE id = ?");
    $paring->bind_param("i", $_GET['miinus1punkt']);
    $paring->execute();
    header("Location: haaletamine.php");
    exit;
}

if (!empty($_POST['kommentaar']) && isset($_POST['laul_id'])) {
    $paring = $yhendus->prepare("INSERT INTO kommentaarid (laul_id, kommentaar) VALUES (?, ?)");
    $paring->bind_param("is", $_POST['laul_id'], $_POST['kommentaar']);
    $paring->execute();
    header("Location: haaletamine.php");
    exit;
}

if (!empty($_POST['lauluNimi']) && !empty($_POST['laulja'])) {
    $paring = $yhendus->prepare(
            "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
    );
    $paring->bind_param("sss", $_POST['lauluNimi'], $_POST['laulja'], $_POST['pilt']);
    $paring->execute();
    header("Location: haaletamine.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hääletamine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Laulude hääletus</h1>

<table border="1">
    <tr>
        <th>Laul</th>
        <th>Laulja</th>
        <th>Punktid</th>
        <th>Hääleta</th>
        <th>Kommentaarid</th>
    </tr>

    <?php
    $paring = $yhendus->prepare("SELECT id, lauluNimi, laulja, punktid FROM laulud WHERE avalik = 1");
    $paring->execute();
    $paring->bind_result($id, $lauluNimi, $laulja, $punktid);

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td>$punktid</td>";
        echo "<td>
            <a href='?lisa1punkt=$id'>+1</a>
            <a href='?miinus1punkt=$id'>-1</a>
          </td>";

        echo "<td>";

        $kom = $yhendus->prepare("SELECT kommentaar FROM kommentaarid WHERE laul_id = ?");
        $kom->bind_param("i", $id);
        $kom->execute();
        $kom->bind_result($tekst);

        while ($kom->fetch()) {
            echo htmlspecialchars($tekst) . "<br>";
        }

        echo "<form method='post'>
            <input type='hidden' name='laul_id' value='$id'>
            <input type='text' name='kommentaar' placeholder='Lisa kommentaar'>
            <button type='submit'>Lisa</button>
          </form>";

        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

<h2>Lisa uus laul</h2>
<form method="post">
    <input type="text" name="lauluNimi" placeholder="Laulu nimi">
    <input type="text" name="laulja" placeholder="Laulja">
    <textarea name="pilt"></textarea>
    <button type="submit">Lisa</button>
</form>

</body>
</html>