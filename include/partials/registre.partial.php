<section id="registre">
    <h1>Registre</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include __DIR__ . '/../processa_registre.php';
    } else {
        ?>
        <form id="formulari" class="form-grid" method="post" action="/wwwJaumeTur/index.php?apartat=registre">
            <fieldset>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" maxlength="20" required>

                <label for="cognoms">Cognoms:</label>
                <input type="text" id="cognoms" name="cognoms" maxlength="50">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" maxlength="70" required>

                <label for="passwd">Contrasenya:</label>
                <input type="password" id="passwd" name="passwd" maxlength="50" required>

                <label for="tlf">Telèfon:</label>
                <input type="tel" id="tlf" name="tlf" maxlength="15">

                <label for="poblacio">Població:</label>
                <input type="text" id="poblacio" name="poblacio" maxlength="50">

                <label for="donacio">Freqüència de donació:</label>
                <select name="donacio" id="donacio">
                    <option value="Una vegada">Una vegada</option>
                    <option value="mensual">Mensual</option>
                    <option value="anual">Anual</option>
                </select>

                <label for="continent">Continent:</label>
                <select name="continent" id="continent">
                    <option value="Africa">Àfrica</option>
                    <option value="Amèrica">Amèrica</option>
                    <option value="Àsia">Àsia</option>
                    <option value="Europa">Europa</option>
                    <option value="Oceania">Oceania</option>
                </select>

                <label>Animal:</label>
                <input type="radio" id="gorila" name="animal" value="gorila" required>
                <label for="gorila">Gorila</label>

                <input type="radio" id="jaguar" name="animal" value="jaguar">
                <label for="jaguar">Jaguar</label>

                <input type="radio" id="oso_polar" name="animal" value="oso polar">
                <label for="oso_polar">Oso polar</label>

                <input type="radio" id="ajolote" name="animal" value="ajolote">
                <label for="ajolote">Ajolote</label>

                <input type="radio" id="elefante" name="animal" value="elefante">
                <label for="elefante">Elefante</label>

                <br><br>

                <label>Color Registre:</label>
                <input type="radio" id="Roig" name="color" value="Roig">
                <label for="Roig">Roig</label>

                <input type="radio" id="Blau" name="color" value="Blau">
                <label for="Blau">Blau</label>

                <br><br>

                <label for="puntuacio">Puntuació de la pagina (1-5):</label>
                <input type="number" id="puntuacio" name="puntuacio" min="1" max="5" value="1">

                <br><br>

                <label for="multiplicador">Multiplicador:</label>
                <input type="range" id="multiplicador" name="multiplicador" min="1" max="100" value="1"
                    oninput="valorMultiplicador.value = this.value">
                <output id="valorMultiplicador">1</output>

                <br><br>

                <button type="reset">Reset</button>
                <button type="submit" id="submit" value="Enviar">Enviar</button>
            </fieldset>
        </form>
        <?php
    }
    ?>
</section>