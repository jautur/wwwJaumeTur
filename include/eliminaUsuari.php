<?php
// eliminaUsuari.php
// S'espera un paràmetre GET id amb l'identificador d'usuari a esborrar.
// Un cop eliminat, redirigeix a la pàgina d'administració.

if (!isset($_GET['id'])) {
    header('Location: ../index.php?apartat=admin');
    exit;
}

$id = intval($_GET['id']);

// registrar la supressió per l'usuari administrador si hi ha sessió
$adminEmail = '';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (file_exists(__DIR__ . '/funcions.php')) {
    include_once __DIR__ . '/funcions.php';
    $adminEmail = $_SESSION['usuari'] ?? '';
}

// recuperem l'email de l'usuari que es va a esborrar
$usuariEmail = '';
$connTemp = mysqli_connect("localhost", "root", "root", "BBDDwwwJaume");
if ($connTemp) {
    $idEsc2 = mysqli_real_escape_string($connTemp, (string)$id);
    $sql2 = "SELECT correu FROM Usuaris WHERE id=$idEsc2";
    $res2 = mysqli_query($connTemp, $sql2);
    if ($res2 && mysqli_num_rows($res2) > 0) {
        $row2 = mysqli_fetch_assoc($res2);
        $usuariEmail = $row2['correu'];
    }
    mysqli_close($connTemp);
}

if (!empty($usuariEmail) && !empty($adminEmail)) {
    registreAccionsUsuari('ELIMINAR USUARI ' . $usuariEmail, $adminEmail);
} elseif (!empty($adminEmail)) {
    registreAccionsUsuari('ELIMINAR USUARI id=' . $id, $adminEmail);
}

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
