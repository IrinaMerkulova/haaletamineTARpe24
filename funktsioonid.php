<?php
require('conf.php');
//tabeli sisu kuvamise funktsioon
function kuvaTabeliLauludKasutaja()
{
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
        echo "<td><img src='" . htmlspecialchars($pilt) . "' alt='pilt'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
        echo "<td><a href='?lahuta1punkt=$id'>-1 punkt</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
            <form action='?' method='post'>
            <input type='hidden' name='uus_kommentaar_id' value='$id'>
            <input type='text' name='uus_kommentaar' id='uus_kommentaar'>
            <input type='submit' value='OK'>
            </form></td>";
        echo "</tr>";
    }
}

function kuvaTabeliLauludAdmin()
{
    global $yhendus;

    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, kommentaarid, avalik
         FROM laulud"
    );
    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $kommentaarid, $avalik
    );
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td><img src='" . htmlspecialchars($pilt) . "' alt='pilt'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td><a href='?kustutaid=$id'>Kustuta</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td><a href='?kustutakommentaarid=$id'>Kustuta kommentaarid</a></td>";
        $tekst = "Näita";
        $seisund = "naita_id";
        $tekstlehel = "Peidetud";
        if ($avalik == 1) {
            $tekst = "Peida";
            $seisund = "peida_id";
            $tekstlehel = "Nähtav";
        }
        echo "<td><a href='?$seisund=$id'>$tekst</a> | $tekstlehel</td>";
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

function lahuta1Punkt($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid - 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
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

function peidaLaul($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['peida_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function naitaLaul($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 1 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['naita_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function kustutaKommentaarid($id)
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