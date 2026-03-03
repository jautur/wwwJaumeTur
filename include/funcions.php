<?php

/**
 * Registre de navegació per apartats
 * @param string $apartat Nom de l'apartat accedit
 * @param string $ruta Ruta completa del fitxer on s'ha d'afegir el registre
 * @return void
 */
function registreNavegacio(string $apartat, string $ruta): void
{
    // Assegurar que la carpeta existeix
    $dir = dirname($ruta);
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }

    // Crear carpeta backup dins de log si no existeix
    $backupDir = $dir . DIRECTORY_SEPARATOR . 'backup';
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0755, true);
    }

    // Comptar línies existents
    $lineesExistents = 0;
    if (file_exists($ruta)) {
        $lines = @file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (is_array($lines)) {
            $lineesExistents = count($lines);
        }
    }

    $numero = $lineesExistents + 1;
    $now = new DateTime();
    $data = $now->format('d/m/Y');
    $hora = $now->format('H:i:s');
    $text = sprintf("%d :: Accés a l'apartat %s el dia %s a l'hora %s", $numero, mb_strtoupper($apartat), $data, $hora);

    // Si el nombre de línies és múltiple de 10, fer backup
    if ($numero % 10 === 0) {
        $stamp = $now->format('Ymd_His');
        $backupFile = $backupDir . DIRECTORY_SEPARATOR . "backup_{$stamp}.log";
        // copy whole file
        @copy($ruta, $backupFile);
    }
}


/**
 * Registre d'accions d'usuari
 * @param string $accio Nom de l'acció (REGISTRE o CONTACTE)
 * @param string $usuari Identificador de l'usuari (email)
 * @param string $ruta Ruta completa del fitxer on s'ha d'afegir el registre
 * @return void
 */
function registreAccionsUsuari(string $accio, string $usuari, string $ruta): void
{
    // Assegurar que la carpeta existeix
    $dir = dirname($ruta);
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }

    $now = new DateTime();
    $data = $now->format('d/m/Y');
    $hora = $now->format('H:i:s');
    $text = sprintf("L'usuari %s ha realitzat l'acció %s el dia %s a l'hora %s", $usuari, mb_strtoupper($accio), $data, $hora);

}
function insereixUsuari(string $nom, string $cognoms, string $correu, string $contrasenya): string
{
    $connexio = mysqli_connect("localhost", "root", "root", "BBDDwwwJaume");

    if (!$connexio) {
        return "error";
    }

    if (usuariExisteix($correu, $connexio)) {
        mysqli_close($connexio);
        return "usuariExisteix";
    }

    $img = "default.png";
    $passwd = password_hash($contrasenya, PASSWORD_DEFAULT);
    $iguals = password_verify($contrasenya, $passwd);

    if ($iguals === true) {
        if (empty($cognoms)) {
            $sql = "INSERT INTO Usuaris (nom, correu, passwd, img, date)
                VALUES ('$nom', '$correu', '$passwd', '$img', NOW())";
        } else {
            $sql = "INSERT INTO Usuaris (nom, cognoms, correu, passwd, img, date)
                VALUES ('$nom', '$cognoms', '$correu', '$passwd', '$img', NOW())";
        }
    }


    if (mysqli_query($connexio, $sql)) {
        mysqli_close($connexio);
        return "usuariInserit";
    } else {
        mysqli_close($connexio);
        return "error";
    }
}

function usuariExisteix(string $correu, $connexio): bool
{
    $sql = "SELECT id FROM Usuaris WHERE LOWER(correu) = LOWER('$correu')";
    $resultat = mysqli_query($connexio, $sql);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        return true;
    } else {
        return false;
    }
}

function passwdCorrecta(string $correu, string $passwd, $connexio): bool
{
    // Recuperem el hash emmagatzemat per aquest correu i el comparem amb la contrasenya
    // enviada pel formulari. No tornem a hash la contrasenya de l'usuari, ja que
    // password_verify ja ho gestiona internament.
    $correuEscapat = mysqli_real_escape_string($connexio, $correu);
    $sql = "SELECT passwd FROM Usuaris WHERE LOWER(correu) = LOWER('$correuEscapat')";
    $resultat = mysqli_query($connexio, $sql);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        $row = mysqli_fetch_assoc($resultat);
        // password_verify compara la contrasenya en pla amb el hash emmagatzemat
        return password_verify($passwd, $row['passwd']);
    } else {
        return false;
    }
}

function redirigeixErrorContrasenya()
{
    header("Location: ?apartat=registre&error=contrasenya");
    die();
}

function redirigeixLoginValid()
{
    header("Location: ?apartat=inici&error=valid");
    die();
}
function redirigeixLoginCorreu()
{
    header("Location: ?apartat=inici&error=correu");
    die();
}
function redirigeixLoginIncorrecte()
{
    header("Location: ?apartat=inici&error=incorrecte");
    die();
}
function redirigeixLoginBuit()
{
    header("Location: ?apartat=inici&error=buit");
    die();
}

function missatgeErrorLogin($error)
{
    if ($error === 'correu') {
        echo '<p style="color:red; margin-top:5px;">No existeix cap usuari amb aquest email</p>';
    } elseif ($error === 'incorrecte') {
        echo '<p style="color:red; margin-top:5px;">L\'usuari o la contrasenya no és correcte</p>';
    }
}

function mostraAnimals()
{
    $connexio = mysqli_connect("localhost", "root", "root", "BBDDwwwJaume");

    if (!$connexio) {
        echo '<p style="color:red;">Error de connexió amb la base de dades</p>';
        return;
    }

    $consulta = "SELECT id, nomcomu, nomcient, descripcio, img, donacio, quantitat FROM Animal";
    $resultat = mysqli_query($connexio, $consulta);

    if (!$resultat) {
        echo '<p style="color:red;">Error en la consulta</p>';
        mysqli_close($connexio);
        return;
    }

    echo "<div class='animals'>";

    while ($fila = mysqli_fetch_assoc($resultat)) {

        echo "<div class='animal'>";

        echo "<div class='animal-id'>id: {$fila['id']}</div>";

        echo "<h2>{$fila['nomcomu']}</h2>";

        echo "<img src='{$fila['img']}' alt='{$fila['nomcomu']}' whidth='200px' height='200px'>";

        echo "<p class='nomcient'><em>{$fila['nomcient']}</em></p>";

        echo "<p>{$fila['descripcio']}</p>";

        echo "<p><strong>Disponibles:</strong> {$fila['quantitat']}</p>";

        echo "<button>Donació: {$fila['donacio']}€</button>";

        mostraFormulariAnimal($fila['id']);  

        echo "</div>";
    }

    echo "</div>";

    mysqli_free_result($resultat);
    mysqli_close($connexio);
}

function mostraFormulariAnimal($id)
{
    echo '
    <form id="formAnimal'.$id.'" 
          name="formAnimal'.$id.'" 
          action="index.php?apartat=apadrina" 
          method="POST">

        <input type="hidden" 
               id="idAnimal'.$id.'" 
               name="idAnimal" 
               value="'.$id.'">

        <div>
            <span>
                <label for="quantitatAnimal'.$id.'">Quantitat:</label>
            </span>
            <span>
                <input id="quantitatAnimal'.$id.'" 
                       name="quantitatAnimal" 
                       type="number" 
                       min="0" 
                       step="1" 
                       required>
            </span>
        </div>

        <div>
            <span>
                <button id="enviaFormAnimal'.$id.'" 
                        name="envia" 
                        type="submit">
                        Afegeix al carret
                </button>
            </span>
        </div>

    </form>';
}