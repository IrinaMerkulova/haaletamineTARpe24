<?php
require('conf.php');
//tabeli sisu kuvamise funktsioon
function kuvaTabeliLaulud()
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
        echo "<td><a href='?kustutaLaul=$id'>Kustuta</a></td>";
        echo "<td><a href='?eemaldaPunktid=$id'>Eemalda punktid</a></td>";
        echo "</tr>";
    }
}

//punkti lisamine funktsioon
function lisa1Punkt($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

//laulu lisamine
function lisaLaul($lauluNimi, $laulja, $pilt)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
    );
    $paring->bind_param(
        'sss',
        $lauluNimi,
        $laulja,
        $pilt
    );
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function kustutaLaul($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "DELETE FROM laulud WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function eemaldaPunktid($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
