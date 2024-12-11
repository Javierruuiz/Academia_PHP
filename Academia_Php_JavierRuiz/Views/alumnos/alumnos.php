<!-- formulario_pruebas.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Alumno</title>
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
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
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
    </style>
</head>
<body>
<header>
</header>
<main>
    <h2>Agregar Nuevo Alumno</h2>
    <?php use Utils\Utils; ?>
    <?php if(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'complete'): ?>
        <h6> <strong class="alert_green">Registro completado correctamente</strong> </h6>
    <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'failed'): ?>
        <h6><strong class="alert_red">Registro fallido, introduzca bien los datos</strong> </h6>
    <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'invalid_format'): ?>
        <h6><strong class="alert_red">Registro fallido, el nombre y apellidos del alumno deben empezar por mayúscula</strong> </h6>
    <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'empty_fields'): ?>
        <h6><strong class="alert_red">Registro fallido, los campos deben estar rellenos</strong> </h6>
    <?php endif; ?>
    <?php Utils::deleteSession('alumno_added'); ?>


    <form action="<?= BASE_URL ?>alumnos/agregarAlumno/" method="post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" required><br><br>


        <label for="id_padre">Padre:</label>
        <select id="id_padre" name="id_padre" required>
            <option value="" disabled selected>Lista de padres</option>
            <?php

            foreach ($padres as $padre) {
                echo "<option value='" . $padre->id . "'>" . $padre->nombre.' '.$padre->apellidos . "</option>";
            }

            ?>
        </select><br><br><br>

        <input type="submit" value="Guardar">
    </form>
</main>
</body>
</html><!-- formulario_pruebas.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Alumno</title>
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
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
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
    </style>
</head>
<body>
<header>
</header>
<main>
    <h2>Agregar Nuevo Alumno</h2>
    <?php if(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'complete'): ?>
        <h6> <strong class="alert_green">Registro completado correctamente</strong> </h6>
    <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'failed'): ?>
        <h6><strong class="alert_red">Registro fallido, introduzca bien los datos</strong> </h6>
    <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'invalid_format'): ?>
        <h6><strong class="alert_red">Registro fallido, el nombre y apellidos del alumno deben empezar por mayúscula</strong> </h6>
    <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'empty_fields'): ?>
        <h6><strong class="alert_red">Registro fallido, los campos deben estar rellenos</strong> </h6>
    <?php endif; ?>
    <?php Utils::deleteSession('alumno_added'); ?>


    <form action="<?= BASE_URL ?>alumnos/agregarAlumno/" method="post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" required><br><br>


        <label for="id_padre">Padre:</label>
        <select id="id_padre" name="id_padre" required>
            <option value="" disabled selected>Lista de padres</option>
            <?php

            foreach ($padres as $padre) {
                echo "<option value='" . $padre->id . "'>" . $padre->nombre.' '.$padre->apellidos . "</option>";
            }

            ?>
        </select><br><br><br>

        <input type="submit" value="Guardar">
    </form>
</main>
</body>
</html>
