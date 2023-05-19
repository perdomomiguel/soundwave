<?php
// Se crea la conexión con la base de datos en el archivo "config.php" 
$config = include "config.php";

// Recoge los datos de la base de datos y verifica si están correctos para realizar dicha conexión
try {
    $sql = file_get_contents("../../sql/musica.sql");

    echo "La base de datos y la tablas se han creado con éxito";
} catch(mysqli_connect_error $error) {
    echo $error -> getMessage();
}
?>