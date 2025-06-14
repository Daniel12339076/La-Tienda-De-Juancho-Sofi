<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Ventas - Panel de Administración</title>
    <link rel="icon" href="../Image/Logo juancho.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            min-height: 100vh;
            display: flex;
            font-family: sans-serif;
            background-color: #f8f9fa;
        }

       

        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .content-header {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .content-header h2 {
            color: #000;
            margin: 0;
        }

        .sales-management-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .sales-form-section {
            width: 100%;
            max-width: 350px;
            flex-shrink: 0;
        }

        .sales-form-section h2 {
            color: #000;
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group input[type="number"] {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-agregar {
            background-color: #ff69b4;; 
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn-agregar:hover {
            background-color: #e6549f;
        }

        .sales-table-section {
            flex-grow: 1;
            width: auto;
            overflow-x: auto;
        }

        .sales-table-section h2 {
            color: #000;
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        .sales-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #ddd;
        }

        .sales-table th, .sales-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .sales-table th {
            background-color: #000;
            color: white;
        }

        .sales-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-opciones {
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            color: white;
        }

        .btn-eliminar {
            background-color: #dc3545; /* Rojo para eliminar */
        }

        .btn-opciones i {
            color: inherit;
        }

        .total-venta {
            margin-top: 15px;
            text-align: right;
            font-weight: bold;
            font-size: 1.2em;
        }

        .btn-realizar-venta {
            background-color: #fbff00; /* Azul para realizar venta */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .btn-realizar-venta:hover {
            background-color: #dbd807de;
        }

        /* Media query para pantallas más pequeñas */
        @media (max-width: 768px) {
            .sales-management-container {
                flex-direction: column;
            }
            .sales-form-section,
            .sales-table-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php 
        include 'sidebar.php';
        include  'header.php'; 
    ?>

    <div class="content-wrapper">
        <div class="content-header">
            <h2><i class="fas fa-box"></i> Gestión de Ventas</h2>
        </div>
        <div class="sales-management-container">
            <div class="sales-form-section">
                <h2><i class="fas fa-plus-circle"></i> Agregar Producto</h2>
                <form id="agregar-producto-form">
                    <div class="form-group">
                        <label for="buscar-producto">Buscar Producto</label>
                        <input type="text" id="buscar-producto" placeholder="Escriba para buscar producto">
                        <small class="form-text text-muted">Puedes buscar por nombre o código.</small>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" placeholder="Precio" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" id="cantidad" placeholder="Cantidad" value="1" min="1">
                    </div>
                    <div class="form-group">
                        <label for="subtotal">Subtotal</label>
                        <input type="text" id="subtotal" placeholder="Subtotal" readonly>
                    </div>
                    <button type="button" class="btn-agregar"><i class="fas fa-plus"></i> AGREGAR</button>
                </form>
            </div>
            <div class="sales-table-section">
                <table class="sales-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="productos-venta-body">
                        </tbody>
                </table>
                <div class="total-venta">
                    Valor Total: <span id="valor-total">0.00</span>
                </div>
                <button class="btn-realizar-venta"><i class="fas fa-check-circle"></i> REALIZAR VENTA</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>