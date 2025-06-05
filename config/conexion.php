<?php
class Conexion {
    private $host = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $base_datos = "tienda_juancho";

    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->usuario, $this->clave, $this->base_datos);
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8");
    }

    public function obtenerConexion() {
        return $this->conn;
    }
}


?>