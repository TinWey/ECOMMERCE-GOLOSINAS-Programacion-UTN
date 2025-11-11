<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$accion = $_GET['accion'] ?? '';

$host = "localhost";
$user = "root";
$pass = "";
$db   = "golosinas_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

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
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];
        $_SESSION['carrito'][$id] = ($_SESSION['carrito'][$id] ?? 0) + 1;
    }
    header("Location: index.php");
    exit;
}
elseif ($accion == 'vaciar') {
    unset($_SESSION['carrito']);
    header("Location: index.php?accion=carrito");
    exit;
}
elseif ($accion == 'comprar') {
    unset($_SESSION['carrito']);
    echo "<script>alert('¡Compra realizada con éxito! 🎉');window.location='index.php';</script>";
    exit;
}
elseif ($accion == 'login_validar') {
    $usuario = $_POST['usuario'] ?? '';
    $passw   = $_POST['pass'] ?? '';

    $stmt = $conn->prepare("SELECT usuario, pass, rol FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        if ($row['pass'] === $passw) {
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['rol'] = $row['rol'];
            if ($row['rol'] === 'admin') {
                echo "<script>window.location='vista/admin/panel.php';</script>";
            } else {
                echo "<script>window.location='index.php';</script>";
            }
            exit;
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos');window.location='index.php?accion=login';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos');window.location='index.php?accion=login';</script>";
        exit;
    }
}
elseif ($accion == 'registro_guardar') {
    $usuario = trim($_POST['usuario'] ?? '');
    $passw   = trim($_POST['pass'] ?? '');

    if ($usuario === '' || $passw === '') {
        echo "<script>alert('Complete todos los campos.');window.location='index.php?accion=registro';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        echo "<script>alert('Ese usuario ya existe');window.location='index.php?accion=registro';</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, pass, rol) VALUES (?, ?, 'user')");
    $stmt->bind_param("ss", $usuario, $passw);
    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado con éxito');window.location='index.php?accion=login';</script>";
        exit;
    } else {
        echo "<script>alert('Error al registrar');window.location='index.php?accion=registro';</script>";
        exit;
    }
}
elseif ($accion == 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
else {
    include "vista/public/home.php";
}
