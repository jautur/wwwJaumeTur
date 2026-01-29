<?php
date_default_timezone_set('Europe/Madrid');


$dies = [
	'Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres', 'Dissabte', 'Diumenge'
];

$mesos = [
	'Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny', 'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre'
];

$diaSetmana = (int) date('N'); 
$diaMes = (int) date('j');     
$mes = (int) date('n'); 
$any = date('Y');

echo $dies[$diaSetmana - 1] . ', ' . $diaMes . ' de ' . ucfirst($mesos[$mes - 1]) . ' de ' . $any;
?> 
