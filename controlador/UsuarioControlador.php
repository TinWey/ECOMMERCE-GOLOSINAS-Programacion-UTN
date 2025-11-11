<?php
session_start();
include_once __DIR__ . "/../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['user'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        if ($row['pass'] === $pass) {
            $_SESSION['logueado'] = true;
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['rol'] = $row['rol'];

            if ($row['rol'] === 'admin') {
                header("Location: ../vista/admin/panel.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else
            $error = "Contraseña incorrecta";
            include __DIR__ . "/../vista/public/login.p
        }
