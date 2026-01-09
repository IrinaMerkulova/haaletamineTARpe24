<?php
$serverinimi='localhost';
$kasutajanimi='arturvartsaba';
$parool='12345';
$andmebaasinimi='arturvartsaba';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");