<?php
session_start();

include "../../parts/config.php";
include "../../parts/functions.php";

// Obtiene el ID del cliente desde la sesión, si está definido
$id_cliente = isset($_SESSION["id_cliente"]) ? $_SESSION["id_cliente"] : null;

// Verifica si se envió el formulario para navegar a la página de favoritos
if(isset($_POST["fav-nav"])) {
    header("location:fav.php"); // Redirecciona al usuario a la página de favoritos
}

// Verifica si se envió el formulario para navegar a la página del carrito de compras
if(isset($_POST["cart-nav"])) {
    header("location:cart.php"); // Redirecciona al usuario a la página del carrito de compras
}

// Verifica si se envió el formulario para cerrar la sesión
if (isset($_POST["cerrar"])) {
    include "../../parts/session_destroy.php"; // Incluye el archivo que destruye la sesión actual
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Perfil</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">

</head>

<body>

<?php
echo nav_cliente();
?>

<?php

// Comprobar si el usuario está autenticado
if (isset($_SESSION["nombre"]) && isset($_SESSION["id_cliente"])) {
    echo profile_table($conn, $id_cliente);
}


// Cerrar la conexión a la base de datos
$conn->close();
?>

</body>

<footer>
    <div class="social">
        <img class="social-icon" src="../../../img/footer/twitter-dark.png" alt="">
        <img class="social-icon" src="../../../img/footer/youtube-dark.png" alt="">
        <img class="social-icon" src="../../../img/footer/instagram-dark.png" alt="">
    </div>

</footer>

<script src="../../../code/code.js"></script>

</html>

<style>
table {
        margin-top: 200px;
        color: aliceblue;
}
    
.session-message {   
    text-align: center;
    margin: auto;
    margin-top:200px;
}

.edit {
    width: 25px;
    height: 25px;
    background-color: aliceblue;
    border-radius: 5px;
    padding: 1em;
}

.edit:hover {
    opacity: 0.7;
    transition: .5s;
    cursor: pointer;
}

.btn-info {
    background-color: rgb(104, 169, 194);
    border: 2px solid rgb(104, 169, 194);
    border-radius: 3px;
}

.btn-info:hover {
    transition: .5s;
    opacity: 0.7;
    cursor: pointer;
}

.btn-danger {
    background-color: #db6161;
    border: 2px solid #db6161;
    border-radius: 3px;
}

.btn-danger:hover {
    transition: .5s;
    opacity: 0.7;
    cursor: pointer;
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