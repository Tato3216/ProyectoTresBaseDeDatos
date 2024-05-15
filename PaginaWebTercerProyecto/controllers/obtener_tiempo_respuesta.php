<?php

require_once 'conexionoracle.php';

class ObtenerTiempoRespuesta {
    protected $conn;

    public function __construct() {
        $db = new ConexionOracle();
        $this->conn = $db->getConnection();
    }

    public function obtenerTiempoRespuesta($id_incidencia) {
        $query = "SELECT CREACION, HORA_INICIO, HORA_FIN FROM REGISTRO_INCIDENCIAS WHERE ID_REGISTRO_INCIDENCIAS = :id_incidencia";
        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':id_incidencia', $id_incidencia);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
    
        $hora_creacion = strtotime($row['CREACION']);
        $hora_inicio = strtotime($row['HORA_INICIO']);
        $hora_fin = isset($row['HORA_FIN']) ? strtotime($row['HORA_FIN']) : null;
    
        if ($hora_fin !== null) {
            $diferencia_tiempo = $hora_fin - $hora_inicio;
        } else {
            return null;
        }
    
        $horas = floor($diferencia_tiempo / 3600);
        $minutos = floor(($diferencia_tiempo % 3600) / 60);
        $segundos = $diferencia_tiempo % 60;
    
        $tiempo_respuesta = sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
    
        return $tiempo_respuesta;
    }
    
}

?>
