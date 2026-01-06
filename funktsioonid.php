<?php
require ('conf.php');
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
        echo "<td><img src='" . htmlspecialchars($pilt) . "'alt='pilt'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
        echo "<td><a href='?kustuta=$id'>kustuta</a></td>";
        echo "<td><a href='?eemalda1puntk=$id'>-1 punkt</a></td>";
        echo "<td><a href='?nullpunkt=$id'>0 punkt</a></td>";


        echo "</tr>";
    }
    if (isset($_REQUEST['lisa1punkt'])) {
        $paring = $yhendus->prepare(
            "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
        );
        $paring->bind_param('i', $_REQUEST['lisa1punkt']);
        $paring->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    if (isset($_REQUEST['eemalda1puntk'])) {
        $paring = $yhendus->prepare(
            "UPDATE laulud SET punktid = punktid - 1 WHERE id = ?"
        );
        $paring->bind_param('i', $_REQUEST['lisa1punkt']);
        $paring->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

}
//punkti lisamise funktsioon
function lisa1puntk($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "Update laulud SET punktid = punktid + 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
//laulu kustutamine
function laulukustutamine($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "DELETE From laulud Where id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
    }
//laulu lisamine
    function laululisamine($laulunimi, $laulja, $pilt)
    {
        global $yhendus;
        $paring = $yhendus->prepare(
            "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
        );
        $paring->bind_param(
            'sss', $laulunimi, $laulja, $pilt);

        $paring->execute();

}
//punktid eemaladime
function eemalda1puntk($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "Update laulud SET punktid = punktid -1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}
function nullpunkt($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "Update laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}







