<?php
session_start();
require_once '../modelos/UsuarioModel.php';

class UsuarioController {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new UsuarioModel();
    }
    
    /**
     * Maneja las diferentes acciones según el parámetro 'action'
     */
    public function procesarAccion() {
        $accion = $_GET['action'] ?? '';
        
        switch ($accion) {
            case 'registrar':
                $this->registrarUsuario();
                break;
            case 'login':
                $this->iniciarSesion();
                break;
            case 'logout':
                $this->cerrarSesion();
                break;
            default:
                $this->responderError('Acción no válida');
        }
    }
    
    /**
     * Registra un nuevo usuario
     */
    private function registrarUsuario() {
        // Verificar que se recibieron los datos necesarios
        if (!isset($_POST['usuario']) || !isset($_POST['correo']) || !isset($_POST['clave'])) {
            $this->responderError('Faltan datos requeridos');
            return;
        }
        
        $usuario = trim($_POST['usuario']);
        $correo = trim($_POST['correo']);
        $celular = isset($_POST['celular']) ? trim($_POST['celular']) : '';
        $clave = $_POST['clave'];
        $rol = isset($_POST['rol']) ? trim($_POST['rol']) : 'cliente'; // Por defecto es cliente
        
        // Validaciones básicas
        if (empty($usuario) || empty($correo) || empty($clave)) {
            $this->responderError('Todos los campos son obligatorios');
            return;
        }
        
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->responderError('El correo electrónico no es válido');
            return;
        }
        
        if (strlen($clave) < 6) {
            $this->responderError('La contraseña debe tener al menos 6 caracteres');
            return;
        }
        
        // Validar rol (solo permitir valores específicos)
        $rolesPermitidos = ['cliente', 'vendedor', 'administrador'];
        if (!in_array($rol, $rolesPermitidos)) {
            $rol = 'cliente'; // Si no es un rol válido, asignar cliente por defecto
        }
        
        // Registrar el usuario
        $resultado = $this->modelo->registrarUsuario($usuario, $correo, $celular, $clave, $rol);
        
        if ($resultado['success']) {
            // Redirigir al login con mensaje de éxito
            $_SESSION['mensaje'] = 'Usuario registrado correctamente. Ahora puedes iniciar sesión.';
            $_SESSION['tipo_mensaje'] = 'success';
            header('Location: ../VISUAL/login.php');
            exit;
        } else {
            // Redirigir al registro con mensaje de error
            $_SESSION['mensaje'] = $resultado['message'];
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: ../VISUAL/Registrar.php');
            exit;
        }
    }
    
    /**
     * Inicia sesión de usuario
     */
    private function iniciarSesion() {
        // Verificar que se recibieron los datos necesarios
        if (!isset($_POST['usuario']) || !isset($_POST['clave'])) {
            $this->responderError('Faltan datos requeridos');
            return;
        }
        
        $usuario = trim($_POST['usuario']);
        $clave = $_POST['clave'];
        
        // Validaciones básicas
        if (empty($usuario) || empty($clave)) {
            $this->responderError('Todos los campos son obligatorios');
            return;
        }
        
        // Verificar credenciales
        $resultado = $this->modelo->verificarCredenciales($usuario, $clave);
        
        if ($resultado['success']) {
            // Iniciar sesión
            $_SESSION['usuario'] = $resultado['usuario'];
            $_SESSION['autenticado'] = true;
            
            // Redirigir según el rol
            if ($resultado['usuario']['rol'] === 'administrador') {
                header('Location: ../VISUAL/Admin/inicio.php');
            } else {
                header('Location: ../VISUAL/inicio.php');
            }
            exit;
        } else {
            // Redirigir al login con mensaje de error
            $_SESSION['mensaje'] = $resultado['message'];
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: ../VISUAL/login.php');
            exit;
        }
    }
    
    /**
     * Cierra la sesión del usuario
     */
    private function cerrarSesion() {
        // Destruir todas las variables de sesión
        $_SESSION = [];
        
        // Si se desea destruir la sesión completamente, borrar también la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Finalmente, destruir la sesión
        session_destroy();
        
        // Redirigir al login
        header('Location: ../VISUAL/login.php');
        exit;
    }
    
    /**
     * Responde con un mensaje de error
     */
    private function responderError($mensaje) {
        $_SESSION['mensaje'] = $mensaje;
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../VISUAL/login.php');
        exit;
    }
}

// Ejecutar el controlador
$controlador = new UsuarioController();
$controlador->procesarAccion();
?>