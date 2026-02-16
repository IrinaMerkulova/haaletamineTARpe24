<?php
require("conf.php");
//tabeli sisu kuvamise funktsioon

function kuvaTabeliLauld()
{
    global $yhendus;

$paring = $yhendus->prepare(
    "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg
     FROM laulud
     WHERE avalik = 1"
);
$paring->bind_result(
    $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg
);
$paring->execute();

while ($paring->fetch()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
    echo "<td>" . htmlspecialchars($laulja) . "</td>";
    echo "<td><img src='" . htmlspecialchars($pilt) . "' alt='pilt'></td>";
    echo "<td>$punktid</td>";
    echo "<td>$lisamisaeg</td>";
    echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
    echo "<td><a href='?vota1punkt=$id'>-1 punkt</a></td>";
    echo "<td><a href='?kustuta=$id'>kustuta</a></td>";
    echo "<td><a href='?nullid=$id'>Nulli punktid</a></td>";

    echo "</tr>";
}
}

function lisa1punkt($id){
    global $yhendus;
   {
        $paring = $yhendus->prepare(
            "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
        );
        $paring->bind_param('i', $id);
        $paring->execute();

    }
}
function vota1punkt($id){
    global $yhendus;
    {
        $paring = $yhendus->prepare(
            "UPDATE laulud SET punktid = punktid - 1 WHERE id = ?"
        );
        $paring->bind_param('i', $id);
        $paring->execute();

    }
}
/* Laulu lisamine */
function lauluLisamine($lauluNimi, $laulja, $pilt){
    global $yhendus;
    $paring = $yhendus->prepare(
        "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
    );
    $paring->bind_param(
        'sss',$lauluNimi, $laulja, $pilt

    );
    $paring->execute();

}
function laulukustutamine($id){
    global $yhendus;
    {
        $paring = $yhendus->prepare(
            "DELETE FROM laulud WHERE id = ?"
        );
        $paring->bind_param('i', $id);
        $paring->execute();

    }
}
function nullipunktid($id){
    global $yhendus;
    {
        $paring = $yhendus->prepare(
            "UPDATE laulud SET punktid = punktid = 0 WHERE id = ?"
        );
        $paring->bind_param('i', $id);
        $paring->execute();

    }
}