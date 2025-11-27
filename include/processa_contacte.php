<?php
$nom = trim($_POST['nom'] ?? '');
$email = trim($_POST['email'] ?? '');
$assumpte = trim($_POST['assumpte'] ?? '');
$missatge = trim($_POST['missatge'] ?? '');

function mostraValor($valor)
{
    return !empty($valor) ? htmlspecialchars($valor) : '<span style="color:red;">Valor buit</span>';
}
?>

<section id="proccContacte">
    <h3>Resultat del Contacte</h3>
    <p><strong>Nom:</strong> <?= mostraValor($nom) ?></p>
    <p><strong>Email:</strong> <?= mostraValor($email) ?></p>
    <p><strong>Assumpte:</strong> <?= mostraValor($assumpte) ?></p>
    <p><strong>Missatge:</strong> <?= mostraValor($missatge) ?></p>
    <p><a href="/wwwJaumeTur/?apartat=registre">Tornar enrere</a></p>

</section>