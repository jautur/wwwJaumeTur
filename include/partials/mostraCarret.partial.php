<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../funcions.php';
include_once __DIR__ . '/../entity/Animal.php';
?>

<section id="apadrinaMostraCarret">
    <?php

    if (isset($_SESSION['carret'])) {

        $carret = unserialize($_SESSION['carret']);

        if (!empty($carret->getLlistaAnimals())) {

            echo "<div class='animalCarret'>";

            foreach ($carret->getLlistaAnimals() as $animal) {
                echo "<div class='animalCarret-id'>";

                echo "<div class='col id-foto'>";
                echo $animal->getId();
                echo '<a href="include/eliminaAnimalCarret.php?id=' . $animal->getId() . '"><img src="img/eliminar.png" alt="eliminar" width="25" height="25"></a>';
                echo "</div>";

                echo "<div class='col nom'>";
                echo "<p>NOM: " . $animal->getNom() . "</p>";
                echo "</div>";

                echo "<div class='col cantitat'>";
                echo "<p>CANTITAT: " . $animal->getCantitat() . "</p>";
                echo "</div>";

                echo "<div class='col preu'>";
                echo "<p>PREU: " . ($animal->getCantitat() * $animal->getDonacio()) . "€</p>";
                echo "</div>";

                echo "</div>";
            }

            echo "</div>";



        } else {
            echo "<p>No hi ha cap animal al carret.</p>";
        }

    } else {
        echo "<p>No hi ha cap animal al carret.</p>";
    }

    ?>
</section>