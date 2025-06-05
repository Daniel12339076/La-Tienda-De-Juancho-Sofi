<?php
// Verifica si la función existe (por si la extensión GD no está habilitada)
if (!function_exists('imagecreate')) {
    die("Error: La función imagecreate() no está disponible. Verifica que la extensión GD esté habilitada en php.ini.");
}

$ancho = 100;
$alto = 100;

// Crea una imagen en blanco
$imagen = imagecreate($ancho, $alto);

// Asigna colores: fondo gris claro, texto negro
$fondo = imagecolorallocate($imagen, 220, 220, 220);
$colorTexto = imagecolorallocate($imagen, 0, 0, 0);

// Dibuja texto en la imagen
imagestring($imagen, 5, 10, 40, "Imagen", $colorTexto);

// Establece el encabezado HTTP para devolver imagen PNG
header('Content-Type: image/png');

// Salida de la imagen
imagepng($imagen);

// Limpia memoria
imagedestroy($imagen);
?>

