<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Pedidos - Panel de Administración</title>
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

        .orders-management-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto; /* Para la responsividad horizontal en tablas grandes */
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #ddd;
        }

        .orders-table th, .orders-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .orders-table th {
            background-color: #ff69b4; /* Rosado para la cabecera */
            color: white;
        }

        .orders-table tbody tr:nth-child(even) {
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

        .btn-confirmar {
            background-color: #28a745; /* Verde para confirmar */
        }

        .btn-rechazar {
            background-color: #dc3545; /* Rojo para rechazar */
        }

        .btn-opciones i {
            color: inherit;
        }

        /* Estilos responsivos */
        @media (max-width: 600px) {
            .orders-table thead {
                display: none; /* Ocultar encabezados en pantallas pequeñas */
            }

            .orders-table tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 10px;
            }

            .orders-table tbody tr td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px dotted #ddd;
            }

            .orders-table tbody tr td:last-child {
                border-bottom: none;
            }

            .orders-table tbody tr td::before {
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                text-align: left;
                font-weight: bold;
                content: attr(data-label); /* Usar el atributo data-label para el encabezado */
            }
        }
    </style>
</head>
<body>
    
    <?php 
    include 'sidebar.php';
    include  'header.php';
    include '../../config/conexion.php';
    include '../../modelos/PedidoModel.php';
    $ordenes=obtenerpedido($conn);
    ?>

    <div class="content-wrapper">
        
        <div class="content-header">
            <h2><i class="fas fa-truck"></i> Gestión de Pedidos</h2>
            <input type="search" id="buscar" class="form-control form-control-sm" placeholder="Buscar Pedido...">
        </div>
        <div class="orders-management-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Número Orden</th>
                        <th>Id_Usuario</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Detalles</th>
                        <th>Confirmar</th>
                        <th>Rechazar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordenes as $orden ): ?>
                        <tr>
                            <td data.label="Id"><?= $orden['id'] ?></td>
                            <td data-label="Número Orden"><?= $orden['codigo'] ?></td>
                            <td data-label="id_usuario"><?= $orden['id_usuario'] ?></td>
                            <td data-label="Fecha"><?= $orden['fecha'] ?></td>
                            <td data-label="Total"><?= '$' . number_format($orden['total'], 0, ',', '.') ?></td>
                            <td data-label="Detalles"><?= $orden['detalles'] ?></td>
                            <td data-label="Confirmar"><button class="btn-opciones btn-confirmar"><i class="fas fa-check"></i></button></td>
                            <td data-label="Rechazar"><button class="btn-opciones btn-rechazar"><i class="fas fa-times"></i></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //buscar
         document.getElementById("buscar").addEventListener("keyup", function () {
        const filtro = this.value.toLowerCase();
        const filas = document.querySelectorAll(".orders-table tbody tr");

        filas.forEach(fila => {
            const textoFila = fila.textContent.toLowerCase();
            fila.style.display = textoFila.includes(filtro) ? "" : "none";
        });
        });
    </script>
</body>
</html>