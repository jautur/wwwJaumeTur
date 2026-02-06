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

    // Afegir al fitxer amb bloqueig
    file_put_contents($ruta, $text . PHP_EOL, FILE_APPEND | LOCK_EX);

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

    file_put_contents($ruta, $text . PHP_EOL, FILE_APPEND | LOCK_EX);
}
