<?php
$serverinimi='localhost';
$kasutajanimi='opilanejuhan';
$parool='12345';
$andmebaasinimi='haal';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");