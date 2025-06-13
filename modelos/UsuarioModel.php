<?php
function login($conn, $data) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Validar claves en $data
    $correo = $data['correo'] ?? null;
    $clave = $data['clave'] ?? null;

    if (!$correo || !$clave) {
        echo alertMessage('DATOS INSUFICIENTES', 'REINTENTAR', '../VISUAL/Admin/login.php', 'warning');
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();

        if (password_verify($clave, $row['clave'])) {
            $_SESSION['id_cliente'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['correo'] = $row['correo'];
            $_SESSION['autenticado'] = true;
            $_SESSION['rol'] = $row['rol']; // Guardar el rol del usuario


            // Redirigir según el rol del usuario
            if ($row['rol'] === 'cliente') {
                //poner la ruta del cliente
                echo alertMessage("Bienvenido(a): " . addslashes($_SESSION["nombre"]), "SIGUIENTE", "../VISUAL/Clientes/Pagprincipal.php", "success");
                exit();
                
            } else{
                echo alertMessage("Bienvenido(a): " . addslashes($_SESSION["nombre"]), "SIGUIENTE", "../VISUAL/admin/inicio.php", "success");
                exit();
            }   

        } else {
            echo alertMessage("CLAVE INCORRECTA", "REINTENTAR", "../VISUAL/Admin/login.php", "error");
            exit();
        }
    } else {
        echo alertMessage("CLIENTE NO ENCONTRADO", "REINTENTAR", "../VISUAL/Admin/login.php", "warning");
        exit();
    }
}

function alertMessage($titulo, $boton, $redireccion, $icono) {
    return "
        <script src='../Assets/SweetAlert2/sweetalert2.all.min.js'></script>
        <script src='../js/funcionesalert.js'></script>
        <body>
            <script>
                informar('" . addslashes($titulo) . "', '" . addslashes($boton) . "', '" . $redireccion . "', '" . $icono . "');
            </script>
        </body>
    ";
}


function salir(){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../VISUAL/admin/login.php");
    exit();
}


function registrar($conn, $data) {
    date_default_timezone_set('America/Bogota');
    $fecha_registro = date('Y-m-d H:i:s');
    $clave_cifrada = password_hash($data['clave'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios 
    VALUES (NULL, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param(
        "ssiss", 
        $data['usuario'], 
        $data['correo'], 
        $data['celular'], 
         
        $clave_cifrada, 
        $data['rol']
    );

    try {
    if ($stmt->execute()) {
        // Registro exitoso, guardamos en sesión
        $_SESSION['usuario'] = $data['usuario'];
        $_SESSION['correo'] = $data['correo'];
        $_SESSION['celular'] = $data['celular'];
        $_SESSION['rol'] = $data['rol'];
        
        echo "
        <script src='../Assets/SweetAlert2/sweetalert2.all.min.js'></script>
        <script src='../js/funcionesalert.js'></script>
        <body>
                <script>
                    informar('CLIENTE REGISTRADO EXITÓSAMENTE.','Ok.', '../VISUAL/admin/login.php', 'success');
                </script>
        </body>";
        
        exit();
    }
    } catch (mysqli_sql_exception $e) {
        // Verificamos si es error por duplicado
        if ($e->getCode() === 1062) {
            // die("Error: Ya existe un registro con este número de documento o correo electrónico.");
            
            echo "
                <script src='../Assets/SweetAlert2/sweetalert2.all.min.js'></script>
                <script src='../js/funcionesalert.js'></script>
                <body>
                        <script>
                            informar('El Correo o el Número de Documento ya está registrado. Por favor, verifica los datos ingresados.','REINTENTAR.', '../VISUAL/admin/login.php', 'error');
                        </script>
                </body>";
        } else {
            die("Error al registrar cliente: " . $e->getMessage());
        }
        }


    $stmt->close();
}


function obtenerusuarios($conn) {
    $result = mysqli_query($conn, "SELECT * FROM usuarios");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function eliminar($conn, $id) {
   
    mysqli_query($conn, "DELETE FROM usuarios WHERE id=$id");
    header("Location: ../VISUAL/admin/login.php");
}

function actualizar($conn, $data) {
    $sql = "UPDATE usuarios SET 
        usuario = '{$data['usuario']}',
        tipo_documento = '{$data['tipo_documento']}',
        numero_documento = '{$data['numero_documento']}',
        fecha_nacimiento = '{$data['fecha_nacimiento']}',
        correo = '{$data['correo']}',
        celular = '{$data['celular']}',
        rol = '{$data['rol']}'
        WHERE id = {$data['id']}";

    mysqli_query($conn, $sql);
    header("Location: ../VISUAL/admin/login.php");
}


?>