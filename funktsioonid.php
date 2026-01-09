<?php
require('conf.php');

/* Tabeli kuvamine */
function tabeliKuvamine()
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg, avalik, kommentaarid
     FROM laulud
     WHERE avalik = 1"
    );
    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg, $avalik, $kommentaarid
    );
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>$lisamisaeg</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
        echo "<td>$punktid</td>";
        echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
        echo "<td><a href='?kustuta1punkt=$id'>-1 punkt</a></td>";
        echo "<td>" . nl2br(htmlspecialchars($kommentaarid)) . "</td>";
        echo "<td>
<form action='?' method='post'>
<input type='hidden' name='uus_kommentaar_id' value='$id'>
<input type='text' name='uus_kommentaar' id='uus_kommentaar'>
<input type='submit' value='Ok'>
</form>
</td>";
        echo "</tr>";

    }
}

function lisa1punkt($id) {
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid + 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

/* -1 punkt */
function kustuta1punkt() {
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid - 1 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['kustuta1punkt']);
    $paring->execute();
}

/* Uue kommentaari lisamine */
function uusKommentaar() {
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?"
    );
    $komment2 = $_REQUEST['uus_kommentaar']."\n";
    $paring->bind_param('si', $komment2, $_REQUEST['uus_kommentaar_id']);
    $paring->execute();
}

/* Laulu lisamine */
function lauluLisamine($lauluNimi, $laulja, $pilt) {
    global $yhendus;
    $paring = $yhendus->prepare(
        "INSERT INTO laulud (lauluNimi, laulja, pilt, avalik, lisamisaeg)
         VALUES (?, ?, ?, 1, NOW())"
    );
    $paring->bind_param(
        'sss', $lauluNimi, $laulja, $pilt
    );
    $paring->execute();
}

/* Admin */
/* Laulu peitmine */
function lauluPeitmine() {
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['peida_id']);
    $paring->execute();
}

/* Laulu näitamine */
function lauluNäitamine()
{
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 1 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['naita_id']);
    $paring->execute();
}

/* Nullida punkti */
function nullidaPunktid() {
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['nullidaPunktid']);
    $paring->execute();
}

/* Kommentaaride kustutamine */
function kommentaarideKustutamine() {
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '' where id = ? "
    );
    $paring->bind_param('i', $_REQUEST['Kustuta']);
    $paring->execute();
}

/* Laulude kustutamine */
function lauludeKustutamine() {
    global $yhendus;
    $paring = $yhendus->prepare(
        "DELETE from laulud where id = ? "
    );
    $paring->bind_param('i', $_REQUEST['KustutaLaul']);
    $paring->execute();
}


