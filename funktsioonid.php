<?php
require ('conf.php');

function kuvaTabeliLauludTava(){
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
        echo "<td><a href='?miinus1punkt=$id'>-1 punkt</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
        <form action='?' method='post' id='kommentaarform'>
            <input type='hidden' name='uus_kommentaar_id' value='$id'>
            <input type='text' name='uus_kommentaar' id='uus_kommentaar'>
            <input type='submit' value='OK'>
        </form>
    </td>";
        echo "</tr>";
    }
}

function kuvaTabeliLauludAdmin(){
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
        echo "<td><img src='" . htmlspecialchars($pilt) . "' alt='pilt'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        $tekst="Näita";
        $seisund="naita_id";
        $tekstlehel="Peidetud";
        if($avalik==1){
            $tekst="Peida";
            $seisund="peida_id";
            $tekstlehel="Nähtav";
        }
        echo "<td><a href='?$seisund=$id'>$tekst</a> ||| $tekstlehel</td>";
        echo "<td><a href='?nullpunkt=$id'>Null Punkt</a></td>";
        echo "<td><a href='?deletekomment=$id'>Kustuta Kommentaar</a></td>";
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

function miinus1punkt($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid - 1 WHERE id = ?"
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

// peitmine ja näitamine
function peida_id($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 0 WHERE id = ?"
    );
    $paring->bind_param('i', $_REQUEST['peida_id']);
    $paring->execute();
}

function naita_id($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET avalik = 1 WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

// kommentaari tegemine

function kommentaariLisamine(){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = CONCAT(kommentaarid,?) WHERE id = ?"
    );
    $komment2=$_REQUEST['uus_kommentaar']."\n";
    $paring->bind_param('si', $komment2,$_REQUEST['uus_kommentaar_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}