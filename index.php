<?php
session_start();

$accion = $_GET['accion'] ?? '';

if ($accion == 'login') {
    include "vista/public/login.php";
}
elseif ($accion == 'registro') {
    include "vista/public/registro.php";
}
elseif ($accion == 'carrito') {
    include "vista/public/carrito.php";
}
elseif ($accion == 'agregar') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];
        $_SESSION['carrito'][$id] = ($_SESSION['carrito'][$id] ?? 0) + 1;
    }
    // Ya no redirige al carrito, vuelve a la página principal
    header("Location: index.php");
    exit;
}
elseif ($accion == 'vaciar') {
    unset($_SESSION['carrito']);
    header("Location: index.php");
    exit;
}
elseif ($accion == 'comprar') {
    unset($_SESSION['carrito']);
    echo "<script>alert('¡Compra realizada con éxito! 🎉');window.location='index.php';</script>";
    exit;
}



elseif ($accion == 'login_validar') {
    $conexion = new mysqli("localhost", "root", "", "golosinas_db");
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];

    $res = $conexion->query("SELECT * FROM usuarios WHERE usuario='$usuario' AND pass='$pass'");
    if ($res->num_rows > 0) {
        $u = $res->fetch_assoc();
        $_SESSION['usuario'] = $u['usuario'];
        $_SESSION['rol'] = $u['rol'];

        if ($u['rol'] === 'admin') {
            echo "<script>window.location='vista/admin/panel.php';</script>";
        } else {
            echo "<script>window.location='index.php';</script>";
        }
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos');window.location='index.php?accion=login';</script>";
    }
}
elseif ($accion == 'registro_guardar') {
    $conexion = new mysqli("localhost", "root", "", "golosinas_db");
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $verif = $conexion->query("SELECT * FROM usuarios WHERE usuario='$usuario'");
    if ($verif->num_rows > 0) {
        echo "<script>alert('Ese usuario ya existe');window.location='index.php?accion=registro';</script>";
    } else {
        $conexion->query("INSERT INTO usuarios (usuario, pass, rol) VALUES ('$usuario', '$pass', 'user')");
        echo "<script>alert('Usuario registrado con éxito');window.location='index.php?accion=login';</script>";
    }
}
elseif ($accion == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}
else {
    include "vista/public/home.php";
}
?>
