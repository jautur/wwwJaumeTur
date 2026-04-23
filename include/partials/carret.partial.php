
<section id="carret">
    <div id="carretinfo">
        <h3 style="color:red;"> INFO CARRET</h3>
    </div>
    <?php if (isset($_SESSION['idAnimal']) && isset($_SESSION['quantitatAnimal'])): ?>
        <?php
        $idAnimal = $_SESSION['idAnimal'];
        $quantitat = $_SESSION['quantitatAnimal'];
        $connexio = mysqli_connect("localhost", "root", "root", "BBDDwwwJaume");
        if ($connexio) {
            $sql = "SELECT nomcomu, donacio FROM Animal WHERE id = '$idAnimal'";
            $result = mysqli_query($connexio, $sql);
            if ($result && $row = mysqli_fetch_assoc($result)) {
                $nom = $row['nomcomu'];
                $preu = $row['donacio'];
                $total = $preu * $quantitat;
                echo "<p>ID Animal: " . htmlspecialchars($idAnimal) . "</p>";
                echo "<p>Nom: " . htmlspecialchars($nom) . "</p>";
                echo "<p>Preu: " . htmlspecialchars($preu) . "€</p>";
                echo "<p>Quantitat: " . htmlspecialchars($quantitat) . "</p>";
                echo "<p>Total: " . htmlspecialchars($total) . "€</p>";
            } else {
                echo "<p>Error obtenint dades de l'animal.</p>";
            }
            mysqli_close($connexio);
        } else {
            echo "<p>Error de connexió.</p>";
        }
        ?>
    <?php else: ?>
        <p>No hi ha cap animal al carret.</p>
    <?php endif; ?>

    <div id="carretinfo">
        <?php if (isset($_SESSION['usuari'])): ?>
            <h3>Carret de: <?= htmlspecialchars($_SESSION['nom']) ?> </h3>
        <?php else: ?>
            <h3 style="color:red;"> Inicia Sessió per poder comprar</h3>
        <?php endif; ?>
    </div>
</section>