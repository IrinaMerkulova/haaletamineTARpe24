<?php
require('conf.php');
//tabeli sisu kuvamise funktsioon

function kuvaTabelidLaulud()
{
    global $yhendus;

    $paring = $yhendus->prepare(
        "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg,kommentaarid,avalik FROM laulud WHERE avalik= 1 ");


    $paring->bind_result(
        $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg,$kommentaarid, $avalik
    );
    $paring->execute();
    $paring->store_result();


    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
        echo "<td>" . htmlspecialchars($laulja) . "</td>";
        echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
        echo "<td><a href='?eemalda1punkt=$id'>-1 punkt</a></td>";
        echo "<td>
        <form action='?' method='post' id='kommentaarform'>
            <input type='hidden' name='uus_kommentaar_id' value='$id'>
            <input type='text' name='uus_kommentaar' id='uus_kommentaar'>
            <input type='submit' value='OK'>
        </form>
      
    </td>";
        echo "<td>$kommentaarid</td>";

    
            
    }
}

    function kuvaTabelidLauludAdmin()
    {
        global $yhendus;

        $paring = $yhendus->prepare(
            "SELECT id, lauluNimi, laulja, pilt, punktid, lisamisaeg,kommentaarid,avalik FROM laulud ");


        $paring->bind_result(
            $id, $lauluNimi, $laulja, $pilt, $punktid, $lisamisaeg,$kommentaarid, $avalik
        );
        $paring->execute();

        while ($paring->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($lauluNimi) . "</td>";
            echo "<td>" . htmlspecialchars($laulja) . "</td>";
            echo "<td><img src='" . htmlspecialchars($pilt) . "'></td>";
            echo "<td>$punktid</td>";
            echo "<td><a href='?teePunkt0=$id'>Tee punktid nulli</a></td>";
            echo "<td>$lisamisaeg</td>";
            echo "<td>$kommentaarid</td>";

            echo "<br>";

            $tekst = "Näita";
            $seisund = "naita_id";
            $tekstlehel = "Peidetud";
            if ($avalik == 1) {
                $tekst = "Peida";
                $seisund = "peida_id";
                $tekstlehel = "Nähtav";
            }




                echo "<td><a href='?$seisund=$id'>$tekst</a> | $tekstlehel</td>";


             echo "<td><a href='?deletekomment=$id'>Kustuta Kommentaar</a></td>";

                echo "<td><a href='?delete=$id'>Kustuta Laul</a></td>";
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
function eemalda1punkt($id)
{
    global $yhendus;


    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = punktid - 1 WHERE id = ? AND punktid > 0"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

function teePunkt0($id)
{
    global $yhendus;


    $paring = $yhendus->prepare(
        "UPDATE laulud SET punktid = 0 WHERE id = ?"
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
function kommentaariLisamine(){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = CONCAT(kommentaarid,?) WHERE id = ?"
    );
    $komment2=$_REQUEST['uus_kommentaar']."\n";
    $paring->bind_param('si', $komment2,$_REQUEST['uus_kommentaar_id']);
    $paring->execute();
}

function deletekomment($id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE laulud SET kommentaarid = '' WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}

function delete($id)
{
    global $yhendus;
    $paring = $yhendus->prepare(
      "DELETE FROM laulud WHERE id = ?"
    );
    $paring->bind_param('i', $id);
    $paring->execute();
}









