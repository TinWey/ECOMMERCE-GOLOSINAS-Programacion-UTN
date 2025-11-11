<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Conexión
$conexion = new mysqli("localhost", "root", "", "golosinas_db");
$res = $conexion->query("SELECT * FROM productos");

// Preparamos productos en un array
$productos = [];
while ($p = $res->fetch_assoc()) {
    $productos[] = [
        'id' => $p['id'],
        'nombre' => htmlspecialchars($p['nombre']),
        'precio' => number_format($p['precio'], 2),
        'imagen' => htmlspecialchars($p['imagen'])
    ];
}

$usuario = $_SESSION['usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🍭 Golosinas - Tienda Dulce</title>
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

        .productos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            padding: 40px;
            max-width: 1200px;
            margin: auto;
        }

        .producto {
            background: white;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .producto:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.15);
        }

        .producto img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 10px;
        }

        .producto b {
            display: block;
            font-size: 1.1em;
            margin: 8px 0;
            color: #ff6388;
        }

        .precio {
            font-weight: bold;
            color: #444;
            margin-bottom: 10px;
        }

        .btn-agregar {
            background: #ff85a2;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-agregar:hover {
            background: #ff6388;
            transform: scale(1.05);
        }

        footer {
            background: #fff;
            text-align: center;
            padding: 15px;
            font-size: 0.9em;
            color: #777;
            border-top: 2px solid #ffd1dc;
        }
    </style>
</head>
<body>
    <header>
        <h1>🍭 Golosineria Fioramonti</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="index.php?accion=carrito">🛒 Carrito</a>
            <?php if ($usuario): ?>
                <a href="#">👋 Hola, <?= $usuario; ?></a>
                <a href="index.php?accion=logout">Cerrar sesión</a>
            <?php else: ?>
                <a href="index.php?accion=login">Iniciar sesión</a>
                <a href="index.php?accion=registro">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="productos">
        <?php foreach ($productos as $p): ?>
            <div class="producto">
                <img src="assets/img/<?= $p['imagen']; ?>" alt="Imagen de <?= $p['nombre']; ?>">
                <b><?= $p['nombre']; ?></b>
                <div class="precio">$<?= $p['precio']; ?></div>
                <form action="index.php" method="get">
                    <input type="hidden" name="accion" value="agregar">
                    <input type="hidden" name="id" value="<?= $p['id']; ?>">
                    <button type="submit" class="btn-agregar">Agregar 🛍️</button>
                </form>
            </div>
        <?php endforeach; ?>
    </main>

    <footer>
         Tienda de Golosinas 🍬 - Hecho por Thiago V. Fioramonti
    </footer>
</body>
</html>
