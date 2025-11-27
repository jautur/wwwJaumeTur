<?php
$nom = trim($_POST['nom'] ?? '');
$cognoms = trim($_POST['cognoms'] ?? '');
$email = trim($_POST['email'] ?? '');
$passwd = trim($_POST['passwd'] ?? '');
$tlf = trim($_POST['tlf'] ?? '');
$poblacio = trim($_POST['poblacio'] ?? '');
$donacio = $_POST['donacio'] ?? '';
$animal = $_POST['animal'] ?? '';

function mostraValor($valor)
{
    return !empty($valor) ? htmlspecialchars($valor) : '<span style="color:red;">Valor buit</span>';
}
?>

<section id="proccRegistre">
    <h3>Resultat del Registre</h3>
    <p><strong>Nom:</strong> <?= mostraValor($nom) ?></p>
    <p><strong>Cognoms:</strong> <?= mostraValor($cognoms) ?></p>
    <p><strong>Email:</strong> <?= mostraValor($email) ?></p>
    <p><strong>Contrasenya:</strong> <span style="color:green;"><?= mostraValor($passwd) ?></span></p>
    <p><strong>Telèfon:</strong> <?= mostraValor($tlf) ?></p>
    <p><strong>Població:</strong> <?= mostraValor($poblacio) ?></p>
    <p><strong>Freqüència de donació:</strong> <?= mostraValor($donacio) ?></p>
    <p><strong>Animal:</strong> <?= mostraValor($animal) ?></p>

</section>