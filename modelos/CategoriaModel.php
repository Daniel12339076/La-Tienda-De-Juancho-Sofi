<?php

function registrar($conn, $data) {
    $sql = "INSERT INTO categorias VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sss", $data['nombre'], $data['descripcion'], "hgjhkjk");

    try {
        if ($stmt->execute()) {
            $_SESSION['nombre'] = $data['nombre'];
            $_SESSION['descripcion'] = $data['descripcion'];

            
            echo "
                <script src='../SweetAlert2/sweetalert2.all.min.js'></script>
                <script src='../VISUAL/alertas/funcionesalert.js'></script>
                <body>
                        <script>
                            informar('CATEGORÍA REGISTRADA EXITÓSAMENTE.','Ok.', '../VISUAL/admin/categorias.php', 'success');
                        </script>
                </body>";
                exit();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
                echo "
                <script src='../SweetAlert2/sweetalert2.all.min.js'></script>
                <script src='../VISUAL/alertas/funcionesalert.js'></script>
                <body>
                        <script>
                            informar('El nombre de la categoría ya está registrado.','Reintentar.', '../VISUAL/admin/categorias.php', 'error');
                        </script>
                </body>";
                exit();
        } else {
            die("Error al registrar categoría: " . $e->getMessage());
        }
    }

    $stmt->close();
}

function obtenerCategorias($conn) {
    $result = mysqli_query($conn, "SELECT * FROM categorias");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function eliminar($conn, $id) {
    mysqli_query($conn, "DELETE FROM categorias WHERE id=$id");
    header("Location: ../VISUAL/admin/categorias.php");
}

function actualizar($conn, $data) {
    $sql = "UPDATE categorias SET 
        nombre = '{$data['nombre']}',
        descripcion = '{$data['descripcion']}'
        WHERE id = {$data['id']}";

    mysqli_query($conn, $sql);
    header("Location: ../VISUAL/admin/categorias.php");
}
?>
