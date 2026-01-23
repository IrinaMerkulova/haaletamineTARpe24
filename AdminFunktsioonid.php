<?php
require('conf.php');
//tabeli sisu kuvamise funktsioon

function AdminkuvaTabeliLaulud()
{

    global $yhendus;

    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg
     FROM laulud
     WHERE avalik = 0 OR 1"
    );
    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg
    );
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>"  . htmlspecialchars($lauluNimi) .  "</td>";
        echo "<td>"  . htmlspecialchars($laulja) .  "</td>";
        echo "<td><img src='"  . htmlspecialchars($pilt) .  "'alt='pilt'></td>";
        echo "<td> $punktid </td>";
        echo "<td> $lisamisaeg </td>";
        echo "<td><a href='?nullipunktid=$id'> Nulli punktid </a></td>";
        echo "<td><a href='?kustuta=$id'> Eemalda </a></td>";
        echo "<td><a href='?peida=$id'> Peida </a></td>";
        echo "<td><a href='?naita=$id'> Näita </a></td>";
        echo "</tr>";


    }
}

function eemaldaLaul($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "delete from laulud WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
function nullipunktid($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
function peida($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
function naita($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}