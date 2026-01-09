<?php
require('conf.php');
//tabeli sisu kuvamise funktsioon

function kuvaTabeliLaulud(){
    global $yhendus;

    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, avalik, lisamisaeg, kommentaarid
     FROM laulud
     WHERE avalik = 1"
    );
    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $avalik, $lisamisaeg, $kommentaarid
    );
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td><a>puudub</a></td>";
        echo "<td><a>puudub</a></td>";
        echo "<td><a href='?nullpunkt=$id'>uuenda</a></td>";
        echo "<td><a href='?kustuta=$id'>kustuta</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";

        echo "<td>
    <form action='?' method='post'>
        <input type='hidden' name='uus_kommentaar_id' value='$id'>
        <input type='text' name='uus_kommentaar' id='uus_kommentaar'>
        <input type='submit' value='OK'>
    </form>
    </td>";
        $tekst = "Näita";
        $seisund = "naita_id";
        $tekstlehel="peidetud";
        if ($avalik == 1) {
            $tekst = "Peida";
            $seisund = "peida_id";
            $tekstlehel="nähtav";
        }
        echo "<td><a href='?seisund=$id'>$tekst</a> ||| $tekstlehel</td>";
        echo "</tr>";
    }
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

//kutsume punktid0 funktsiooni
function nullpunkt($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
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








