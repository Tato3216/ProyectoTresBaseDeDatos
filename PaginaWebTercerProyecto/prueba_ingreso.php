<?php
require_once 'controllers/auth.php';
$auth = new Auth();

$usuario = 'System';
$contrasena = 'system12345';

if ($auth->authenticate($usuario, $contrasena)) {
    echo "Usuario autenticado correctamente.\n";
} else {
    echo "Usuario o contraseña incorrectos.\n";
}
?>
