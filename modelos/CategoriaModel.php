<?php

function registrar($conn, $data) {
    $sql = "INSERT INTO categorias (nombre, descripcion, imagen) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $imagen = $data['imagen'];

    $stmt->bind_param("sss", $nombre, $descripcion, $imagen);

    if ($stmt->execute()) {
        $_SESSION['nombre'] = $nombre;

        echo "
        <script src='../libs/SweetAlert2/sweetalert2.all.min.js'></script>
        <script src='../VISUAL/alertas/funcionesalert.js'></script>
        <body>
                <script>
                    informar('CATEGORÍA REGISTRADA EXITÓSAMENTE.','Ok.', '../VISUAL/admin/categorias.php', 'success');
                </script>
        </body>";
        exit();
    } else {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }
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
        descripcion = '{$data['descripcion']}',
        imagen = '{$data['imagen']}'
        WHERE id = {$data['id']}";

    mysqli_query($conn, $sql) or die("Error al actualizar la categoría: " . mysqli_error($conn));
    header("Location: ../VISUAL/Admin/categorias.php");
}
?>
