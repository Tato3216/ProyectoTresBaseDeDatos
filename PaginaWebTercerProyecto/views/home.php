<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100%;
            background-color: #333;
            padding-top: 20px;
            color: #fff;
        }

        .sidebar h2 {
            padding: 10px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #fff;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 10px 20px;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            background-color: #555;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .content h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Barra lateral vertical con el menú -->
    <div class="sidebar">
        <h2>Menú</h2>
        <ul>
            <li><a href="home.php">Inicio</a></li>
            <?php
            // Generar dinámicamente los elementos del menú basados en las ventanas permitidas
            if (isset($_SESSION["permitted_windows"])) {
                foreach ($_SESSION["permitted_windows"] as $window) {
                    echo "<li><a href='../views" . $window['path'] . "'>" . $window['nombre'] . "</a></li>";
                }
            }
            ?>
            <li><a href="user/index.php">Salir</a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <h2>Bienvenido, <?php echo $_SESSION["username"]; ?></h2>
        <!-- Aquí va el contenido principal de la página -->
    </div>
</body>
</html>
