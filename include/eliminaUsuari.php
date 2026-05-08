<?php

if (!isset($_GET['id'])) {
    header('Location: ../index.php?apartat=admin');
    exit;
}

$id = intval($_GET['id']);

$adminEmail = '';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (file_exists(__DIR__ . '/funcions.php')) {
    include_once __DIR__ . '/funcions.php';
    $adminEmail = $_SESSION['usuari'] ?? '';
}

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

header('Location: ../index.php?apartat=admin');
exit;
