<?php

require_once 'conexionoracle.php';

class RegistroIncidencias {
    protected $conn;

    public function __construct() {
        $db = new ConexionOracle();
        $this->conn = $db->getConnection();
    }

    public function asignarIncidencia($id_incidencia, $id_agente) {

        $tiempo_respuesta = $this->calcularTiempoRespuesta($id_incidencia);
        
        $query = "UPDATE registro_incidencias SET id_agente = :id_agente, tiempo_respuesta = :tiempo_respuesta WHERE id_incidencia = :id_incidencia";
        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':id_agente', $id_agente);
        oci_bind_by_name($stmt, ':tiempo_respuesta', $tiempo_respuesta);
        oci_bind_by_name($stmt, ':id_incidencia', $id_incidencia);
        oci_execute($stmt);
        
        return $tiempo_respuesta;
    }

    private function calcularTiempoRespuesta($id_incidencia) {
        $query = "SELECT creacion FROM registro_incidencias WHERE id_incidencia = :id_incidencia";
        $stmt = oci_parse($this->conn, $query);
        oci_bind_by_name($stmt, ':id_incidencia', $id_incidencia);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $hora_creacion = strtotime($row['CREACION']);
        
        $hora_actual = time();
        
        $diferencia_tiempo = $hora_actual - $hora_creacion;
        
        $horas = floor($diferencia_tiempo / 3600);
        $minutos = floor(($diferencia_tiempo % 3600) / 60);
        $segundos = $diferencia_tiempo % 60;
        
        $tiempo_respuesta = sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
        
        return $tiempo_respuesta;
    }
}

?>
