<?php
include '../config/conexion.php';
include '../modelos/ProductoModel.php';
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
if ($accion == 'ingresar') {
    login($conn, $_POST);
}
elseif ($accion=='salir') {
    salir();
}
elseif ($accion=='registrar') {
    $_POST['imagen'] = guardar_imagen($_FILES['imagen']);
    registrar($conn, $_POST);

} elseif ($accion == 'actualizar') {
    $producto = obtenerproductoPorID($conn, $_POST['id']);

    // Verificar si se ha subido una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        // Si se subió nueva imagen, eliminar la anterior y guardar la nueva
        $_POST['imagen'] = guardar_imagen($_FILES['imagen'], $producto);
    } else {
        // Si no se subió imagen nueva, mantener la anterior
        $_POST['imagen'] = $producto['imagen'];
    }

    actualizar($conn, $_POST);

} elseif ($accion == 'eliminar') {
    $producto = obtenerproductoPorID($conn, $_GET['id']);
    eliminar_imagen($producto);
    eliminar($conn, $_GET['id']);
}

// Guarda imagen nueva y elimina la anterior si hay
function guardar_imagen($imagen, $producto = null) {
    // Eliminar imagen anterior si hay producto
    eliminar_imagen($producto);

    $ruta = '../image/productos/';
    $nombre_imagen = uniqid() . '-' . basename($imagen['name']);
    $ruta_completa = $ruta . $nombre_imagen;

    if (move_uploaded_file($imagen['tmp_name'], $ruta_completa)) {
        return $nombre_imagen;
    } else {
        return null; // Manejo de error opcional
    }
}

// Elimina imagen de un producto si existe
function eliminar_imagen($producto = null) {
    if ($producto && isset($producto['imagen']) && $producto['imagen']) {
        $ruta_existente = '../image/productos/' . $producto['imagen'];
        if (file_exists($ruta_existente)) {
            unlink($ruta_existente);
        }
    }
}

?>