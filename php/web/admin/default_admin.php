<?php
include("../../parts/config.php");

// Verificar si ya existe un administrador en la tabla de usuarios
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE tipo = 1");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // No hay administrador, agregar uno por defecto

    // Obtener los datos del administrador
    $dni = "12345678A";
    $name = "Admin";
    $email = "admin@example.com";
    $password = "admin123";
    $date = "1990-01-01";
    $address = "Admin Address";

    // Encriptar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el administrador en la tabla de usuarios
    $stmt = $conn->prepare("INSERT INTO usuarios (tipo, dni, nombre, correo, contrasena, fecha_nacimiento, tarjeta, direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); 
    $tipo = 1; // Valor para indicar que es un administrador
    $tarjeta = null;
    $stmt->bind_param("isssssss", $tipo, $dni, $name, $email, $hashedPassword, $date, $tarjeta, $address); 
    if ($stmt->execute()) {
        echo "Se agregó el administrador por defecto exitosamente.";
    } else {
        echo "Error al agregar el administrador por defecto.";
    }
} else {
    echo "Ya existe un administrador en la tabla de usuarios.";
}
?>