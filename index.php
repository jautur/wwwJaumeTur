<?php
$apartat = $_GET['apartat'] ?? 'inici';
if (!empty($_POST['apartat'])) {
    $apartat = $_POST['apartat'];
}

$path = __DIR__ . '/include/partials/' . $apartat . '.partial.php';

$cssSelecionat = 'css/estils.css';
if (!empty($_POST['color'])) {
    $c = $_POST['color'];
    if ($c === 'Roig') {
        $cssSelecionat = 'css/estilRoig.css';
    } elseif ($c === 'Blau') {
        $cssSelecionat = 'css/estilBlau.css';
    }
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