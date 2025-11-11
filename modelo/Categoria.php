<?php
include_once __DIR__ . "/../config/database.php";
function categorias_todos(){
    global $conn;
    $sql = "SELECT * FROM categorias ORDER BY nombre";
    $res = $conn->query($sql);
    $rows = [];
    while($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}
function categoria_por_id($id){
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM categorias WHERE id = $id LIMIT 1";
    $res = $conn->query($sql);
    return $res->fetch_assoc();
}
function categoria_crear($nombre){
    global $conn;
    $n = $conn->real_escape_string($nombre);
    $sql = "INSERT INTO categorias (nombre) VALUES ('$n')";
    return $conn->query($sql);
}
function categoria_modificar($id, $nombre){
    global $conn;
    $id = intval($id);
    $n = $conn->real_escape_string($nombre);
    $sql = "UPDATE categorias SET nombre='$n' WHERE id=$id";
    return $conn->query($sql);
}
function categoria_borrar($id){
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM categorias WHERE id=$id";
    return $conn->query($sql);
}
?>
