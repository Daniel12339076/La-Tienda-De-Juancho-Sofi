<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reportes de Ventas - Panel de Administración</title>
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

        .sales-reports-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .filters-section {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filters-section .form-group {
            margin-bottom: 0;
        }

        .filters-section label {
            margin-right: 5px;
            color: #333;
            font-size: 0.9em;
        }

        .filters-section input[type="date"],
        .filters-section select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .export-button-container {
            display: flex;
            justify-content: flex-end;
        }

        .btn-exportar {
            background-color: #fbff00; 
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-exportar:hover {
            background-color: #dbd807de;
        }

        .sales-table-container {
            overflow-x: auto;
        }

        .sales-report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #ddd;
        }

        .sales-report-table th, .sales-report-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .sales-report-table th {
            background-color: #ff69b4; /* Rosado para la cabecera */
            color: white;
        }

        .sales-report-table tbody tr:nth-child(even) {
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

        .btn-detalles {
            background-color: #007bff; /* Azul para detalles */
        }

        .btn-opciones i {
            color: inherit;
        }

        /* Estilos responsivos para la tabla */
        @media (max-width: 768px) {
            .filters-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .sales-report-table thead {
                display: none;
            }

            .sales-report-table tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 10px;
            }

            .sales-report-table tbody tr td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px dotted #ddd;
            }

            .sales-report-table tbody tr td:last-child {
                border-bottom: none;
            }

            .sales-report-table tbody tr td::before {
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                text-align: left;
                font-weight: bold;
                content: attr(data-label);
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
            <h2><i class="fas fa-chart-line"></i> Reportes de Ventas</h2>
        </div>
        <div class="sales-reports-container">
            <div class="filters-section">
                <div class="form-group">
                    <label for="fecha-filtro">Fecha:</label>
                    <input type="date" id="fecha-filtro" value="2025-05-02">
                </div>
                <div class="form-group">
                    <label for="tipo-venta-filtro">Tipo de Venta:</label>
                    <select id="tipo-venta-filtro">
                        <option value="">Todas las Ventas</option>
                        <option value="online">Online</option>
                        <option value="fisica">Física</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="vendedor-filtro">Vendedor:</label>
                    <select id="vendedor-filtro">
                        <option value="">Todos los Vendedores</option>
                        <option value="vendedor1">Vendedor 1</option>
                        <option value="vendedor2">Vendedor 2</option>
                        </select>
                </div>
            </div>
            <div class="export-button-container">
                <button class="btn-exportar"><i class="fas fa-file-excel"></i> Exportar</button>
            </div>
            <div class="sales-table-container">
                <table class="sales-report-table">
                    <thead>
                        <tr>
                            <th>Número Orden</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Tipo de Venta</th>
                            <th>Vendedor</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Número Orden">VNT-2025-001</td>
                            <td data-label="Fecha">2025-05-02</td>
                            <td data-label="Total">$150.00</td>
                            <td data-label="Tipo de Venta">Online</td>
                            <td data-label="Vendedor">Vendedor 1</td>
                            <td data-label="Detalles"><button class="btn-opciones btn-detalles"><i class="fas fa-info-circle"></i></button></td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>