<?php
$serverinimi='localhost';
$kasutajanimi='opilaneSavva';
$parool='kala';
$andmebaasinimi='haal';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");