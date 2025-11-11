<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Golosineria Fioramonti</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #ffe5ec, #ffe8a1, #d4f8e8);
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background: linear-gradient(90deg, #ff85a2, #ffb347);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        header h1 {
            font-family: 'Fredoka One', cursive;
            font-size: 2.2em;
            margin: 0;
        }

        nav {
            margin-top: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
            font-weight: bold;
            transition: 0.3s;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            max-width: 400px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #ff6388;
            font-family: 'Fredoka One', cursive;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1em;
        }

        input[type="submit"] {
            background: #ff85a2;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #ff6388;
            transform: scale(1.05);
        }

        p {
            margin-top: 10px;
        }

        a {
            color: #ff85a2;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            background: #fff;
            text-align: center;
            padding: 15px;
            font-size: 0.9em;
            color: #777;
            border-top: 2px solid #ffd1dc;
            margin-top: 60px;
        }

        .error {
            background: #ffdddd;
            color: #b30000;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <h1>🍭 Golosineria Fioramonti 🍭</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="index.php?accion=carrito">Carrito</a>
            <a href="index.php?accion=registro">Registrarse</a>
        </nav>
    </header>

    <main>
        <h2>Iniciar Sesión</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?accion=login_validar" method="post">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <input type="submit" value="Ingresar">
        </form>

        <p>¿No tenés cuenta? <a href="index.php?accion=registro">Registrate acá</a></p>
    </main>

    <footer>
        Tienda de Golosinas 🍬 - Hecho por Thiago V. Fioramonti
    </footer>
</body>
</html>
