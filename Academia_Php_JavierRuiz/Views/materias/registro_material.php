<!-- formulario_materia.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Materia</title>
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
    <h2>Agregar Nueva Materia</h2>
    <?php use Utils\Utils; ?>
    <?php if(isset($_SESSION['materia_added']) && $_SESSION['materia_added'] == 'complete'): ?>
        <h6>  <strong class="alert_green">Registro completado correctamente</strong> </h6>
    <?php elseif(isset($_SESSION['materia_added']) && $_SESSION['materia_added'] == 'failed'): ?>
        <h6> <strong class="alert_red">Registro fallido, introduzca bien los datos</strong> </h6>
    <?php elseif(isset($_SESSION['materia_added']) && $_SESSION['materia_added'] == 'duplicate'): ?>
        <h6> <strong class="alert_red">Registro fallido, esa asignatura ya esta asignada</strong> </h6>
    <?php elseif(isset($_SESSION['materia_added']) && $_SESSION['materia_added'] == 'invalid_format'): ?>
        <h6> <strong class="alert_red">Registro fallido, la primera letra debe empezar por mayúscula</strong> </h6>
    <?php endif; ?>
    <?php Utils::deleteSession('materia_added'); ?>
    <form action="<?= BASE_URL ?>materia/agregarMateria/" method="post">

        <label for="nombre_materia">Nombre de la Materia:</label><br>
        <input type="text" id="nombre_materia" name="nombre_materia" required><br>

        <label for="id_profesor">Profesor de la materia:</label>
        <select id="id_profesor" name="id_profesor" required>
            <option value="" disabled selected>Selecciona un profesor</option>
            <?php

            foreach ($profesores as $profesor) {
                echo "<option value='" . $profesor->id . "'>" . $profesor->nombre. ' '. $profesor->apellidos. "</option>";
            }

            ?>
        </select><br><br><br>

        <input type="submit" value="Guardar">
    </form>
</main>
</body>
</html>
