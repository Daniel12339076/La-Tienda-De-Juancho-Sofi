<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Categorías - Panel de Administración</title>
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
            <li><a href="categorias.php" class="nav-link active"><i class="fas fa-tags"></i> Categorías</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-chart-line"></i> Ventas</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-truck"></i> Pedidos</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-chart-bar"></i> Reportes</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-tags"></i> Gestión de Categorías</h2>
        </div>
        <div class="category-management-container">
            <div class="category-form-section">
                <h2><i class="fas fa-plus-circle"></i> Nueva Categoría</h2>
                
                <div id="mensaje" class="alert" style="display: none;"></div>
                
                <form id="formCategoria" enctype="multipart/form-data">
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
        // Variables globales
        let categorias = [];
        let categoriasFiltradas = [];
        let paginaActual = 1;
        let entriesPorPagina = 10;
        let editandoId = null;

        // Inicializar cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarCategorias();
            configurarEventos();
        });

        // Configurar eventos
        function configurarEventos() {
            document.getElementById('formCategoria').addEventListener('submit', guardarCategoria);
            document.getElementById('buscar').addEventListener('input', function() {
                buscarCategorias(this.value);
            });
            document.getElementById('entriesPorPagina').addEventListener('change', function() {
                entriesPorPagina = parseInt(this.value);
                paginaActual = 1;
                mostrarCategorias();
            });
            document.getElementById('imagen').addEventListener('change', function() {
                mostrarPreviewImagen(this);
            });
        }

        // Cargar categorías desde la base de datos
        async function cargarCategorias() {
            try {
                const response = await fetch('../../controladores/CategoriaController.php?accion=obtener');
                const data = await response.json();
                
                if (data.success) {
                    categorias = data.data;
                    categoriasFiltradas = [...categorias];
                    mostrarCategorias();
                } else {
                    mostrarMensaje('Error al cargar categorías', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('Error de conexión Cargar Datos', 'error');
            }
        }

        // Buscar categorías
        async function buscarCategorias(termino) {
            if (termino.trim() === '') {
                categoriasFiltradas = [...categorias];
            } else {
                try {
                    const response = await fetch(`../../controladores/CategoriaController.php?accion=buscar&termino=${encodeURIComponent(termino)}`);
                    const data = await response.json();
                    
                    if (data.success) {
                        categoriasFiltradas = data.data;
                    }
                } catch (error) {
                    console.error('Error en búsqueda:', error);
                }
            }
            
            paginaActual = 1;
            mostrarCategorias();
        }

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

        // Mostrar categorías en la tabla
        function mostrarCategorias() {
            const tbody = document.getElementById('tablaCategorias');
            const inicio = (paginaActual - 1) * entriesPorPagina;
            const fin = inicio + entriesPorPagina;
            const categoriasPagina = categoriasFiltradas.slice(inicio, fin);
            
            tbody.innerHTML = '';
            
            categoriasPagina.forEach(categoria => {
                const fila = document.createElement('tr');
                
                // Manejar la imagen
                let imagenHtml = '';
                const rutaImagen = obtenerRutaImagen(categoria.imagen);
                
                if (rutaImagen) {
                    imagenHtml = `<img src="${rutaImagen}" alt="Imagen de ${categoria.nombre}" class="categoria-imagen" 
                                  onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                  <div class="imagen-placeholder" style="display: none;">Sin imagen</div>`;
                } else {
                    imagenHtml = `<div class="imagen-placeholder">Sin imagen</div>`;
                }
                
                fila.innerHTML = `
                    <td>${categoria.nombre}</td>
                    <td>${categoria.descripcion}</td>
                    <td>${imagenHtml}</td>
                    <td>
                        <button class="btn-opciones btn-editar" onclick="editarCategoria(${categoria.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-opciones btn-eliminar" onclick="eliminarCategoria(${categoria.id})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(fila);
            });
            
            actualizarInfoPaginacion();
            actualizarPaginacion();
        }

        // Guardar categoría (crear o actualizar)
        async function guardarCategoria(e) {
            e.preventDefault();
            
            const formData = new FormData();
            const nombre = document.getElementById('nombre').value.trim();
            const descripcion = document.getElementById('descripcion').value.trim();
            const imagen = document.getElementById('imagen').files[0];
            
            if (!nombre || !descripcion ) {
                mostrarMensaje('Nombre y descripción son obligatorios', 'error');
                return;
            }
            
            toggleLoading(true);
            
            formData.append('nombre', nombre);
            formData.append('descripcion', descripcion);

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
                const response = await fetch('../../controladores/CategoriaController.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data) {
                    mostrarMensaje("Registro Exitoso", 'success');
                    limpiarFormulario();
                    cargarCategorias();
                } else {
                    mostrarMensaje("Error al registrar", 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('Error de conexión', 'error');
            } finally {
                toggleLoading(false);
            }
        }

        // Editar categoría
        function editarCategoria(id) {
            const categoria = categorias.find(c => c.id == id);
            if (categoria) {
                document.getElementById('nombre').value = categoria.nombre;
                document.getElementById('descripcion').value = categoria.descripcion;
                editandoId = id;
                
                document.querySelector('.btn-text').textContent = 'ACTUALIZAR';
                document.querySelector('.category-form-section').scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Eliminar categoría
        async function eliminarCategoria(id) {
            if (!confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
                return;
            }
            
            const formData = new FormData();
            formData.append('accion', 'eliminar');
            formData.append('id', id);
            
            try {
                const response = await fetch('../../controladores/CategoriaController.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data) {
                    mostrarMensaje("Eliminado Exitosomente", 'success');
                    limpiarFormulario();
                    cargarCategorias();
                } else {
                    mostrarMensaje("Error al eliminar", 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('Error de conexión', 'error');
            }
        }

        // Limpiar formulario
        function limpiarFormulario() {
            document.getElementById('formCategoria').reset();
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
            const inicio = (paginaActual - 1) * entriesPorPagina + 1;
            const fin = Math.min(inicio + entriesPorPagina - 1, categoriasFiltradas.length);
            const total = categoriasFiltradas.length;
            
            info.textContent = `Mostrando ${inicio} a ${fin} de ${total} entradas`;
        }

        // Actualizar paginación
        function actualizarPaginacion() {
            const paginacion = document.getElementById('paginacion');
            const totalPaginas = Math.ceil(categoriasFiltradas.length / entriesPorPagina);
            
            let html = '';
            
            html += `<button class="paginate_button ${paginaActual === 1 ? 'disabled' : ''}" 
                     onclick="cambiarPagina(${paginaActual - 1})" 
                     ${paginaActual === 1 ? 'disabled' : ''}>Anterior</button>`;
            
            html += `<span><button class="paginate_button current">${paginaActual}</button></span>`;
            
            html += `<button class="paginate_button ${paginaActual === totalPaginas ? 'disabled' : ''}" 
                     onclick="cambiarPagina(${paginaActual + 1})" 
                     ${paginaActual === totalPaginas ? 'disabled' : ''}>Siguiente</button>`;
            
            paginacion.innerHTML = html;
        }

        // Cambiar página
        function cambiarPagina(nuevaPagina) {
            const totalPaginas = Math.ceil(categoriasFiltradas.length / entriesPorPagina);
            
            if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
                paginaActual = nuevaPagina;
                mostrarCategorias();
            }
        }
    </script>
</body>
</html>