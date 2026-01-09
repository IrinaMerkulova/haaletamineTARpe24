<?php
require('conf.php');

// tabeli sisu kuvamise funktsioon

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
        echo "<td><img src='" . htmlspecialchars($pilt) . "' alt='albumi pilt'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
        echo "<td><a href='?eemalda1punkt=$id'>-1 punkt</a></td>";
        echo "<td><a href='?nulleeripunktid=$id'>Nulleeri Punktid</a></td>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
        echo "<td> </td>";
        echo "</tr>";
    }

}

function kuvaAdminVaade()
{
    global $yhendus;

    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, avalik
     FROM laulud"
    );
    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $avalik
    );
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td><img alt='albumi pilt' src='" . htmlspecialchars($pilt) . "'></td>";
        echo "<td>$punktid</td>";
        echo "<td><a href='?nulleeripunktid=$id'>Nulleeri punktid</a></td>";
        echo "<td><a href='?kustutakommentaarid=$id'>Kustuta kommentaarid</a></td>";
        echo "<td><a href='?kustuta=$id'>Eemalda laul</a></td>";
        echo "<td>$lisamisaeg</td>";


        $tekst = "Näita";
        $seisund = "naita_id";
        $tekstlehel = "Peidetud";
        if ($avalik == 1) {
            $tekst = "Peida";
            $seisund = "peida_id";
            $tekstlehel = "Nähtav";
        }
        echo "<td><a href='?$seisund=$id'>$tekst</a>";
        echo "<td>$tekstlehel</td>";
        echo "</tr>";
    }
}

// punkti lisamise funktsioon
function lisa1punkt($id)
{
    global $yhendus;
    /* +1 punkt */
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}

// laulu lisamine

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
}

// punktide nulleerimise funktsioon
function nulleeriPunktid($id)
{
    global $yhendus;
    /* +1 punkt */
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}

// punktide nulleerimise funktsioon
function kustuta($id)
{
    global $yhendus;
    /* +1 punkt */
    $paring = $yhendus->prepare(
        "DELETE FROM laulud WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}

function eemalda1punkt($id)
{
    global $yhendus;
    /* +1 punkt */
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid - 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}

// kommentaaride kustutamine
function kustutaKommentaarid($id)
{
    global $yhendus;
    /* +1 punkt */
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '' WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();

}

function lisaKommentaar($id)
{
    global $yhendus;

    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = CONCAT(kommentaarid, ' ', ?) WHERE id = ?"
    );

    $paring->bind_param('si',
        $_REQUEST['uus_kommentaar'],
        $_REQUEST['uus_kommentaar_id']
    );
    $paring->execute();
}