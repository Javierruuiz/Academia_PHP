<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas por Alumno</title>
    <style>
        .table-container {
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        h1{
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Notas por Alumno</h1>
<?php if (!empty($notas)): ?>
    <table>
        <thead>
        <tr>
            <th>Asignatura</th>
            <th>Trimestre</th>
            <th>Nota</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($notas as $nota): ?>
            <tr>
                <td><?= $nota['nombre_materia'] ?></td>
                <td><?= $nota['trimestre'] ?></td>
                <td><?= $nota['nota'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay notas para mostrar.</p>
<?php endif; ?>
</body>
</html>
