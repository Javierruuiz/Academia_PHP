<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<h2>Crear una cuenta</h2>
<?php use Utils\Utils; ?>
<?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
    <h6><strong class="alert_green">Registro completado correctamente</strong></h6>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
    <h6> <strong class="alert_red">Registro fallido, introduzca bien los datos</strong> </h6>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'invalid_name_format'): ?>
    <h6> <strong class="alert_red">Registro fallido, el nombre debe empezar por mayúscula</strong> </h6>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'invalid_last_name_format'): ?>
    <h6> <strong class="alert_red">Registro fallido, los apellidos deben empezar por mayuscula, y deben ser al menos 2</strong> </h6>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'empty_fields'): ?>
    <h6> <strong class="alert_red">Registro fallido, loas campos no pueden estar vacios</strong> </h6>
<?php endif; ?>
<?php Utils::deleteSession('register'); ?>
<form action="<?=BASE_URL?>usuario/registro/" method="POST">

    <label for="nombre">Nombre</label>
    <input type="text" name="data[nombre]"  value="<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ''; ?>" required/>
    <br>
    <label for="apellidos">Apellidos</label>
    <input type="text" name="data[apellidos]" value="<?php echo isset($_SESSION['apellidos']) ? $_SESSION['apellidos'] : ''; ?>" required/>
    <br>
    <label for="nombre_usuario">Nombre de usuario</label>
    <input type="text" name="data[nombre_usuario]" required/>
    <br>
    <label for="pass">Contraseña</label>
    <input type="password" name="data[pass]" required/>
    <br>
    <label for="rol">Rol</label>
    <select name="data[rol]" required>
        <option value="profesor">Profesor</option>
        <option value="padre">Padre</option>
    </select>
    <br>
    <br>

    <input type="submit" value="Registrarse" />
</body>
</html>
