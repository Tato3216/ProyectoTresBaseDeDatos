<?php

session_start();

require_once 'login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $login = new Login();

    if ($login->authenticate($username, $password)) {
        $_SESSION["username"] = $username;
        $_SESSION["permitted_windows"] = $login->getPermittedWindows($username);
        header("Location: ../views/home.php");
        exit();
    } else {
        echo "<script>alert('Usuario o Contraseña inválidos');</script>";
        echo "<meta http-equiv='refresh' content='1;url=../views/user/index.php'>";
    }
}

?>
