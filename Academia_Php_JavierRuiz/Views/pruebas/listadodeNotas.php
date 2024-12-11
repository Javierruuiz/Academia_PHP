<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Notas</title>
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
<h1>Listado de notas</h1>
<div class="table-container">
    <?php if (!empty($notas)): ?>
        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Horario</th>
                <th>Nota</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($notas as $nota): ?>
                <tr>
                    <td><?= $nota['nombre'] ?></td>
                    <td><?= $nota['apellidos'] ?></td>
                    <td><?= $nota['horario'] ?></td>
                    <td><?= $nota['nota'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay notas para mostrar.</p>
    <?php endif; ?>
</div>


</body>
</html>
