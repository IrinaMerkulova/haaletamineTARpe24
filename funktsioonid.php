<?php
require('conf.php');
//tabeli sisu kuvamise funktsioon

function kuvaTabeliLaulud(){
    global $yhendus;

    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, kommentaarid
     FROM laulud
     WHERE avalik = 1"
    );
    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $kommentaarid
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
        echo "<td><a href='?eemalda1punkt=$id'>-1 punkt</a></td>";
        echo "<td><a href='?kustuta=$id'>kustuta</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
    <form action='?' method='post'>
        <input type='hidden' name='uus_kommentaar_id' value='$id'>
        <input type='text' name='uus_kommentaar' id='uus_kommentaar'>
        <input type='submit' value='OK'>
    </form>
    </td>";
        echo "</tr>";
    }
}

//punkti lisamine funktsioon
function lisa1punkt($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

//punkti eemaldamise funktsioon
function eemalda1punkt($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid - 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}


//punktid nulli funktsioon
function nullpunkt($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}



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

/* Laulu lisamine */
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

function lisaKommentaar($kommentaar, $kommentaar_id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?"
    );
    $uusKommentaar = $kommentaar . "\n";
    $paring->bind_param('si', $uusKommentaar, $kommentaar_id);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

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