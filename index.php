<?php
session_start();

require_once __DIR__ . '/include/entity/CarretCompra.php';
require_once __DIR__ . '/include/entity/Animal.php';
require_once __DIR__ . '/include/funcions.php';

$usuariId = $_SESSION['usuari'] ?? session_id();
$carret = null;
if (isset($_SESSION['carret'])) {
    if (is_string($_SESSION['carret'])) {
        $carret = unserialize($_SESSION['carret'], ['allowed_classes' => true]);
    } elseif ($_SESSION['carret'] instanceof CarretCompra) {
        $carret = $_SESSION['carret'];
    }
}

if (!($carret instanceof CarretCompra)) {
    $carret = new CarretCompra($usuariId);
    $_SESSION['carret'] = serialize($carret);
} elseif ($carret->getUsuariId() !== $usuariId) {
    $carret->setUsuariId($usuariId);
    $_SESSION['carret'] = serialize($carret);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envia'])) {
    $idAnimal = intval($_POST['idAnimal'] ?? 0);
    $quantitat = intval($_POST['quantitatAnimal'] ?? 0);

    if ($idAnimal > 0 && $quantitat > 0) {
        $animalExist = $carret->getAnimal($idAnimal);

        if ($animalExist !== null) {
            $novaQuantitat = intval($animalExist->getCantitat()) + $quantitat;
            $carret->canviarQuantitatAnimal($idAnimal, $novaQuantitat);
        } else {
            $animal = nouAnimal($idAnimal, $quantitat);
            if ($animal !== null) {
                $carret->afegirAnimal($animal);
            }
        }

        $_SESSION['carret'] = serialize($carret);
        $_SESSION['ultimAnimalId'] = $idAnimal;
        $_SESSION['ultimaQuantitatAfegida'] = $quantitat;
        unset($carret);
    }

    header('Location: index.php?apartat=apadrina');
    exit();
}

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
            include $path;
        if ($path !== __DIR__ . '/include/partials/admin.partial.php') {
            include __DIR__ . '/include/partials/carret.partial.php';
        }
        ?>
    </main>

    <footer>
        <?php include __DIR__ . '/include/partials/peu.partial.php'; ?>
    </footer>

</body>

</html>