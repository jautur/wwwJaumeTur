<?php
session_start();

if (isset($_POST['envia'])) {

    $_SESSION['idAnimal'] = $_POST['idAnimal'];
    $_SESSION['quantitatAnimal'] = $_POST['quantitatAnimal'];

    header("Location: index.php?apartat=apadrina");
    exit();
}

require_once __DIR__ . '/include/funcions.php';

$apartat = $_GET['apartat'] ?? 'inici';
if (!empty($_POST['apartat'])) {
    $apartat = $_POST['apartat'];
}

registreNavegacio($apartat);

$ruta = match ($apartat) {
    'inici' => '/include/partials/inici.partial.php',
    'registre' => '/include/partials/registre.partial.php',
    'contacte' => '/include/partials/contacte.partial.php',
    'apadrina' => '/include/partials/apadrina.partial.php',
    'processa_registre' => '/include/processa_registre.php',
    'processa_contacte' => '/include/processa_contacte.php',
    'processa_login' => '/include/processa_login.php',
    'admin' => '/include/partials/admin.partial.php',
    default => '/include/partials/inici.partial.php',
};

$path = __DIR__ . $ruta;

if (isset($_POST['color'])) {
    $_SESSION['color'] = $_POST['color'];
}

$colorSession = $_SESSION['color'] ?? 'perDefecte';

$cssSelecionat = 'css/estils.css';
if ($colorSession === 'Roig') {
    $cssSelecionat = 'css/estilRoig.css';
} elseif ($colorSession === 'Blau') {
    $cssSelecionat = 'css/estilBlau.css';
}
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <link rel='stylesheet' href='<?php echo htmlspecialchars($cssSelecionat); ?>'>
    <title>Web</title>
</head>

<body>
    <header>
        <?php include __DIR__ . '/include/partials/cap.partial.php'; ?>
    </header>
    <nav>
        <?php include __DIR__ . '/include/partials/menu.partial.php'; ?>
    </nav>

    <main>
        <?php if (file_exists($path))
            include $path; ?>
    </main>

    <footer>
        <?php include __DIR__ . '/include/partials/peu.partial.php'; ?>
    </footer>

</body>

</html>