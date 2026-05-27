<?php
$serverinimi = 'localhost';
$kasutajanimi = 'root';
$parool = '';
$andmebaasinimi = 'haal2';

$yhendus = new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");
?>