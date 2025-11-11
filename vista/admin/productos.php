<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../../index.php?accion=login");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "golosinas_db");

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria_id = $_POST['categoria_id'];
    $imagen = $_FILES['imagen']['name'];
    $ruta = "../../assets/img/" . $imagen;
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    $conexion->query("INSERT INTO productos (nombre, descripcion, precio, categoria_id, imagen) VALUES ('$nombre', '$descripcion', '$precio', '$categoria_id', '$imagen')");
    header("Location: productos.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM productos WHERE id=$id");
    header("Location: productos.php");
    exit;
}

if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria_id = $_POST['categoria_id'];

    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $ruta = "../../assets/img/" . $imagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
        $conexion->query("UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', categoria_id='$categoria_id', imagen='$imagen' WHERE id=$id");
    } else {
        $conexion->query("UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', categoria_id='$categoria_id' WHERE id=$id");
    }
    header("Location: productos.php");
    exit;
}

$categorias = $conexion->query("SELECT * FROM categorias");

if (isset($_GET['editar'])) {
    $idEditar = $_GET['editar'];
    $editar = $conexion->query("SELECT * FROM productos WHERE id=$idEditar")->fetch_assoc();
}

$productos = $conexion->query("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id=c.id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - Productos</title>
    <link rel="stylesheet" href="../../assets/css/estilos.css">
</head>
<body>
    <h1>Panel de administración - Productos</h1>
    <a href="panel.php">Volver al panel</a> |
    <a href="../../index.php?accion=logout">Cerrar sesión</a>

    <h2><?= isset($editar) ? 'Editar producto' : 'Agregar nuevo producto' ?></h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <?php if (isset($editar)) { ?>
            <input type="hidden" name="id" value="<?= $editar['id'] ?>">
        <?php } ?>
        <input type="text" name="nombre" placeholder="Nombre" value="<?= $editar['nombre'] ?? '' ?>" required><br>
        <textarea name="descripcion" placeholder="Descripción" required><?= $editar['descripcion'] ?? '' ?></textarea><br>
        <input type="number" step="0.01" name="precio" placeholder="Precio" value="<?= $editar['precio'] ?? '' ?>" required><br>
        <select name="categoria_id" required>
            <option value="">Seleccionar categoría</option>
            <?php while ($c = $categorias->fetch_assoc()) { ?>
                <option value="<?= $c['id'] ?>" <?= isset($editar) && $editar['categoria_id'] == $c['id'] ? 'selected' : '' ?>><?= $c['nombre'] ?></option>
            <?php } ?>
        </select><br>
        <input type="file" name="imagen" accept="image/*" <?= isset($editar) ? '' : 'required' ?>><br>
        <input type="submit" name="<?= isset($editar) ? 'editar' : 'agregar' ?>" value="<?= isset($editar) ? 'Guardar cambios' : 'Agregar producto' ?>">
    </form>

    <h2>Lista de productos</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Categoría</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
        <?php while ($p = $productos->fetch_assoc()) { ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['nombre'] ?></td>
                <td><?= $p['descripcion'] ?></td>
                <td>$<?= $p['precio'] ?></td>
                <td><?= $p['categoria'] ?></td>
                <td><img src="../../assets/img/<?= $p['imagen'] ?>" width="60"></td>
                <td>
                    <a href="?editar=<?= $p['id'] ?>">Editar</a> |
                    <a href="?eliminar=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
