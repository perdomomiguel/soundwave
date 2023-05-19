<?php

function nav_cliente() {
    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION["nombre"]) && isset($_SESSION["id_cliente"])) {
        $nav_title = $_SESSION["nombre"];
    } else {
        $nav_title = "Iniciar Sesión";
    }
    ?>
    
    <nav class="navbar navbar-dark">
        <div class="nav-section1">
            <a href="home.php"><img class="logo" src="../../../img/logo/logo.png" alt=""></a>
        </div>

        <div class="nav-section2">
        <?php if (isset($_SESSION["nombre"])): ?>
                <form method="POST">
                    <h1 class="h1" name="bought"><a href="bought.php"><?php echo "Comprado" ?></a></h1>
                </form>
        <?php endif;?>

            <h1 class="h1"><a href="guitar.php">Guitarras</a></h1>
            <h1 class="h1"><a href="sound.php">Dispositivos de Sonido</a></h1>

        </div>

        <div class="nav-section3">

            <form method="POST">
                <button class="btn btn-danger" name="fav-nav">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-bag-heart" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5Zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0ZM14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1ZM8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
                    </svg>
                </button>

               <button class="btn btn-info" name="cart-nav">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-cart2" viewBox="0 0 16 16">
                        <path
                            d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                    </svg>
                </button>
            </form>


                <?php if (isset($_SESSION["nombre"])): ?>
                    <a href="profile.php" class="h1"><?php echo $nav_title ?></a>
                <?php else: ?>
                    <a href="../form/login.php"><h1 class="h1"><?php echo $nav_title ?></h1></a>
                <?php endif;?>
        </div>

        <form action="" method="post">
            <?php if (isset($_SESSION["nombre"])) {?>
                <button class="cerrar-sesion" name="cerrar">Cerrar sesión</button>
            <?php }?>
        </form>

    </nav>

    <?php 

}


/**
 * Agrega un producto al carrito del usuario.
 * 
 * @param mysqli $conn La conexión a la base de datos.
 * @param int $id_cliente El ID del cliente.
 * @param int $id_producto El ID del producto a agregar.
 * 
 * @return void
 */

function add_to_cart($conn, $id_cliente, $id_producto) {
    // Consulta para obtener los detalles del producto
    $query = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Obtiene los detalles del producto
        $producto = $result->fetch_assoc();
    
        // Verifica si el producto ya está en el carrito
        $query = "SELECT * FROM carrito WHERE id_cliente = ? AND id_producto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id_cliente, $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // El producto ya está en el carrito, muestra un mensaje de error
            // "El producto ya se ha añadido al carrito";
        } else {
            // Agrega los detalles del producto al carrito en la base de datos
            $query = "INSERT INTO carrito (id_cliente, id_producto, nombre_producto, categoria, precio) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iisss", $id_cliente, $id_producto, $producto['nombre_producto'], $producto['categoria'], $producto['precio']);
            $stmt->execute();
    
            // Muestra un mensaje de éxito
            // "Añadido al carrito";
        }
    } else {
        echo "Inicie sesión para ver los productos";
    }
}

/**
 * Agrega un producto a la lista de favoritos del cliente.
 * 
 * @param mysqli $conn La conexión a la base de datos.
 * @param int $id_cliente El ID del cliente.
 * @param string $id_producto El ID del producto a agregar.
 * 
 * @return void
 */

function add_to_fav($conn, $id_cliente, $id_producto) {
    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION["nombre"]) && isset($_SESSION["id_cliente"])) {
        $nav_title = $_SESSION["nombre"];
    } else {
        $nav_title = "Iniciar Sesión";
    }

    // Consulta preparada para verificar si el producto ya se encuentra en favoritos para el usuario actual
    $query = "SELECT * FROM favoritos WHERE id_cliente = ? AND id_producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $id_cliente, $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el producto ya existe en la tabla de favoritos, devolver un mensaje al usuario
        echo "<p error-message>El producto ya se encuentra en tus favoritos.</p>";
    } else {
        // Si el producto no existe en la tabla de favoritos, agregarlo a la base de datos
        $query = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtiene los detalles del producto
            $producto = $result->fetch_assoc();

            // Agrega los detalles del producto a favoritos en la base de datos
            $query = "INSERT INTO favoritos (id_cliente, id_producto, nombre_producto, categoria, precio) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $id_cliente, $id_producto, $producto['nombre_producto'], $producto['categoria'], $producto['precio']);
            $stmt->execute();
        }
    }
}

