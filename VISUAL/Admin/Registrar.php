<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - La Tienda de Juancho & Sofi</title>
    <link rel="icon" href="../Image/Logo juancho.png">
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .logo {
            display: block;
            margin: 40px auto 10px auto;
            width: 150px;
        }
        .titulo {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .linea {
            height: 4px;
            background: linear-gradient(90deg, #ffe600, #ff00c8);
            border: none;
            margin-bottom: 40px;
        }
        .registro-box {
            background: #000;
            border: 3px solid;
            border-image: linear-gradient(90deg, #ffe600, #ff00c8) 1;
            box-shadow: 0 0 20px #ff00c8, 0 0 10px #ffe600;
            width: 350px;
            margin: 0 auto;
            padding: 40px 30px;
            border-radius: 8px;
            text-align: center;
        }
        .registro-box label {
            display: block;
            text-align: left;
            margin: 15px 0 5px 0;
            font-weight: bold;
        }
        .registro-box input,
        .registro-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: none;
            font-size: 1em;
            box-sizing: border-box;
        }
        .registro-box select {
            background: white;
            color: #000;
        }
        .registro-box button {
            width: 100%;
            padding: 12px;
            background: #ffe600;
            color: #000;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        .registro-box button:hover {
            background: #ffed33;
        }
        .registro-box a {
            color: #ffe600;
            text-decoration: underline;
            display: block;
            margin-top: 18px;
            font-size: 0.95em;
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

        /* Validación visual */
        .campo-error {
            border: 2px solid #dc3545 !important;
        }
        
        .campo-valido {
            border: 2px solid #28a745 !important;
        }
    </style>
</head>
<body>
    <img src="../Image/Logo juancho.png" alt="Logo La Tienda de Juancho & Sofi" class="logo">
    <div class="titulo">LA TIENDA DE JUANCHO & SOFI</div>
    <hr class="linea">
    <div class="registro-box">
        <div id="mensaje" class="mensaje" style="display: none;"></div>
        
    <!--quitar-->
        <?php if(isset($_SESSION['mensaje'])): ?>
            <div class="mensaje mensaje-<?php echo $_SESSION['tipo_mensaje']; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php 
            // Limpiar el mensaje después de mostrarlo
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        <?php endif; ?>
        
        <form id="formularioRegistro" method="POST" action="../../controladores/UsuarioController.php?accion=registrar">
            <div style="margin-bottom: 20px; font-size: 1.1em;">Crea tu cuenta</div>
            
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" placeholder="Nombre Usuario" required>

            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo" placeholder="Ej: nombre@dominio.com" required>

            <label for="celular">Número de celular</label>
            <input type="tel" id="celular" name="celular" placeholder="Ej: +57 300 123 4567" required>

            <label for="rol">Rol</label>
            <select id="rol" name="rol" required>
                <option value="">Selecciona un rol</option>
                <option value="cliente">Cliente</option>
                <option value="vendedor">Vendedor</option>
                <option value="administrador">Administrador</option>
            </select>

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="clave" required>

            <button type="submit">Registrarse</button>
        </form>
        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
    </div>

    <!--quitar-->
    <script>
        // Validación del formulario
        document.getElementById('formularioRegistro').addEventListener('submit', function(e) {
            // Prevenir el envío del formulario para validar primero
            e.preventDefault();
            
            const usuario = document.getElementById('usuario').value.trim();
            const correo = document.getElementById('correo').value.trim();
            const celular = document.getElementById('celular').value.trim();
            const rol = document.getElementById('rol').value;
            const contrasena = document.getElementById('contrasena').value;
            
            // Limpiar clases de validación previas
            const campos = document.querySelectorAll('input, select');
            campos.forEach(campo => {
                campo.classList.remove('campo-error', 'campo-valido');
            });
            
            let errores = [];
            
            // Validar usuario
            if (usuario.length < 3) {
                errores.push('El usuario debe tener al menos 3 caracteres');
                document.getElementById('usuario').classList.add('campo-error');
            } else {
                document.getElementById('usuario').classList.add('campo-valido');
            }
            
            // Validar correo
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(correo)) {
                errores.push('El correo electrónico no es válido');
                document.getElementById('correo').classList.add('campo-error');
            } else {
                document.getElementById('correo').classList.add('campo-valido');
            }
            
            // Validar celular
            const celularRegex = /^[\+]?[0-9\s\-]{10,15}$/;
            if (!celularRegex.test(celular)) {
                errores.push('El número de celular no es válido');
                document.getElementById('celular').classList.add('campo-error');
            } else {
                document.getElementById('celular').classList.add('campo-valido');
            }
            
            // Validar rol
            if (!rol) {
                errores.push('Debes seleccionar un rol');
                document.getElementById('rol').classList.add('campo-error');
            } else {
                document.getElementById('rol').classList.add('campo-valido');
            }
            
            // Validar contraseña
            if (contrasena.length < 6) {
                errores.push('La contraseña debe tener al menos 6 caracteres');
                document.getElementById('contrasena').classList.add('campo-error');
            } else {
                document.getElementById('contrasena').classList.add('campo-valido');
            }
            
            // Mostrar errores o enviar formulario
            const mensajeDiv = document.getElementById('mensaje');
            if (errores.length > 0) {
                mensajeDiv.className = 'mensaje mensaje-error';
                mensajeDiv.innerHTML = errores.join('<br>');
                mensajeDiv.style.display = 'block';
            } else {
                // Si todo está bien, enviar el formulario
                this.submit();
            }
        });
        
        // Formatear número de celular mientras se escribe
        document.getElementById('celular').addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');
            if (valor.length > 0) {
                if (valor.startsWith('57')) {
                    valor = '+' + valor;
                } else if (!valor.startsWith('+')) {
                    valor = '+57' + valor;
                }
            }
            e.target.value = valor;
        });
        
        // Validación en tiempo real
        const campos = document.querySelectorAll('input, select');
        campos.forEach(campo => {
            campo.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('campo-error');
                    this.classList.add('campo-valido');
                }
            });
        });
    </script>
</body>
</html>