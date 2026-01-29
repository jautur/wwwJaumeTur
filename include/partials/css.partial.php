<form id="formulari-css" class="form-css" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] ?? '') ; ?>">

    <label>Color Registre:</label>
    <input type="radio" id="Roig" name="color" value="Roig" 
    <?php if (!empty($_POST['color']) && $_POST['color'] === 'Roig') echo 'checked'; ?>>
    <label for="Roig">Roig</label>

    <input type="radio" id="Blau" name="color" value="Blau" 
    <?php if (!empty($_POST['color']) && $_POST['color'] === 'Blau') echo 'checked'; ?>>
    <label for="Blau">Blau</label>
    
    <button type="submit" id="submit" value="Canvia">Canvia</button>

    <?php
    $apartatActual = 'inici';
    if (!empty($apartat)) {
        $apartatActual = $apartat;
    } elseif (!empty($_GET['apartat'])) {
        $apartatActual = $_GET['apartat'];
    }
    ?>
    <input type="hidden" name="apartat" value="<?php echo htmlspecialchars($apartatActual); ?>">
    <input type="hidden" name="form" value="css">

</form>