<?php
$serverinimi='localhost';
$kasutajanimi='opilaneSavva';
$parool='12345';
$andmebaasinimi='';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");