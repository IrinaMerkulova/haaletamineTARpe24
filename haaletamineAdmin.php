<?php
require ('funktsioonid.php');
global $yhendus;

/* laulu peitmine */
if (isset($_REQUEST['peida_id'])) {
    lauluPeitmine();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* 0 punkt */
if (isset($_REQUEST['nullidaPunktid'])) {
    nullidaPunktid();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* laulu näitamine */
if (isset($_REQUEST['naita_id'])) {
    lauluNäitamine();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* Kommentaaride kustutamine */
if (isset($_REQUEST['Kustuta'])) {
    kommentaarideKustutamine();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
/* Laulude kustutamine */
if (isset($_REQUEST['KustutaLaul'])) {
    lauludeKustutamine();
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
        <th>Punktid</th>
        <th>Kommentaarid</th>
        <th>Nullida punktid</th>
        <th>Kustuta kommentaarid</th>
        <th>Peida/Näita</th>
        <th>Kustuta laul</th>
    </tr>

<?php
tabeliKuvamineAdmin();
?>
</table>

</body>
</html>
