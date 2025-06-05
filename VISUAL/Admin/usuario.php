<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Usuarios - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            min-height: 100vh;
            display: flex; /* Usamos flex para la disposición horizontal */
            font-family: sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar personalizado */
        .sidebar {
            width: 60px; /* Ancho inicial reducido para el icono */
            background-color: #000; /* negro */
            color: white;
            overflow-x: hidden; /* Ocultar el contenido que se desborda horizontalmente */
            transition: width 0.3s ease; /* Transición suave para el cambio de ancho */
            display: flex;
            flex-direction: column;
            align-items: center; /* Centrar elementos horizontalmente cuando está colapsado */
        }

        .sidebar:hover {
            width: 150px; /* Ancho al pasar el ratón para centrar el texto */
            align-items: flex-start; /* Alinear a la izquierda al expandir */
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
            width: 100%; /* Ocupar todo el ancho del sidebar */
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
            font-size: 1em; /* Reducido el tamaño del título cuando está colapsado */
            opacity: 0; /* Ocultar el título cuando está colapsado */
            transition: opacity 0.3s ease;
            width: 100%;
        }

        .sidebar:hover .nav-title {
            opacity: 1; /* Mostrar el título al pasar el ratón */
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
            align-items: center; /* Centrar verticalmente el icono y el texto */
            justify-content: center; /* Centrar horizontalmente el contenido */
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            opacity: 0; /* Ocultar los enlaces cuando está colapsado */
            transform: translateX(-20px); /* Mover los enlaces hacia la izquierda cuando está colapsado */
            transition: opacity 0.3s ease 0.1s, transform 0.3s ease 0.1s; /* Añadir un pequeño retraso para la animación */
        }

        .sidebar:hover .nav-pills li a {
            opacity: 1; /* Mostrar los enlaces al pasar el ratón */
            transform: translateX(0); /* Mover los enlaces a su posición original */
            justify-content: flex-start; /* Alinear el texto a la izquierda cuando el sidebar está expandido */
            padding-left: 15px; /* Añadir espacio para el icono */
        }

        .sidebar .nav-pills li a i {
            margin-right: 10px; /* Espacio entre el icono y el texto */
        }

        .sidebar .nav-pills li a:hover {
            background-color: #ff69b4; /* rosado fuerte */
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
    <div class="sidebar d-flex flex-column p-3">
        <a href="#" class="menu-toggle"><i class="fas fa-bars"></i></a>
        <div class="logo-container">
            <img src="logo.png" alt="Logo de la Empresa">
        </div>
        <h4 class="nav-title">Panel Admin</h4>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="./inicio.html" class="nav-link"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="./usuario.html" class="nav-link active"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="categorias.html" class="nav-link"><i class="fas fa-tags"></i> Categorías</a></li>
            <li><a href="" class="nav-link"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="ventas.html" class="nav-link"><i class="fas fa-chart-line"></i> Ventas</a></li>
            <li><a href="pedidos.html" class="nav-link"><i class="fas fa-truck"></i> Pedidos</a></li>
            <li><a href="reportes.html" class="nav-link"><i class="fas fa-chart-bar"></i> Reportes</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-users"></i> Gestión de Usuarios</h2>
        </div>
        <div class="user-management-container">
            <div class="form-section">
                <h2><i class="fas fa-user-plus"></i> Nuevo Usuario</h2>
                <form>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo">
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input type="text" id="celular">
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave</label>
                        <input type="password" id="clave">
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select class="form-select" id="rol">
                            <option value="empleado">Empleado</option>
                            <option value="administrador">Administrador</option>
                        </select>
                    </div>
                    <button type="button" class="btn-guardar"><i class="fas fa-save"></i> GUARDAR</button>
                </form>
                <div id="form-message"></div>
            </div>
            <div class="table-section">
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
                        <tr>
                            <td>Valeri</td>
                            <td>valeri@gmail.com</td>
                            <td>2146483647</td>
                            <td>administrador</td>
                            <td><button class="btn-editar"><i class="fas fa-edit"></i></button></td>
                            <td><button class="btn-eliminar"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                        <tr>
                            <td>Juan</td>
                            <td>juan@gmail.com</td>
                            <td>2147483647</td>
                            <td>empleado</td>
                            <td><button class="btn-editar"><i class="fas fa-edit"></i></button></td>
                            <td><button class="btn-eliminar"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
        
    </script>
</body>
</html>