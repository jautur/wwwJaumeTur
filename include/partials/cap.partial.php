<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<header>
    <h1>Projecte <i><b>APADRIMALS</b></i> </h1>
    <div class="data-css" id="data">
        <div class="divdata">
            <h3><?php include __DIR__ . '/data.partial.php'; ?></h3>
        </div>
        <div class="divcss">
            <h3><?php include __DIR__ . '/css.partial.php'; ?></h3>
        </div>
    </div>
    <div class="divlogin">
        <?php if (isset($_SESSION['usuari'])): ?>
                <h3>Benvingut <?= htmlspecialchars($_SESSION['nom']) ?> 👋</h3>
                <a href="?logout=1">Logout</a>
        <?php else: ?>
                <h3><?php include __DIR__ . '/login.partial.php'; ?></h3>
        <?php endif; ?>
    </div>


</header>