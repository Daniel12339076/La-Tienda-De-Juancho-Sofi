<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Productos - Panel de Administración</title>
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

        .product-management-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .product-form-section {
            width: 100%;
            max-width: 400px;
            flex-shrink: 0;
        }

        .product-form-section h2 {
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
        .form-group input[type="number"],
        .form-group select,
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

        .product-table-section {
            flex-grow: 1;
            width: auto;
            overflow-x: auto;
        }

        .product-table-section h2 {
            color: #000;
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #ddd;
        }

        .product-table th, .product-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .product-table th {
            background-color: #000;
            color: white;
        }

        .product-table tbody tr:nth-child(even) {
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
        .producto-imagen {
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

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-activo {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactivo {
            background-color: #f8d7da;
            color: #721c24;
        }

        .price-cell {
            font-weight: bold;
            color: #28a745;
        }

        .stock-cell {
            text-align: center;
        }

        .stock-low {
            color: #dc3545;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .product-management-container {
                flex-direction: column;
            }
            .product-form-section,
            .product-table-section {
                width: 100%;
            }
            .product-table th:nth-child(3),
            .product-table td:nth-child(3),
            .product-table th:nth-child(4),
            .product-table td:nth-child(4) {
                display: none;
            }
        }
    </style>
</head>
<body>
   <?php 
   include 'sidebar.php';
   include  'header.php';
   include '../../config/Conexion.php';
   include '../../modelos/ProductoModel.php';
   $productos = obtenerProductos($conn);
   $categorias = obtenerCategorias($conn);

   ?>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-box"></i> Gestión de Productos</h2>
        </div>
        <div class="product-management-container">
            <div class="product-form-section">
                <h2><i class="fas fa-plus-circle"></i> Nuevo Producto</h2>
                
                <div id="mensaje" class="alert" style="display: none;"></div>
                
                <form action="../../controladores/ProductoController.php?accion=registrar" method="POST" id="formProducto" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="cantidad" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria_id">Categoría</label>
                        <select id="categoria_id" name="categoria_id" required>
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id']; ?>"><?= $categoria['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" required>
                            <option value="ACTI">Activo</option>
                            <option value="INAC">Inactivo</option>
                        </select>
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
            <div class="product-table-section">
                <div class="dataTables_wrapper">
                    <div class="dataTables_filter">
                        <input type="search" id="buscar" class="form-control form-control-sm" placeholder="Buscar Producto...">
                    </div>
                    <br>
                    
                    <table id="productTable" class="product-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProductos">
                            <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?= $producto['id']; ?></td>
                                
                                <td><?= $producto['nombre']; ?></td>
                                <td><?= $producto['id_categoria']; ?></td>
                                <td class="price-cell">$<?= number_format($producto['precio_unitario'], 2, ',', '.'); ?></td>
                                <td class="stock-cell">
                                    <?= $producto['cantidad']; ?>
                                    <?php if ($producto['cantidad'] < 5): ?>
                                        <span class="stock-low">Bajo Stock</span>
                                    <?php endif; ?> 
                                </td>
                                <td>
                                    <span class="status-badge">
                                        <?php if ($producto['estado'] == 'ACTI'): ?>
                                            <span class="status-activo">Habilitado</span>
                                        <?php else: ?>
                                            <span class="status-inactivo">Inactivo</span>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-opciones btn-editar" data-bs-toggle="modal" data-bs-target="#modalEditarProducto<?= $producto['id']; ?>">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button class="btn-opciones btn-eliminar" onclick="eliminarProducto(<?= $producto['id']; ?>)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal para editar producto -->
                            <div class="modal fade" 
                                id="modalEditarProducto<?= $producto['id']; ?>" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditarProductoLabel">Editar Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body"> 
                                            <form action="../../controladores/ProductoController.php?accion=actualizar" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?= $producto['id']; ?>">
                                                <div class="form-group">
                                                    <label for="nombreEditar">Nombre</label>
                                                    <input type="text" id="nombreEditar" name="nombre" value="<?= $producto['nombre']; ?>" required> 
                                                </div>
                                                <div class="form-group">
                                                    <label for="descripcionEditar">Descripción</label>
                                                    <textarea id="descripcionEditar" name="descripcion" rows="3" required><?= $producto['descripcion']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="precioEditar">Precio</label>
                                                    <input type="number" id="precioEditar" name="precio" step="0.01" min="0" value="<?= $producto['precio_unitario']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="stockEditar">Stock</label>
                                                    <input type="number" id="stockEditar" name="cantidad" min="0" value="<?= $producto['cantidad']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="categoriaEditar">Categoría</label>
                                                    <select id="categoriaEditar" name="categoria_id" required>
                                                        <option value="">Seleccione una categoría</option>
                                                        <?php foreach ($categorias as $categoria): ?>
                                                            <option value="<?= $categoria['id']; ?>" <?php if ($producto['id_categoria'] == $categoria['id']) echo 'selected'; ?>>
                                                                <?= $categoria['nombre']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="estadoEditar">Estado</label>
                                                    <select id="estadoEditar" name="estado" required>
                                                        <option value="ACTI" <?php if ($producto['estado'] == 'ACTI') echo 'selected'; ?>>Habilitado</option>
                                                        <option value="INAC" <?php if ($producto['estado'] == 'INAC') echo 'selected'; ?>>Inactivo</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                        <label for="imagenproducto<?= $producto['id'] ?>" class="form-label">Imagen</label>
                                                        <input type="file"
                                                            id="imagenproducto<?= $producto['id'] ?>"
                                                            name="imagen"
                                                            accept="image/*"
                                                            class="form-control"
                                                            onchange="mostrarNombreArchivo(this)" />
                                                        
                                                        <!-- Mostrar el nombre del archivo actual -->
                                                        <div class="form-text text-success mt-1">
                                                            Archivo actual: <?= htmlspecialchars($producto['imagen']) ?>
                                                        </div>
                                                       

                                                        <!-- Aquí se mostrará el nuevo archivo seleccionado -->
                                                        <div id="nombreArchivo<?= $producto['id'] ?>" class="form-text mt-1 text-primary"></div>
                                                    </div>
                                                <button type="submit" class="btn-guardar">
                                                    <i class="fas fa-save"></i> Guardar Cambios
                                                </button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function mostrarNombreArchivo(input) {
        const nombreArchivo = input.files[0]?.name || 'Ningún archivo seleccionado';
        const id = input.id.replace('imagenproducto', 'nombreArchivo');
        document.getElementById(id).textContent = 'Seleccionado: ' + nombreArchivo;
        }
        //Buscar en la tabla
        document.getElementById("buscar").addEventListener("keyup", function () {
        const filtro = this.value.toLowerCase();
        const filas = document.querySelectorAll("#productTable tbody tr");

        filas.forEach(fila => {
            const textoFila = fila.textContent.toLowerCase();
            fila.style.display = textoFila.includes(filtro) ? "" : "none";
        });
        });
    </script>
</body>
</html>
