<?php
require('conf.php');
function kuvaTabeliLaulud(){
    global $yhendus;

    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, avalik, lisamisaeg, kommentaarid
     FROM laulud"
    );
    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $avalik, $lisamisaeg, $kommentaarid
    );
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td><a href='?nullpunkt=$id'>uuenda</a></td>";
        echo "<td><a href='?kustutalaul=$id'>kustuta laul</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td><a href='?kustutakommentaar=$id'>kustuta kommentaar</a></td>";
        $tekst = "Näita";
        $seisund = "naita_id";
        $tekstlehel="peidetud";
        if ($avalik == 1) {
            $tekst = "Peida";
            $seisund = "peida_id";
            $tekstlehel="nähtav";
        }
        echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstlehel</td>";
    }
}
//funktsioonid
//kustutamine
function lauluKustutamine($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "DELETE FROM laulud WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
//nullimine
function nullpunkt($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
//peida/naita
function peidaLaul($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
function naitaLaul($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
//kommentaarid kustutamine
function kustutaKommentaar($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '' WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}