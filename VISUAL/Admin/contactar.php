<?php
session_start();

// Incluir la conexión a la base de datos
require_once '../../config/conexion.php';

// Procesar formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Conexion();
        $conexion = $db->obtenerConexion();
        
        $accion = $_POST['accion'] ?? '';
        $nombre = trim($_POST['nombre'] ?? '');
        $celular = trim($_POST['celular'] ?? '');
        
        // Validaciones
        if (empty($nombre) || empty($celular)) {
            throw new Exception('Nombre y celular son obligatorios');
        }
        
        if (strlen($nombre) < 2) {
            throw new Exception('El nombre debe tener al menos 2 caracteres');
        }
        
        if (!preg_match('/^[0-9]{10}$/', $celular)) {
            throw new Exception('El celular debe tener exactamente 10 dígitos');
        }
        
        if ($accion === 'crear') {
            // Verificar si el celular ya existe
            $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM contactar WHERE celular = ?");
            $stmt->bind_param("s", $celular);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $fila = $resultado->fetch_assoc();
            
            if ($fila['total'] > 0) {
                throw new Exception('Ya existe un contacto con este número de celular');
            }
            
            // Insertar nuevo contacto
            $stmt = $conexion->prepare("INSERT INTO contactar (nombre, celular) VALUES (?, ?)");
            $stmt->bind_param("ss", $nombre, $celular);
            
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = 'Contacto agregado exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                throw new Exception('Error al crear contacto');
            }
            
        } elseif ($accion === 'editar') {
            $id = $_POST['id'] ?? '';
            
            if (empty($id)) {
                throw new Exception('ID requerido para editar');
            }
            
            // Verificar si el celular ya existe en otro contacto
            $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM contactar WHERE celular = ? AND id != ?");
            $stmt->bind_param("si", $celular, $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $fila = $resultado->fetch_assoc();
            
            if ($fila['total'] > 0) {
                throw new Exception('Ya existe otro contacto con este número de celular');
            }
            
            // Actualizar contacto
            $stmt = $conexion->prepare("UPDATE contactar SET nombre = ?, celular = ? WHERE id = ?");
            $stmt->bind_param("ssi", $nombre, $celular, $id);
            
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = 'Contacto actualizado exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                throw new Exception('Error al actualizar contacto');
            }
        }
        
        $conexion->close();
        
    } catch (Exception $e) {
        $_SESSION['mensaje'] = $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'error';
    }
    
    // Redireccionar para evitar reenvío del formulario
    header('Location: contactenos.php');
    exit;
}

// Procesar eliminación
if (isset($_GET['eliminar'])) {
    try {
        $id = $_GET['eliminar'];
        
        $db = new Conexion();
        $conexion = $db->obtenerConexion();
        
        $stmt = $conexion->prepare("DELETE FROM contactar WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = 'Contacto eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar contacto';
            $_SESSION['tipo_mensaje'] = 'error';
        }
        
        $conexion->close();
        
    } catch (Exception $e) {
        $_SESSION['mensaje'] = 'Error al eliminar: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'error';
    }
    
    header('Location: contactenos.php');
    exit;
}

// Obtener contactos de la base de datos
$contactos = [];
try {
    $db = new Conexion();
    $conexion = $db->obtenerConexion();
    
    $resultado = $conexion->query("SELECT id, nombre, celular, fecha_registro FROM contactar ORDER BY fecha_registro DESC");
    
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $contactos[] = $fila;
        }
    }
    
    $conexion->close();
    
} catch (Exception $e) {
    $_SESSION['mensaje'] = 'Error al cargar contactos: ' . $e->getMessage();
    $_SESSION['tipo_mensaje'] = 'error';
}

