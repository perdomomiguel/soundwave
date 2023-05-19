<?php
session_start();

include "../../parts/config.php";

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION["nombre"]) && isset($_SESSION["id_cliente"])) {
    $nav_title = $_SESSION["nombre"];
} else {
    $nav_title = "Iniciar Sesión";
}

$id_cliente = isset($_SESSION["id_cliente"]) ? $_SESSION["id_cliente"] : null;


if (isset($_POST["cerrar"])) {
    include "../../parts/session_destroy.php";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Admin Home</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">

</head>

<body>
<nav class="navbar navbar-dark">
        <div class="nav-section1">
            <img class="logo" src="../../../img/logo/logo.png" alt="">
        </div>

        <div class="nav-section2">    
            <h1 class="h1"><a href="users_table.php">Tabla de Usuarios</a></h1>
            <h1 class="h1"><a href="admin_table.php">Tabla de Administradores</a></h1>
            <h1 class="h1"><a href="add_admin.php">Añadir Administrador</a></h1>
        </div>


        <div class="nav-section3">


                <?php if (isset($_SESSION["nombre"])): ?>
                    <h1 class="h1"><?php echo $nav_title ?></h1>
                <?php else: ?>
                    <a href="../form/login.php"><h1 class="h1"><?php echo $nav_title ?></h1></a>
                <?php endif;?>
        </div>

        <form action="" method="post">
            <?php if (isset($_SESSION["nombre"])) {?>
                <button class="cerrar-sesion" name="cerrar">Cerrar sesión</button>
            <?php }?>
        </form>

    </nav>

    <h1 class="title-admin">Bienvenido Administrador <?php echo $nav_title ?></h1>





</body>

</html>

<style>

.title-admin {
    font-size: 50px;
    margin: auto;
    margin-top: 200px;
    text-align: center;

}

@media screen and (max-width: 767px) {
    .logo {
        width: 30px;
        height: 30px;
        margin-top: 10px;
    }

    nav {
        width: 100%;
        margin: auto;
    }

  .logo {
    width: 100px;
    height: auto;
  }

  .h1 {
    font-size: 15px;
    transition: font-size 0.3s;
  }

  .cerrar-sesion {
    margin-top: 0;
    margin-right: 10px;
  }
  
  
    .background-image {
  width: 100%;
  height: auto;
  margin: 0;
}

.images {
    margin-top: 100px;
}

.example {
  height: auto;
  width: 100%;
}

.example .fadedbox {
  width: 100%;
  height: auto;
  padding: 10% 5%;
}

.example2 {
  height: auto;
  width: 100%;
}

.example2 .fadedbox2 {
  width: 80%;
  padding: 20% 10%;
}

.img-section,
.img-section2 {
  width: 100%;
  height: auto;
  margin-top: 20px;
}

.text-section {
  font-size: 15px;
}

.title {
  font-size: 1.8em;
}

.title.text {
  font-size: 1.5em;
}

.section {
  flex-direction: column;
  align-items: center;
}

.menu-section {
  padding-left: 1em;
  width: 100%;
  border: none;
}

.menu-section2 {
  width: 50%;
  height: auto;
  margin-top: 20px;
}

.section2 {
    flex-direction: column;
    height: auto;
  }

  .menu-section2 {
    width: 100%;
    padding-left: 1em;
    margin-top: 20px;
    height: auto;
  }

  .text-section {
    margin-bottom: 20px;
  }

  .comments {
  flex-wrap: wrap;
}

.comment {
  flex-direction: column;
  align-items: center;
  width: 100%;
  text-align: center;
}

.stars {
    margin: auto;
    display: block;
}

.person {
  width: 150px;
  height: 150px;
  margin-right: 0;
  margin-bottom: 10px;
}
}

/* Tamaño de fuente de los títulos para dispositivos móviles */
@media screen and (max-width: 480px) {
    .h1 {
      font-size: 10px;
    }
  }
}

</style>