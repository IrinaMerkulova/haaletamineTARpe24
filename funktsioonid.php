<?php
require('conf.php');
//tabeli sisu kuvamise funktsioon

function kuvaTabeliLaulud(){
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
    echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
    echo "<td>$punktid</td>";
    echo "<td>$lisamisaeg</td>";
    echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
    echo "<td><a href='?kustuta1punkt=$id'>-1 punkt</a></td>";
    echo "<td><a href='?kustuta=$id'>kustuta</a></td>";
    echo "<td><a href='?kustutaKoikPunktid=$id'>Kustuta Kõik punktid</a></td>";
    echo "</tr>";
}
}
//punkti lisamise funktsioon
function lisa1punkt($id){
    global $yhendus;
        $paring = $yhendus->prepare(
            "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
        );
        $paring->bind_param('i', $id);
        $paring->execute();

}

function lisaLaul($lauluNimi, $laulja, $pilt){
    global $yhendus;
        $paring = $yhendus->prepare(
            "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
        );
        $paring->bind_param(
            'sss', $lauluNimi, $laulja, $pilt);
        $paring->execute();

}


function kustuta1punkt($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid - 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}
//lulu kustutamine
function lauluKustutamine($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "DELETE FROM laulud WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}
function kustutaKoikPunktid($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}