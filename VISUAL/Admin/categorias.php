<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Categorías - Panel de Administración</title>
    <link rel="icon" href="../Image/Logo juancho.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            min-height: 100vh;
            display: flex;
            font-family: sans-serif;
            background-color: #f8f9fa;
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
    </style>
</head>
<body>
   <?php 
   include 'sidebar.php';
   include  'header.php'; 
   ?>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-tags"></i> Gestión de Categorías</h2>
        </div>
        <div class="category-management-container">
            <div class="category-form-section">
                <h2><i class="fas fa-plus-circle"></i> Nueva Categoría</h2>
                
                <div id="mensaje" class="alert" style="display: none;"></div>
                
                <form id="formCategoria" action="../../controladores/CategoriaController.php?accion=registrar" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input type="file" id="imagen" name="imagen" accept="image/*">
                        <div id="preview" style="margin-top: 10px;"></div>
                    </div>
                    <button type="submit" class="btn-guardar">
                        <i class="fas fa-save"></i> 
                        <span class="btn-text">GUARDAR</span>
                        <i class="fas fa-spinner fa-spin loading"></i>
                    </button>
                </form>
            </div>
            <div class="category-table-section">
                <div class="dataTables_wrapper">
                    <div class="dataTables_filter">
                        <label>Buscar:<input type="search" id="buscar" placeholder="" aria-controls="categoryTable"></label>
                    </div>
                    <br>
                    <div class="dataTables_length">
                        <label>Mostrar <select id="entriesPorPagina" aria-controls="categoryTable"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entradas</label>
                    </div>
                    <table id="categoryTable" class="category-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCategorias">
                            <!-- Las categorías se cargarán aquí dinámicamente -->
                        </tbody>
                    </table>
                    <div id="tablaInfo" class="dataTables_info">Mostrando 1 a 5 de 5 entradas</div>
                    <div id="paginacion" class="dataTables_paginate">
                        <button class="paginate_button previous disabled">Anterior</button>
                        <span><button class="paginate_button current">1</button></span>
                        <button class="paginate_button next disabled">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       
        // Función para obtener la ruta correcta de la imagen
        function obtenerRutaImagen(imagen) {
            if (!imagen || imagen === null || imagen === 'null') {
                return null;
            }
            
            // Si la imagen ya incluye la ruta completa, la usamos tal como está
            if (imagen.startsWith('../../uploads/') || imagen.startsWith('uploads/')) {
                return imagen.startsWith('../../') ? imagen : '../../' + imagen;
            }
            
            // Si no, construimos la ruta
            return '../../uploads/' + imagen.replace('uploads/', '');
        }

        
    </script>
</body>
</html>