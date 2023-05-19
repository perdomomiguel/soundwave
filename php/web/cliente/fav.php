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

if (isset($_POST["delete"])) {
    $nombre_producto = $_POST["nombre_producto"];
    
    // Consulta para obtener los detalles del producto
    $query = "SELECT * FROM favoritos WHERE id_cliente = '$id_cliente'";
    $result = mysqli_query($conn, $query);


  
    if (mysqli_num_rows($result) > 0) {
      // Obtiene los detalles del producto
      $producto = mysqli_fetch_assoc($result);
      
      // Se elimina la fila del producto seleccionado
      $query = "DELETE FROM favoritos WHERE id_cliente = '$id_cliente' AND nombre_producto = '$nombre_producto'";
      mysqli_query($conn, $query);
    }
}

if (isset($_POST["add-to-cart"])) {
    $nombre_producto = $_POST["nombre_producto"];
    echo fav_to_cart($conn, $id_cliente, $nombre_producto);
}

if(isset($_POST["fav-nav"])) {
    header("location:fav.php");
}

if(isset($_POST["cart-nav"])) {
    header("location:cart.php");
}

if(isset($_POST["cerrar"])) {
    include("../../parts/session_destroy.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Favoritos</title>
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

    // Obtener los productos favoritos del usuario
    $sql = "SELECT nombre_producto, categoria, precio FROM favoritos WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Generar la tabla HTML para mostrar los productos favoritos
    if ($result->num_rows > 0) {
        echo "<main>
            <table class='tabla-carrito'>
                <thead>
                    <tr>
                        <th class='encabezado'>Producto</th>
                        <th class='encabezado'>Categoria</th>
                        <th class='encabezado'>Subtotal</th>
                        <th class='encabezado'></th>
                        <th class='encabezado'></th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            $nombre_producto = $row["nombre_producto"];
            $categoria = $row["categoria"];
            $precio = $row["precio"];
           
            // Generar una fila en la tabla para cada producto favorito
            echo "<tr class='producto'>
                <td class='nombre'>$nombre_producto</td>
                <td class='categoria'>$categoria</td>
                <td class='subtotal'>$precio €</td>
                <form method='POST'>
                    <input type='hidden' name='nombre_producto' value='$nombre_producto'>
                    <td class='eliminar'><button name='delete' class='eliminar-carrito'>ELIMINAR DE FAVORITOS</button></td>
                    <td class='comprar-tabla'><button name='add-to-cart' class='comprar-fav'>AÑADIR AL CARRITO</button></td>
                </form>
            </tr>";
        }
        echo "</tbody></table></main>";
    } else {
        echo "<h1 class='session-message'>No hay productos en favoritos</h1>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<h1 class='session-message'>Debe iniciar sesión para ver sus productos favoritos.</h1>";
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

</html>

<style>

main {
    margin-top: 100px;
}

.error-message {
    margin-top: 150px;
    text-align: center;
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