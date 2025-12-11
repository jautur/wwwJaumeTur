<?php
$nom = trim($_POST['nom'] ?? '');
$cognoms = trim($_POST['cognoms'] ?? '');
$email = trim($_POST['email'] ?? '');
$passwd = trim($_POST['passwd'] ?? '');
$tlf = trim($_POST['tlf'] ?? '');
$poblacio = trim($_POST['poblacio'] ?? '');
$donacio = $_POST['donacio'] ?? '';
$continent = $_POST['continent'] ?? '';
$animal = $_POST['animal'] ?? '';
$color = $_POST['color'] ?? '';
$puntuacio = intval($_POST['puntuacio'] ?? 1);
$multiplicador = intval($_POST['multiplicador'] ?? 1);

function mostraValor($valor)
{
    return !empty($valor) ? htmlspecialchars($valor) : '<span style="color:green;">Predeterminat</span>';
}

$puntuacioFinal = $puntuacio * $multiplicador;

$imatgesAnimals = [
    'gorila' => './img/gorila.jpg',
    'jaguar' => 'img/jaguar.jpg',
    'oso polar' => 'img/oso_polar.jpg',
    'ajolote' => 'img/ajolote.jpg',
    'elefante' => 'img/elefante.jpg'
];
$imgSrc = $imatgesAnimals[$animal];

$cssLink = match ($color) {
    'Roig' => 'css/estilRoig.css',
    'Blau' => 'css/estilBlau.css',
    default => 'css/estilperdefecte.css'
};
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Resultat del Registre</title>
    <link rel="stylesheet" href="<?= htmlspecialchars($cssLink) ?>">
</head>

<body>
    <section id="proccRegistre">
        <h3>Resultat del Registre</h3>
        <p><strong>Nom:</strong> <?= mostraValor($nom) ?></p>
        <p><strong>Cognoms:</strong> <?= mostraValor($cognoms) ?></p>
        <p><strong>Email:</strong> <?= mostraValor($email) ?></p>
        <p><strong>Contrasenya:</strong> <span style="color:green;"><?= mostraValor($passwd) ?></span></p>
        <p><strong>Telèfon:</strong> <?= mostraValor($tlf) ?></p>
        <p><strong>Població:</strong> <?= mostraValor($poblacio) ?></p>
        <p><strong>Freqüència de donació:</strong> <?= mostraValor($donacio) ?></p>
        <p><strong>Continent:</strong> <?= mostraValor($continent) ?></p>
        <p><strong>Animal:</strong> <?= mostraValor($animal) ?></p>
        <img src="<?= $imgSrc ?>" alt="Animal seleccionat" width="300">
        <p><strong>Puntuació:</strong> <?= $puntuacio ?> x <?= $multiplicador ?> = <?= $puntuacioFinal ?></p>
        <div class="imatges-repetides">
            <?php
            for ($i = 0; $i < $puntuacioFinal; $i++) {
                echo "<img src='img/punts.png' alt='Animal' width='30'>";
            }
            ?>
        </div>
        <p><strong>Color d'estil seleccionat:</strong> <?= mostraValor($color) ?></p>
    </section>
</body>

</html>