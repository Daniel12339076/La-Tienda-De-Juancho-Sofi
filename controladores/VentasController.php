<?php
include '../config/conexion.php';
include '../modelos/VentasModel.php';

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

if ($accion === 'agregar') {
    agregarAVenta($_POST);
} elseif ($accion === 'actualizar') {
    actualizarVenta($_POST);
} elseif ($accion === 'eliminar') {
    eliminarDeVenta($_POST['index']);
} elseif ($accion === 'realizar') {
    session_start(); // Asegúrate que esto esté antes de usar $_SESSION

    if (!isset($_SESSION['venta']) || empty($_SESSION['venta'])) {
        header('Location: ../VISUAL/Admin/ventas.php?mensaje=vacía');
        exit;
    }

    $resultado = finalizarVenta($conn, $_SESSION['venta']);

    if ($resultado) {
        unset($_SESSION['venta']);
        header('Location: ../VISUAL/Admin/ventas.php?mensaje=ok');
    } else {
        header('Location: ../VISUAL/Admin/ventas.php?mensaje=error');
    }
    exit;
}


?>