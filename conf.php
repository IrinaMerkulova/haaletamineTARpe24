<?php
$serverinimi='localhost';
$kasutajanimi='opilaneStenver';
$parool='12345';
$andmebaasinimi='haaletamine';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);

if ($yhendus->connect_error) {
    die("Ühendus ebaõnnestus: " . $yhendus->connect_error);
}


$yhendus->set_charset("utf8");