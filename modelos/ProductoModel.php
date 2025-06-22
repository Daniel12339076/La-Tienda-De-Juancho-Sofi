<?php

function registrar($conn, $data) {
    $sql = "INSERT INTO productos (nombre, precio_unitario, cantidad, imagen, id_categoria, descripcion, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $imagen = $data['imagen'];
    $precio_unitario = $data['precio'];
    $cantidad = $data['cantidad'];
    $id_categoria = $data['categoria_id'];
    $estado = $data['estado'];
    $stmt->bind_param("sdissss", $nombre, $precio_unitario, $cantidad, $imagen, $id_categoria, $descripcion, $estado);

    if ($stmt->execute()) {
        $_SESSION['nombre'] = $nombre;

        echo "
        <script src='../libs/SweetAlert2/sweetalert2.all.min.js'></script>
        <script src='../VISUAL/alertas/funcionesalert.js'></script>
        <body>
                <script>
                    informar('PRODUCTO REGISTRADO EXITÓSAMENTE.','Ok.', '../VISUAL/admin/productos.php', 'success');
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

//obtener productos
function obtenerProductos($conn) {
    $result = mysqli_query($conn, "SELECT * FROM productos ORDER BY id DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//obtener productos con categorias
function obtenerProductosConCategorias($conn) {
    $sql = "SELECT p.*, c.nombre AS categoria_nombre 
            FROM productos p 
            JOIN categorias c ON p.id_categoria = c.id 
            ORDER BY p.id DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function eliminar($conn, $id) {
    mysqli_query($conn, "DELETE FROM productos WHERE id=$id");
    header("Location: ../VISUAL/admin/productos.php");
}

function actualizar($conn, $data) {
    $sql = "UPDATE productos SET 
        nombre = '{$data['nombre']}',
        descripcion = '{$data['descripcion']}',
        precio_unitario = {$data['precio']},
        cantidad = {$data['cantidad']},
        id_categoria = {$data['categoria_id']},
        estado = '{$data['estado']}',
        imagen = '{$data['imagen']}'
        WHERE id = {$data['id']}";

    mysqli_query($conn, $sql) or die("Error al actualizar la categoría: " . mysqli_error($conn));
    header("Location: ../VISUAL/Admin/productos.php");
}

function obtenerproductoPorID($conn, $id) {
    $result = mysqli_query($conn, "SELECT * FROM productos wHERE id = $id");
    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // O manejar el error de otra manera
    }
}
?>
