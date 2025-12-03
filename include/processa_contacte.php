<?php
$nom = trim($_POST['nom'] ?? '');
$email = trim($_POST['email'] ?? '');
$assumpte = trim($_POST['assumpte'] ?? '');
$missatge = trim($_POST['missatge'] ?? '');

function mostraValor($valor)
{
    return !empty($valor) ? htmlspecialchars($valor) : '<span style="color:red;">Valor buit</span>';
}

$paraules = explode(" ", $missatge);
$paraulesClau = ['animal', 'apadrinar', 'donacio', 'voluntari'];
?>

<link rel="stylesheet" href="css/contacte.css">

<section id="proccContacte">
    <h3>Resultat del Contacte</h3>
    <p><strong>Nom:</strong> <?= mostraValor($nom) ?></p>
    <p><strong>Email:</strong> <?= mostraValor($email) ?></p>
    <p><strong>Assumpte:</strong> <?= mostraValor($assumpte) ?></p>
    <p><strong>Missatge:</strong></p>

    <ul class="paraules">
        <?php foreach ($paraules as $paraula):
            $classe = 'paraula-normal';

            if (in_array(strtolower($paraula), $paraulesClau)) {
                $classe = 'paraula-clau';
            }

            if (strlen($paraula) >= 10) {
                $classe = 'paraula-llarga';
            }
        ?>
            <li class="<?= $classe ?>"><?= htmlspecialchars($paraula) ?></li>
        <?php endforeach; ?>
    </ul>

    <p><a href="/wwwJaumeTur/?apartat=contacte">Tornar enrere</a></p>
</section>
