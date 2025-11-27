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
        <?php include 'include/partials/cap.partial.php'; ?>
    </header>
    <nav>
        <?php include 'include/partials/menu.partial.php'; ?>
    </nav>

    <main>
        <?php if (file_exists($path))
            include $path; ?>
    </main>

    <footer>
        <?php include 'include/partials/peu.partial.php'; ?>
    </footer>

</body>

</html>