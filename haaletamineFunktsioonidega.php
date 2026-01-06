<?php
require('funktsioonid.php');
//funktsiooni kutsumine
if(isset($_REQUEST['lisa1punkt'])){
    lisa1punkt($_REQUEST['lisa1punkt']);
    header("Location: ". $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>

</head>
<body>

<h1>🎵 Laulude hääletus (funktsioonid on eraldi php failides)</h1>

<table>
    <tr>
        <th>Laulu nimi</th>
        <th>Laulja</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
    </tr>
    <?php
    kuvaTabeliLaulud();

    ?>
</table>
</body>
</html>
