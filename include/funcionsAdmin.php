<?php

/**
 * Mostra una taula amb els usuaris existents.
 * El camp contrasenya es tallarà a 15 caràcters amb "...".
 * A la columna d'accions hi ha un enllaç a include/eliminaUsuari.php.
 */
function gestionaUsuaris(): void
{
    $connexio = mysqli_connect("localhost", "root", "root", "BBDDwwwJaume");
    if (!$connexio) {
        echo '<p style="color:red;">Error de connexió amb la base de dades</p>';
        return;
    }

    // la taula Usuaris usa `correu` i `passwd` en lloc d'`email`/`contrasenya`
    $consulta = "SELECT `id`,`nom`,`correu`,`passwd` FROM `Usuaris`";
    $resultat = mysqli_query($connexio, $consulta);
    if (!$resultat) {
        echo '<p style="color:red;">Error en la consulta</p>';
        mysqli_close($connexio);
        return;
    }

    echo "<table class='taulaUsuaris'>"; 
    echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Contrasenya</th><th>Acció</th></tr>"; // corresponents a `correu` i `passwd`

    while ($fila = mysqli_fetch_assoc($resultat)) {
        $id = $fila['id'];
        $nom = htmlspecialchars($fila['nom']);
        $email = htmlspecialchars($fila['correu']);
        $pass = $fila['passwd'];

        if (strlen($pass) > 15) {
            $pass = substr($pass, 0, 15) . '...';
        }
        $pass = htmlspecialchars($pass);

        echo '<tr>';
        echo "<td>$id</td>";
        echo "<td>$nom</td>";
        echo "<td>$email</td>";
        echo "<td>$pass</td>";

        if ($email === 'admin@daw.com') {
            echo '<td><img src="img/admin.png" alt="admin" width="50px" height="50px"></td>';
        } else {
            echo '<td><a href="include/eliminaUsuari.php?id=' . $id . '"><img src="img/eliminar.png" alt="eliminar" width="50px" height="50px"></a></td>';
        }

        echo '</tr>';
    }

    echo '</table>';

    mysqli_free_result($resultat);
    mysqli_close($connexio);
}

function mostraAccionsUsuaris(): void
{
    // cada línia es mostrarà amb classe segons l'acció per tal de poder-li aplicar
    // un color de fons diferent des de CSS.
    $ruta = __DIR__ . '/../log/accionsUsuari.log';
    if (!file_exists($ruta)) {
        echo '<p style="color:red;">No s\'han trobat accions d\'usuaris.</p>';
        return;
    }

    $lines = @file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!is_array($lines)) {
        echo '<p style="color:red;">Error llegint el fitxer de registres.</p>';
        return;
    }

    echo '<div class="accions-usuaris">';
    foreach ($lines as $line) {
        $cls = 'accio-default';
        $lower = mb_strtolower($line);
        if (str_contains($lower, 'accés correcte') || str_contains($lower, 'acces correcte')) {
            $cls = 'accio-correcte';
        } elseif (str_contains($lower, 'accés incorrecte') || str_contains($lower, 'acces incorrecte')) {
            $cls = 'accio-incorrecte';
        } elseif (str_contains($lower, 'usuari eliminat') || str_contains($lower, 'eliminar usuari')) {
            $cls = 'accio-eliminat';
        } elseif (str_contains($lower, 'registre')) {
            $cls = 'accio-registre';
        } elseif (str_contains($lower, 'logout')) {
            $cls = 'accio-logout';
        }
        echo '<p class="' . $cls . '">' . htmlspecialchars($line) . '</p>';
    }
    echo '</div>';
}
