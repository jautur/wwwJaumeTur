<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php missatgeErrorLogin($_GET['error'] ?? ''); ?>

<form id="formulari-login" class="form-login" method="post" action="?apartat=processa_login">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" maxlength="70" >

    <label for="passwd">Contrasenya:</label>
    <input type="password" id="passwd" name="passwd" maxlength="50" >

    <button type="submit">Login</button>
    <input type="hidden" name="form" value="login">

</form>