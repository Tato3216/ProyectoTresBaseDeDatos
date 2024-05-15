<?php

require_once 'conexionoracle.php';

class Login {
    protected $conn;

    public function __construct() {
        $db = new ConexionOracle();
        $this->conn = $db->getConnection();
    }

    public function authenticate($username, $password) {
        $query = "SELECT COUNT(*) AS count FROM usuario WHERE nombre = :username AND password = :password";

        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':username', $username);
        oci_bind_by_name($stmt, ':password', $password);
        oci_execute($stmt);
        
        $row = oci_fetch_assoc($stmt);
        $count = $row['COUNT'];

        return $count > 0;
    }

    public function getPermittedWindows($username) {
        $query = "SELECT V.PATH, V.NOMBRE 
                  FROM VENTANAS V
                  INNER JOIN ACCESO_ROL AR ON AR.ID_VENTANA = V.ID_VENTANA
                  INNER JOIN ROLES R ON R.ID_ROL = AR.ID_ROL
                  INNER JOIN USUARIO_ROL UR ON UR.ID_ROL = R.ID_ROL
                  INNER JOIN USUARIO U ON U.ID_USUARIO = UR.ID_USUARIO
                  WHERE U.nombre = :username";
    
        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':username', $username);
        oci_execute($stmt);
    
        $windows = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $windows[] = array(
                'path' => $row['PATH'],
                'nombre' => $row['NOMBRE']
            );
        }
    
        return $windows;
    }
    
}

?>
