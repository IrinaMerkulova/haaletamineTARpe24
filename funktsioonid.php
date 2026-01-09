<?php
require('conf.php');
//tabeli sisu kuvamise funktsioon

function kuvaTabelidLaulud()
{
    global $yhendus;

    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg,avalik FROM laulud ");


    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $avalik
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
        $tekst = "Näita";
        $seisund = "naita_id";
        $tekstlehel = "Peidetud";
        if ($avalik == 1) {
            $tekst = "Peida";
            $seisund = "peida_id";
            $tekstlehel = "Nähtav";
            echo "<td><a href='?$seisund=$id'>$tekst</a> | $tekstlehel</td>";
            echo "</tr>";
        }
    }


    function lisa1punkt($id)
    {
        global $yhendus;


        $paring = $yhendus->prepare(
            "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
        );
        $paring->bind_param('i', $id);
        $paring->execute();
    }

    /* Laulu lisamine */
    function laululisamine($lauluNimi, $laulja, $pilt)
    {
        global $yhendus;
        $paring = $yhendus->prepare(
            "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
        );
        $paring->bind_param('sss', $lauluNimi, $laulja, $pilt);

        $paring->execute();
    }

    function lauluKustutamine($id)
    {
        global $yhendus;
        $paring = $yhendus->prepare(
            "DELETE FROM laulud WHERE id = ?"
        );
        $paring->bind_param('i', $id);

        $paring->execute();
    }
}