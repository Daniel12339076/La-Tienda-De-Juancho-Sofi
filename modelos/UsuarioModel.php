<?php
function login($conn, $data) {
    session_start();
    $correo=$data['correo'];
    $clave=$data['clave'];
    
    $stmt=$conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado=$stmt->get_result();

    if($resultado->num_rows===1){
        $row=$resultado->fetch_assoc();
        
        if(password_verify($clave, $row['clave'])){
            $_SESSION['id_cliente']=$row['id'];
            $_SESSION['usuario']=$row['usuario'];
            $_SESSION['correo']=$row['correo'];
            
            echo "
                <script src='../Assets/SweetAlert2/sweetalert2.all.min.js'></script>
                <script src='../js/funcionesalert.js'></script>
                <body>
                        <script>
                            informar('Bienvenido " . addslashes($_SESSION["usuario"]) . "','ACEPTAR', '../VISUAL/admin/login.php', 'success');
                        </script>
            </body>";

            // header("Location: ../js/SweetAlert2/PaginaPrincipal.php");
            exit();
        }else{
         echo "
                <script src='../Assets/SweetAlert2/sweetalert2.all.min.js'></script>
                <script src='../js/funcionesalert.js'></script>
                <body>
                        <script>
                            informar('CLAVE INCORRECTA','REINTENTAR', 'http://localhost/La-Tienda-De-Juancho-Sofi/VISUAL/Admin/Registrar.php', 'error');
                        </script>
            </body>";
        }
    }else{
        echo "
                <script src='../Assets/SweetAlert2/sweetalert2.all.min.js'></script>
                <script src='../js/funcionesalert.js'></script>
                <body>
                        <script>
                            informar('CLIENTE NO ENCONTRADO','REINTENTAR', 'http://localhost/La-Tienda-De-Juancho-Sofi/VISUAL/Admin/Registrar.php', 'warning');
                        </script>
            </body>";
        exit();
    }
}

function salir(){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../js/login.php");
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