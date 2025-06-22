<?php
session_start();
    if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
        header('Location: login.php');
        exit;
    } 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Usuarios - Panel de Administración</title>
    <link rel="icon" href="../Image/Logo juancho.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            min-height: 100vh;
            display: flex; /* Usamos flex para la disposición horizontal */
            font-family: sans-serif;
            background-color: #f8f9fa;
        }

        
        .content-wrapper {
            flex-grow: 1; /* El contenido ocupa el espacio restante */
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
            justify-content: space-between; /* Espacio entre el título y otros elementos si los hay */
        }

        .content-header h2 {
            color: #000;
            margin: 0;
        }

        .user-management-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex; /* Usamos flex para la disposición horizontal de formulario y tabla */
            gap: 30px;
            /* flex-wrap: wrap; Eliminamos el wrap para forzar la fila */
        }

        .form-section {
            width: 100%;
            max-width: 350px;
        }

        .table-section {
            flex-grow: 1; /* La tabla ocupa el espacio restante */
            overflow-x: auto;
            width: 100%;
        }

        .form-section h2, .table-section h2 {
            color: #000;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group select {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group select {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="currentColor" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right center;
            background-size: 1em;
            padding-right: 2em;
        }

        .btn-guardar {
            background-color: #ff69b4; /* Rosado para el botón Guardar */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn-guardar:hover {
            background-color: #e6549f;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .user-table th, .user-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .user-table th {
            background-color: #000; /* Negro para la cabecera */
            color: white;
        }

        .user-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn-editar, .btn-eliminar {
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            color: white;
        }

        .btn-editar {
            background-color: #ffd700; /* Amarillo para editar */
        }

        .btn-eliminar {
            background-color: #ff69b4; /* Rosado para eliminar */
        }

        .btn-editar i, .btn-eliminar i {
            color: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #ff69b4;
            box-shadow: 0 0 5px rgba(255, 105, 180, 0.5);
        }

        /* Media query para pantallas más pequeñas */
        @media (max-width: 768px) {
            .user-management-container {
                flex-direction: column; /* Apilar formulario y tabla */
            }
            .form-section, .table-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php 
        include 'sidebar.php';
        include  'header.php'; 
        include '../../config/conexion.php';
        include '../../modelos/UsuarioModel.php';
        $usuarios = obtenerUsuarios($conn);
   ?>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-users"></i> Gestión de Usuarios</h2>
        </div>
        <div class="user-management-container">
            <div class="form-section">
                <h2><i class="fas fa-user-plus"></i> Nuevo Usuario</h2>
                <form method="POST" action="../../controladores/UsuarioController.php?accion=registrar" id="user-form">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="usuario" placeholder="Nombre del Usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" placeholder="Ej:usuario@dominio.com" required>
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input type="text" id="celular" name="celular" placeholder="Número de Celular" required>
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave</label>
                        <input type="password" id="clave" name="clave" placeholder="Clave de Usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="" disabled selected>Seleccione un rol...</option>
                            <option value="empleado">Empleado</option>
                            <option value="administrador">Administrador</option>
                            <option value="vendedor">Vendedor</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-guardar"><i class="fas fa-save"></i> GUARDAR</button>
                </form>
                <div id="form-message"></div>
            </div>
            <div class="table-section">
                <div class="dataTables_filter">
                    <input type="search" id="buscar" class="form-control form-control-sm" placeholder="Buscar USUARIOS...">
                </div>
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Rol</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['celular']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                            <td>
                                    <button class="btn-opciones btn-editar" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $usuario['id'] ?>">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                </td>
                                <td>
                                    <button class="btn-opciones btn-eliminar" onclick="eliminar(event, <?= $usuario['id'] ?>)">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            <!--Modal editar Usuario -->
                            <div class="modal fade" id="modalEditar<?= $usuario['id'] ?>" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalEditarLabel">Editar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="../../controladores/UsuarioController.php?accion=actualizar" method="POST">
                                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>" />
                                    <!-- <div class="mb-3">
                                        <label for="contacto1usuarios" class="form-label">Imagen</label>
                                        <input type="file" id="imagen" name="imagen" accept="image/*" class="form-control" />
                                    </div> -->
                                    <div class="mb-3">
                                        <label for="nombreusuarios" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name="usuario"  value="<?= $usuario['nombre'] ?>" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="correousuarios" class="form-label">Correo</label>
                                        <input type="email" class="form-control" name="correo"  value="<?= $usuario['correo'] ?>" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="rolusuario<?= $usuario['id'] ?>" class="form-label">Rol</label>
                                        <select class="form-select" name="rol" id="rolusuario<?= $usuario['id'] ?>">
                                        <option value="administrador" <?= $usuario['rol'] == "ADMIN" ? 'selected' : '' ?>>Administrador</option>
                                        <option value="empleado" <?= $usuario['rol'] == "empleado" ? 'selected' : '' ?>>Empleado</option>
                                        <option value="vendedor" <?= $usuario['rol'] == "vendedor" ? 'selected' : '' ?>>Vendedor</option>
                                        <option value="cliente" <?= $usuario['rol'] == "cliente" ? 'selected' : '' ?>>Cliente</option>
                                        </select>
                                    </div>


                                    <div class="mb-3">
                                        <label for="contacto1usuarios" class="form-label">celular</label>
                                        <input type="number" class="form-control" name="celular"  value="<?= $usuario['celular'] ?>" />
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-dark">Guardar</button>
                                    </div>
                                    
                                    </form>
                                </div>
                                
                                </div>
                            
                            </div>

                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
        
    </script>
    <script>

        async function eliminar(event, id) {
            event.preventDefault();
            const confirmarSalida = await confirmar(
                '¿Estás seguro de que deseas eliminar a este USUARIO?',
                'SÍ', 'No', 'warning'
            );

            if (confirmarSalida) {
                window.location.href = `../../controladores/UsuarioController.php?accion=eliminar&id=${id}`;
            }
        }

        //Buscar en la tabla
        document.getElementById("buscar").addEventListener("keyup", function () {
        const filtro = this.value.toLowerCase();
        const filas = document.querySelectorAll("table tbody tr");

        filas.forEach(fila => {
            const textoFila = fila.textContent.toLowerCase();
            fila.style.display = textoFila.includes(filtro) ? "" : "none";
        });
        });
    </script>
</body>
</html>