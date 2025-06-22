<?php
//obtener productos
function obtenerProductos($conn) {
    $result = mysqli_query($conn, "SELECT * FROM productos ORDER BY id DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Agrega un producto a la venta
function agregarAVenta($data) {
    session_start();
    $id = $data['id_producto'];
    $nombre = $data['nombre'];
    $precio = $data['precio'];
    $cantidad = $data['cantidad'];

    $item = [
        'id' => $id,
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    ];

    if (!isset($_SESSION['venta'])) {
        $_SESSION['venta'] = [];
    }

    $existe = false;
    foreach ($_SESSION['venta'] as &$producto) {
        if ($producto['id'] == $id) {
            $producto['cantidad'] += $cantidad;
            $existe = true;
            break;
        }
    }

    if (!$existe) {
        $_SESSION['venta'][] = $item;
    }

    header("Location: ../VISUAL/Admin/ventas.php");
    exit();
}

// Actualiza la cantidad de un producto en la venta
function actualizarVenta($data) {
    session_start();
    $index = $data['index'];
    $cantidad = $data['cantidad'];

    if (isset($_SESSION['venta'][$index])) {
        $_SESSION['venta'][$index]['cantidad'] = $cantidad;
    }

    header("Location: ../VISUAL/Admin/ventas.php");
    exit();
}

// Elimina un producto de la venta
function eliminarDeVenta($index) {
    session_start();
    if (isset($_SESSION['venta'][$index])) {
        unset($_SESSION['venta'][$index]);
        $_SESSION['venta'] = array_values($_SESSION['venta']); // reindexar
    }

    header("Location: ../VISUAL/Admin/ventas.php");
    exit();
}

// (Opcional) Obtener los productos actuales en la venta
function obtenerVenta() {
    session_start();
    return $_SESSION['venta'] ?? [];
}

//finalizar venta
function finalizarVenta($conn, $venta) {
    if (empty($venta)) return false;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $id_usuario = $_SESSION['id_cliente'] ?? null;
    if (!$id_usuario) return false;

    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d H:i:s');

    // 🔐 Generar código único
    do {
        $codigo = 'ORD-' . generarCodigoUnico(8);
        $check = $conn->prepare("SELECT id FROM ordenes WHERE codigo = ?");
        $check->bind_param("s", $codigo);
        $check->execute();
        $res = $check->get_result();
    } while ($res->num_rows > 0);

    // 💰 Calcular total y armar detalles con precio
    $total = 0;
    $detalles = '';
    foreach ($venta as $item) {
        $subtotal = $item['precio'] * $item['cantidad'];
        $total += $subtotal;
        $detalles .= $item['cantidad'] . 'x ' . $item['nombre'] . ' ($' . number_format($subtotal, 0, ',', '.') . '), ';
    }
    $detalles = rtrim($detalles, ', ');

    // 📝 Insertar orden
    $stmtOrden = $conn->prepare("INSERT INTO ordenes (fecha, total, codigo, id_usuario, detalles) VALUES (?, ?, ?, ?, ?)");
    $stmtOrden->bind_param("sdsis", $fecha, $total, $codigo, $id_usuario, $detalles);

    if ($stmtOrden->execute()) {
        
        return true;
    }

    return false;
}


function generarCodigoUnico($longitud = 8) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}

?>