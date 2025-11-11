<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "golosinas_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexión fallida");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'agregar') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = floatval($_POST['precio'] ?? 0);
    $categoria = intval($_POST['categoria'] ?? 0);
    $imagen = $_POST['imagen'] ?? '';

    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, categoria_id, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $categoria, $imagen);
    $stmt->execute();
    header("Location: panel.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: panel.php");
    exit;
}

$productos = $conn->query("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id");
$categorias = $conn->query("SELECT * FROM categorias");
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Panel Admin</title><link rel="stylesheet" href="../../assets/css/estilos.css"></head>
<body>
    <h1>Panel Admin</h1>
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>

    <h2>Agregar producto</h2>
    <form method="POST">
        <input type="hidden" name="accion" value="agregar">
        <input name="nombre" required placeholder="Nombre"><br>
        <input name="descripcion" required placeholder="Descripción"><br>
        <input name="precio" type="number" step="0.01" required placeholder="Precio"><br>
        <select name="categoria" required>
            <option value="">Seleccionar</option>
            <?php while($c = $categorias->fetch_assoc()): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nombre']); ?></option>
            <?php endwhile; ?>
        </select><br>
        <input name="imagen" placeholder="archivo.jpg" required><br>
        <button type="submit">Agregar</button>
    </form>

    <h2>Productos</h2>
    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Imagen</th><th>Nombre</th><th>Precio</th><th>Categoria</th><th>Acciones</th></tr>
        <?php while($p = $productos->fetch_assoc()): ?>
            <tr>
                <td><?php echo $p['id']; ?></td>
                <td><img src="../../assets/img/<?php echo htmlspecialchars($p['imagen']); ?>" width="60"></td>
                <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                <td>$<?php echo number_format($p['precio'],2); ?></td>
                <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                <td><a href="panel.php?eliminar=<?php echo $p['id']; ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
