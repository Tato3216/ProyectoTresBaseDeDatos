<?php

require_once 'conexionoracle.php';

class InsertarPersona {
    protected $conn;

    public function __construct() {
        $db = new ConexionOracle();
        $this->conn = $db->getConnection();
    }

    public function insertar($nombre, $apellido, $nit, $correo) {
        $query = "INSERT INTO persona (nombre, apellido, nit, correo, id_tipo_persona) VALUES (:nombre, :apellido, :nit, :correo, '1000003')";

        $stmt = oci_parse($this->conn, $query);

        oci_bind_by_name($stmt, ':nombre', $nombre);
        oci_bind_by_name($stmt, ':apellido', $apellido);
        oci_bind_by_name($stmt, ':nit', $nit);
        oci_bind_by_name($stmt, ':correo', $correo);

        $resultado = oci_execute($stmt);

        return $resultado;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $nit = $_POST["nit"];
    $correo = $_POST["correo"];

    $insertarPersona = new InsertarPersona();
    
        $resultado = $insertarPersona->insertar($nombre, $apellido, $nit, $correo);

        if ($resultado) {
            session_start();
            $_SESSION['nit'] = $nit;
            $_SESSION['correo'] = $correo;
            echo "Datos de la persona insertados correctamente.";
            header('Location: ../views/user/formulario_contraseña.php');
            exit();
        } else {
            echo "<script>alert('Nit Existente');</script>";
            // echo "<div style='color: red; font-weight: bold;'>Nit Existente</div>";
            echo "Error al insertar los datos de la persona.";
            header("refresh:2;url=../views/user/formnewperson.php");
            // header("Location: ../views/user/formnewperson.php");
            // exit();
        }
}
?>