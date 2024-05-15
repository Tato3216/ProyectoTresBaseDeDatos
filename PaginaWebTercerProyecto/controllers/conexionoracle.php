<?php

class ConexionOracle {
    protected $conn;

    public function __construct() {
        $usuario = 'tercer_proyecto';
        $contrasena = 'A5000shg';
        $servidor = 'localhost';
        $puerto = '1521';
        $servicio = 'admin';

        $this->conn = oci_connect($usuario, $contrasena, "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = $servidor)(PORT = $puerto)))(CONNECT_DATA=(SID=$servicio)))");

        if (!$this->conn) {
            $m = oci_error();
            echo $m['message'], "\n";
            exit;
        } else {
            error_log("Conexión exitosa a Oracle desde la clase ConexionOracle");
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
