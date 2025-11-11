<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Golosinas</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #ff6b81, #feca57);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            margin: 100px auto;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 {
            color: #ff6b81;
            margin-bottom: 20px;
            font-size: 26px;
        }

        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border: 1px solid #ff6b81;
        }

        button {
            background: #ff6b81;
            color: #fff;
            border: none;
            padding: 12px 0;
            width: 100%;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #ff4757;
        }

        a {
            text-decoration: none;
            color: #ff6b81;
            display: inline-block;
            margin-top: 15px;
        }

        a:hover {
            color: #ff4757;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear cuenta</h1>
        <form method="POST" action="index.php?accion=registro_guardar">
            <input type="text" name="usuario" placeholder="Nombre de usuario" required><br>
            <input type="password" name="pass" placeholder="Contraseña" required><br>
            <button type="submit">Registrarme</button>
        </form>
        <a href="index.php?accion=login">¿Ya tienes cuenta? Inicia sesión</a><br>
        <a href="index.php">← Volver al inicio</a>
    </div>
</body>
</html>
