<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Prueba</title>
    <style>
        /* Estilos CSS */
        /* ... */
    </style>
</head>
<body>
<h2>Editar Prueba</h2>
<form action="<?= BASE_URL ?>pruebas/actualizarPrueba/?id=<?= $pruebas->id ?>" method="post">
    <label for="nombre_alumno">Nombre del Alumno:</label>
    <input type="text" id="nombre_alumno" name="nombre_alumno" value="<?= $pruebas->nombre_alumno ?>" required><br><br>

    <label for="apellidos_alumno">Apellidos del Alumno:</label>
    <input type="text" id="apellidos_alumno" name="apellidos_alumno" value="<?= $pruebas->apellidos ?>" required><br><br>

    <label for="id_materia">Materias:</label>
    <select id="id_materia" name="id_materia" required>
        <!-- Opciones de materias -->
        <?php foreach ($materias as $materia): ?>
            <option value="<?= $materia->id ?>" <?php if ($materia->id === $pruebas->id_materia) echo 'selected'; ?>>
                <?= $materia->nombre_materia ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="trimestre">Trimestre:</label>
    <select id="trimestre" name="trimestre" required>
        <option value="primero" <?php if ($pruebas->trimestre === 'primero') echo 'selected'; ?>>Primero</option>
        <option value="segundo" <?php if ($pruebas->trimestre === 'segundo') echo 'selected'; ?>>Segundo</option>
        <option value="tercero" <?php if ($pruebas->trimestre === 'tercero') echo 'selected'; ?>>Tercero</option>
    </select><br><br>

    <label for="horario">Horario:</label>
    <input type="text" id="horario" name="horario" value="<?= $pruebas->horario ?>" required><br><br>

    <label for="nota">Nota:</label>
    <input type="text" id="nota" name="nota" value="<?= $pruebas->nota ?>" required><br><br>

    <!-- Botón para actualizar -->
    <input type="submit" value="Actualizar">
</form>
</body>
</html>
