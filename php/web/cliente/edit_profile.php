<?php
session_start();

include "../../parts/config.php";
include "../../parts/functions.php";

// Definir el mapeo de campos y tipos de entrada
$fieldTypes = array(
    "nombre" => "text",
    "correo" => "email",
    "fecha_nacimiento" => "date",
    "direccion" => "text",
    "numero_tarjeta" => "text"
);

// Obtener el ID del cliente desde la sesión, si está definido
$id_cliente = $_SESSION["id_cliente"];

// Verificar si se envió el formulario para navegar a la página de favoritos
if(isset($_POST["fav-nav"])) {
    header("location:fav.php"); // Redirecciona al usuario a la página de favoritos
    exit();
}

// Verificar si se envió el formulario para navegar a la página del carrito de compras
if(isset($_POST["cart-nav"])) {
    header("location:cart.php"); // Redirecciona al usuario a la página del carrito de compras
    exit();
}

// Verificar si se envió el formulario para cerrar la sesión
if (isset($_POST["cerrar"])) {
    include "../../parts/session_destroy.php"; // Incluye el archivo que destruye la sesión actual
    exit();
}

// Verificar si se ha enviado el formulario de edición
if (isset($_POST["submit"])) {
    // Obtener los datos del formulario
    $id_cliente = $_POST["id_cliente"];
    $field = $_POST["field"];
    $new_value = $_POST["new_value"];

    // Realizar la consulta para actualizar el campo en la tabla de usuarios
    $sql = "UPDATE usuarios SET $field = ? WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_value, $id_cliente);
    $stmt->execute();

    // Verificar si la consulta se realizó correctamente y mostrar un mensaje adecuado
    if ($stmt->affected_rows > 0) {
        echo "El campo $field se ha actualizado correctamente.";

        // Actualizar el nombre en la sesión si se cambió el campo de nombre
        if ($field === "nombre") {
            $_SESSION["nombre"] = $new_value;
        }

        header("location:profile.php");
    } else {
        echo "<h1 class='error-message'>No se pudo actualizar el campo $field.</h1>";
    }
}

$field = $_GET["field"];

// Obtener los datos del usuario a editar
$sql = "SELECT * FROM usuarios WHERE id_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (isset($_POST["return"])) {
    header("Location: ../cliente/profile.php");
    exit();
}
?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Editar Perfil</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">

</head>

<?php
// Mostrar el formulario de edición
echo "<h1 class='title-edit'>Editar $field</h1>";
echo "<br>";
echo "<br>";
?>

<!-- Formulario de edición -->
<form method="POST" action="" class="edit-form">
    <input type="hidden" class="edit-input" name="id_cliente" value="<?php echo $id_cliente; ?>">
    <input type="hidden" class="edit-input" name="field" value="<?php echo $field; ?>">
    
    <?php if (array_key_exists($field, $fieldTypes)): ?>
        <label for="new_value">Nuevo <?php echo ucfirst($field); ?>:</label>
        <input type="<?php echo $fieldTypes[$field]; ?>" class="edit-input" name="new_value" id="new_value" value="<?php echo $row[$field]; ?>">
    <?php endif; ?>
    

    <div class="edit-buttons">
        <input type="submit" class="edit-return" name="return" value="Volver">
        <input type="submit" class="edit-submit" name="submit" value="Guardar cambios">
    </div>
</form>

<style>

.error-message {
    margin: auto;
    text-align: center;
}

    .title-edit {
        margin: auto;
        margin-top: 200px;
        text-align: center;
        font-size: 40px;
        border-bottom: 3px solid aliceblue;
        border-radius: 10px;
        width: 560px;
        margin-bottom: 1.5em;
    }

  

.edit-form {
    margin: 0 auto;
    width: 400px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0px 0px 5px #cccccc;
}
  
.edit-label {
    display: block;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333333;
}
  
.edit-input {
    width: 380px;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: none;
    border-bottom: 2px solid #ccc;
    font-size: 16px;
}

.edit-input:focus {
    border-bottom: 2px solid #181818;
    outline: none;
  }

.edit-buttons {
    display: flex;
    justify-content: space-around;
}

.edit-return {
    background-color: #db6161;
    color: #ffffff;
    padding: 10px;
    font-weight: bold;
    font-size: 15px;
    border-radius: 3px;
    cursor: pointer;
    border: 0px;
}

.edit-return:hover {
      opacity: 0.8;
}
  

.edit-submit {
    background-color: #333333;
    color: #ffffff;
    border: none;
    padding: 10px;
    border-radius: 3px;
    font-size: 15px;
    cursor: pointer;
    width: 100%;
    margin: auto;
    font-weight: bold;
    margin-left: 5px;
}

.edit-submit:hover {
    background-color: #555555;
}

.new_account {
      margin: auto;
      margin-top: 50px;
      display: block;
      color: aliceblue;
      text-align: center;
      text-decoration: none;
}

.new_account:hover {
    opacity: 0.8;
    cursor: pointer;
    text-decoration: underline;
}

    .error-message {
        margin: auto;
        text-align: center;
        padding: 1em;
    }

@media (max-width: 767px) {
    .title-edit {
        font-size: 35px;
        width: 360px;
    }

  .edit-form {
    width: 70%;
  }

  .edit-label {
    display: block;
    margin-bottom: 5px;
  }

  .edit-input {
    width: 100%;
    padding: 5px;
    margin-bottom: 10px;
  }

  .edit-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 10px;
  }

  .return-edit,
  .edit-submit {
    width: 45%;
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