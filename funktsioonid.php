<?php
require ('conf.php');
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
        echo "<td><img src='" . htmlspecialchars($pilt) . "' alt='pilt'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td><a href='?lisa1Punkt=$id'>+1 punkt</a></td>";
        echo "<td><a href='?punktidNull=$id'>Punktid null</a></td>";
        echo "<td><a href='?lauluKustutamine=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
}

function lisa1Punkt($id){
    global $yhendus;
        $paring = $yhendus->prepare(
            "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
        );
        $paring->bind_param('i', $id);
        $paring->execute();

}

//kustutamine
function lauluKustutamine($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "DELETE FROM laulud WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}

//laululisamine
function lauluLisamine($lauluNimi, $laulja, $pilt){
    global $yhendus;
        $paring = $yhendus->prepare(
            "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
        );
        $paring->bind_param(
            'sss', $lauluNimi, $laulja, $pilt);
        $paring->execute();

}

function punktidNull($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}