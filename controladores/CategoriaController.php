<?php
header('Content-Type: application/json');
require_once '../modelos/CategoriaModel.php';

class CategoriaController {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new CategoriaModel();
    }
    
    public function manejarPeticion() {
        $accion = $_POST['accion'] ?? $_GET['accion'] ?? '';
        
        switch ($accion) {
            case 'crear':
                $this->crearCategoria();
                break;
            case 'obtener':
                $this->obtenerCategorias();
                break;
            case 'buscar':
                $this->buscarCategorias();
                break;
            case 'actualizar':
                $this->actualizarCategoria();
                break;
            case 'eliminar':
                $this->eliminarCategoria();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        }
    }
    
    private function crearCategoria() {
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        
        if (empty($nombre) || empty($descripcion)) {
            echo json_encode(['success' => false, 'message' => 'Nombre, descripción son obligatorios']);
            return;
        }
        
        // Manejar subida de imagen
        $nombreImagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = $this->subirImagen($_FILES['imagen']);
            if (!$nombreImagen) {
                echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
                return;
            }
        }
        
        $resultado = $this->modelo->crear($nombre, $descripcion, $nombreImagen);
        echo json_encode($resultado);
    }
    
    private function obtenerCategorias() {
        $categorias = $this->modelo->obtenerTodos();
        echo json_encode(['success' => true, 'data' => $categorias]);
    }
    
    private function buscarCategorias() {
        $termino = $_GET['termino'] ?? '';
        $categorias = $this->modelo->buscarCategorias($termino);
        echo json_encode(['success' => true, 'data' => $categorias]);
    }
    
    private function actualizarCategoria() {
        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        
        
        if (empty($id) || empty($nombre) || empty($descripcion)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
            return;
        }
        
        // Manejar subida de imagen si se proporciona
        $nombreImagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = $this->subirImagen($_FILES['imagen']);
        }
        
        $resultado = $this->modelo->actualizar($id, $nombre, $descripcion, $nombreImagen);
        echo json_encode($resultado);
    }
    
    private function eliminarCategoria() {
        $id = $_POST['id'] ?? '';
        
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID de categoría requerido']);
            return;
        }
        
        $resultado = $this->modelo->eliminar($id);
        echo json_encode($resultado);
    }
    
    private function subirImagen($archivo) {
        // Directorio de destino (relativo al controlador)
        $directorioDestino = '../uploads/';
        
        // Crear directorio si no existe
        if (!file_exists($directorioDestino)) {
            if (!mkdir($directorioDestino, 0777, true)) {
                error_log("No se pudo crear el directorio: " . $directorioDestino);
                return false;
            }
        }
        
        // Verificar que el directorio sea escribible
        if (!is_writable($directorioDestino)) {
            error_log("El directorio no es escribible: " . $directorioDestino);
            return false;
        }
        
        // Validar tipo de archivo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg'];
        if (!in_array($archivo['type'], $tiposPermitidos)) {
            error_log("Tipo de archivo no permitido: " . $archivo['type']);
            return false;
        }
        
        // Validar tamaño (máximo 5MB)
        if ($archivo['size'] > 5 * 1024 * 1024) {
            error_log("Archivo muy grande: " . $archivo['size']);
            return false;
        }
        
        // Generar nombre único
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $nombreArchivo = uniqid('img_') . '.' . $extension;
        $rutaCompleta = $directorioDestino . $nombreArchivo;
        
        // Mover archivo
        if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
            // Retornar solo el nombre del archivo (sin la ruta)
            return $nombreArchivo;
        } else {
            error_log("Error al mover archivo a: " . $rutaCompleta);
            return false;
        }
    }
}

// Ejecutar controlador
$controlador = new CategoriaController();
$controlador->manejarPeticion();
?>