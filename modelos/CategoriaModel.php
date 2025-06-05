<?php
require_once dirname(__DIR__) . '/config/conexion.php';

class CategoriaModel {
    private $conn;
    private $table = 'categorias';

    public $id;
    public $nombre;
    public $descripcion;
    public $estado;
    public $fecha_creacion;

    public function __construct() {
        try {
            $conexion = new Conexion();
            $this->conn = $conexion->obtenerConexion();
            
            if (!$this->conn) {
                throw new Exception("No se pudo establecer la conexión a la base de datos");
            }
            
        } catch (Exception $e) {
            error_log("Error en CategoriaModel constructor: " . $e->getMessage());
            throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Obtener todas las categorías
    public function obtenerTodos() {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY nombre ASC";
            $result = $this->conn->query($query);
            
            if (!$result) {
                throw new Exception("Error en la consulta SQL: " . $this->conn->error);
            }
            
            $categorias = [];
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row;
            }
            return $categorias;
            
        } catch (Exception $e) {
            error_log("Error en obtenerTodos: " . $e->getMessage());
            throw $e;
        }
    }

    // Obtener categoría por ID
    public function obtenerPorId($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $this->conn->error);
            }
            
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
            
        } catch (Exception $e) {
            error_log("Error en obtenerPorId: " . $e->getMessage());
            throw $e;
        }
    }

    // Buscar categorías
    public function buscar($termino) {
        try {
            $query = "SELECT * FROM " . $this->table . " 
                      WHERE nombre LIKE ? 
                      OR descripcion LIKE ? 
                      ORDER BY nombre ASC";
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $this->conn->error);
            }
            
            $termino_like = "%{$termino}%";
            $stmt->bind_param('ss', $termino_like, $termino_like);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $categorias = [];
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row;
            }
            return $categorias;
            
        } catch (Exception $e) {
            error_log("Error en buscar: " . $e->getMessage());
            throw $e;
        }
    }

    // Crear nueva categoría
    public function crear($nombre, $descripcion,$imagen) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                      (nombre, descripcion, imagen) 
                      VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $this->conn->error);
            }
            
            $stmt->bind_param('sss', 
                $nombre, 
                $descripcion, 
                $imagen
            );
            
            return $stmt->execute();
            
        } catch (Exception $e) {
            error_log("Error en crear: " . $e->getMessage());
            throw $e;
        }
    }

    // Actualizar categoría
    public function actualizar($id, $nombre, $descripcion, $nombreImagen) {
        try {
            $query = "UPDATE categorias
                      SET nombre = ?, descripcion = ?";
            if($nombreImagen!=null){
                $query .= ", imagen = ? ";
            }

            $query .= " WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $this->conn->error);
            }
            
            if($nombreImagen==null){
                $stmt->bind_param('ssi', 
                    $nombre, 
                    $descripcion, 
                    $id
                );
            }else{
                $stmt->bind_param('sssi', 
                    $nombre, 
                    $descripcion, 
                    $nombreImagen, 
                    $id
                );
            }
            
            
            return $stmt->execute();
            
        } catch (Exception $e) {
            error_log("Error en actualizar: " . $e->getMessage());
            throw $e;
        }
    }

    // Eliminar categoría
    public function eliminar($id) {
        try {
            // Verificar si hay productos asociados a esta categoría
            // $query = "SELECT COUNT(*) as total FROM productos WHERE categoria_id = ?";
            // $stmt = $this->conn->prepare($query);
            // $stmt->bind_param('i', $id);
            // $stmt->execute();
            // $result = $stmt->get_result();
            // $row = $result->fetch_assoc();
            
            // if ($row['total'] > 0) {
            //     throw new Exception("No se puede eliminar la categoría porque tiene productos asociados");
            // }
            
            $query = "DELETE FROM categorias WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $this->conn->error);
            }
            
            $stmt->bind_param('i', $id);
            return $stmt->execute();
            
        } catch (Exception $e) {
            error_log("Error en eliminar: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
