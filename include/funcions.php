<?php

/**
 * Registre de navegació per apartats
 * Escriu una línia numerada en log/navegacio.log amb l'apartat, data i hora.
 * El fitxer (i el directori) es crea si no existeix, i es fan còpies de seguretat cada 10 línies.
 * @param string $apartat Nom de l'apartat accedit
 * @return void
 */
function registreNavegacio(string $apartat): void
{
    
    $ruta = __DIR__ . '/../log/navegacio.log';
    $dir = dirname($ruta);
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }

    $backupDir = $dir . DIRECTORY_SEPARATOR . 'backup';
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0755, true);
    }

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
    $text = sprintf("%d :: Accés a l'apartat %s el dia %s a l'hora %s" . PHP_EOL,
        $numero,
        mb_strtoupper($apartat),
        $data,
        $hora
    );

    if ($numero % 10 === 0) {
        $stamp = $now->format('Ymd_His');
        $backupFile = $backupDir . DIRECTORY_SEPARATOR . "backup_{$stamp}.log";
        @copy($ruta, $backupFile);
    }

    if (!file_exists($ruta)) {
        @touch($ruta);
    }

    if (false === @file_put_contents($ruta, $text, FILE_APPEND | LOCK_EX)) {
        error_log("No s'ha pogut escriure al fitxer de navegació: $ruta");
    }
}


/**
 * Registre d'accions d'usuari
 * Escriu al fitxer /log/accionsUsuari.log una línia amb: usuari, acció, data i hora.
 * Només s'utilitzen accions com "accés correcte", "accés incorrecte", "usuari eliminat", "registre", "logout", etc.
 * @param string $accio Acció realitzada per l'usuari
 * @param string $usuari Email o identificador de l'usuari
 * @return void
 */
function registreAccionsUsuari(string $accio, string $usuari): void
{
    $ruta = __DIR__ . '/../log/accionsUsuari.log';

    $dir = dirname($ruta);
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }

    if (!file_exists($ruta)) {
        @touch($ruta);
    }

    $now = new DateTime();
    $data = $now->format('d/m/Y');
    $hora = $now->format('H:i:s');

    $text = sprintf(
        "%s, %s, %s, %s" . PHP_EOL,
        $usuari,
        $accio,
        $data,
        $hora
    );

    if (false === @file_put_contents($ruta, $text, FILE_APPEND | LOCK_EX)) {
        error_log("No s'ha pogut escriure al fitxer de registre: $ruta");
    }
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
    $correuEscapat = mysqli_real_escape_string($connexio, $correu);
    $sql = "SELECT passwd FROM Usuaris WHERE LOWER(correu) = LOWER('$correuEscapat')";
    $resultat = mysqli_query($connexio, $sql);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        $row = mysqli_fetch_assoc($resultat);
        return password_verify($passwd, $row['passwd']);
    } else {
        return false;
    }
}

function nouAnimal(int $idAnimal, int $quantitat): ?Animal
{
    $connexio = mysqli_connect('localhost', 'root', 'root', 'BBDDwwwJaume');
    if (!$connexio) {
        return null;
    }

    $sql = sprintf('SELECT id, nomcomu, nomcient, donacio, descripcio, img FROM Animal WHERE id = %d', $idAnimal);
    $resultat = mysqli_query($connexio, $sql);

    if (!$resultat || mysqli_num_rows($resultat) === 0) {
        mysqli_close($connexio);
        return null;
    }

    $fila = mysqli_fetch_assoc($resultat);
    $animal = new Animal(
        intval($fila['id']),
        $fila['nomcomu'],
        $fila['nomcient'],
        $quantitat,
        intval($fila['donacio']),
        $fila['descripcio'],
        $fila['img']
    );

    mysqli_free_result($resultat);
    mysqli_close($connexio);

    return $animal;
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
    <form id="formAnimal' . $id . '" 
          name="formAnimal' . $id . '" 
          action="index.php?apartat=apadrina" 
          method="POST">

        <input type="hidden" 
               id="idAnimal' . $id . '" 
               name="idAnimal" 
               value="' . $id . '">

        <div>
            <span>
                <label for="quantitatAnimal' . $id . '">Quantitat:</label>
            </span>
            <span>
                <input id="quantitatAnimal' . $id . '" 
                       name="quantitatAnimal" 
                       type="number" 
                       min="0" 
                       step="1" 
                       required>
            </span>
        </div>

        <div>
            <span>
                <button id="enviaFormAnimal' . $id . '" 
                        name="envia" 
                        type="submit">
                        Afegeix al carret
                </button>
            </span>
        </div>

    </form>';
}

function mostraApadrina($mostrar)
{
    if ($mostrar === 'carret') {
        include __DIR__ . '/partials/mostraCarret.partial.php';
    }else if ($mostrar === 'apadrina') {
        include __DIR__ . '/partials/mostrarApadrina.partial.php';
    }
     else {
        mostraAnimals();
    }
}
