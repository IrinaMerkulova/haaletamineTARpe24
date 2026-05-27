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

if (isset($_GET['kustuta_kom'])) {
    $paring = $yhendus->prepare("DELETE FROM kommentaarid WHERE id = ?");
    $paring->bind_param("i", $_GET['kustuta_kom']);
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

<?php
$paring = $yhendus->prepare("SELECT id, lauluNimi, laulja, punktid, avalik FROM laulud");
$paring->execute();
$paring->bind_result($id, $lauluNimi, $laulja, $punktid, $avalik);

while ($paring->fetch()) {
    echo "<h2>" . htmlspecialchars($lauluNimi) . "</h2>";
    echo "<p>$laulja | Punktid: $punktid</p>";

    if ($avalik == 1) {
        echo "<a href='?peida=$id'>Peida</a><br>";
    } else {
        echo "<a href='?naita=$id'>Näita</a><br>";
    }

    echo "<h3>Kommentaarid</h3>";

    $kom = $yhendus->prepare("SELECT id, kommentaar FROM kommentaarid WHERE laul_id = ?");
    $kom->bind_param("i", $id);
    $kom->execute();
    $kom->bind_result($komId, $tekst);

    while ($kom->fetch()) {
        echo htmlspecialchars($tekst);
        echo " <a href='?kustuta_kom=$komId'>Kustuta</a><br>";
    }

    echo "<hr>";
}
?>

</body>
</html>