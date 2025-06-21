<?php
session_start();
?>
<html lang="es">

<head>
	<title>Ingresar</title>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
	<link rel="icon" href="../Image/Logo juancho.png">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
	<script src="../js/jquery-3.4.1.js"></script>
	<style>
		body {
			font-family: 'Poppins', serif;
			background-color: rgb(0, 0, 0);
			color: black;
			margin: 0;
			padding: 0;
		}

		.container {
			padding: 20px;
			border: 5px solid;
			border-image: linear-gradient(to right, #ffff00, #ff69b4) 1;
			border-radius: 10px;
			margin: 20px auto;
			max-width: 800px;
		}

		.cover {
			background-color: black;
			background-size: cover;
			background-position: center;
			height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 30px;
			flex-direction: column;
		}

		.logInForm {
			background-color: rgb(0, 0, 0);
			color: white;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0px 4px 15px rgba(255, 255, 255, 0.2);
			width: 100%;
			max-width: 400px;
			text-align: center;
			margin: 0 auto;
			margin-top: 150px;
			border: 5px solid;
			border-image: linear-gradient(to right, #ffff00, #ff69b4) 1;
		}

		.dashboard-Navbar {
			background-color: rgb(0, 0, 0);
			color: black;
			padding: 10px 20px;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
			z-index: 1000;
			display: flex;
			justify-content: center;
			align-items: center;
			border-bottom: 5px solid transparent;
			border-image: linear-gradient(to right, #ffff00, #ff69b4) 1;
			border-image-slice: 1;
		}

		.dashboard-sideBar-title {
			text-align: center;
		}

		.dashboard-sideBar-title img {
			border-radius: 50%;
			width: 150px;
			height: 150px;
			display: block;
			margin: 0 auto;
			animation: bounce 2s infinite;
			margin-top: 15px;
		}

		.dashboard-sideBar-title h1 {
			font-size: 30px;
			color: white;
			margin-top: 10px;
			font-weight: bold;
			letter-spacing: 2px;
			text-transform: uppercase;
			text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
		}

		@keyframes bounce {
			0%, 100% {
				transform: translateY(0);
			}
			50% {
				transform: translateY(-10px);
			}
		}

		.form-group {
			margin-bottom: 20px;
			text-align: center;
		}

		.form-control {
			width: 100%;
			max-width: 300px;
			padding: 10px;
			border: 1px solid #ddd;
			border-radius: 5px;
			box-sizing: border-box;
			font-size: 16px;
			text-align: center;
		}

		.control-label {
			font-weight: bold;
			margin-bottom: 5px;
			display: block;
		}

		.btncolor {
			background-color: #ffff00;
			color: black;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			width: 100%;
			font-size: 16px;
			transition: background-color 0.3s;
		}

		.dashboard-Navbar h1,
		.logInForm,
		.form-control,
		.btncolor {
			font-family: 'Poppins', sans-serif;
		}

		.btncolor:hover {
			background-color: #ff69b4;
			color: white;
		}

		.logInForm {
			margin-top: 150px;
		}
        
        /* Estilos para mensajes */
        .mensaje {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .mensaje-success {
            background-color: rgba(40, 167, 69, 0.7);
            border: 1px solid #28a745;
            color: white;
        }
        
        .mensaje-error {
            background-color: rgba(220, 53, 69, 0.7);
            border: 1px solid #dc3545;
            color: white;
        }
        
        .registro-link {
            margin-top: 15px;
            display: block;
            color: #ffff00;
            text-decoration: none;
        }
        
        .registro-link:hover {
            color: #ff69b4;
            text-decoration: underline;
        }
	</style>
</head>

<body class="cover">
	<section class="ashboard-contentPage">
		<nav class="full-box dashboard-Navbar">
			<div class="full-box text-center text-titles dashboard-sideBar-title">
				<img src="../Image/Logo juancho.png" alt="Logo">
				<h1>LA TIENDA DE JUANCHO & SOFI</h1>
			</div>
		</nav>
	</section>
	<br>
	<br>
	<br>
	<br>
	<form method="POST" action="../../controladores/UsuarioController.php?accion=ingresar" class="logInForm" id="formulario">
		<p class="text-center text-muted"><i class="fa fa-user-circle fa-5x"></i></p>
		<p class="text-center  text-uppercase" style="color: white;">Inicia sesión con tu cuenta</p>
		<div class="form-group">
			<label class="control-label" for="UserEmail">Usuario</label>
			<input class="form-control" id="UserEmail" name="correo" type="text" placeholder="Correo electrónico" required>
		</div>
		<div class="form-group">
			<label class="control-label" for="UserPass">Contraseña</label>
			<input class="form-control" id="UserPass" name="clave" type="password" placeholder="Contraseña" required>
		</div>
		<div>
			<input type="submit" value="Iniciar sesión" class="btncolor" id="btn_iniciar">
		</div>
        <a href="Registrar.php" class="registro-link">¿No tienes cuenta? Regístrate aquí</a>
	</form>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>