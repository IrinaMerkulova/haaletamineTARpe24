<?php
require('conf.php');
require ('funktsioonid.php');
global $yhendus;



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
if(isset($_REQUEST['deletekomment'])){
    deletekomment($_REQUEST['deletekomment']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

IF(isset($_REQUEST['delete'])){
    delete($_REQUEST['delete']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if(isset($_REQUEST['teePunkt0']))
{
    teePunkt0($_REQUEST['teePunkt0']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <link rel="stylesheet" href="haaleCSS.css">
    
</head>
<body>

<h1>🎵 Laulude hääletus ADMIN (funktsioonid eraldi)</h1>
<nav>
    <ul>
        <li><a href="haaletamineFunktsioonidega.php">Kasutaja leht</a></li>
        <li><a href="haaletamineAdmin.php">Admin leht</a></li>
    </ul>
</nav>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>Kommentaarid</th>
        <th>Peida/Näida</th>
    </tr>

<?php
kuvaTabelidLauludAdmin();
?>
</table>



</body>
</html>