/**
 * Mueve un producto de la lista de favoritos al carrito del cliente.
 * 
 * @param mysqli $conn La conexión a la base de datos.
 * @param int $id_cliente El ID del cliente.
 * @param string $nombre_producto El nombre del producto a mover al carrito.
 * 
 * @return void
 */

function fav_to_cart($conn, $id_cliente, $nombre_producto) {
    // Consulta preparada para verificar si el producto ya está en el carrito
    $check_cart_query = "SELECT * FROM carrito WHERE id_cliente = ? AND nombre_producto = ?";
    $stmt = $conn->prepare($check_cart_query);
    $stmt->bind_param("is", $id_cliente, $nombre_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El producto ya está en el carrito, muestra un mensaje de error
        echo "<p class='error-message'> El producto ya se encuentra en el carrito.</p>";
    } else {
        // Consulta preparada para obtener los detalles del producto desde favoritos
        $get_fav_query = "SELECT * FROM favoritos WHERE id_cliente = ? AND nombre_producto = ?";
        $stmt = $conn->prepare($get_fav_query);
        $stmt->bind_param("is", $id_cliente, $nombre_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtiene los detalles del producto desde favoritos
            $producto = $result->fetch_assoc();

            // Consulta preparada para agregar el producto al carrito
            $add_to_cart_query = "INSERT INTO carrito (id_cliente, id_producto, nombre_producto, categoria, precio) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($add_to_cart_query);
            $stmt->bind_param("iisss", $id_cliente, $producto['id_producto'], $producto['nombre_producto'], $producto['categoria'], $producto['precio']);
            $stmt->execute();

            // Consulta preparada para eliminar el producto de favoritos
            $delete_query = "DELETE FROM favoritos WHERE id_cliente = ? AND nombre_producto = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("is", $id_cliente, $nombre_producto);
            $stmt->execute();
        }
    }
}

/**
 * Genera la tabla HTML para mostrar los datos de usuario.
 * 
 * @param mysqli $conn La conexión a la base de datos.
 * @param int $id_cliente El ID del cliente.
 * 
 * @return void
 */

function profile_table($conn, $id_cliente) {
    include "../../parts/config.php";

    $id_cliente = $_SESSION["id_cliente"];

    // Obtener los productos en el carrito del usuario
    $sql = "SELECT * FROM usuarios WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Generar la tabla HTML para mostrar los productos en el carrito
    if ($result->num_rows > 0) {
        echo "<main>
                <h2 class='subtitulo'>Carrito de Compra</h2>
                <table class='tabla-carrito'>
                    <thead>
                        <tr>
                            <th class='encabezado'>Información</th>
                            <th class='encabezado'>Datos personales</th>
                            <th class='encabezado'>Editar</th>
                        </tr>
                    </thead>
                    <tbody>";

        while ($row = $result->fetch_assoc()) {
            $nombre = $row["nombre"];
            $correo = $row["correo"];
            $fecha_nacimiento = $row["fecha_nacimiento"];
            $direccion = $row["direccion"];
            $tarjeta = $row["tarjeta"];

            echo "<tr class='producto'>
                    <td class='nombre'>Nombre de usuario</td>
                    <td class='categoria'>$nombre</td>
                    <td><a href='edit_profile.php?id=$id_cliente&field=nombre'><svg class='edit' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z'/></svg></a></td>
                </tr>";

            echo "<tr class='producto'>
                    <td class='nombre'>Correo Electrónico</td>
                    <td class='categoria'>$correo</td>
                    <td><a href='edit_profile.php?id=$id_cliente&field=correo'><svg class='edit' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z'/></svg></a></td>
                </tr>";

            echo "<tr class='producto'>
                    <td class='nombre'>Fecha de nacimiento</td>
                    <td class='categoria'>$fecha_nacimiento</td>
                    <td><a href='edit_profile.php?id=$id_cliente&field=fecha_nacimiento'><svg class='edit' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z'/></svg></a></td>
                </tr>";

            echo "<tr class='producto'>
                    <td class='nombre'>Dirección</td>
                    <td class='categoria'>$direccion</td>
                    <td><a href='edit_profile.php?id=$id_cliente&field=direccion'><svg class='edit' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z'/></svg></a></td>
                </tr>";

            echo "<tr class='producto'>
                    <td class='nombre'>Nº de Tarjeta</td>
                    <td class='categoria'>$tarjeta</td>
                    <td>
                </tr>";
        }

        echo "</tbody></table></main>";
    } else {
        echo "<h1 class='session-message'>No existen datos de usuario</h1>";
    }
}

