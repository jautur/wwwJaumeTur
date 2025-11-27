<section id="contacte">
    <h1>Contacte</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include __DIR__ . '/../processa_contacte.php';
    } else {
        ?>

        <form id="formulari" class="form-grid" method="post" action="/wwwJaumeTur/index.php?apartat=contacte">
            <fieldset>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" maxlength="20" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" maxlength="70" required>

                <label for="assumpte">Assumpte:</label>
                <input type="text" id="assumpte" name="assumpte" maxlength="50" required>

                <label for="missatge">Missatge:</label>
                <textarea id="missatge" name="missatge" cols="70%" rows="3" maxlength="500"
                    required>Escriu açí...</textarea>


                <button type="reset">Reset</button>
                <button type="submit" id="submit" value="Enviar">Enviar</button>
            </fieldset>
        </form>
        <?php
    }
    ?>
</section>