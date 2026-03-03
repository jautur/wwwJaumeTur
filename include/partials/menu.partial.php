<nav>
    <ul>
        <li><a href="?apartat=inici">Inici</a></li>
        <li><a href="?apartat=registre">Registre</a></li>
        <li><a href="?apartat=contacte">Contacte</a></li>
        <li><a href="?apartat=apadrina">Apadrina</a></li>
        <?php if (isset($_SESSION['usuari']) && $_SESSION['usuari'] === 'admin@daw.com'): ?>
            <li><a href="?apartat=admin">Administracio</a></li>
        <?php endif; ?>
    </ul>
</nav>