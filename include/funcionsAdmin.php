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

    echo "<table class='taula-animal'>"; 
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
            echo '<td><img src="img/admin.jpeg" alt="admin" width="50px" height="50px"></td>';
        } else {
            echo '<td><a href="include/eliminaUsuari.php?id=' . $id . '"><img src="img/eliminar.jpg" alt="eliminar" width="50px" height="50px"></a></td>';
        }

        echo '</tr>';
    }

    echo '</table>';

    mysqli_free_result($resultat);
    mysqli_close($connexio);
}

