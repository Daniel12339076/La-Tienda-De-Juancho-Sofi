<?php
include '../config/conexion.php';
include '../modelosPedidoModel.php';
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
if ($accion == 'ingresar') {
    login($conn, $_POST);
}
elseif ($accion=='salir') {
    salir();
}
elseif ($accion=='registrar') {
    registrar($conn, $_POST);

} elseif ($accion == 'actualizar') {
    actualizar($conn, $_POST);

}
elseif ($accion == 'eliminar') {
    eliminar($conn, $_GET['id']);
}
?>