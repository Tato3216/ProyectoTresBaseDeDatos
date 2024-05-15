<?php
session_start();

if (isset($_SESSION['nit']) && isset($_SESSION['correo'])) {
    $nit = $_SESSION['nit'];
    $correo = $_SESSION['correo'];
    $contrasena = $_POST['contrasena'];

    require_once 'conexionoracle.php';

    $db = new ConexionOracle();
    $conn = $db->getConnection();

    $query = "SELECT id_persona FROM persona WHERE nit = :nit";

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':nit', $nit);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);
    $id_persona = $row['ID_PERSONA'];

    $query = "INSERT INTO usuario (nombre, correo, password, id_persona) VALUES (:correo, :correo, :contrasena, :id_persona)";

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':correo', $correo);
    oci_bind_by_name($stmt, ':contrasena', $contrasena);
    oci_bind_by_name($stmt, ':id_persona', $id_persona);

    $resultado = oci_execute($stmt);

    if ($resultado) {
        header("Location: ../views/user/index.php?mensaje=Usuario%20creado");
        exit();
    } else {
        echo "Error al crear el usuario.";
    }
    oci_close($conn);
} else {
    // Redirigir si las variables de sesión no están disponibles
    header("Location: ../views/user/formulario_contrasena.php");
    exit();
}
?>