/**
 * Muestra una tabla con los usuarios que son administradores.
 * La tabla muestra los siguientes campos: DNI, Nombre, Correo Electrónico, Fecha de Nacimiento y Dirección.
 * Permite eliminar usuarios administradores (excepto el usuario actual).
 *
 * @param mysqli $conn La conexión a la base de datos
 * @param int $id_cliente El ID del cliente actual
 */
function admin_table($conn, $id_cliente) {
    // Obtener los usuarios que sean clientes
    $sql = "SELECT * FROM usuarios WHERE tipo = TRUE";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generar la tabla HTML para mostrar los usuarios
    if ($result->num_rows > 0) {
        echo "<main>
                <h2 class='subtitulo'>Tabla de Admin</h2>
                <table class='tabla-carrito'>
                    <thead>
                        <tr>
                            <th class='encabezado'>DNI</th>
                            <th class='encabezado'>Nombre</th>
                            <th class='encabezado'>Correo Electrónico</th>
                            <th class='encabezado'>Fecha de Nacimiento</th>
                            <th class='encabezado'>Dirección</th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($row = $result->fetch_assoc()) {
            $dni = $row["dni"];
            $nombre = $row["nombre"];
            $correo = $row["correo"];
            $fecha_nacimiento = $row["fecha_nacimiento"];
            $direccion = $row["direccion"];
            $tarjeta = $row["tarjeta"];

            // Verificar si el usuario actual es administrador y no es el usuario en la fila actual
            $currentAdmin = isset($_SESSION["correo"]) && $_SESSION["correo"] === $correo;
            $isAdministrator = $row["tipo"];
            $showDeleteButton = $isAdministrator && !$currentAdmin;

            echo "<tr class='producto'>
                    <td class='categoria'>$dni</td>
                    <td class='categoria'>$nombre</td>
                    <td class='categoria'>$correo</td>
                    <td class='categoria'>$fecha_nacimiento</td>
                    <td class='categoria'>$direccion</td>";

            echo "</tr>";
        }
        echo "</tbody></table></main>";
    } else {
        echo "<h1 class='session-message'>No existen datos de usuario</h1>";
    }
}

/**
 * Muestra una tabla con los usuarios que no son administradores.
 * La tabla muestra los siguientes campos: DNI, Nombre, Correo Electrónico, Fecha de Nacimiento, Dirección y Tarjeta.
 * Permite eliminar usuarios.
 * @param mysqli $conn La conexión a la base de datos
 * @param int $id_cliente El ID del cliente actual
 */
