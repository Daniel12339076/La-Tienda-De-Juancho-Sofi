<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Productos - Panel de Administración</title>
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
            <li><a href="categorias.php" class="nav-link"><i class="fas fa-tags"></i> Categorías</a></li>
            <li><a href="productos.php" class="nav-link active"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-chart-line"></i> Ventas</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-truck"></i> Pedidos</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-chart-bar"></i> Reportes</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-box"></i> Gestión de Productos</h2>
        </div>
        <div class="product-management-container">
            <div class="product-form-section">
                <h2><i class="fas fa-plus-circle"></i> Nuevo Producto</h2>
                
                <div id="mensaje" class="alert" style="display: none;"></div>
                
                <form id="formProducto" enctype="multipart/form-data">
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
                        <input type="number" id="stock" name="stock" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria_id">Categoría</label>
                        <select id="categoria_id" name="categoria_id" required>
                            <option value="">Seleccionar categoría</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
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
                        <label>Buscar:<input type="search" id="buscar" placeholder="" aria-controls="productTable"></label>
                    </div>
                    <br>
                    <div class="dataTables_length">
                        <label>Mostrar <select id="entriesPorPagina" aria-controls="productTable"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entradas</label>
                    </div>
                    <table id="productTable" class="product-table">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProductos">
                            <!-- Los productos se cargarán aquí dinámicamente -->
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
        // Variables globales
        let productos = [];
        let productosFiltrados = [];
        let categorias = [];
        let paginaActual = 1;
        let entriesPorPagina = 10;
        let editandoId = null;

        // Inicializar cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarCategorias();
            cargarProductos();
            configurarEventos();
        });

        // Configurar eventos
        function configurarEventos() {
            document.getElementById('formProducto').addEventListener('submit', guardarProducto);
            document.getElementById('buscar').addEventListener('input', function() {
                buscarProductos(this.value);
            });
            document.getElementById('entriesPorPagina').addEventListener('change', function() {
                entriesPorPagina = parseInt(this.value);
                paginaActual = 1;
                mostrarProductos();
            });
            document.getElementById('imagen').addEventListener('change', function() {
                mostrarPreviewImagen(this);
            });
        }

        // Cargar categorías para el select
        async function cargarCategorias() {
            try {
                console.log('Intentando cargar categorías...');
                const response = await fetch('../../controladores/CategoriaController.php?accion=obtener');
                console.log('Respuesta recibida:', response);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Datos de categorías:', data);
                
                if (data.success) {
                    categorias = data.data;
                    const select = document.getElementById('categoria_id');
                    select.innerHTML = '<option value="">Seleccionar categoría</option>';
                    
                    categorias.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = categoria.nombre;
                        select.appendChild(option);
                    });
                    console.log('Categorías cargadas exitosamente');
                } else {
                    throw new Error(data.message || 'Error desconocido');
                }
            } catch (error) {
                console.error('Error al cargar categorías:', error);
                mostrarMensaje('Error al cargar categorías. Verifica la conexión.', 'error');
            }
        }

        // Cargar productos desde la base de datos
        async function cargarProductos() {
            try {
                console.log('Intentando cargar productos...');
                const response = await fetch('../../controladores/ProductoController.php?accion=obtener');
                console.log('Respuesta de productos:', response);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Datos de productos:', data);
                
                if (data.success) {
                    productos = data.data;
                    productosFiltrados = [...productos];
                    mostrarProductos();
                    console.log('Productos cargados exitosamente');
                } else {
                    throw new Error(data.message || 'Error desconocido');
                }
            } catch (error) {
                console.error('Error al cargar productos:', error);
                mostrarMensaje('Error de conexión al cargar productos', 'error');
            }
        }

        // Buscar productos
        async function buscarProductos(termino) {
            if (termino.trim() === '') {
                productosFiltrados = [...productos];
                mostrarProductos();
                return;
            }
            
            try {
                const response = await fetch(`../../controladores/ProductoController.php?accion=buscar&termino=${encodeURIComponent(termino)}`);
                const data = await response.json();
                
                if (data.success) {
                    productosFiltrados = data.data;
                } else {
                    mostrarMensaje('Error en la búsqueda: ' + (data.message || ''), 'error');
                }
            } catch (error) {
                console.error('Error en búsqueda:', error);
                mostrarMensaje('Error de conexión durante la búsqueda', 'error');
            }
            
            paginaActual = 1;
            mostrarProductos();
        }

        // Función para obtener la ruta correcta de la imagen
        function obtenerRutaImagen(imagen) {
            if (!imagen || imagen === null || imagen === 'null') {
                return null;
            }
            
            return '../../uploads/' + imagen;
        }

        // Mostrar productos en la tabla
        function mostrarProductos() {
            const tbody = document.getElementById('tablaProductos');
            const inicio = (paginaActual - 1) * entriesPorPagina;
            const fin = inicio + entriesPorPagina;
            const productosPagina = productosFiltrados.slice(inicio, fin);
            
            tbody.innerHTML = '';
            
            if (productosPagina.length === 0) {
                const fila = document.createElement('tr');
                fila.innerHTML = '<td colspan="7" class="text-center">No hay productos disponibles</td>';
                tbody.appendChild(fila);
            } else {
                productosPagina.forEach(producto => {
                    const fila = document.createElement('tr');
                    
                    // Manejar la imagen
                    let imagenHtml = '';
                    const rutaImagen = obtenerRutaImagen(producto.imagen);
                    
                    if (rutaImagen) {
                        imagenHtml = `<img src="${rutaImagen}" alt="Imagen de ${producto.nombre}" class="producto-imagen" 
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="imagen-placeholder" style="display: none;">Sin imagen</div>`;
                    } else {
                        imagenHtml = `<div class="imagen-placeholder">Sin imagen</div>`;
                    }

                    // Estado
                    const estadoClass = producto.estado === 'activo' ? 'status-activo' : 'status-inactivo';
                    const estadoTexto = producto.estado === 'activo' ? 'Activo' : 'Inactivo';

                    // Stock con alerta si es bajo
                    const stockClass = producto.stock < 10 ? 'stock-low' : '';
                    
                    fila.innerHTML = `
                        <td>${imagenHtml}</td>
                        <td>
                            <strong>${producto.nombre}</strong><br>
                            <small>${producto.descripcion}</small>
                        </td>
                        <td>${producto.categoria_nombre || 'Sin categoría'}</td>
                        <td class="price-cell">$${parseFloat(producto.precio).toFixed(2)}</td>
                        <td class="stock-cell ${stockClass}">${producto.stock}</td>
                        <td><span class="status-badge ${estadoClass}">${estadoTexto}</span></td>
                        <td>
                            <button class="btn-opciones btn-editar" onclick="editarProducto(${producto.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-opciones btn-eliminar" onclick="eliminarProducto(${producto.id})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(fila);
                });
            }
            
            actualizarInfoPaginacion();
            actualizarPaginacion();
        }

        // Guardar producto (crear o actualizar)
        async function guardarProducto(e) {
            e.preventDefault();
            
            const formData = new FormData();
            const nombre = document.getElementById('nombre').value.trim();
            const descripcion = document.getElementById('descripcion').value.trim();
            const precio = document.getElementById('precio').value;
            const stock = document.getElementById('stock').value;
            const categoria_id = document.getElementById('categoria_id').value;
            const estado = document.getElementById('estado').value;
            const imagen = document.getElementById('imagen').files[0];
            
            if (!nombre || !descripcion || !precio || !stock || !categoria_id) {
                mostrarMensaje('Todos los campos son obligatorios', 'error');
                return;
            }
            
            toggleLoading(true);
            
            formData.append('nombre', nombre);
            formData.append('descripcion', descripcion);
            formData.append('precio', precio);
            formData.append('stock', stock);
            formData.append('categoria_id', categoria_id);
            formData.append('estado', estado);
            if (imagen) {
                formData.append('imagen', imagen);
            }
            
            if (editandoId) {
                formData.append('accion', 'actualizar');
                formData.append('id', editandoId);
            } else {
                formData.append('accion', 'crear');
            }
            
            try {
                const response = await fetch('../../controladores/ProductoController.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    mostrarMensaje(data.message, 'success');
                    limpiarFormulario();
                    cargarProductos();
                } else {
                    mostrarMensaje(data.message || 'Error al procesar la solicitud', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('Error de conexión', 'error');
            } finally {
                toggleLoading(false);
            }
        }

        // Editar producto
        function editarProducto(id) {
            const producto = productos.find(p => p.id == id);
            if (producto) {
                document.getElementById('nombre').value = producto.nombre;
                document.getElementById('descripcion').value = producto.descripcion;
                document.getElementById('precio').value = producto.precio;
                document.getElementById('stock').value = producto.stock;
                document.getElementById('categoria_id').value = producto.categoria_id;
                document.getElementById('estado').value = producto.estado;
                editandoId = id;
                
                // Si hay imagen, mostrar preview
                if (producto.imagen) {
                    const preview = document.getElementById('preview');
                    preview.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = obtenerRutaImagen(producto.imagen);
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';
                    img.style.objectFit = 'cover';
                    img.style.border = '1px solid #ddd';
                    img.style.borderRadius = '4px';
                    preview.appendChild(img);
                }
                
                document.querySelector('.btn-text').textContent = 'ACTUALIZAR';
                document.querySelector('.product-form-section').scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Eliminar producto
        async function eliminarProducto(id) {
            if (!confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                return;
            }
            
            const formData = new FormData();
            formData.append('accion', 'eliminar');
            formData.append('id', id);
            
            try {
                const response = await fetch('../../controladores/ProductoController.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    mostrarMensaje(data.message, 'success');
                    cargarProductos();
                } else {
                    mostrarMensaje(data.message || 'Error al eliminar', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('Error de conexión', 'error');
            }
        }

        // Limpiar formulario
        function limpiarFormulario() {
            document.getElementById('formProducto').reset();
            document.getElementById('preview').innerHTML = '';
            editandoId = null;
            document.querySelector('.btn-text').textContent = 'GUARDAR';
        }

        // Mostrar mensaje
        function mostrarMensaje(texto, tipo) {
            const mensaje = document.getElementById('mensaje');
            mensaje.textContent = texto;
            mensaje.className = `alert alert-${tipo}`;
            mensaje.style.display = 'block';
            
            setTimeout(() => {
                mensaje.style.display = 'none';
            }, 5000);
        }

        // Toggle loading
        function toggleLoading(mostrar) {
            const loading = document.querySelector('.loading');
            const btnText = document.querySelector('.btn-text');
            const btn = document.querySelector('.btn-guardar');
            
            if (mostrar) {
                loading.classList.add('show');
                btnText.style.display = 'none';
                btn.disabled = true;
            } else {
                loading.classList.remove('show');
                btnText.style.display = 'inline';
                btn.disabled = false;
            }
        }

        // Mostrar preview de imagen
        function mostrarPreviewImagen(input) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';
                    img.style.objectFit = 'cover';
                    img.style.border = '1px solid #ddd';
                    img.style.borderRadius = '4px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Actualizar información de paginación
        function actualizarInfoPaginacion() {
            const info = document.getElementById('tablaInfo');
            const total = productosFiltrados.length;
            
            if (total === 0) {
                info.textContent = 'No hay entradas para mostrar';
                return;
            }
            
            const inicio = (paginaActual - 1) * entriesPorPagina + 1;
            const fin = Math.min(inicio + entriesPorPagina - 1, total);
            
            info.textContent = `Mostrando ${inicio} a ${fin} de ${total} entradas`;
        }

        // Actualizar paginación
        function actualizarPaginacion() {
            const paginacion = document.getElementById('paginacion');
            const totalPaginas = Math.ceil(productosFiltrados.length / entriesPorPagina);
            
            let html = '';
            
            html += `<button class="paginate_button ${paginaActual === 1 ? 'disabled' : ''}" 
                     onclick="cambiarPagina(${paginaActual - 1})" 
                     ${paginaActual === 1 ? 'disabled' : ''}>Anterior</button>`;
            
            html += `<span><button class="paginate_button current">${paginaActual}</button></span>`;
            
            html += `<button class="paginate_button ${paginaActual === totalPaginas || totalPaginas === 0 ? 'disabled' : ''}" 
                     onclick="cambiarPagina(${paginaActual + 1})" 
                     ${paginaActual === totalPaginas || totalPaginas === 0 ? 'disabled' : ''}>Siguiente</button>`;
            
            paginacion.innerHTML = html;
        }

        // Cambiar página
        function cambiarPagina(nuevaPagina) {
            const totalPaginas = Math.ceil(productosFiltrados.length / entriesPorPagina);
            
            if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
                paginaActual = nuevaPagina;
                mostrarProductos();
            }
        }
    </script>
</body>
</html>
