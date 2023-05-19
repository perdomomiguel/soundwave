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

if (isset($_POST["cart"])) {
    $id_producto = $_POST["id_producto"];
    echo add_to_cart($conn, $id_cliente, $id_producto);
}

if (isset($_POST["fav"])) {
    $id_producto = $_POST["id_producto"];
    echo add_to_fav($conn, $id_cliente, $id_producto);
}

if(isset($_POST["fav-nav"])) {
    header("location:fav.php");
}

if(isset($_POST["cart-nav"])) {
    header("location:cart.php");
}

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
    <title>Soundwave | Sonido</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">
</head>

<body>

<?php
echo nav_cliente();
?>


<h1 class="sound-title">Amplificadores</h1>
<div class="popular-section">

<?php
// Selecciona los datos de la tabla productos
$sql = "SELECT * FROM productos WHERE categoria = 'Amplificadores'";
$result = mysqli_query($conn, $sql);

// Genera una sección HTML para cada producto
if (mysqli_num_rows($result) > 0) {
    $count = 0;
    echo '<div class="row">';

    while ($row = mysqli_fetch_assoc($result)) {

        echo '<div class="product-section">';
        echo '<img class="popular-image" src="' . $row['imagen'] . '" alt="">';
        // Agrega la conexión a la base de datos antes de esta sección de código
        $id_producto = $row['id_producto'];

        // Verificar si el producto ya ha sido comprado por el usuario
        $sql = "SELECT * FROM compras WHERE id_producto='$id_producto' AND id_cliente='$id_cliente'";
        $resultado = mysqli_query($conn, $sql);

        // Si se encuentra el producto en la tabla de compras, mostrar un mensaje
        if (mysqli_num_rows($resultado) > 0) {
            echo '<p class="comprado">Este producto ya ha sido comprado.</p>';
            echo '<div class="product">';
            echo '<h2 class="product-title">' . $row['nombre_producto'] . '</h2>';
            echo '<h2 class="precio">' . $row['precio'] . '€</h2>';
            
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="product">';
            echo '<h2 class="product-title">' . $row['nombre_producto'] . '</h2>';
            echo '<h2 class="precio">' . $row['precio'] . '€</h2>';
            echo '</div>';
            echo '<div class="popular-buttons">';
            echo '<form method="post" class="form-buttons">';
            echo '<input type="hidden" name="id_producto" value="' . $row['id_producto'] . '">';

            if (isset($_SESSION["nombre"])):
                
                echo '<button class="cart" name="cart">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="comprar" viewBox="0 0 16 16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                 </svg>';
            echo '</button>';
    
            echo '<button class="fav" name="fav">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"';
            echo 'class="bi bi-heart" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                   d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5Zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0ZM14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1ZM8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
            </svg>';
            echo '</button>';
        
            endif;
    
            
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
        $count++;
    }
    echo '</div>';
} else {
    echo 'No se encontraron productos.';
}
?>

</div>
</div>
    

<h1 class="sound-title">Cableado y Sonido</h1>
<div class="popular-section">


<?php
// Selecciona los datos de la tabla productos
$sql = "SELECT * FROM productos WHERE categoria = 'Cableado y Sonido'";
$result = mysqli_query($conn, $sql);

// Genera una sección HTML para cada producto
if (mysqli_num_rows($result) > 0) {
    $count = 0;
    echo '<div class="row">';

    while ($row = mysqli_fetch_assoc($result)) {

        echo '<div class="product-section">';
        echo '<img class="popular-image" src="' . $row['imagen'] . '" alt="">';
        // Agrega la conexión a la base de datos antes de esta sección de código
        $id_producto = $row['id_producto'];

        // Verificar si el producto ya ha sido comprado por el usuario
        $sql = "SELECT * FROM compras WHERE id_producto='$id_producto' AND id_cliente='$id_cliente'";
        $resultado = mysqli_query($conn, $sql);

        // Si se encuentra el producto en la tabla de compras, mostrar un mensaje
        if (mysqli_num_rows($resultado) > 0) {
            echo '<p class="comprado">Este producto ya ha sido comprado.</p>';
            echo '<div class="product">';
            echo '<h2 class="product-title">' . $row['nombre_producto'] . '</h2>';
            echo '<h2 class="precio">' . $row['precio'] . '€</h2>';
            
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="product">';
            echo '<h2 class="product-title">' . $row['nombre_producto'] . '</h2>';
            echo '<h2 class="precio">' . $row['precio'] . '€</h2>';
            echo '</div>';
            echo '<div class="popular-buttons">';
            echo '<form method="post" class="form-buttons">';
            echo '<input type="hidden" name="id_producto" value="' . $row['id_producto'] . '">';

            if (isset($_SESSION["nombre"])):
                
                echo '<button class="cart" name="cart">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="comprar" viewBox="0 0 16 16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                 </svg>';
            echo '</button>';
    
            echo '<button class="fav" name="fav">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"';
            echo 'class="bi bi-heart" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                   d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5Zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0ZM14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1ZM8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
            </svg>';
            echo '</button>';
        
            endif;
    
            
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
        $count++;
    }
    echo '</div>';
} else {
    echo 'No se encontraron productos.';
}
?>

</div>
</div>


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
    .product-section {
        border-radius: 5px;
    }

    .popular-image {
        width:350px;
        height:350px;
        margin: auto;
        padding: 1em;
    }

    .buttons-comprar {
        display: flex;
        justify-content: space-evenly;
        width: 400px;
        margin: auto;
    }

    .fav {
    padding: 1em;
    background-color: #db6161;
    border: 3px solid #db6161;
    border-radius: 5px;
    margin: auto;
}

.fav:hover {
    transition: .5s;
    opacity: 0.7;
    cursor: pointer;
}

.cart {
    border-radius: 5px;
    margin: auto;
    background-color: rgb(104, 169, 194);
    border: 3px solid rgb(104, 169, 194);
    padding: 1em;
    margin-right: 50px;
}

.cart:hover {
    transition: .5s;
    opacity: 0.7;
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

.sound-title {
    width: 500px;
    text-align: center;
    font-size: 50px;
    border-bottom: 3px solid aliceblue;
    border-radius: 10px;
    margin: auto;
    margin-top: 200px;
    margin-bottom: 100px;
}

.product-section {
    margin-bottom: 100px;
}

.comprado {
    text-align: center;
}

.cerrar-sesion {
  padding: 1em;
  margin: auto;
  display: block;
  background-color: #db6161;
  border: 2px solid #db6161;
  border-radius: 5px;
  margin-top: 20px;
}


.cerrar-sesion:hover {
  transition: .5s;
  opacity: 0.7;
  cursor: pointer;
}

.row {
        display: flex;
        flex-wrap: wrap;
        margin-left: 200px;
    }

    .product-section {
        margin: auto;
        display: block;
        align-items: center;
        margin-bottom: 50px;
        margin-right: 80px;
        margin-left: 20px;
        padding: 15px;
        background-color: #273036;
        padding-bottom: 1em;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
    }

    .product-section2 {
        width: 33.33%;
        padding: 15px;
        box-sizing: border-box;
        background-color: #181818;
        padding-bottom: 1em;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
    }

    .product {
        display: flex;
        justify-content: space-around;
    }

    .product-title {
        font-size: 20px;
        font-weight: 300;
        padding-top: .5em;
        color: #fff;
    }

    .precio {
        font-size: 20px;
        font-weight: 300;
        background-color: #181818;
        color: aliceblue;
        border-radius: 20px;
        padding: .5em;
    }

    .precio2 {
        font-size: 20px;
        font-weight: 300;
        background-color: #273036;
        color: aliceblue;
        border-radius: 20px;
        padding: .5em;
    }

    .popular-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
    }

    @media (max-width: 768px) {
        .row {
            margin: auto;
            margin-top: 50px;         

            flex-direction: column;
        }

        .product-section {
            width: 90%;
            margin: 0;
            margin-bottom: 50px;
        }

        .product-section2 {
            width: 100%;
        }
    }

    @media (max-width: 480px) {

        .sound-title {
            font-size: 30px;
            margin-bottom: 50px;
            width: 300px;
        }

        .popular-image {
            margin: auto;
            width: 300px;
        }

        .row {
            margin: auto;
            margin-top: 50px;         

            flex-direction: column;
        }

        .product-section {
            width: 90%;
            margin: auto;
            margin-bottom: 50px;
        }

        .product-section2 {
            width: 100%;
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

.sound-title {
        font-size: 40px;
        width: 400px;
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