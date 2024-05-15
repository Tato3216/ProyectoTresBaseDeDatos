<?php
require_once '../controllers/conexionoracle.php';
require_once '../controllers/obtener_tiempo_respuesta.php';


class PanelControl {
    protected $conn;

    public function __construct() {
        $db = new ConexionOracle();
        $this->conn = $db->getConnection();
    }

    public function obtenerIncidencias() {
        $query = "SELECT RI.ID_REGISTRO_INCIDENCIAS, I.NOMBRE AS incidente, P.NOMBRE AS cliente, RI.ESTADO_INCIDENCIA AS Estado, RI.CREACION AS Creacion_incidencia 
                  FROM REGISTRO_INCIDENCIAS RI
                  INNER JOIN INCIDENTES I ON I.ID_INCIDENTE = RI.ID_INCIDENTE
                  INNER JOIN PERSONA P ON P.ID_PERSONA = I.ID_CLIENTE";

        $stmt = oci_parse($this->conn, $query);

        oci_execute($stmt);

        $incidencias = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $obtenerTiempoRespuesta = new ObtenerTiempoRespuesta();
            $tiempoRespuesta = $obtenerTiempoRespuesta->obtenerTiempoRespuesta($row['ID_REGISTRO_INCIDENCIAS']);
            $row['TIEMPO_RESPUESTA'] = $tiempoRespuesta;
            $incidencias[] = $row;
        }

        return $incidencias;
    }
}

$panelControl = new PanelControl();

$incidencias = $panelControl->obtenerIncidencias();

echo "<h1>Incidencias</h1>";
echo "<table class='incidencias'>";
echo "<tr><th>Incidente</th><th>Cliente</th><th>Estado</th><th>Creación de la incidencia</th><th>Acciones</th></tr>";
foreach ($incidencias as $incidencia) {
    echo "<tr>";
    echo "<td>" . $incidencia['INCIDENTE'] . "</td>";
    echo "<td>" . $incidencia['CLIENTE'] . "</td>";
    echo "<td>" . $incidencia['ESTADO'] . "</td>";
    echo "<td>" . $incidencia['CREACION_INCIDENCIA'] . "</td>";
    // echo "<td>" . $incidencia['TIEMPO_RESPUESTA'] . "</td>";

    echo "<td><a href='ver_incidencia.php?id=" . $incidencia['ID_REGISTRO_INCIDENCIAS'] . "'>Ver Detalles</a></td>";
    echo "</tr>";
}
echo "</table>";

?>

<style>
    .incidencias {
        width: 100%;
        border-collapse: collapse;
    }
    .incidencias th, .incidencias td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .incidencias th {
        background-color: #f2f2f2;
    }
    .incidencias tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .incidencias tr:hover {
        background-color: #ddd;
    }
</style>
