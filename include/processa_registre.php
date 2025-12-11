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
$color = $_POST['color'] ?? 'per defecte';
$puntuacio = intval($_POST['puntuacio'] ?? 1);
$multiplicador = intval($_POST['multiplicador'] ?? 1);
$animalDelMes = $_POST['noms'] ?? [];

function mostraValor($valor)
{
    if (is_array($valor)) {
        return !empty($valor)
            ? htmlspecialchars(implode(', ', $valor))
            : '<span style="color:green;"> --buit--</span>';
    }

    return !empty($valor)
        ? htmlspecialchars($valor)
        : '<span style="color:green;"> --valor buit--</span>';
}

$puntuacioFinal = $puntuacio * $multiplicador;

$noms = [
    'A' => 'Elefant africà del bosc',
    'B' => 'Tórtora Valenciana',
    'C' => 'Colibrí del sud',
    'D' => 'Dofí volador',
    'E' => 'Pangolí del llevant',
    'F' => 'Lim go home'
];

$imatgesAnimals = [
    'gorila' => 'img/gorila.jpg',
    'jaguar' => 'img/jaguar.jpg',
    'oso polar' => 'img/oso_polar.jpg',
    'ajolote' => 'img/ajolote.jpg',
    'elefante' => 'img/elefante.jpg'
];

$datosAnimals = [
    'gorila' => [
        'Nom cientific' => 'Gorilla gorilla',
        'Estat de conservació' => 'En perill crític',
        'Hàbitat' => 'Boscos tropicals d\'Àfrica occidental',
        'Alimentació' => 'Herbívors',
        'Descripció' => 'Els goril·les són els primats més grans i viuen en grups socials liderats per un mascle dominant.'
    ],
    'jaguar' => [
        'Nom cientific' => 'Panthera onca',
        'Estat de conservació' => 'Vulnerable',
        'Hàbitat' => 'Selves d\'Amèrica',
        'Alimentació' => 'Carnívors',
        'Descripció' => 'El jaguar és el felí més gran d’Amèrica i excel·lent nedador.'
    ],
    'oso polar' => [
        'Nom cientific' => 'Ursus maritimus',
        'Estat de conservació' => 'Vulnerable',
        'Hàbitat' => 'Regions àrtiques',
        'Alimentació' => 'Carnívors',
        'Descripció' => 'Depèn del gel marí per caçar foques.'
    ],
    'ajolote' => [
        'Nom cientific' => 'Ambystoma mexicanum',
        'Estat de conservació' => 'En perill crític',
        'Hàbitat' => 'Llacs de Mèxic',
        'Alimentació' => 'Carnívors',
        'Descripció' => 'Conserva característiques larvals tota la vida.'
    ],
    'elefante' => [
        'Nom cientific' => 'Loxodonta africana',
        'Estat de conservació' => 'Vulnerable',
        'Hàbitat' => 'Sabana africana',
        'Alimentació' => 'Herbívors',
        'Descripció' => 'El mamífer terrestre més gran del món.'
    ]
];

$imatgesAnimalMes = [
    'A' => 'img/A.jpg',
    'B' => 'img/B.jpg',
    'C' => 'img/C.jpg',
    'D' => 'img/D.jpg',
    'E' => 'img/E.jpg',
    'F' => 'img/F.jpg'
];

$cssLink = match ($color) {
    'Roig' => 'css/estilRoig.css',
    'Blau' => 'css/estilBlau.css',
    default => 'css/estilperdefecte.css'
};

$imgSrc1 = $imatgesAnimals[$animal] ?? 'img/default.png';

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

        <fieldset>
            <h3>Resultat del Registre</h3>
        </fieldset>
        <br>

        <fieldset>
            <p><strong>Nom:</strong> <?= mostraValor($nom) ?></p>
            <p><strong>Cognoms:</strong> <?= mostraValor($cognoms) ?></p>
            <p><strong>Email:</strong> <?= mostraValor($email) ?></p>
            <p><strong>Contrasenya:</strong> <span style="color:green;"><?= mostraValor($passwd) ?></span></p>
            <p><strong>Telèfon:</strong> <?= mostraValor($tlf) ?></p>
            <p><strong>Població:</strong> <?= mostraValor($poblacio) ?></p>
            <p><strong>Freqüència de donació:</strong> <?= mostraValor($donacio) ?></p>
            <p><strong>Continent:</strong> <?= mostraValor($continent) ?></p>

            <p><strong>Animal:</strong> <?= mostraValor($animal) ?></p>
            <img src="<?= $imgSrc1 ?>" alt="Animal seleccionat" width="300">

            <table class="taula-animal" style="margin-top:15px;">
                <tr>
                    <th colspan="2">Dades de l'animal:</th>
                </tr>

                <tr>
                    <td class="col-titol">Nom científic</td>
                    <td><?= mostraValor($datosAnimals[$animal]['Nom cientific'] ?? '') ?></td>
                </tr>

                <tr>
                    <td class="col-titol">Estat de conservació</td>
                    <td><?= mostraValor($datosAnimals[$animal]['Estat de conservació'] ?? '') ?></td>
                </tr>

                <tr>
                    <td class="col-titol">Hàbitat</td>
                    <td><?= mostraValor($datosAnimals[$animal]['Hàbitat'] ?? '') ?></td>
                </tr>

                <tr>
                    <td class="col-titol">Alimentació</td>
                    <td><?= mostraValor($datosAnimals[$animal]['Alimentació'] ?? '') ?></td>
                </tr>

                <tr>
                    <td class="col-titol">Descripció</td>
                    <td><?= mostraValor($datosAnimals[$animal]['Descripció'] ?? '') ?></td>
                </tr>

            </table>
        </fieldset>

        <br>
        <fieldset>
            <p><strong>Puntuació:</strong> <?= $puntuacio ?> x <?= $multiplicador ?> = <?= $puntuacioFinal ?></p>

            <div class="imatges-repetides">
                <?php for ($i = 0; $i < $puntuacioFinal; $i++): ?>
                    <img src="img/punts.png" alt="Punt" width="30">
                <?php endfor; ?>
            </div>

            <p><strong>Color d'estil seleccionat:</strong> <?= mostraValor($color) ?></p>
        </fieldset>

        <br>
        <fieldset>
            <p><strong>Animals del mes seleccionats:</strong></p>

            <?php if (!empty($animalDelMes)): ?>
                <div class="animals-mes">
                    <?php foreach ($animalDelMes as $codi): ?>
                        <?php
                        $nomAnimal = $noms[$codi] ?? 'Sense nom';
                        $imgAnimal = $imatgesAnimalMes[$codi] ?? 'img/default.png';
                        ?>
                        <div class="animal-mes">
                            <img src="<?= htmlspecialchars($imgAnimal) ?>" alt="<?= htmlspecialchars($nomAnimal) ?>"
                                width="150">
                            <p><?= htmlspecialchars($nomAnimal) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p><span style="color:green;"> --valor buit--</span></p>
                <img src="img/default.png" width="300" alt="Sense animal del mes">
            <?php endif; ?>
        </fieldset>

    </section>
</body>

</html>