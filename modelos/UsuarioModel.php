<?php
require_once '../config/conexion.php';

class UsuarioModel {
    private $conexion;
    
    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->obtenerConexion();
    }
    
    /**
     * Registra un nuevo usuario en la base de datos
     */
    public function registrarUsuario($usuario, $correo, $celular, $clave, $rol) {
        // Verificar si el usuario ya existe
        if ($this->existeUsuario($usuario, $correo)) {
            return [
                'success' => false,
                'message' => 'El usuario o correo ya está registrado'
            ];
        }
        
        // Encriptar la contraseña
        $claveEncriptada = password_hash($clave, PASSWORD_DEFAULT);
        
        // Preparar la consulta SQL
        $sql = "INSERT INTO usuarios (nombre, correo, celular, clave, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssss", $usuario, $correo, $celular, $claveEncriptada, $rol);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Usuario registrado correctamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al registrar el usuario: ' . $this->conexion->error
            ];
        }
    }
    
    /**
     * Verifica si un usuario o correo ya existe en la base de datos
     */
    public function existeUsuario($usuario, $correo) {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE nombre = ? OR correo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $usuario, $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        
        return $fila['total'] > 0;
    }
    
    /**
     * Verifica las credenciales de un usuario para el inicio de sesión
     */
    public function verificarCredenciales($usuario, $clave) {
        $sql = "SELECT id, nombre, correo, celular, clave, rol FROM usuarios WHERE nombre = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 0) {
            return [
                'success' => false,
                'message' => 'Usuario no encontrado'
            ];
        }
        
        $usuario = $resultado->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($clave, $usuario['clave'])) {
            // Eliminar la clave del array antes de devolverlo
            unset($usuario['clave']);
            
            return [
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'usuario' => $usuario
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Contraseña incorrecta'
            ];
        }
    }
    
    /**
     * Obtiene todos los usuarios (para administración)
     */
    public function obtenerUsuarios() {
        $sql = "SELECT id, nombre, correo, celular, rol FROM usuarios";
        $resultado = $this->conexion->query($sql);
        
        $usuarios = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }
        }
        
        return $usuarios;
    }
}
?>