<?php
session_start();
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
}

include '../../config/conexion.php';
include '../../modelos/VentasModel.php';

$productos = obtenerProductos($conn);
$venta = $_SESSION['venta'] ?? [];

$alerta = '';
if (isset($_GET['mensaje'])) {
    switch ($_GET['mensaje']) {
        case 'ok':
            $alerta = '<div id="alerta" class="alert alert-success">Venta realizada correctamente.</div>';
            break;
        case 'error':
            $alerta = '<div id="alerta" class="alert alert-danger">Error al realizar la venta.</div>';
            break;
        case 'vacía':
            $alerta = '<div id="alerta" class="alert alert-warning">No hay productos agregados a la venta.</div>';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Ventas</title>
    <link rel="icon" href="../Image/Logo juancho.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            font-family: sans-serif;
            background-color: #f8f9fa;
        }
        .content-wrapper { flex-grow: 1; padding: 20px; display: flex; flex-direction: column; }
        .content-header { background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; }
        .sales-management-container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); display: flex; gap: 20px; flex-wrap: wrap; }
        .sales-form-section { width: 100%; max-width: 350px; }
        .sales-table-section { flex-grow: 1; overflow-x: auto; }
        .form-group { margin-bottom: 15px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-agregar { background-color: #ff69b4; color: white; width: 100%; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-agregar:hover { background-color: #e6549f; }
        .sales-table { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #ddd; }
        .sales-table th, .sales-table td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .sales-table th { background-color: #000; color: white; }
        .btn-eliminar { background-color: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; }
        .total-venta { margin-top: 15px; text-align: right; font-weight: bold; font-size: 1.2em; }
        .btn-realizar-venta { background-color: #fbff00; color: black; padding: 10px; border: none; border-radius: 4px; margin-top: 20px; cursor: pointer; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; include 'header.php'; ?>

<div class="content-wrapper">
    <?php if (!empty($alerta)) echo $alerta; ?>
    
    <div class="content-header">
        <h2><i class="fas fa-box"></i> Gestión de Ventas</h2>
    </div>
    <div class="sales-management-container">
        <div class="sales-form-section">
            <h2><i class="fas fa-plus-circle"></i> Agregar Producto</h2>
            <form action="../../controladores/VentasController.php?accion=agregar" method="POST">
                <div class="form-group">
                    <label for="buscar-producto">Buscar Producto</label>
                    <select name="id_producto" id="buscar-producto" required>
                        <option value="">Seleccione un producto</option>
                        <?php foreach ($productos as $producto): ?>
                            <option 
                                value="<?= $producto['id'] ?>" 
                                data-precio="<?= $producto['precio_unitario'] ?>" 
                                data-nombre="<?= htmlspecialchars($producto['nombre']) ?>">
                                <?= htmlspecialchars($producto['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="hidden" name="nombre" id="nombre_hidden">
                <input type="hidden" name="precio" id="precio_hidden">
                <input type="hidden" name="cantidad" id="cantidad_hidden">
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="text" id="precio" readonly>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" value="1" min="1">
                </div>
                <div class="form-group">
                    <label for="subtotal">Subtotal</label>
                    <input type="text" id="subtotal" readonly>
                </div>
                <button type="submit" class="btn-agregar"><i class="fas fa-plus"></i> AGREGAR</button>
            </form>
        </div>

        <div class="sales-table-section">
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($venta as $index => $producto): 
                        $subtotal = $producto['precio'] * $producto['cantidad'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td>$<?= number_format($producto['precio'], 2) ?></td>
                            <td><?= $producto['cantidad'] ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td>
                                <form method="POST" action="../../controladores/VentasController.php?accion=eliminar">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" class="btn-eliminar"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($venta)): ?>
                        <tr><td colspan="5">No hay productos agregados a la venta.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="total-venta">
                Valor Total: $<span id="valor-total"><?= number_format($total, 2) ?></span>
            </div>
            <form action="../../controladores/VentasController.php?accion=realizar" method="POST">
                <button class="btn-realizar-venta"><i class="fas fa-check-circle"></i> REALIZAR VENTA</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectProducto = document.getElementById('buscar-producto');
        const precioInput = document.getElementById('precio');
        const cantidadInput = document.getElementById('cantidad');
        const subtotalInput = document.getElementById('subtotal');
        const nombreHidden = document.getElementById('nombre_hidden');
        const precioHidden = document.getElementById('precio_hidden');
        const cantidadHidden = document.getElementById('cantidad_hidden');

        function actualizarCampos() {
            const option = selectProducto.options[selectProducto.selectedIndex];
            const precio = parseFloat(option.getAttribute('data-precio')) || 0;
            const nombre = option.getAttribute('data-nombre') || '';
            const cantidad = parseInt(cantidadInput.value) || 1;
            const subtotal = (precio * cantidad).toFixed(2);

            precioInput.value = precio.toFixed(2);
            subtotalInput.value = subtotal;

            nombreHidden.value = nombre;
            precioHidden.value = precio;
            cantidadHidden.value = cantidad;
        }

        selectProducto.addEventListener('change', actualizarCampos);
        cantidadInput.addEventListener('input', actualizarCampos);
    });

    //desaparecer alerta
    setTimeout(function() {
        const alerta = document.getElementById('alerta');
        if (alerta) {
            alerta.style.transition = 'opacity 0.5s ease';
            alerta.style.opacity = '0';
            setTimeout(() => alerta.remove(), 500); // Luego de desvanecerla, la elimina del DOM
        }
    }, 5000); // 5000 ms = 5 segundos

    
</script>

</body>
</html>
