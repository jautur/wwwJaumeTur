<?php
if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
    header('Location: ../index.php?apartat=admin');
    exit;
}

include_once __DIR__ . '/../funcionsAdmin.php';
?>

<section id="apadrina">
    <h1 style="color:red;">ADMINISTRACIÓ</h1>
    <?php gestionaUsuaris(); ?>
</section>