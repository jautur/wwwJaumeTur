<?php
// fitxer dedicat per gestionar el tancament de sessió i el registre
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// registrar l'acció abans de destruir la sessió
if (file_exists(__DIR__ . '/funcions.php')) {
    require_once __DIR__ . '/funcions.php';
    $usuari = $_SESSION['usuari'] ?? '';
    registreAccionsUsuari('LOGOUT', $usuari);
}

// destruir sessió i redirigir
$_SESSION = [];
session_destroy();
header('Location: ../index.php');
exit;
