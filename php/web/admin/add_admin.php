<?php
include("../../parts/config.php");

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener los datos del formulario
    $dni = test_input($_POST["dni"]);
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $date = test_input($_POST["date"]);
    $address = test_input($_POST["address"]);

    // Verificar si algún campo está vacío o en formato incorrecto
    if (empty($dni) || !preg_match("/^[0-9]{8}[A-Za-z]$/", $dni)) {
        $error_message = "El campo DNI es obligatorio y debe tener formato 12345678A.";
    } elseif (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
        $error_message = "El campo Nombre es obligatorio y solo debe contener letras y espacios.";
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "El campo Correo electrónico es obligatorio y debe tener formato example@example.com.";
    } elseif (empty($password) || strlen($password) < 8) {
        $error_message = "El campo Contraseña es obligatorio y debe tener al menos 8 caracteres.";
    } elseif (empty($date)) {
        $error_message = "El campo Fecha de nacimiento es obligatorio.";
    } elseif (empty($address)) {
        $error_message = "El campo Dirección es obligatorio.";
    } else {
        // Verificar si el correo electrónico ya existe en la base de datos
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?"); 
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Mostrar mensaje de error si el correo electrónico ya existe
            $error_message = "El correo electrónico introducido ya existe";
        } else {
            // Encriptar la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el usuario en la base de datos
            $stmt = $conn->prepare("INSERT INTO usuarios (tipo, dni, nombre, correo, contrasena, fecha_nacimiento, tarjeta, direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); 
            $tipo = true;
            $tarjeta = null;
            $stmt->bind_param("isssssss", $tipo, $dni, $name, $email, $hashedPassword, $date, $tarjeta, $address); 
            if ($stmt->execute()) {
                header("Location: admin_home.php");
                exit;
            } else {
                // Manejar el error si la inserción no fue exitosa
                $error_message = "Error al insertar el nuevo usuario en la base de datos.";
            }
        }
    }
}

// Función para limpiar y validar los datos del formulario
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Verificar si se ha enviado el formulario para regresar a la página principal del administrador
if (isset($_POST["return"])) {
    header("location:admin_home.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Registrar Admin</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
    <h1 class="admin-register-heading">Registrar Administrador</h1>
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
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
        <label class="register-label" for="address">Dirección:</label>
        <input class="register-input" type="text" id="address" name="address"><br><br>
        <div class="register-buttons">
            <input type="submit" class="return-register" name="return" value="Volver">
            <input class="register-submit" type="submit" name="register" value="Registrar">
        </div>
        
    </form>

</body>
</html>

<style>
    .error-message {
        margin: auto;
        text-align: center;
        padding: 1em;
    }

    .admin-register-heading {
        margin: auto;
        text-align: center;
        font-size: 40px;
        border-bottom: 3px solid aliceblue;
        border-radius: 10px;
        width: 600px;
        margin-bottom: 40px;
        padding-bottom: 5px;
    }

    @media (max-width: 767px) {

        .admin-register-heading {
        font-size: 30px;
        text-align: center;
        width: 450px;
    }


  .error-message {
    text-align: center;
    margin-bottom: 10px;
  }

  .register-form {
    width: 60%;
    margin: auto;
  }

  .register-label {
    display: block;
    margin-bottom: 5px;
  }

  .register-input {
    width: 100%;
    padding: 5px;
    margin-bottom: 10px;
  }

  .register-buttons {
    justify-content: space-between;
    margin-top: 10px;
  }

  .return-register,
  .register-submit {
    width: 45%;
    margin-top: 5px;
  }
}

@media (max-width: 767px) {

.admin-register-heading {
font-size: 20px;
text-align: center;
width: 300px;
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