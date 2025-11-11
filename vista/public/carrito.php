<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();}
$conexion = new mysqli("localhost", "root", "", "golosinas_db");

$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito - Golosinas</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #ff6b81, #feca57);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: #fff;
            margin: 60px auto;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #ff6b81;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #555;
        }

        td img {
            border-radius: 8px;
        }

        .acciones {
            text-align: center;
            margin-top: 20px;
        }

        button, .btn {
            background: #ff6b81;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            margin: 5px;
            display: inline-block;
        }

        button:hover, .btn:hover {
            background: #ff4757;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
            margin-top: 15px;
        }

        a.volver {
            display: inline-block;
            margin-top: 20px;
            color: #ff6b81;
            text-decoration: none;
        }

        a.volver:hover {
            color: #ff4757;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛒 Tu Carrito</h1>

        <?php if (empty($carrito)): ?>
            <p style="text-align:center;">Tu carrito está vacío 😢</p>
            <div class="acciones">
                <a href="index.php" class="btn">Volver a la tienda</a>
            </div>
        <?php else: ?>
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
                <?php
                foreach ($carrito as $id => $cantidad):
                    $res = $conexion->query("SELECT * FROM productos WHERE id = $id");
                    if ($p = $res->fetch_assoc()):
                        $subtotal = $p['precio'] * $cantidad;
                        $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $p['nombre']; ?></td>
                    <td>$<?php echo number_format($p['precio'], 2); ?></td>
                    <td><?php echo $cantidad; ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endif; endforeach; ?>
            </table>

            <div class="total">Total: $<?php echo number_format($total, 2); ?></div>

            <div class="acciones">
                <form method="POST" action="index.php?accion=comprar" style="display:inline;">
                    <button type="submit">Finalizar compra</button>
                </form>
                <a href="index.php?accion=vaciar" class="btn">Vaciar carrito</a>
                <a href="index.php" class="btn">Seguir comprando</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
