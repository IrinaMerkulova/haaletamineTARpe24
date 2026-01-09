<?php
require('funktsioonid.php');
//funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt']))
{
    lisa1punkt($_REQUEST['lisa1punkt']);
    header('Location: '.$_SERVER['PHP_SELF']);
    exit();
}

//laulu lisamise funktsiooni kutsumine
if (
    isset($_REQUEST['lauluNimi'], $_REQUEST['laulja']) &&
    !empty($_REQUEST['lauluNimi']) &&
    !empty($_REQUEST['laulja'])
)
{
    lisaLaul($_REQUEST['lauluNimi'], $_REQUEST['laulja'], $_REQUEST['pilt']);
}

//laulu kustutamise funktsiooni kutsumine
if (isset($_REQUEST['kustutaLaul']))
{
    kustutaLaul($_REQUEST['kustutaLaul']);
}

//punktide eemaldamise funktsiooni kutsumine
if (isset($_REQUEST['eemaldaPunktid']))
{
    eemaldaPunktid($_REQUEST['eemaldaPunktid']);
}

//eemalda 1 punkti funktsiooni kutsumine
if (isset($_REQUEST['lahuta1punkt']))
{
    lahuta1Punkt($_REQUEST['lahuta1punkt']);
}

// peida laul
if (isset($_REQUEST['peida_id']))
{
    peidaLaul($_REQUEST['peida_id']);
}

// näita laulu
if (isset($_REQUEST['naita_id']))
{
    naitaLaul($_REQUEST['naita_id']);
}

//kustuta kommentaar
if (isset($_REQUEST['kustutakommentaarid']))
{
    kustutaKommentaarid($_REQUEST['kustutakommentaarid']);
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>🎵 Laulude hääletus (funktsioonid eraldi .php failis)</h1>
<nav>
    <ul>
        <li><a href="haaletamineFunktsioonidega.php">Kasutaja leht</a></li>
        <li><a href="haaletamineFunktsioonidegaAdmin.php">Admin leht</a></li>
    </ul>
</nav>
<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>Kustuta laul</th>
        <th>Kommentaarid</th>
        <th>Kustuta kommentaarid</th>
        <th>Peida/näita</th>
        <th>Eemalda punktid</th>
    </tr>
    <?php
    kuvaTabeliLauludAdmin();
    ?>
</table>
</body>
</html>
