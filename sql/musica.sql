CREATE DATABASE IF NOT EXISTS musica;
USE musica;


CREATE USER 'miguel'@'localhost' IDENTIFIED BY 'wazowski';
GRANT ALL PRIVILEGES ON musica.* TO miguel@"%" IDENTIFIED BY "wazowski";
FLUSH PRIVILEGES;

/* TABLA DE USUARIOS */

CREATE TABLE usuarios (
    id_cliente INT(10) NOT NULL AUTO_INCREMENT,
    tipo BOOLEAN NOT NULL DEFAULT false,
    dni VARCHAR(9),
    nombre VARCHAR(255),
    correo VARCHAR(255),
    contrasena VARCHAR(255),
    fecha_nacimiento VARCHAR(10),
    tarjeta VARCHAR(12),
    direccion VARCHAR(255),
    PRIMARY KEY(id_cliente)
);


/* TABLA DE PRODUCTOS */

CREATE TABLE productos (
    id_producto INT NOT NULL AUTO_INCREMENT,
    nombre_producto VARCHAR(255),
    precio INT(4),
    imagen VARCHAR(255),
    categoria VARCHAR(255),
    PRIMARY KEY(id_producto)
);

INSERT INTO productos (nombre_producto, precio, imagen, categoria) VALUES 
    ("Fender 75 Aniversario", 1500, "../../../img/guitars/fender/Fender 75th Anniversary.png", "Guitarras Fender"),
    ("Fender Thomann Acústica", 1000, "../../../img/guitars/fender/Fender Thomann.png", "Guitarras Fender"),
    ("Fender Jazzmaster", 1800, "../../../img/guitars/fender/Fender Jazzmaster.png", "Guitarras Fender"),
    ("Strat Postmoderna", 2000, "../../../img/guitars/fender/Postmodern Strat.png", "Guitarras Fender"),
    ("Fender Squier Telecaster", 900, "../../../img/guitars/fender/Arctic White Stratocaster.png", "Guitarras Fender"),
    ("Stratocaster Ártica Blanca", 1200, "../../../img/guitars/fender/Fender Standard Stratocaster.png", "Guitarras Fender");

INSERT INTO productos (nombre_producto, precio, imagen, categoria) VALUES 
    ("Gibson Epiphone", 500, "../../../img/guitars/gibson/Gibson Epiphone.png", "Guitarras Gibson"),
    ("Gibson Kirk Hammett", 800, "../../../img/guitars/gibson/Gibson Kirk Hammett.png", "Guitarras Gibson"),
    ("Gibson Les Paul Negro Noche", 600, "../../../img/guitars/gibson/Gibson Les Paul Night Black.png", "Guitarras Gibson"),
    ("Gibson Les Paul Especial", 1500, "../../../img/guitars/gibson/Gibson Les Paul Special.png", "Guitarras Gibson"),
    ("Gibson Les Paul Estándar", 550, "../../../img/guitars/gibson/Gibson Les Paul Standard.png",  "Guitarras Gibson"),
    ("Gibson J-45 Estándar", 330, "../../../img/guitars/gibson/Gibson J-45 Standard.png",  "Guitarras Gibson");

INSERT INTO productos (nombre_producto, precio, imagen, categoria) VALUES 
    ("Ibáñez Rojo Carmesí", 400, "../../../img/guitars/ibanez/Ibanez Crimson Red.png", "Guitarras Ibáñez"),
    ("Ibáñez Electroacústica", 500, "../../../img/guitars/ibanez/Ibanez Electroacustic.png", "Guitarras Ibáñez"),
    ("Ibáñez Gio", 500, "../../../img/guitars/ibanez/Ibanez Gio.png", "Guitarras Ibáñez"),
    ("Ibáñez GRX40", 900, "../../../img/guitars/ibanez/Ibanez GRX40.png", "Guitarras Ibáñez"),
    ("Ibáñez Azul Mar", 600, "../../../img/guitars/ibanez/Ibanez Sea Blue.png", "Guitarras Ibáñez"),
    ("Ibáñez Moderna", 1200, "../../../img/guitars/ibanez/Ibanez Moderna.png", "Guitarras Ibáñez");

INSERT INTO productos (nombre_producto, precio, imagen, categoria) VALUES 
    ("Amplificador Fender", 350, "../../../img/amp/Fender Amp.png", "Amplificadores"),
    ("Amplificador Ibáñez", 600, "../../../img/amp/Ibanez Amp.png", "Amplificadores"),
    ("Amplificador Marshall", 300, "../../../img/amp/Marshall Amp.png", "Amplificadores"),
    ("Amplificador Vox", 440, "../../../img/amp/Vox Amp.png", "Amplificadores"),
    ("Amplificador Yamaha", 400, "../../../img/amp/Yamaha Amp.png", "Amplificadores"),
    ("Amplificador Fender Blanco", 800, "../../../img/amp/Amplificador Fender White.png", "Amplificadores");

INSERT INTO productos (nombre_producto, precio, imagen, categoria) VALUES 
    ("Altavoces MS1", 100, "../../../img/sound/Altavoces Basic 14-v2.png", "Cableado y Sonido"),
    ("Altavoces Basic 14-v2", 150, "../../../img/sound/Altavoces Focal Aria.png", "Cableado y Sonido"),
    ("Altavoces Focal Aria", 280, "../../../img/sound/ALTAVOCES MS1.png", "Cableado y Sonido"),
    ("Cableado de guitarra", 20, "../../../img/sound/Cableado de guitarra.png", "Cableado y Sonido"),
    ("Altavoces Herdio", 200, "../../../img/sound/Altavoces Herdio.png", "Cableado y Sonido"),
    ("Altavoces Archeer", 30, "../../../img/sound/Altavoces Archeer.png", "Cableado y Sonido");


/* TABLA DE COMPRAS */

CREATE TABLE compras (
    id_cliente INT(10) NOT NULL, 
    id_producto INT(10) NOT NULL,
    nombre_producto VARCHAR(255), 
    fecha VARCHAR(255),
    categoria VARCHAR(255),
    precio DECIMAL(8,2),
    FOREIGN KEY (id_cliente) REFERENCES usuarios(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
);



/* TABLA DE FAVORITOS */

CREATE TABLE favoritos (
    id_cliente INT(10) NOT NULL, 
    id_producto INT(10) NOT NULL,
    nombre_producto VARCHAR(255), 
    categoria VARCHAR(255),
    precio DECIMAL(8,2),
    FOREIGN KEY (id_cliente) REFERENCES usuarios(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
);




/* TABLA DE CARRITO */

CREATE TABLE carrito (
    id_cliente INT(10) NOT NULL, 
    id_producto INT(10) NOT NULL,
    nombre_producto VARCHAR(255), 
    categoria VARCHAR(255),
    precio DECIMAL(8,2),
    FOREIGN KEY (id_cliente) REFERENCES usuarios (id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
);



