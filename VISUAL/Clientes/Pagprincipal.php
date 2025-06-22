<?php

  session_start();
  if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
      header('Location: login.php');
      exit;
  }


  // Obtener información del usuario
  $nombreUsuario = $_SESSION['nombre']
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>La Tienda de Juancho & Sofi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="misestilos.css">
  <link rel="icon" href="../Image/Logo juancho.png" type="image/png">
  <style>
    /* Fondo negro y texto blanco */
    body {
      background-color: black;
      color: white;
    }

    /* Bordes de la página */
    body::before,
    body::after {
      content: '';
      display: block;
      position: fixed;
      width: 100%;
      height: 10px;
      
      z-index: 9999;
    }

    body::before {
      top: 0;
    }

    body::after {
      bottom: 0;
    }

    /* Estilo para los enlaces */
    a {
      color: white;
    }

    a:hover {
      color: yellow;
    }

    /* Navbar */
    .navbar {
      font-family: 'Poppins', sans-serif;
      background-color: black !important;
      font-weight: bold;
    }

    .navbar .nav-link {
      color: white !important;
    }

    .navbar .nav-link:hover {
      color: yellow !important;
    }

    .navbar {
      border-bottom: 1px solid #444;
      border-bottom: 5px solid transparent;
			/* Necesario para aplicar el degradado */
			border-image: linear-gradient(to right, #ffff00, #ff69b4) 1;
			/* Degradado amarillo a rosado */
			border-image-slice: 1;
			/* Aplica el degradado al borde */
    }


    .hero-section {
      background-color: black;
      color: white;
    }

    /* Tarjetas */
    .card {
      background-color: #333;
      border: 1px solid yellow;
    }

    .card-title,
    .card-text {
      color: white;
    }

    .ropa-section {
      background-color: #000;
      /* Fondo negro puro */
      color: #fff;
      /* Texto blanco */
    }

    .ropa-section .card {
      background-color: #000;
      /* Fondo de las tarjetas */
      color: #fff;
      /* Texto blanco en las tarjetas */
      border: 2px solid yellow;
      /* Amarillo (dorado) */
    }

    .ropa-section .card:hover {
      border-color: #fff;
      /* Borde blanco al pasar el mouse */
      transition: 0.3s;
      /*cursor*/
      cursor: pointer;
    }

    /* Footer */
    footer.bg-black {
      background-color: #000;
      /* Fondo negro puro */
      color: #fff;
      /* Texto blanco */
      border-top: 2px solid #FFD700;
      /* Borde superior amarillo (opcional) */
    }


    /* Estilo para submenús */
    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -1px;
      display: none;
      /* Ocultar submenús por defecto */
    }

    .dropdown-submenu:hover .dropdown-menu {
      display: block;
      /* Mostrar submenús al pasar el mouse */
    }

    /* Estilo general para los menús desplegables */
    .navbar .dropdown-menu {
      background-color: black;
      /* Fondo negro */
      border: 1px solid yellow;
      /* Borde amarillo */
      color: white;
      /* Texto blanco */
    }

    /* Estilo para los enlaces dentro del menú */
    .navbar .dropdown-menu .dropdown-item {
      color: white;
      /* Texto blanco */
      font-weight: bold;
      /* Texto en negrita */
      transition: background-color 0.3s, color 0.3s;
      /* Transición suave */
    }

    /* Hover en los enlaces del menú */
    .navbar .dropdown-menu .dropdown-item:hover {
      background-color: yellow;
      /* Fondo amarillo al pasar el mouse */
      color: black;
      /* Texto negro al pasar el mouse */
    }

    /* Submenús */
    .navbar .dropdown-submenu .dropdown-menu {
      background-color: black;
      /* Fondo negro */
      border: 1px solid pink;
      /* Borde rosa */
      margin-left: 0.1rem;
      /* Ajuste de posición */
    }

    /* Hover en los submenús */
    .navbar .dropdown-submenu:hover>.dropdown-menu {
      display: block;
      /* Mostrar submenú al pasar el mouse */
    }

    /* Estilo para los enlaces dentro de los submenús */
    .navbar .dropdown-submenu .dropdown-item {
      color: white;
      /* Texto blanco */
    }

    /* Hover en los enlaces de los submenús */
    .navbar .dropdown-submenu .dropdown-item:hover {
      background-color: pink;
      /* Fondo rosa al pasar el mouse */
      color: black;
      /* Texto negro al pasar el mouse */
    }

    /* Ajuste de posición para submenús */
    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu .dropdown-menu {
      top: 0;
      left: 100%;
      /* Posicionar a la derecha del menú principal */
      margin-top: -1px;
    }

    footer {
      background-color: black;
      color: white;
    }

    footer a {
      color: white;
      text-decoration: none;
    }

    footer a:hover {
      color: yellow;
      text-decoration: underline;
    }

    footer .btn-outline-light {
      border-color: yellow;
      color: yellow;
    }

    footer .btn-outline-light:hover {
      background-color: yellow;
      color: black;
    }

    /* Separación entre las columnas del footer */
    footer .col-md-4 {
      margin-bottom: 30px;
      /* Espacio entre las columnas */
    }

    /* Separación entre los elementos de las listas */
    footer ul li {
      margin-bottom: 10px;
      /* Espacio entre los elementos de la lista */
    }

    /* Separación entre el formulario y las redes sociales */
    footer .input-group {
      margin-bottom: 20px;
      /* Espacio entre el formulario y las redes sociales */
    }
  </style>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Logo y menú -->
      <a class="navbar-brand" href="Pagina inicial.html">
        <img src="../Image/Logo juancho.png" alt="Logo" width="110" height="110">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links de navegación -->
      <div class="collapse navbar-collapse bs-body-bg" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="Socios.html">Inicio</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Productos
            </a>
            <ul class="dropdown-menu" aria-labelledby="productosDropdown">
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#" id="dropdown_celulares" role="button"
                  data-bs-toggle="dropdown" aria-expanded="false">Celulares</a>
                <ul class="dropdown-menu" aria-labelledby="dropdown_celulares">
                  <li><a class="dropdown-item" href="#">Apple</a></li>
                  <li><a class="dropdown-item" href="#">Samsung</a></li>
                  <li><a class="dropdown-item" href="#">Xiaomi</a></li>
                </ul>
              </li>
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Accesorios</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Fundas</a></li>
                  <li><a class="dropdown-item" href="#">Cargadores</a></li>
                  <li><a class="dropdown-item" href="#">Audífonos</a></li>
                </ul>
              </li>
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Ropa</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Prendas Superiores</a></li>
                  <li><a class="dropdown-item" href="#">Prendas Inferiores</a></li>
                  <li><a class="dropdown-item" href="#">Prendas Deportivas</a></li>
                </ul>
              </li>
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Calzado</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Zapatos Deportivos</a></li>
                  <li><a class="dropdown-item" href="#">Zapatos Para Dama</a></li>
                  <li><a class="dropdown-item" href="#">Sandalias</a></li>
                </ul>
              </li>
              <li><a class="dropdown-item" href="#">Ofertas por tiempo limitado</a></li>
              <li><a class="dropdown-item" href="#">Combos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="servicioDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Servicio Técnico
            </a>
            <ul class="dropdown-menu" aria-labelledby="servicioDropdown">
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Reparaciones</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Celulares</a></li>
                  <li><a class="dropdown-item" href="#">Laptops</a></li>
                  <li><a class="dropdown-item" href="#">Tablets</a></li>
                </ul>
              </li>
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Mantenimiento</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Hardware</a></li>
                  <li><a class="dropdown-item" href="#">Software</a></li>
                </ul>
              </li>

              <li><a class="dropdown-item" href="#">Asesoramiento técnico</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="#">Colecciones</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
        </ul>

        <!-- Logos de patrocinadores y botón de acceso -->
        <div class="d-flex align-items-center">
          <a href="buscar.html">
            <img src="../Image/lupa.png" alt="Buscar" width="50" class="me-3">
          </a>
          <a href="comprar.html">
            <img src="../Image/carrito-de-compras (1).png" alt="Carrito" width="50" class="me-3">
          </a>
          <a href="Login.html">
            <img src="../Image/avatar.png" alt="Avatar" width="50" class="me-3">
          </a>
        </div>
      </div>
    </div>
  </nav>

  <div class="hero-section text-center py-5">
    <div class="container">
      <h1 class="display-4">LA TIENDA DE JUANCHO & SOFI</h1>
      <p class="lead">Somos tu tienda ideal para encontrar lo último en tecnología y estilo...</p>
    </div>
  </div>


  <!-- Celulares Section -->
  <section class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">CELULARES</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card">
            <img src="samsung.jpg" class="card-img-top" alt="Samsung">
            <div class="card-body text-center">
              <h5 class="card-title">SAMSUNG</h5>
              <p class="card-text">Innovación y potencia con pantallas brillantes...</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <img src="iphone.jpg" class="card-img-top" alt="iPhone">
            <div class="card-body text-center">
              <h5 class="card-title">IPHONE</h5>
              <p class="card-text">Diseño premium, ecosistema fluido...</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <img src="motorola.jpg" class="card-img-top" alt="Motorola">
            <div class="card-body text-center">
              <h5 class="card-title">MOTOROLA</h5>
              <p class="card-text">Durabilidad, batería de larga duración...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Sección ROPA -->
  <section class="py-5 ropa-section">
    <div class="container">
      <h2 class="text-center mb-4">ROPA</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card text-center">
            <img src="polos.jpg" class="card-img-top" alt="Polos">
            <div class="card-body">
              <h5 class="card-title">POLOS</h5>
              <p class="card-text">Elegancia y comodidad en una prenda versátil...</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
            <img src="buzos.jpg" class="card-img-top" alt="Buzos">
            <div class="card-body">
              <h5 class="card-title">BUZOS</h5>
              <p class="card-text">Abrigo y estilo con diseños modernos...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer -->
  <footer class="bg-black text-white py-5">
    <div class="container">
      <div class="row">
        <!-- Menú Inferior -->
        <div class="col-md-4">
          <h5 class="text-uppercase fw-bold">Menú Inferior</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white text-decoration-none">Búsqueda</a></li>
            <li><a href="#" class="text-white text-decoration-none">Términos y condiciones</a></li>
            <li><a href="#" class="text-white text-decoration-none">Preguntas Frecuentes</a></li>
            <li><a href="#" class="text-white text-decoration-none">Nosotros</a></li>
          </ul>
        </div>

        <!-- Menú Principal -->
        <div class="col-md-4">
          <h5 class="text-uppercase fw-bold">Menú Principal</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white text-decoration-none">Inicio</a></li>
            <li><a href="#" class="text-white text-decoration-none">Productos</a></li>
            <li><a href="#" class="text-white text-decoration-none">Servicio Técnico</a></li>
            <li><a href="#" class="text-white text-decoration-none">Colecciones</a></li>
            <li><a href="#" class="text-white text-decoration-none">Quiénes somos</a></li>
            <li><a href="#" class="text-white text-decoration-none">Nuestra Feria</a></li>
            <li><a href="#" class="text-white text-decoration-none">¿Qué te puedes comprar con $?</a></li>
          </ul>
        </div>

        <!-- Regístrate y Ahorra -->
        <div class="col-md-4">
          <h5 class="text-uppercase fw-bold">Regístrate y Ahorra</h5>
          <p>Suscríbete para recibir ofertas especiales, obsequios gratuitos y ofertas únicas.</p>
          <form>
            <div class="input-group">
              <input type="email" class="form-control" placeholder="Suscríbete a nuestra lista de correo"
                aria-label="Correo electrónico">
              <button class="btn btn-outline-light" type="submit">Enviar</button>
            </div>
          </form>
          <div class="mt-3">
            <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-youtube"></i></a>
            <a href="#" class="text-white"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>
      </div>
      <div class="text-center mt-4">
        <p class="mb-0">Tecnología de JUANCHO</p>
      </div>
    </div>
  </footer>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Habilitar submenús en dispositivos táctiles
      const dropdownSubmenus = document.querySelectorAll('.dropdown-submenu');

      dropdownSubmenus.forEach(function (submenu) {
        submenu.addEventListener('click', function (e) {
          e.stopPropagation();
          const submenuDropdown = this.querySelector('.dropdown-menu');
          if (submenuDropdown) {
            submenuDropdown.classList.toggle('show');
          }
        });
      });
    });

  </script>
</body>

</html>