// Verificar si estamos editando
$editando = false;
$contactoEditar = null;
if (isset($_GET['editar'])) {
    $idEditar = $_GET['editar'];
    foreach ($contactos as $contacto) {
        if ($contacto['id'] == $idEditar) {
            $editando = true;
            $contactoEditar = $contacto;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle de Usuario - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            min-height: 100vh;
            display: flex;
            font-family: sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar (mismo estilo que antes) */
        .sidebar {
            width: 60px;
            background-color: #000;
            color: white;
            overflow-x: hidden;
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar:hover {
            width: 150px;
            align-items: flex-start;
        }

        .sidebar .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 15px;
            text-decoration: none;
            font-size: 1.5em;
            cursor: pointer;
            width: 100%;
        }

        .sidebar .logo-container {
            padding: 15px;
            text-align: center;
            margin-bottom: 10px;
            width: 100%;
        }

        .sidebar:not(:hover) .logo-container {
            display: flex;
            justify-content: center;
        }

        .sidebar .logo-container img {
            max-width: 80%;
            height: auto;
            border-radius: 5px;
        }

        .sidebar .nav-title {
            color: #ffd700;
            text-align: center;
            margin-bottom: 10px;
            font-size: 1em;
            opacity: 0;
            transition: opacity 0.3s ease;
            width: 100%;
        }

        .sidebar:hover .nav-title {
            opacity: 1;
        }

        .sidebar .nav-pills {
            margin-top: 10px;
            width: 100%;
        }

        .sidebar .nav-pills li {
            margin-bottom: 5px;
        }

        .sidebar .nav-pills li a {
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.3s ease 0.1s, transform 0.3s ease 0.1s;
        }

        .sidebar:hover .nav-pills li a {
            opacity: 1;
            transform: translateX(0);
            justify-content: flex-start;
            padding-left: 15px;
        }

        .sidebar .nav-pills li a i {
            margin-right: 10px;
        }

        .sidebar .nav-pills li a:hover {
            background-color: #ff69b4;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .content-header {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .content-header h2 {
            color: #000;
            margin: 0;
        }

        .user-detail-container {
    background-color: #fff;
    padding: 30px; /* Aumentamos el padding para darle más espacio interior */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px; /* Aumentamos el ancho máximo del contenedor */
    margin: 20px auto; /* Mantenemos el centrado y agregamos un poco de margen superior e inferior */
}

.user-info {
    padding-bottom: 20px; /* Aumentamos el padding inferior para más espacio */
    margin-bottom: 20px; /* Aumentamos el margen inferior */
    border-bottom: 1px solid #eee;
}

.user-info p {
    margin-bottom: 12px; /* Aumentamos el margen inferior entre los párrafos */
    color: #333;
    display: flex;
    align-items: center;
    gap: 15px; /* Aumentamos el espacio entre el icono y el texto */
    font-size: 1.1em; /* Opcional: aumentar un poco el tamaño de la fuente */
}

.user-info p i {
    color: #007bff;
    font-size: 1.2em; /* Opcional: aumentar un poco el tamaño del icono */
}

.contact-button-container {
    display: flex;
    justify-content: center;
    margin-top: 20px; /* Añadimos un poco de espacio sobre el botón */
}

.btn-contactado {
    background-color: #ff69b4; /* Cambiamos el color a rosado, como en otros botones */
    color: white;
    padding: 12px 25px; /* Aumentamos el padding del botón */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: bold;
    font-size: 1.1em; /* Opcional: aumentar un poco el tamaño de la fuente del botón */
}

.btn-contactado:hover {
    background-color: #e6549f; /* Oscurecemos un poco al pasar el ratón */
}

/* Estilos responsivos (ajustamos el margen en pantallas pequeñas) */
@media (max-width: 600px) {
    .user-detail-container {
        margin: 20px;
    }
}
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column p-3">
        <a href="#" class="menu-toggle"><i class="fas fa-bars"></i></a>
        <div class="logo-container">
            <img src="logo.png" alt="Logo de la Empresa">
        </div>
        <h4 class="nav-title">Panel Admin</h4>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="./inicio.html" class="nav-link"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="./usuario.html" class="nav-link"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="categorias.html" class="nav-link"><i class="fas fa-tags"></i> Categorías</a></li>
            <li><a href="" class="nav-link"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="ventas.html" class="nav-link"><i class="fas fa-chart-line"></i> Ventas</a></li>
            <li><a href="pedidos.html" class="nav-link"><i class="fas fa-truck"></i> Pedidos</a></li>
            <li><a href="reportes.html" class="nav-link"><i class="fas fa-chart-bar"></i> Reportes</a></li>
            <li><a href="contactar.html" class="nav-link"><i class="fas fa-envelope"></i> Contactar</a></li> 
            <li><a href="pagina5.html" class="nav-link"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-envelope"></i> Gestión de Contactos</h2>
        </div>
        
        <?php if(isset($_SESSION['mensaje'])): ?>
            <div class="mensaje mensaje-<?php echo $_SESSION['tipo_mensaje']; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php 
            // Limpiar el mensaje después de mostrarlo
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        <?php endif; ?>
        
        <div class="contact-container">
            <div class="form-section">
                <h2><i class="fas fa-user-plus"></i> <?php echo $editando ? 'Editar Contacto' : 'Nuevo Contacto'; ?></h2>
                <form method="POST" action="">
                    <?php if ($editando): ?>
                        <input type="hidden" name="accion" value="editar">
                        <input type="hidden" name="id" value="<?php echo $contactoEditar['id']; ?>">
                    <?php else: ?>
                        <input type="hidden" name="accion" value="crear">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required 
                               value="<?php echo $editando ? htmlspecialchars($contactoEditar['nombre']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input type="text" id="celular" name="celular" required maxlength="10" pattern="[0-9]{10}"
                               value="<?php echo $editando ? htmlspecialchars($contactoEditar['celular']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn-guardar">
                        <i class="fas fa-save"></i> <?php echo $editando ? 'ACTUALIZAR' : 'GUARDAR'; ?>
                    </button>
                    
                    <?php if ($editando): ?>
                        <a href="contactenos.php" class="btn-cancelar">
                            <i class="fas fa-times"></i> CANCELAR
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="table-section">
                <h2><i class="fas fa-list"></i> Lista de Contactos</h2>
                <table class="contact-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Celular</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($contactos)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">No hay contactos registrados</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($contactos as $contacto): ?>
                                <tr>
                                    <td><?php echo $contacto['id']; ?></td>
                                    <td><?php echo htmlspecialchars($contacto['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($contacto['celular']); ?></td>
                                    <td>
                                        <a href="contactenos.php?editar=<?php echo $contacto['id']; ?>" class="btn-editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="contactenos.php?eliminar=<?php echo $contacto['id']; ?>" class="btn-eliminar"
                                           onclick="return confirm('¿Está seguro de que desea eliminar este contacto?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Validación en tiempo real del celular
        document.getElementById('celular').addEventListener('input', function(e) {
            // Solo permitir números
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            
            // Limitar a 10 dígitos
            if (e.target.value.length > 10) {
                e.target.value = e.target.value.slice(0, 10);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>