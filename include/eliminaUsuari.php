<?php
// eliminaUsuari.php
// S'espera un paràmetre GET id amb l'identificador d'usuari a esborrar.
// Un cop eliminat, redirigeix a la pàgina d'administració.

if (!isset($_GET['id'])) {
    header('Location: ../index.php?apartat=admin');
    exit;
}

$id = intval($_GET['id']);

$conn = mysqli_connect("localhost", "root", "root", "BBDDwwwJaume");
if ($conn) {
    $idEsc = mysqli_real_escape_string($conn, (string)$id);
    $sql = "DELETE FROM Usuaris WHERE id=$idEsc";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

// després de l'acció tornem a l'administració
header('Location: ../index.php?apartat=admin');
exit;
