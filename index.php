<?php
$apartat = $_GET['apartat'] ?? 'inici';
$path = __DIR__ . '/include/partials/' . $apartat . '.partial.php';
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <link rel='stylesheet' href='css/estils.css'>
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