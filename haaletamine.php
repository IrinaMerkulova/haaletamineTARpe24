<?php
require('funktsioonid.php');
global $yhendus;

// laulu kustutamine
if(!empty($_REQUEST['kustuta'])){
    lauluKustutamine($_REQUEST['kustuta']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}
// punkti lisamine
if(isset($_REQUEST['lisa1punkt'])){
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}
//punkti eemaldamine
if(isset($_REQUEST['eemalda1punkt'])) {
    eemalda1punkt($_REQUEST['eemalda1punkt']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}
//laulu lisamine
    if (
        isset($_REQUEST['lauluNimi'], $_REQUEST['laulja']) &&
        !empty($_REQUEST['lauluNimi']) &&
        !empty($_REQUEST['laulja'])
    ) {
        lauluLisamine($_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    //nullimne
if(isset($_REQUEST['nullpunkt'])) {
    nullpunkt($_REQUEST['nullpunkt']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}
// kommentaari lisamine
if(isset($_REQUEST['kommentaariLisamine'])) {
    kommentaariLisamine($_REQUEST['kommentaariLisamine']);
    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}
if (isset($_REQUEST['uus_kommentaar_id'])) {
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?"
    );
    $kommentaar = $_REQUEST['uus_kommentaar'] . "\n";
    $paring->bind_param('si', $kommentaar, $_REQUEST['uus_kommentaar_id']);
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
    <link rel="stylesheet" href="haaletamineStyle.css">
    <nav>
        <ul>
            <li><a href="haaletamine.php">Kasutaja leht</a></li>
            <li><a href="adminHaaletamine.php">Admin leht</a></li>
        </ul>
    </nav>
</head>
<body>

<h1>🎵 Laulude hääletus</h1>
<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>kommentaar</th>
        <th>lisa kommentaar</th>
    </tr>
<?php
kuvaTabelilaulud();
?>
</table>

<h2>Lisa uus laul</h2>
<form action="?" method="post">
    <label>Laulu nimi:</label><br>
    <input type="text" name="lauluNimi"><br><br>

    <label>Laulja:</label><br>
    <input type="text" name="laulja"><br><br>

    <input type="submit" value="Lisa laul">
</form>