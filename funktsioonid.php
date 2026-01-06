<?php
require ('conf.php');

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
        echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
        echo "<td><a href='?nullpunkt=$id'>Null Punkt</a></td>";
        echo "<td><a href='?delete=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
}
// punkti lisamise funktsioon
function lisa1punkt($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

function nullpunkt($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

function delete($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "DELETE FROM laulud WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

// laulu lisamine
function lauluLisamine($lauluNimi, $laulja, $pilt){
    global $yhendus;

        $paring = $yhendus->prepare(
            "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
        );
        $paring->bind_param(
            'sss',$lauluNimi,$laulja,$pilt
        );
        $paring->execute();
}

