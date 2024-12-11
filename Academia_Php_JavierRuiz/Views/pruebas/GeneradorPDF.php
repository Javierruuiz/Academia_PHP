<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar PDF de Notas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            width: 60vw;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        select, button {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Notas por Materia y Trimestre</h1>
    <form action="<?= BASE_URL ?>pruebas/NotasPorMateriaYTrimestre/" method="post">
        <label for="id_materia">Materia:</label>
        <select name="id_materia" id="id_materia">
            <?php
            foreach ($materias as $materia) {
                echo '<option value="' . $materia->id . '">' . $materia->nombre_materia . '</option>';
            }

            ?>
        </select>
        <br>
        <label for="trimestre">Trimestre:</label>
        <select name="trimestre" id="trimestre">
            <option value="primero">Primero</option>
            <option value="segundo">Segundo</option>
            <option value="tercero">Tercero</option>
        </select>
        <br>
        <button type="submit">Ver</button>
    </form>
</div>

<div class="form-container">
    <h1>Listado completo de notas de un alumno</h1>
    <form action="<?= BASE_URL ?>pruebas/ListadoCompletoPorAlumno/" method="post">
        <label for="alumno">Alumno:</label>
        <select name="alumno" id="alumno">
            <?php foreach ($alumnos as $alumno): ?>
                <option value="<?= $alumno['id'] ?>"><?= $alumno['nombre'] ?> <?= $alumno['apellidos'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Ver</button>
    </form>

</div>

<div class="form-container">
    <h1>Listado notas medias por asignatura.</h1>

    <form action="<?= BASE_URL ?>pruebas/NotasMediasPorAsignatura/" method="post">
        <label for="id_materia">Materia:</label>
        <select name="id_materia" id="id_materia">
            <?php
            foreach ($materias as $materia) {
                echo '<option value="' . $materia->id . '">' . $materia->nombre_materia . '</option>';
            }

            ?>
        </select>

        <br>
        <button type="submit">Ver</button>
    </form>
</div>

<div class="form-container">
    <h1>Listado notas medias por alumno.</h1>

    <form action="<?= BASE_URL ?>pruebas/NotasMediasPorAlumno/" method="post">
        <label for="alumno">Alumno:</label>
        <select name="alumno" id="alumno">
            <?php foreach ($alumnos as $alumno): ?>
                <option value="<?= $alumno['id'] ?>"><?= $alumno['nombre'] ?> <?= $alumno['apellidos'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Ver</button>
    </form>
</div>
</body>
</html>
