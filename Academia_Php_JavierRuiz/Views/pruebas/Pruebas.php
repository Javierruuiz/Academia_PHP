<!-- formulario_pruebas.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Prueba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2{
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            margin-left: 20px;
            background-color: #007bff;
            color: #fff;
            font-weight: bolder;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            color:#007bff;
            background-color: white;
            border:1px solid #007bff;
        }
        .alert_green {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .alert_red {
            color: #721c24;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        h6{
            text-align: center;
        }

        table {
            margin: 0 auto; /* Margen automático a la izquierda y derecha */
            text-align: center;
        }

    </style>
</head>
<body>
<header>
</header>
<main>
    <h2>Lista de Pruebas</h2>
    <?php use Utils\Utils; ?>
    <?php if(isset($_SESSION['prueba_added']) && $_SESSION['prueba_added'] == 'duplicate'): ?>
        <h6><strong class="alert_red">El alumno ya tiene una nota para esta asignatura y trimestre</strong></h6>
    <?php elseif(isset($_SESSION['prueba_added']) && $_SESSION['prueba_added'] == 'complete'): ?>
        <h6><strong class="alert_green">Registro completado correctamente</strong></h6>
    <?php elseif(isset($_SESSION['prueba_added']) && $_SESSION['prueba_added'] == 'failed'): ?>
        <h6><strong class="alert_red">Registro fallido, introduzca bien los datos</strong></h6>
    <?php endif; ?>
    <?php Utils::deleteSession('prueba_added'); ?>


    <?php if(isset($_SESSION['prueba_updated']) && $_SESSION['prueba_updated'] == 'complete'): ?>
        <h6><strong class="alert_green">Registro actualizado correctamente</strong></h6>
    <?php elseif(isset($_SESSION['prueba_updated']) && $_SESSION['prueba_updated'] == 'failed'): ?>
        <h6><strong class="alert_red">Edición fallida, introduzca bien los datos</strong></h6>
    <?php elseif(isset($_SESSION['prueba_updated']) && $_SESSION['prueba_updated'] == 'duplicate'): ?>
        <h6><strong class="alert_red">Edición fallida, esa nota ya esta puesta</strong></h6>
    <?php endif; ?>
    <?php Utils::deleteSession('prueba_updated'); ?>

    <?php if(isset($_SESSION['prueba_deleted']) && $_SESSION['prueba_deleted'] == 'complete'): ?>
        <h6><strong class="alert_green">Registro eliminado correctamente</strong></h6>
    <?php elseif(isset($_SESSION['prueba_deleted']) && $_SESSION['prueba_deleted'] == 'failed'): ?>
        <h6><strong class="alert_red">Eliminación fallida</strong></h6>
    <?php endif; ?>
    <?php Utils::deleteSession('prueba_deleted'); ?>

    <!-- Aquí se mostrará la lista de pruebas existentes -->
    <table>
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Materia</th>
            <th>Trimestre</th>
            <th>Horario</th>
            <th>Nota</th>
            <th colspan="2">Operaciones</th>
        </tr>
        </thead>
        <tbody>
        <!-- Recorrido de los registros de la tabla pruebas -->
        <?php foreach ($pruebas as $prueba): ?>
            <tr>
                <td><?= $prueba->nombre_alumno?></td>
                <td><?= $prueba->apellidos?></td>
                <td><?= $prueba->nombre_materia?></td>
                <td><?= $prueba->trimestre?></td>
                <td><?= $prueba->horario?></td>
                <td><?= $prueba->nota?></td>
                <td><a href="<?= BASE_URL ?>pruebas/editarPrueba/?id=<?= $prueba->id ?>">Editar</a></td>
                <td><a href="<?= BASE_URL ?>pruebas/eliminarPrueba/?id=<?= $prueba->id ?>">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <form action="<?= BASE_URL ?>pruebas/agregarPrueba/" method="post">
                <td><input type="text" id="nombre_alumno" name="nombre_alumno" required></td>
                <td><input type="text" id="apellidos_alumno" name="apellidos_alumno" required></td>
                <td><select id="id_materia" name="id_materia" required>
                        <option value="" disabled selected>Selecciona una categoría</option>
                        <?php foreach ($materias as $materia): ?>
                            <option value="<?= $materia->id ?>"><?= $materia->nombre_materia ?></option>
                        <?php endforeach; ?>
                    </select></td>
                <td><select id="trimestre" name="trimestre" required>
                        <option value="" disabled selected>Selecciona un trimestre</option>
                        <option value="primero">Primero</option>
                        <option value="segundo">Segundo</option>
                        <option value="tercero">Tercero</option>
                    </select></td>
                <td><input type="text" id="horario" name="horario" required></td>
                <td><input type="text" id="nota" name="nota" required></td>
                <td><input type="submit" value="Guardar"></td>
            </form>
        </tr>
        </tbody>
    </table>


</main>
</body>
</html>
