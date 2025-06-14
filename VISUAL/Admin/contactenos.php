<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contáctenos - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            min-height: 100vh;
            display: flex;
            font-family: sans-serif;
            background-color: #f8f9fa;
        }

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

        .category-management-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .category-form-section {
            width: 100%;
            max-width: 400px;
            flex-shrink: 0;
        }

        .category-form-section h2 {
            color: #000;
            margin-bottom: 15px;
            font-size: 1.5em;
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
        .form-group textarea {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            width: 100%;
        }

        .btn-guardar {
            background-color: #ff69b4;
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

        .btn-guardar:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .category-table-section {
            flex-grow: 1;
            width: auto;
            overflow-x: auto;
        }

        .category-table-section h2 {
            color: #000;
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        .category-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #ddd;
        }

        .category-table th, .category-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .category-table th {
            background-color: #000;
            color: white;
        }

        .category-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-opciones {
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            color: white;
        }

        .btn-editar {
            background-color: #ffd700;
        }

        .btn-eliminar {
            background-color: #ff69b4;
        }

        .btn-opciones i {
            color: inherit;
        }

        .dataTables_paginate {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-top: 10px;
        }

        .dataTables_paginate .paginate_button {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px 10px;
            margin-left: 5px;
            cursor: pointer;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #000;
            color: white;
        }

        .dataTables_paginate .paginate_button.disabled {
            color: #999;
            cursor: not-allowed;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #ddd;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            display: none;
        }

        .loading.show {
            display: inline-block;
        }

        /* Estilos para las imágenes en la tabla */
        .categoria-imagen {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .imagen-placeholder {
            width: 50px;
            height: 50px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .category-management-container {
                flex-direction: column;
            }
            .category-form-section,
            .category-table-section {
                width: 100%;
            }
            .category-table th, .category-table td:nth-child(3) {
                display: none;
            }
        }
        body {
            min-height: 100vh;
            display: flex;
            font-family: sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar personalizado */
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

        .sidebar .nav-pills li a:hover,
        .sidebar .nav-pills li a.active {
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

        .contact-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 30px;
        }

        .form-section {
            width: 100%;
            max-width: 350px;
        }

        .table-section {
            flex-grow: 1;
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
            font-weight: 500;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .btn-guardar {
            background-color: #ff69b4;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
        }

        .btn-guardar:hover {
            background-color: #e6549f;
        }

        .btn-cancelar {
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-cancelar:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
        }

        .contact-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .contact-table th, .contact-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .contact-table th {
            background-color: #000;
            color: white;
        }

        .contact-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn-editar, .btn-eliminar {
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .btn-editar {
            background-color: #ffd700;
        }

        .btn-eliminar {
            background-color: #ff69b4;
        }

        .btn-editar:hover, .btn-eliminar:hover {
            color: white;
            text-decoration: none;
        }

        .form-group input:focus {
            border-color: #ff69b4;
            box-shadow: 0 0 5px rgba(255, 105, 180, 0.5);
            outline: none;
        }

        /* Estilos para mensajes */
        .mensaje {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        
        .mensaje-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .mensaje-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Media query para pantallas más pequeñas */
        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
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
            <img src="Image/Logo juancho.png" alt="Logo de la Empresa">
        </div>
        <h4 class="nav-title">Panel Admin</h4>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="inicio.php" class="nav-link"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="usuario.php" class="nav-link"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="Admin/categorias.php" class="nav-link"><i class="fas fa-tags"></i> Categorías</a></li>
            <li><a href="productos.php" class="nav-link"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="ventas.php" class="nav-link"><i class="fas fa-chart-line"></i> Ventas</a></li>
            <li><a href="pedidos.php" class="nav-link"><i class="fas fa-truck"></i> Pedidos</a></li>
            <li><a href="reportes.php" class="nav-link"><i class="fas fa-chart-bar"></i> Reportes</a></li>
            <li><a href="contactenos.php" class="nav-link active"><i class="fas fa-envelope"></i> Contáctenos</a></li>
            <li><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-envelope"></i> Gestión de Contactos</h2>
        </div>
        <div class="contact-container">
            <div class="form-section">
                <h2><i class="fas fa-user-plus"></i> <?php echo $editando ? 'Editar Contacto' : 'Nuevo Contacto'; ?></h2>
                <form method="POST" action="">
                    
                    
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required 
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <input type="text" id="celular" name="celular" required maxlength="10" pattern="[0-9]{10}"
                               value=" ">
                    </div>
                    <button type="submit" class="btn-guardar">
                        <i class="fas fa-save">hola</i>
                    </button>
                    
                    
                        <a href="contactenos.php" class="btn-cancelar">
                            <i class="fas fa-times"></i> CANCELAR
                        </a>
                    
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

                            <tr>
                                <td colspan="5" style="text-align: center;">No hay contactos registrados</td>
                            </tr>

                           
                                <tr>
                                    <td>id</td>
                                    <td>nombre</td>
                                    <td>celula</td>
                                    <td>
                                        <a href="" class="btn-editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                       
                                </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
       
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
