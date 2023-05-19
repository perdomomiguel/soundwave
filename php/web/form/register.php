<?php
include("../../parts/config.php");
include("../../parts/functions.php");

// Verificar si el formulario ha sido enviado
if (isset($_POST["register"])) {
    
    // Obtener los datos del formulario
    $dni = test_input($_POST["dni"]);
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $date = test_input($_POST["date"]);
    $card = test_input($_POST["card"]);
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
    } elseif (empty($card) || !preg_match("/^[0-9]{16}$/", $card)) {
        $error_message = "El campo Número de tarjeta es obligatorio y debe tener 16 dígitos.";
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
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insertar el usuario en la base de datos
            $stmt = $conn->prepare("INSERT INTO usuarios (dni, nombre, correo, contrasena, fecha_nacimiento, tarjeta, direccion) VALUES (?, ?, ?, ?, ?, ?, ?)"); 
            $stmt->bind_param("sssssss", $dni, $name, $email, $hashedPassword, $date, $card, $address); 
            if ($stmt->execute()) {
                // Iniciar sesión y redirigir al usuario a la página principal
                session_start();
                $_SESSION["correo"] = $email; // Cambiado
                header("Location: login.php");
            } else {
                // Mostrar mensaje de error si no se pudo insertar el usuario en la base de datos
                $error_message = "No se pudo insertar el usuario en la base de datos.";
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

if (isset($_POST["return"])) {
    header("location:login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Registro</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
    <h1 class="register-heading">Registro</h1>
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
        <label class="register-label" for="card">Número de tarjeta:</label>
        <input class="register-input" type="text" id="card" name="card" maxlength="16"><br><br>
        <label class="register-label" for="address">Dirección:</label>
        <input class="register-input" type="text" id="address" name="address"><br><br>
        <div class="register-buttons">
            <input type="submit" class="return-register" name="return" value="Volver">
            <input class="register-submit" type="submit" name="register" value="Registrarse">
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

    @media (max-width: 767px) {
  .error-message {
    text-align: center;
    margin-bottom: 10px;
  }

  .register-form {
    width: 60%;
    font
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
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 10px;
  }

  .return-register,
  .register-submit {
    width: 45%;
    margin-top: 5px;
  }
}
</style>