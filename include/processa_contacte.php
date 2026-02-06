<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

if (!empty($email)) {
    if (file_exists(__DIR__ . '/funcions.php')) {
        include_once __DIR__ . '/funcions.php';
        registreAccionsUsuari('CONTACTE', $email, __DIR__ . '/../log/accionsUsuari.log');
    }
}
$cssTaula = 'css/contacte.css';


?>

<link rel="stylesheet" href="<?= htmlspecialchars($cssTaula) ?>">

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


    <?php $retApartat = $_POST['apartat'] ?? 'contacte'; ?>
    <p><a href="../?apartat=<?= htmlspecialchars($retApartat) ?>">Tornar enrere</a></p>
</section>