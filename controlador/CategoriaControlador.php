<?php
session_start();
if(!isset($_SESSION['logueado']) || ($_SESSION['rol'] ?? '') !== 'admin'){
    header("Location: ../vista/public/login.php");
    exit;
}
include_once __DIR__ . "/../modelo/Categoria.php";
$accion = $_GET['accion'] ?? 'list';
if ($accion == 'list') {
    $categorias = categorias_todos();
    include __DIR__ . "/../vista/admin/categorias.php";
    exit;
}
if ($accion == 'nuevo') {
    include __DIR__ . "/../vista/admin/categorias.php";
    exit;
}
if ($accion == 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    categoria_crear($nombre);
    header("Location: ../controlador/CategoriaControlador.php?accion=list");
    exit;
}
if ($accion == 'editar') {
    $id = intval($_GET['id'] ?? 0);
    $categoria = categoria_por_id($id);
    include __DIR__ . "/../vista/admin/categorias.php";
    exit;
}
if ($accion == 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'] ?? '';
    categoria_modificar($id, $nombre);
    header("Location: ../controlador/CategoriaControlador.php?accion=list");
    exit;
}
if ($accion == 'borrar') {
    $id = intval($_GET['id'] ?? 0);
    categoria_borrar($id);
    header("Location: ../controlador/CategoriaControlador.php?accion=list");
    exit;
}
?>
