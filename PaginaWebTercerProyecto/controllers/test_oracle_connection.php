<?php
$usuario = 'tercer_proyecto';
$contrasena = 'A5000shg';
$servidor = 'localhost';
$puerto = '1521';
$servicio = 'admin';

// Intenta establecer la conexión
$conn = oci_connect($usuario, $contrasena, "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = $servidor)(PORT = $puerto)))(CONNECT_DATA=(SID=$servicio)))");

// Verifica si la conexión fue exitosa
if (!$conn) {
    $m = oci_error();
    echo "Error de conexión a Oracle: " . $m['message'] . "\n";
} else {
    echo "Conexión exitosa a Oracle!";
    // Cierra la conexión cuando hayas terminado de usarla
    oci_close($conn);
}
?>
