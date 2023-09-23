<?php
$hostname='192.168.0.30';
$dbname='PROTHEUS_PRD';
$dbname2 = 'ELIPSE_E3';
$username='elipse';
$password='E#lipse#365#ic';


$dbDB  = new PDO("sqlsrv:Server=$hostname;Database=$dbname", $username, $password);
$dbDB2 = new PDO("sqlsrv:Server=$hostname;Database=$dbname2", $username, $password);
?>
