<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/entity/CarretCompra.php';
include_once __DIR__ . '/entity/Animal.php';

if (!isset($_GET['id'])) {
    echo "Error: ID not provided.";
    exit;
}

if (!empty($_SESSION['carret'])) {
    $carret = unserialize($_SESSION['carret']);

    if ($carret instanceof CarretCompra) {
        $carret->eliminarAnimal($_GET['id']);
        $_SESSION['carret'] = serialize($carret);
        header('Location: ../index.php?apartat=apadrina&mostrar=carret');
        exit;
    } else {
        echo "Error: Invalid cart object.";
    }
} else {
    header('Location: ../index.php?apartat=apadrina&mostrar=carret');
    exit;
}

exit;
