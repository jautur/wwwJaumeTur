<?php
if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
    header('Location: ../index.php?apartat=admin');
    exit;
}

include_once __DIR__ . '/../funcionsAdmin.php';
?>

<section id="admin">
    <div class="contenidorAdmin">
        <h1 style="color:red;">ADMINISTRACIÓ</h1>
        <div class="taulaUsuaris">
            <?php gestionaUsuaris(); ?>
        </div>
        <?php if (isset($_GET['mostrarLog']) && $_GET['mostrarLog'] === 'true'): ?>
            <div class="logUsuaris">
                <h2>Log d'Accions dels Usuaris</h2>
                <?php mostraAccionsUsuaris(); ?>
            </div>
            <div class="logUsuaris">
                <h2>Log Navegacio</h2>
                <?php mostraNavegacio(); ?>
            </div>
        <?php endif; ?>
        <div class="controls">
            <button><a href="?apartat=admin&mostrarLog=false">Oculta Log</a></button>
            <button><a href="?apartat=admin&mostrarLog=true">Mostra Log</a></button>
        </div>
    </div>
</section>