<section id="carret">
    <div id="carretinfo">
        <h3 style="color:red;"> INFO CARRET</h3>
    </div>
    <?php if (isset($carret) && count($carret->getLlistaAnimals()) > 0): ?>
        <?php
        $distinctAnimals = count($carret->getLlistaAnimals());
        $ultimAnimalId = $_SESSION['ultimAnimalId'] ?? null;
        $ultimaQuantitatAfegida = intval($_SESSION['ultimaQuantitatAfegida'] ?? 0);
        $ultimAnimal = null;

        if ($ultimAnimalId !== null) {
            $ultimAnimal = $carret->getAnimal(intval($ultimAnimalId));
        }

        if ($ultimAnimal === null) {
            $animals = $carret->getLlistaAnimals();
            $ultimAnimal = end($animals) ?: null;
        }

        $totalQuantitatActual = $ultimAnimal ? $ultimAnimal->getCantitat() : 0;
        ?>

        <?php if ($ultimAnimal !== null): ?>
            <div id="animal-carret-ultim-animal">
                <h4>Últim animal adquirit</h4>
                <p>ID Animal: <?= htmlspecialchars($ultimAnimal->getId()) ?></p>
                <p>Nom: <?= htmlspecialchars($ultimAnimal->getNom()) ?></p>
                <p>Donació per unitat: <?= htmlspecialchars($ultimAnimal->getDonacio()) ?>€</p>
                <p>Quantitat: <?= htmlspecialchars($ultimaQuantitatAfegida) ?> / <?= htmlspecialchars($totalQuantitatActual) ?>
                </p>
                <p>Total: <?= htmlspecialchars($ultimAnimal->getDonacio() * $ultimaQuantitatAfegida) ?>€</p>
                <p>Animals al carret: <?= htmlspecialchars($distinctAnimals) ?></p>
            </div>

        <?php endif; ?>
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

    <div id="botonscarret">
        <button><a href="index.php?apartat=apadrina&mostrar=carret">Ves al carret</a></button>
        <button><a href="index.php?apartat=apadrina&mostrar=apadrina">Apadrina €€</a></button>
    </div>
</section>