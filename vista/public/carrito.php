<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$conexion = new mysqli("localhost", "root", "", "golosinas_db");
$carrito = $_SESSION['carrito'] ?? [];
$productos = [];
$total = 0;

if (!empty($carrito)) {
    $ids = implode(',', array_map('intval', array_keys($carrito)));
    $res = $conexion->query("SELECT * FROM productos WHERE id IN ($ids)");
    while ($p = $res->fetch_assoc()) {
        $p['cantidad'] = $carrito[$p['id']];
        $p['subtotal'] = $p['cantidad'] * $p['precio'];
        $total += $p['subtotal'];
        $productos[] = $p;
    }
}

$usuario = $_SESSION['usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🛒 Carrito de Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <header>
        <h1>🍭 Golosineria Fioramonti</h1>
        <nav>
            <a href="index.php">Inicio</a>
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
        <?php if (empty($productos)): ?>
            <p>Tu carrito está vacío.</p>
        <?php else: ?>
            <?php foreach ($productos as $p): ?>
                <div class="producto">
                    <img src="assets/img/<?= htmlspecialchars($p['imagen']); ?>" alt="Imagen de <?= htmlspecialchars($p['nombre']); ?>">
                    <b><?= htmlspecialchars($p['nombre']); ?></b>
                    <div class="precio">$<?= number_format($p['precio'],2); ?></div>
                    <p>Cantidad: <?= $p['cantidad']; ?></p>
                    <p>Subtotal: $<?= number_format($p['subtotal'],2); ?></p>
                </div>
            <?php endforeach; ?>
            <div class="producto" style="width:100%; text-align:center;">
                <h3>Total: $<?= number_format($total,2); ?></h3>
                <form action="index.php" method="get" style="display:inline-block; margin-right:10px;">
                    <input type="hidden" name="accion" value="vaciar">
                    <button type="submit" class="btn-agregar">Vaciar Carrito</button>
                </form>
                <form action="index.php" method="get" style="display:inline-block;">
                    <input type="hidden" name="accion" value="comprar">
                    <button type="submit" class="btn-agregar">Finalizar Compra</button>
                </form>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        Tienda de Golosinas 🍬 - Hecho por Thiago V. Fioramonti
    </footer>
</body>
</html>
