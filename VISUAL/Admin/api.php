<?php
require_once '../config.php';

// Obtener el método HTTP y la acción
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    $pdo = getConnection();
    
    switch ($method) {
        case 'GET':
            if ($action === 'list') {
                // Obtener todos los contactos
                $stmt = $pdo->query("SELECT * FROM contactar ORDER BY id DESC");
                $contacts = $stmt->fetchAll();
                echo json_encode([
                    'success' => true,
                    'data' => $contacts
                ]);
            } elseif ($action === 'get' && isset($_GET['id'])) {
                // Obtener un contacto específico
                $stmt = $pdo->prepare("SELECT * FROM contactar WHERE id = ?");
                $stmt->execute([$_GET['id']]);
                $contact = $stmt->fetch();
                
                if ($contact) {
                    echo json_encode([
                        'success' => true,
                        'data' => $contact
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Contacto no encontrado'
                    ]);
                }
            }
            break;
            
        case 'POST':
            // Crear nuevo contacto
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['nombre']) || !isset($input['celular'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Nombre y celular son requeridos'
                ]);
                break;
            }
            
            $nombre = trim($input['nombre']);
            $celular = trim($input['celular']);
            
            // Validaciones
            if (empty($nombre)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El nombre es requerido'
                ]);
                break;
            }
            
            if (!preg_match('/^[0-9]{10}$/', $celular)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El celular debe tener 10 dígitos'
                ]);
                break;
            }
            
            try {
                $stmt = $pdo->prepare("INSERT INTO contactar (nombre, celular) VALUES (?, ?)");
                $stmt->execute([$nombre, $celular]);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Contacto agregado exitosamente',
                    'id' => $pdo->lastInsertId()
                ]);
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry
                    echo json_encode([
                        'success' => false,
                        'message' => 'Este número de celular ya está registrado'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al guardar el contacto'
                    ]);
                }
            }
            break;
            
        case 'PUT':
            // Actualizar contacto
            if (!isset($_GET['id'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID requerido para actualizar'
                ]);
                break;
            }
            
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $_GET['id'];
            $nombre = trim($input['nombre']);
            $celular = trim($input['celular']);
            
            // Validaciones
            if (empty($nombre)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El nombre es requerido'
                ]);
                break;
            }
            
            if (!preg_match('/^[0-9]{10}$/', $celular)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El celular debe tener 10 dígitos'
                ]);
                break;
            }
            
            try {
                $stmt = $pdo->prepare("UPDATE contactar SET nombre = ?, celular = ? WHERE id = ?");
                $result = $stmt->execute([$nombre, $celular, $id]);
                
                if ($stmt->rowCount() > 0) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Contacto actualizado exitosamente'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'No se encontró el contacto o no hubo cambios'
                    ]);
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry
                    echo json_encode([
                        'success' => false,
                        'message' => 'Este número de celular ya está registrado'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al actualizar el contacto'
                    ]);
                }
            }
            break;
            
        case 'DELETE':
            // Eliminar contacto
            if (!isset($_GET['id'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID requerido para eliminar'
                ]);
                break;
            }
            
            $id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM contactar WHERE id = ?");
            $result = $stmt->execute([$id]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Contacto eliminado exitosamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se encontró el contacto'
                ]);
            }
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            break;
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>
