<?php
session_start();

include "../../parts/config.php";
include "../../parts/functions.php";

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION["nombre"]) && isset($_SESSION["id_cliente"])) {
    $nav_title = $_SESSION["nombre"];
} else {
    $nav_title = "Iniciar Sesión";
}

$id_cliente = isset($_SESSION["id_cliente"]) ? $_SESSION["id_cliente"] : null;

if (isset($_POST["return"])) {
    header("location: home.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Compra Finalizada</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
    <div class="success">
    <h1>¡GRACIAS POR SU COMPRA!</h1>

    <form method="POST">
        <input type="submit" class="btn-success" name="return" value="VOLVER AL INICIO"></input>
    </form>
    </div>
    
    
</body>
</html>

<style>
    .btn-success {
        padding: 1.5em;
        background-color: rgb(185, 194, 104);
        color: aliceblue;
        border-radius: 5px;
        padding-left: 3em;
        padding-right: 3em;
    }

    .btn-success:hover {
    transition: .5s;
    opacity: 0.7;
    cursor: pointer;
}

    .success {
        margin: auto;
        margin-top: 300px;
        text-align:center;
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