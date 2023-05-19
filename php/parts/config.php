<?php

// Configuración de la base de datos
$dbserver = "localhost";
$dbuser = "miguel";
$dbpass = "wazowski";
$dbname = "musica";

// Crear una conexión a la base de datos
$conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    // Si hay un error en la conexión, muestra un mensaje y termina la ejecución del script
    die("Conexión fallida: " . $conn->connect_error);
}

// A partir de este punto, la variable $conn contiene la conexión a la base de datos y se puede utilizar para realizar consultas y otras operaciones en la base de datos.

?>