function users_table($conn, $id_cliente) {
    // Obtener los usuarios que sean clientes (no administradores)
    $sql = "SELECT * FROM usuarios WHERE tipo = FALSE";
    
    // Preparar la consulta SQL para su ejecución segura
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Obtener los resultados de la consulta
    $result = $stmt->get_result();

    // Generar la tabla HTML para mostrar los usuarios
    if ($result->num_rows > 0) {
        echo "<main>
                <h2 class='subtitulo'>Tabla de Usuarios</h2>
                <table class='tabla-carrito'>
                    <thead>
                        <tr>
                            <th class='encabezado'>DNI</th>
                            <th class='encabezado'>Nombre</th>
                            <th class='encabezado'>Correo Electrónico</th>
                            <th class='encabezado'>Fecha de Nacimiento</th>
                            <th class='encabezado'>Dirección</th>
                            <th class='encabezado'>Tarjeta</th>
                            <th class='encabezado'></th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($row = $result->fetch_assoc()) {
            $dni = $row["dni"];
            $nombre = $row["nombre"];
            $correo = $row["correo"];
            $fecha_nacimiento = $row["fecha_nacimiento"];
            $direccion = $row["direccion"];
            $tarjeta = $row["tarjeta"];

            echo "<tr class='producto'>
                    <td class='categoria'>$dni</td>
                    <td class='categoria'>$nombre</td>
                    <td class='categoria'>$correo</td>
                    <td class='categoria'>$fecha_nacimiento</td>
                    <td class='categoria'>$direccion</td>
                    <td class='categoria'>$tarjeta</td>";

            // Formulario para eliminar un usuario
            echo "<form method='POST'>
                        <input type='hidden' name='dni' value='$dni'>
                        <input type='hidden' name='correo' value='$correo'>
                        <td class='eliminar'><button name='delete' class='eliminar-carrito'>ELIMINAR</button></td>
                    </form>
                </tr>";
        }
        echo "</tbody></table></main>";
    } else {
        echo "<h1 class='session-message'>No existen datos de usuario</h1>";
    }
}

/**
 * Elimina un producto del carrito de un cliente.
 *
 * @param mysqli $conn Objeto de conexión a la base de datos.
 * @param int|null $id_cliente ID del cliente actual.
 * @param int $id_producto ID del producto a eliminar.
 */
function delete_from_cart($conn, $id_cliente, $id_producto) {

    $nombre_producto = $_POST["nombre_producto"];

    // Consulta para obtener los detalles del producto del carrito del cliente
    $query = "SELECT * FROM carrito WHERE id_cliente = ?";

    // Preparar la consulta SQL para su ejecución segura
    $stmt = $conn->prepare($query);

    // Asociar el parámetro de ID del cliente a la consulta
    $stmt->bind_param("i", $id_cliente);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados de la consulta
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        // Obtener los detalles del producto
        $producto = mysqli_fetch_assoc($result);

        // Eliminar la fila del producto seleccionado del carrito del cliente
        $query = "DELETE FROM carrito WHERE id_cliente = ? AND nombre_producto = ?";

        // Preparar la consulta SQL para su ejecución segura
        $stmt = $conn->prepare($query);

        // Asociar los parámetros de ID del cliente y nombre del producto a la consulta
        $stmt->bind_param("is", $id_cliente, $nombre_producto);

        // Ejecutar la consulta
        $stmt->execute();
    }
}

/**
 * Elimina un usuario de la base de datos, incluyendo registros relacionados en la tabla "carrito".
 *
 * @param mysqli $conn La conexión a la base de datos.
 * @param int $id_cliente El ID del cliente a eliminar.
 */

function delete_user($conn, $id_cliente) {

    $dni = $_POST["dni"];
    $correo = $_POST["correo"];

    // Verificar si existen registros relacionados en la tabla "carrito"
    $query = "SELECT * FROM carrito WHERE id_cliente IN (SELECT id_cliente FROM usuarios WHERE dni = ? AND correo = ?)";

    // Preparar la consulta SQL para su ejecución segura
    $stmt = $conn->prepare($query);

    // Asociar los parámetros a la consulta preparada
    $stmt->bind_param("ss", $dni, $correo);

    // Ejecutar la consulta preparada
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
  
    if ($result->num_rows > 0) {
        // Eliminar los registros relacionados en la tabla "carrito"
        $query = "DELETE FROM carrito WHERE id_cliente IN (SELECT id_cliente FROM usuarios WHERE dni = ? AND correo = ?)";

        // Preparar la consulta SQL para su ejecución segura
        $stmt = $conn->prepare($query);

        // Asociar los parámetros a la consulta preparada
        $stmt->bind_param("ss", $dni, $correo);

        // Ejecutar la consulta preparada
        $stmt->execute();
    }

    // Eliminar el cliente de la tabla "usuarios"
    $query = "DELETE FROM usuarios WHERE dni = ? AND correo = ?";

    // Preparar la consulta SQL para su ejecución segura
    $stmt = $conn->prepare($query);

    // Asociar los parámetros a la consulta preparada
    $stmt->bind_param("ss", $dni, $correo);

    // Ejecutar la consulta preparada
    $stmt->execute();
}
?>