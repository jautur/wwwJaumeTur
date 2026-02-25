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

    if (empty($cognoms)) {
        $sql = "INSERT INTO Usuaris (nom, correu, passwd, img, date)
                VALUES ('$nom', '$correu', '$contrasenya', '$img', NOW())";
    } else {
        $sql = "INSERT INTO Usuaris (nom, cognoms, correu, passwd, img, date)
                VALUES ('$nom', '$cognoms', '$correu', '$contrasenya', '$img', NOW())";
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
    $sql = "SELECT id FROM Usuaris WHERE correu = '$correu'";
    $resultat = mysqli_query($connexio, $sql);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        return true;
    } else {
        return false;
    }
}

function redirigeixErrorContrasenya()
{
    header("Location: ?apartat=registre&error=contrasenya");
    die();
}