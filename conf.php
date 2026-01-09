<?php
$serverinimi='localhost';
$kasutajanimi='opilaneRobin';
$parool='12345';
$andmebaasinimi='haal';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");

//$serverinimi='d141165.mysql.zonevs.eu';
//$kasutajanimi='d141165_trobin';
//$parool='12345';
//$andmebaasinimi='haal';
//$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
//$yhendus->set_charset("utf8");