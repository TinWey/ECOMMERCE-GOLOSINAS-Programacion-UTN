<?php
include_once __DIR__ . "/../config/database.php";
function productos_todos(){
    global $conn;
    $sql = "SELECT p.*, c.nombre AS categoria_nombre
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            ORDER BY p.nombre";
    $res = $conn->query($sql);
    $rows = [];
    while($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}
function producto_por_id($id){
    global $conn;
    $id = intval($id);
    $sql = "SELECT p.*, c.nombre AS categoria_nombre
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.id = $id LIMIT 1";
    $res = $conn->query($sql);
    return $res->fetch_assoc();
}
function producto_crear($nombre, $descripcion, $precio, $categoria_id, $imagen){
    global $conn;
    $n = $conn->real_escape_string($nombre);
    $d = $conn->real_escape_string($descripcion);
    $p = floatval($precio);
    $c = intval($categoria_id);
    $i = $conn->real_escape_string($imagen);
    $sql = "INSERT INTO productos (nombre, descripcion, precio, categoria_id, imagen) VALUES ('$n', '$d', $p, $c, '$i')";
    return $conn->query($sql);
}
function producto_modificar($id, $nombre, $descripcion, $precio, $categoria_id, $imagen){
    global $conn;
    $id = intval($id);
    $n = $conn->real_escape_string($nombre);
    $d = $conn->real_escape_string($descripcion);
    $p = floatval($precio);
    $c = intval($categoria_id);
    $i = $conn->real_escape_string($imagen);
    $sql = "UPDATE productos SET nombre='$n', descripcion='$d', precio=$p, categoria_id=$c, imagen='$i' WHERE id=$id";
    return $conn->query($sql);
}
function producto_borrar($id){
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM productos WHERE id=$id";
    return $conn->query($sql);
}
?>
