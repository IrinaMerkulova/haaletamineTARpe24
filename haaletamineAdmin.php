<?php
require('AdminFunktsioonid.php');
if(isset($_REQUEST['kustuta'])){
    eemaldaLaul($_REQUEST['kustuta']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['nullipunktid'])){
    nullipunktid($_REQUEST['nullipunktid']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_REQUEST['peida'])){
    peida($_REQUEST['peida']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['naita'])){
    naita($_REQUEST['naita']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <link rel="stylesheet" href="StyleHaal.css">
    <meta charset="UTF-8">
    <title>Laulude leht</title>

</head>
<body>

<h1>Laulude hääletuse tume turg //////</h1>

<table>
    <tr>
        <th>/ Laulu nimi /</th>
        <th>/ Laulja /</th>
        <th>/ Pilt /</th>
        <th>/ Punktid /</th>
        <th>/ Lisamisaeg /</th>
        <th>/ Nulli punktid /</th>
        <th>/ Valikud /</th>
        <th>/ Avalikus /</th>
    </tr>
    <?php
    AdminkuvaTabeliLaulud();
    ?>
</table>
</body>
<div class="binary-wrap">
    <div class="binary-line">1010101010101010010101010101010101010101010101010101010101010101</div>
    <div class="binary-line">0101010101010101101010101010101010101010101010101010101010101010</div>
    <div class="binary-line">1010010101010101010101010101010101010101010101010101010101010101</div>
    <div class="binary-line">0101011010101010101010101010101010101010101010101010101010101010</div>
    <div class="binary-line">1010101010100101010101010101010101010101010101010101010101010101</div>
</div>
</html>