<?php

require_once 'conexionoracle.php';

class Auth {
    protected $conn;

    public function __construct() {
        $db = new ConexionOracle();
        $this->conn = $db->getConnection();
    }

    public function authenticate($usuario, $contrasena) {
        $stmt = oci_parse($this->conn, 'SELECT * FROM usuario WHERE nombre = :usuario AND password = :contrasena');
        oci_bind_by_name($stmt, ':usuario', $usuario);
        oci_bind_by_name($stmt, ':contrasena', $contrasena);
        oci_execute($stmt);
        
        $row = oci_fetch_assoc($stmt);
        if ($row) {
            return true; // Usuario autenticado
        } else {
            return false; // Usuario no autenticado
        }
    }
}
?>
