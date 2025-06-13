<?php

session_start();
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
}


// Obtener información del usuario
// $usuario = $_SESSION['usuario'];
$nombreUsuario = $_SESSION['nombre']
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administración</title>
    <link rel="icon" href="../Image/Logo juancho.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }

        

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #fffbea; /* fondo claro (amarillo muy suave) */
        }

        .content h1 {
            background-color: #000;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center; /* Centrar el título principal */
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* Reducido el espacio entre las tarjetas */
        }

        .card {
            flex: 1 0 calc(33.33% - 15px); /* Tres columnas con espacio reducido */
            padding: 15px; /* Reducido el padding interior */
            text-align: center;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 120px; /* Altura mínima para los cuadros */
        }

        .card i {
            font-size: 2.5em; /* Ligeramente más pequeños que antes */
            margin-bottom: 8px;
        }

        .card h3 {
            margin-top: 0;
            font-size: 1.2em; /* Tamaño de fuente más pequeño para el título */
        }

        /* Colores de los cuadros */
        .card:nth-child(1), .card:nth-child(6) { /* Ventas, Usuarios */
            background-color: #ff69b4; /* rosado */
            color: white;
        }

        .card:nth-child(2), .card:nth-child(4) { /* Pedidos, Categorías */
            background-color: #ffd700; /* amarillo */
            color: black;
        }

        .card:nth-child(3), .card:nth-child(5) { /* Reportes, Productos */
            background-color: #000; /* negro */
            color: white;
        }

        /* Media query para pantallas más pequeñas */
        @media (max-width: 768px) {
            .card {
                flex: 1 0 calc(50% - 15px); /* Dos columnas en pantallas medianas */
            }
        }

        @media (max-width: 576px) {
            .card {
                flex: 1 0 100%; /* Una columna en pantallas pequeñas */
            }
        }
        
        /* Estilos para el usuario logueado */
        .user-info {
            background-color: #000;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .user-info .user-name {
            font-weight: bold;
            color: #ffe600;
        }
        
        .user-info .user-role {
            background-color: #ff69b4;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.8em;
            text-transform: uppercase;
        }
    </style>
</head>
<body>


   <?php 
   include 'header.php'; // Incluye el encabezado del panel de administración
   include 'sidebar.php'; // Incluye la barra lateral de navegación
   ?>

    <div class="content">
        <h1>Panel de Administración</h1>
        
        <div class="user-info">
            <div>
                Bienvenido, <span class="user-name"><?php echo $nombreUsuario; ?></span>
            </div>
            <div class="user-role">
                <?php echo $_SESSION['rol']; ?>
            </div>
        </div>
        
        <div class="card-container">
            <div class="card">
                <i class="fas fa-shopping-cart"></i>
                <h3>VENTAS</h3>
            </div>
            <div class="card">
                <i class="fas fa-truck"></i>
                <h3>PEDIDOS</h3>
            </div>
            <div class="card">
                <i class="fas fa-file-alt"></i>
                <h3>REPORTES</h3>
            </div>
            <div class="card">
                <i class="fas fa-folder"></i>
                <h3>CATEGORÍAS</h3>
            </div>
            <div class="card">
                <i class="fas fa-box"></i>
                <h3>PRODUCTOS</h3>
            </div>
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>USUARIOS</h3>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>