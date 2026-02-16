<?php
/*$serverinimi='d141151.mysql.zonevs.eu';
$kasutajanimi='d141151_christoferkrabbi';
$parool='Tere6htust';
$andmebaasinimi='d141151_phpbaas';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");*/


$serverinimi = 'localhost';
$kasutajanimi = 'christoferkrabbi';
$parool = '12345';
$andmebaasinimi = 'haal';
$yhendus = new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");
