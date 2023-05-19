<?php

// Iniciar la sesión
session_start();

// Incluir archivos de configuración y funciones
include "../../parts/config.php";
include "../../parts/functions.php";

// Obtener los datos almacenados en la sesión
$id_cliente = isset($_SESSION["id_cliente"]) ? $_SESSION["id_cliente"] : null;
$id_producto = isset($_SESSION["id_producto"]) ? $_SESSION["id_producto"] : null;
$nombre_producto = isset($_SESSION["nombre_producto"]) ? $_SESSION["nombre_producto"] : null;
$categoria = isset($_SESSION["categoria"]) ? $_SESSION["categoria"] : null;
$precio = isset($_SESSION["precio"]) ? $_SESSION["precio"] : null;

// Procesar el formulario cuando se hace clic en el botón de comprar
if (isset($_POST["buy"])) {
    // Obtener los datos del formulario
    $dni = mysqli_real_escape_string($conn, $_POST["dni"]);
    $nombre = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $card = mysqli_real_escape_string($conn, $_POST["card"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);

    // Verificar si el usuario existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE dni= '$dni' AND id_cliente = '$id_cliente'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Si el usuario existe, verificar la contraseña
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row["contrasena"];
        if (password_verify($password, $hashedPassword)) {
            // La contraseña es correcta, realizar la compra
            $fecha = date("Y-m-d");
            $address = mysqli_real_escape_string($conn, $_POST["address"]);

            // Insertar los datos de la compra en la tabla "compras"
            $sql = "INSERT INTO compras (id_cliente, id_producto, nombre_producto, fecha, categoria, precio)
                    VALUES ('$id_cliente', '$id_producto', '$nombre_producto', '$fecha', '$categoria', '$precio')";
            if (mysqli_query($conn, $sql)) {
                // Eliminar el producto del carrito
                $sql = "DELETE FROM carrito WHERE id_cliente='$id_cliente' AND id_producto='$id_producto'";
                if (mysqli_query($conn, $sql)) {
                    echo "<p class='error-message'>Compra realizada con éxito</p>";

                    // Redireccionar a la página de éxito
                    header("location:success.php");
                    exit;
                } else {
                    echo "<p class='error-message'>Error al eliminar el producto del carrito: " . mysqli_error($conn) . "<p>";
                }
            } else {
                echo "<p class='error-message'>Error al realizar la compra: " . mysqli_error($conn) . "<p>";
            }
        } else {
            // La contraseña es incorrecta
            $error_message = "<p class='error-message'>Los datos no coinciden<p>";
        }
    } else {
        // El usuario no existe en la base de datos
        $error_message = "<p class='error-message'>Usuario no encontrado</p>";
    }
}

// Procesar el formulario cuando se hace clic en el botón de volver
if (isset($_POST["return"])) {
    header("location:cart.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Carrito</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">

</head>

<body>
    <h1 class="article-heading">Compra</h1>

    <div class="section-code">
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif;?>
        <div class="section-compra">
    
            <form class="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label class="register-label" for="dni">DNI:</label>
                <input class="register-input" type="text" id="dni" name="dni" maxlength="9"><br><br>
                <label class="register-label" for="name">Nombre:</label>
                <input class="register-input" type="text" id="name" name="name"><br><br>
                <label class="register-label" for="email">Correo electrónico:</label>
                <input class="register-input" type="email" id="email" name="email"><br><br>
                <label class="register-label" for="password">Contraseña:</label>
                <input class="register-input" type="password" id="password" name="password"><br><br>
                <label class="register-label" for="date">Fecha de nacimiento:</label>
                <input class="register-input" type="date" id="date" name="date"><br><br>
                <label class="register-label" for="card">Número de tarjeta:</label>
                <input class="register-input" type="text" id="card" name="card" maxlength="16"><br><br>
                <label class="register-label" for="address">Dirección:</label>
                <input class="register-input" type="text" id="address" name="address"><br><br>
                <div class="register-buttons">
                    <input type="submit" class="return-register" name="return" value="Volver">
                    <input class="register-submit" type="submit" name="buy" value="COMPRAR PRODUCTO">
                </div>

            </form>

            <?php

            // Consulta SQL para obtener los datos del producto con id_producto = 6
            $sql = "SELECT carrito.nombre_producto, carrito.precio, productos.imagen
                    FROM carrito
                    INNER JOIN productos ON carrito.id_producto = productos.id_producto
                    WHERE carrito.id_cliente = '$id_cliente' AND carrito.nombre_producto = '$nombre_producto'";
            $result = $conn->query($sql);

            // Comprueba si se han obtenido resultados
            if ($result->num_rows > 0) {
                // Si hay resultados, los muestra en el HTML
                while ($row = $result->fetch_assoc()) {
                    $nombre_producto = $row["nombre_producto"];
                    $precio = $row["precio"];
                    $imagen = $row["imagen"];

                    echo "<div class='article'>
                            <h1 class='article-comprar'>ARTÍCULO A COMPRAR</h1>
                            <img class='article-img' src='$imagen' alt='$nombre_producto'>
                            <p class='p-article'>$nombre_producto</p>
                            <p class='p-precio'>$precio €</p>
                          </div>";
                }
            } else {
                // Si no hay resultados, muestra un mensaje de error
                echo "No se han encontrado resultados.";
            }

            // Cierra la conexión
            $conn->close();
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
    .p-precio {
    text-align: center;
    font-size: 25px;
    font-weight: bold;
}

.error-message {
    text-align: center;
    margin: auto;
}

@media (max-width: 767px) {

  .section-compra {
    display: flex;
    flex-direction: column;
  }

  .register-form {
    width: 60%;
    margin: auto;
  }

  .register-label,
  .register-input {
    width: 100%;
  }

  .register-submit,
  .return-register {
    width: 100%;
    margin-top: 10px;
  }

  .article {
    margin-top: 20px;
    text-align: center;
  }

  .article-img {
    width: 100%;
    height: auto;
    max-width: 300px;
    margin: 0 auto;
  }

  .p-article,
  .p-precio {
    margin-top: 10px;
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