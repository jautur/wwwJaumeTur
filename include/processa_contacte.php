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
$paraulesClau = ['animal', 'apadrinar', 'donacio', 'voluntari', 'salvar', 'proteccio', 'perill'];
?>

<link rel="stylesheet" href="css/contacte.css">

<section id="proccContacte">
    <h3>Resultat del Contacte</h3>
    <p><strong>Nom:</strong> <?= mostraValor($nom) ?></p>
    <p><strong>Email:</strong> <?= mostraValor($email) ?></p>
    <p><strong>Assumpte:</strong> <?= mostraValor($assumpte) ?></p>
    <p><strong>Missatge:</strong></p>

    <?php
    $numParaules = count($paraules);
    $dimensio = ceil(sqrt($numParaules));
    ?>

    <table class="taula-paraules">
        <?php
        $index = 0;
        for ($fila = 0; $fila < $dimensio; $fila++):
            echo "<tr>";
            for ($col = 0; $col < $dimensio; $col++):
                if ($index < $numParaules) {
                    $paraula = $paraules[$index];
                    $classe = 'paraula-normal';
                    if (in_array(strtolower($paraula), $paraulesClau)) {
                        $classe = 'paraula-clau';
                    }

                    if (mb_strlen($paraula) >= 10) {
                        $classe = 'paraula-llarga';
                    }

                    echo "<td class='$classe'>" . htmlspecialchars($paraula) . "</td>";
                } else {
                    echo "<td></td>";
                }
                $index++;
            endfor;
            echo "</tr>";
        endfor;
        ?>
    </table>


    <p><a href="/wwwJaumeTur/?apartat=contacte">Tornar enrere</a></p>
</section>