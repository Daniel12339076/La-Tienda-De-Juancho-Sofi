<?php
include '../config/conexion.php';
include '../modelos/CategoriaModel.php';
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
    $categoria = obtenerCategoriaPorID($conn, $_POST['id']);
    $_POST['imagen'] = guardar_imagen($_FILES['imagen']);
    actualizar($conn, $_POST);

}
elseif ($accion == 'eliminar') {
    $categoria = obtenerCategoriaPorID($conn, $_GET['id']);
    eliminar_imagen( $categoria);
    eliminar($conn, $_GET['id']);
}

function guardar_imagen($imagen, $categoria=null) {
    eliminar_imagen($categoria);
    
    $ruta = '../image/categorias/';
    $nombre_imagen = uniqid() . '-' . basename($imagen['name']);
    $ruta_completa = $ruta . $nombre_imagen;

    if (move_uploaded_file($imagen['tmp_name'], $ruta_completa)) {
        return $nombre_imagen;
    } else {
        return null; // O manejar el error de otra manera
    }
    
}

function eliminar_imagen($categoria=null) {
    if ($categoria) {
        if ($categoria && $categoria['imagen']) {
            $ruta_existente = '../image/categorias/' . $categoria['imagen'];
            if (file_exists($ruta_existente)) {
                unlink($ruta_existente); // Elimina la imagen existente
            }
        }
    }    
}
?>