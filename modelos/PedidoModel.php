<?php
    //obtener pedido
    function obtenerpedido($conn) {
    $result = mysqli_query($conn, "SELECT * FROM ordenes ORDER BY id DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

?>