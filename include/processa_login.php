<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$passwd = trim($_POST['passwd'] ?? '');

require_once __DIR__ . '/funcions.php';
require_once __DIR__ . '/entity/CarretCompra.php';
require_once __DIR__ . '/entity/Animal.php';


if (empty($email) || empty($passwd)) {

    registreAccionsUsuari("accés incorrecte (camps buits)", $email);

    redirigeixLoginBuit();
    exit;
}

$connexio = mysqli_connect("localhost", "root", "root", "BBDDwwwJaume");

if (!$connexio) {
    header("Location: ../index.php");
    exit;
}

if (!usuariExisteix($email, $connexio)) {

    registreAccionsUsuari("accés incorrecte (correu no existent)", $email);

    mysqli_close($connexio);
    redirigeixLoginCorreu();
    exit;
}

if (!passwdCorrecta($email, $passwd, $connexio)) {

    registreAccionsUsuari("accés incorrecte (contrasenya incorrecta)", $email);

    mysqli_close($connexio);
    redirigeixLoginIncorrecte();
    exit;
}

$sql = "SELECT nom FROM Usuaris WHERE LOWER(correu) = LOWER('$email')";
$resultat = mysqli_query($connexio, $sql);

if ($resultat && mysqli_num_rows($resultat) > 0) {

    $row = mysqli_fetch_assoc($resultat);

    $_SESSION['usuari'] = $email;
    $_SESSION['nom'] = $row['nom'];

    if (isset($_SESSION['carret'])) {
        $carret = null;
        if (is_string($_SESSION['carret'])) {
            $carret = unserialize($_SESSION['carret'], ['allowed_classes' => true]);
        } elseif ($_SESSION['carret'] instanceof CarretCompra) {
            $carret = $_SESSION['carret'];
        }
        if ($carret instanceof CarretCompra) {
            $carret->setUsuariId($email);
            $_SESSION['carret'] = serialize($carret);
        }
    }

    registreAccionsUsuari("accés correcte", $email);

} else {

    registreAccionsUsuari("accés incorrecte", $email);
    mysqli_close($connexio);
    redirigeixLoginIncorrecte();
    exit;
}

mysqli_close($connexio);

session_regenerate_id(true);

redirigeixLoginValid();
exit;