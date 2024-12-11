<header>
    <nav>
        <ul>
            <?php if (isset($_SESSION['identity'])): ?>

                <h3><?= $_SESSION['identity']->nombre ?> <?= $_SESSION['identity']->apellidos ?></h3>
                <?php if ($_SESSION['identity']->rol === 'padre'): ?>
                    <li><a href="<?= BASE_URL ?>usuario/logout/">Cerrar sesión</a></li>
                    <li><a href="<?= BASE_URL ?>pruebas/generarPDF/">Ver notas</a></li>
                <?php elseif ($_SESSION['identity']->rol === 'admin'): ?>
                    <li><a href="<?= BASE_URL ?>pruebas/registroPrueba/">Asignar Prueba</a></li>
                    <li><a href="<?= BASE_URL ?>materia/obtenerPosibleProfesor/">Agregar Materia</a></li>
                    <li><a href="<?= BASE_URL ?>alumnos/obtenerPosiblePadre/">Agregar alumno</a></li>
                    <li><a href="<?= BASE_URL ?>usuario/registro/">Crear cuenta</a></li>
                    <li><a href="<?= BASE_URL ?>usuario/logout/">Cerrar sesión</a></li>

                <?php elseif ($_SESSION['identity']->rol === 'profesor'): ?>
                    <li><a href="<?= BASE_URL ?>pruebas/registroPrueba/">Asignar Prueba</a></li>
                    <li><a href="<?= BASE_URL ?>pruebas/generarPDF/">Ver notas</a></li>
                    <li><a href="<?= BASE_URL ?>usuario/logout/">Cerrar sesión</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </nav>
</header>
