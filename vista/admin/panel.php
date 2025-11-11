<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "golosinas_db");

if (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $imagen = $_POST['imagen'];
    $conexion->query("INSERT INTO productos (nombre, descripcion, precio, categoria_id, imagen) VALUES ('$nombre', '$descripcion', '$precio', '$categoria', '$imagen')");
    header("Location: panel.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM productos WHERE id=$id");
    header("Location: panel.php");
    exit;
}

$productos = $conexion->query("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id");
$categorias = $conexion->query("SELECT * FROM categorias");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../../assets/css/estilos.css">
</head>
<body>
    <h1>Panel de Administración</h1>
    <p>Bienvenido, <b><?php echo $_SESSION['usuario']; ?></b></p>
    <a href="../../index.php">Volver a la tienda</a> |
    <a href="../../index.php?accion=logout">Cerrar sesión</a>

    <hr>
    <h2>Agregar Producto</h2>
    <form method="POST">
        <input type="hidden" name="accion" value="agregar">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <select name="categoria" required>
            <option value="">Seleccionar categoría</option>
            <?php while($c = $categorias->fetch_assoc()): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo $c['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="text" name="imagen" placeholder="Nombre del archivo de imagen (ej: nuevo.jpg)" required>
        <button type="submit">Agregar</button>
    </form>

    <hr>
    <h2>Listado de Productos</h2>
    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
        <?php while($p = $productos->fetch_assoc()): ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><img src="../../assets/img/<?php echo $p['imagen']; ?>" width="60"></td>
            <td><?php echo $p['nombre']; ?></td>
            <td><?php echo $p['descripcion']; ?></td>
            <td>$<?php echo number_format($p['precio'], 2); ?></td>
            <td><?php echo $p['categoria']; ?></td>
            <td><a href="panel.php?eliminar=<?php echo $p['id']; ?>">Eliminar</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
