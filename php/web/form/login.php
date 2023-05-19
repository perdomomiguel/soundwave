<?php

include "../../parts/config.php";

// Verificar si el formulario ha sido enviado
if (isset($_POST["login"])) {
    // Verificar si el usuario y la contraseña son válidos
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["contrasena"];

        // Verificar si la contraseña ingresada coincide con la contraseña almacenada en la base de datos
        if (password_verify($password, $hashedPassword)) {
            $tipoUsuario = $row["tipo"];
            
            // Iniciar sesión y redirigir al usuario a la página correspondiente
            session_start();
            $_SESSION["email"] = $email;
            $_SESSION["nombre"] = $row["nombre"];
            $_SESSION["id_cliente"] = $row["id_cliente"];

            if ($tipoUsuario) {
                // Usuario admin, redirigir a users_table.php
                header("Location: ../admin/admin_home.php");
            } else {
                // Usuario cliente, redirigir a home.php
                header("Location: ../cliente/home.php");
            }
        } else {
            // Mostrar mensaje de error si la contraseña no es válida
            $error_message = "El correo electrónico o la contraseña no son válidos.";
        }
    } else {
        // Mostrar mensaje de error si el usuario no existe
        $error_message = "El correo electrónico o la contraseña no son válidos.";
    }
}

if (isset($_POST["return"])) {
    header("Location: ../cliente/home.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Inicio Sesión</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">
</head>

<body>
    <h1 class="login-heading">Iniciar sesión</h1>

    <?php if (isset($error_message)): ?>
        <div><p class="error-message"><?php echo  $error_message; ?></p></div>
    <?php endif;?>

<form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label class="login-label" for="email">Correo electrónico:</label>
    <input class="login-input" type="email" id="email" name="email"><br><br>
    <label class="login-label" for="password">Contraseña:</label>
    <input class="login-input" type="password" id="password" name="password"><br><br>
    <div class="login-buttons">
        <input type="submit" class="return-login" name="return" value="Volver">
        <input class="login-submit" type="submit" name="login" value="Iniciar sesión">
    </div>

</form>


    <div>
        <a class="new_account" href="register.php">¿Aún no tiene una cuenta? Pulse aquí</a>
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
    .error-message {
        margin: auto;
        text-align: center;
        padding: 1em;
    }

@media (max-width: 767px) {
  .login-form {
    width: 70%;
  }

  .login-label {
    display: block;
    margin-bottom: 5px;
  }

  .login-input {
    width: 100%;
    padding: 5px;
    margin-bottom: 10px;
  }

  .login-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 10px;
  }

  .return-login,
  .login-submit {
    width: 45%;
    margin-top: 5px;
  }
}
</style>