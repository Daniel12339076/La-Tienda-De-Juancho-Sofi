
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="icon" href="../Image/Logo juancho.png">
    <title>Panel de Administración - Juancho & Sofi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Fondo negro */
            color: #fff; /* Texto blanco */
        }
        .sidebar {
            background-color: #ffcc00; /* Amarillo de Juancho & Sofi */
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            overflow-y: auto; /* Permite desplazamiento vertical */
            overflow-x: hidden; /* Evita el desbordamiento horizontal */
        }
        .sidebar a {
            color: #000; /* Texto negro */
            text-decoration: none;
            display: block;
            margin: 15px 0;
            font-weight: bold;
            text-align: center; /* Centra el texto de los enlaces */
        }
        .sidebar a:hover {
            color: #ffffff; /* Texto blanco al pasar el mouse */
        }

        .sidebar a.active {
            color: #000; /* Texto negro */
            text-decoration: none;
            width: 150%; /* Ocupa todo el ancho de la barra lateral */
            padding: 15px 10px; /* Espaciado interno */
            font-weight: bold;
            text-align: center; /* Centra el texto */
            position: relative; /* Necesario para el pseudo-elemento */
            margin: 0; /* Elimina márgenes */
        }


        .sidebar a.active { /* Aplica estilos al pasar el mouse o cuando está activo */
            background-color: #fd00db; /* Fondo oscuro */
            color: #fff; /* Texto blanco */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Sombra */
        }

        .sidebar a.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px; /* Ancho de la barra de color */
            background-color: #00ffcc; /* Color de la barra */
        }
        .content {

            margin-left: 270px;
            padding: 20px;
        }
        .card {
            background-color: #333; /* Fondo oscuro */
            border: 2px solid #ffcc00; /* Borde amarillo */
            color: #fff;
        }
        .card:hover {
            background-color: #444; /* Fondo más claro al pasar el mouse */
        }
        .card i {
            font-size: 3rem; /* Tamaño del ícono */
            margin-bottom: 10px;
        }
    </style>
</head>
    <body>
        <?php 
        include 'sidebar.php';
        include  'header.php'; 
        ?>
        
        <div class="content">
            <h1>Panel de Administración</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>VENTAS</h3>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <i class="fas fa-truck"></i>
                        <h3>PEDIDOS</h3>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <i class="fas fa-file-alt"></i>
                        <h3>REPORTES</h3>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <i class="fas fa-folder"></i>
                        <h3>CATEGORÍAS</h3>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <i class="fas fa-box"></i>
                        <h3>PRODUCTOS</h3>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <i class="fas fa-users"></i>
                        <h3>USUARIOS</h3>
                        
                    </div>
                </div>
            </div>
        </div>
        <script>
        </script>
    </body>
    </html>