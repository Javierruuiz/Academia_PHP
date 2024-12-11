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
        strong{
            text-align: center;
        }
    </style>
</head>
<body>
<h2>Login</h2>
<?php use Utils\Utils; ?>
<?php if(isset($_SESSION['error_login']) && $_SESSION['error_login'] == 'failed'): ?>
    <h6> <strong class="alert_red">Registro fallido, introduzca bien los datos</strong> </h6>
<?php endif; ?>
<?php Utils::deleteSession('error_login'); ?>

<form action="<?=BASE_URL?>usuario/login/" method="post">
    <label for="nombre_usuario">Nombre de usuario</label>
    <input type="text" name="data[nombre_usuario]" id="nombre_usuario" />
    <br>
    <label for="pass">Contraseña</label>
    <input type="password" name="data[pass]" id="pass"/>
    <br>
    <input type="submit" value="Enviar" />
</form>

</body>
</html>
