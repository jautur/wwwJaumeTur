<?php 
$servidor = CredencialsBD::SERVIDOR;
$usuari = CredencialsBD::USUARI;
$contrasenya = CredencialsBD::CONTRASENYA;
$basedades = CredencialsBD::BASEDADES;
$connexio = new mysqli($servidor, $usuari, $contrasenya, $basedades);
?>