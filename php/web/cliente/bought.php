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

// Verificar si se ha enviado el formulario para redireccionar a la página de favoritos
if(isset($_POST["fav-nav"])) {
    header("location:fav.php");
}

// Verificar si se ha enviado el formulario para redireccionar a la página de carrito
if(isset($_POST["cart-nav"])) {
    header("location:cart.php");
}

// Verificar si se ha enviado el formulario para cerrar sesión
if (isset($_POST["cerrar"])) {
    include("../../parts/session_destroy.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Compra</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">

</head>

<body>

<?php
echo nav_cliente();
?>




    <?php
    
if (isset($_SESSION["nombre"]) && isset($_SESSION["id_cliente"])) {
    $id_cliente = $_SESSION["id_cliente"];

    // Obtener los productos en el carrito del usuario
    $sql = "SELECT * FROM compras WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();
    
 // Generar la tabla HTML para mostrar los productos en el carrito
 if ($result->num_rows > 0) {
    echo "<main>
            <h2 class='subtitulo'>Carrito de Compra</h2>
            <table class='tabla-carrito'>
                <thead>
                    <tr>
                        <th class='encabezado'>Producto adquirido</th>
                        <th class='encabezado'>Categoria</th>
                        <th class='encabezado'>Subtotal</th>
                        <th class='encabezado'>Fecha de compra</th>
                    </tr>
                </thead>
                <tbody>";
    while ($row = $result->fetch_assoc()) {
        $id_producto = $row["id_producto"];
        $nombre_producto = $row["nombre_producto"];
        $categoria = $row["categoria"];
        $precio = $row["precio"];
        $fecha = $row["fecha"];
       

        echo "<tr class='producto'>
                <td class='nombre'>$nombre_producto</td>
                <td class='categoria'>$categoria</td>
                <td class='subtotal'>$precio €</td>
                <td class='subtotal'>$fecha</td>
                <form method='POST'>
                <input type='hidden' name='id_producto' value='$id_producto'>
                    <input type='hidden' name='nombre_producto' value='$nombre_producto'>
                    <input type='hidden' name='categoria' value='$categoria'>
                    <input type='hidden' name='precio' value='$precio'>
                    
                </form>
            </tr>";
    }
    echo "</tbody></table></main>";
} else {
    echo "<h1 class='session-message'>No hay productos comprados</h1>";
}

$stmt->close();
$conn->close();
} else {
echo "<h1 class='session-message'>Debe iniciar sesión para ver su carrito.</h1>";
}
    ?>


</body>

<footer>
    <div class="social">
        <img class="social-icon" src="../../../img/footer/twitter-dark.png" alt="">
        <img class="social-icon" src="../../../img/footer/youtube-dark.png" alt="">
        <img class="social-icon" src="../../../img/footer/instagram-dark.png" alt="">
    </div>

</footer>

<script src="../../code/code.js"></script>

</html>

<style>

.session-message {   
    text-align: center;
    margin: auto;
    margin-top:200px;
}

@media (max-width: 767px) {
  .tabla-carrito {
    width: 100%;
    border-collapse: collapse;
  }

  td {
    text-align: center;
    margin: auto;
  }

  .encabezado {
    display: none;
  }

  .producto {
    display: block;
    border-bottom: 1px solid #ccc;
    padding: 10px 0;
  }

  .nombre,
  .categoria,
  .subtotal,
  .eliminar,
  .comprar-tabla {
    display: block;
    text-align: center;
    padding: 5px 0;
  }

  .eliminar,
  .comprar-tabla {
    text-align: center;
  }

  .eliminar-carrito,
  .comprar-fav {
    width: 100%;
    margin-top: 5px;
  }
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