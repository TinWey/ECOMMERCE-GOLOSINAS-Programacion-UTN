<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$conexion = new mysqli("localhost", "root", "", "golosinas_db");
$res = $conexion->query("SELECT * FROM productos");

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
    <style> </style>
</head>
<link rel="stylesheet" href="assets/css/estilos.css">
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
