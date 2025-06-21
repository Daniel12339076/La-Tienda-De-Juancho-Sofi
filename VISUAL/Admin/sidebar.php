<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       
    </style>
</head>
<body>
     <?php $pagina = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); ?>
    <div class="sidebar d-flex flex-column p-2">
        <a class="menu-toggle"><i class="fas fa-bars"></i></a>
        <div class="logo-container">
            <img src="../Image/Logo juancho.png" alt="Logo de la Empresa">
        </div>
        <h4 class="nav-title">Panel Admin</h4>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto ">
            <li class=""><a href="inicio.php" class="nav-link i-inicio"><i class="fas fa-home "></i> Inicio</a></li>
            <li class=""><a href="usuario.php" class="nav-link i-usuario"><i class="fas fa-users "></i> Usuarios</a></li>
            <li class=""><a href="categorias.php" class="nav-link i-categorias"><i class="fas fa-tags "></i> Categorías</a></li>
            <li class=""><a href="productos.php" class="nav-link i-productos"><i class="fas fa-box "></i> Productos</a></li>
            <li class=""><a href="ventas.php" class="nav-link i-ventas"><i class="fas fa-chart-line "></i> Ventas</a></li>
            <li class=""><a href="pedidos.php" class="nav-link i-pedidos"><i class="fas fa-truck "></i> Pedidos</a></li>
            <li class=""><a href="reportes.php" class="nav-link i-reportes"><i class="fas fa-chart-bar "></i> Reportes</a></li>
            <hr>
            <li class=""><a href="../../controladores/UsuarioController.php?accion=salir" class="nav-link"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
        </ul>
    </div>

</body>
</html>