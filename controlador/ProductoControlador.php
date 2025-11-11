<?php
session_start();
include_once __DIR__ . "/../modelo/Producto.php";
include_once __DIR__ . "/../modelo/Categoria.php";
$accion = $_GET['accion'] ?? 'catalogo';
if ($accion == 'catalogo') {
    $productos = productos_todos();
    include __DIR__ . "/../vista/public/home.php";
    exit;
}
if ($accion == 'ver') {
    $id = intval($_GET['id'] ?? 0);
    $producto = producto_por_id($id);
    include __DIR__ . "/../vista/public/producto.php";
    exit;
}
if ($accion == 'admin_list') {
    if(!isset($_SESSION['logueado']) || ($_SESSION['rol'] ?? '') !== 'admin'){
        header("Location: ../vista/public/login.php");
        exit;
    }
    $productos = productos_todos();
    include __DIR__ . "/../vista/admin/productos.php";
    exit;
}
if ($accion == 'nuevo') {
    if(!isset($_SESSION['logueado']) || ($_SESSION['rol'] ?? '') !== 'admin'){ header("Location: ../vista/public/login.php"); exit; }
    $categorias = categorias_todos();
    include __DIR__ . "/../vista/admin/productos.php";
    exit;
}
if ($accion == 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = floatval($_POST['precio'] ?? 0);
    $categoria_id = intval($_POST['categoria_id'] ?? 0);
    $imagen = $_POST['imagen'] ?? '';
    producto_crear($nombre, $descripcion, $precio, $categoria_id, $imagen);
    header("Location: ../controlador/ProductoControlador.php?accion=admin_list");
    exit;
}
if ($accion == 'editar') {
    if(!isset($_SESSION['logueado']) || ($_SESSION['rol'] ?? '') !== 'admin'){ header("Location: ../vista/public/login.php"); exit; }
    $id = intval($_GET['id'] ?? 0);
    $producto = producto_por_id($id);
    $categorias = categorias_todos();
    include __DIR__ . "/../vista/admin/productos.php";
    exit;
}
if ($accion == 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = floatval($_POST['precio'] ?? 0);
    $categoria_id = intval($_POST['categoria_id'] ?? 0);
    $imagen = $_POST['imagen'] ?? '';
    producto_modificar($id, $nombre, $descripcion, $precio, $categoria_id, $imagen);
    header("Location: ../controlador/ProductoControlador.php?accion=admin_list");
    exit;
}
if ($accion == 'borrar') {
    if(!isset($_SESSION['logueado']) || ($_SESSION['rol'] ?? '') !== 'admin'){ header("Location: ../vista/public/login.php"); exit; }
    $id = intval($_GET['id'] ?? 0);
    producto_borrar($id);
    header("Location: ../controlador/ProductoControlador.php?accion=admin_list");
    exit;
}
?>
