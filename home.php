<?php
session_start();

include "../../parts/config.php";
include "../../parts/functions.php";

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION["nombre"]) && isset($_SESSION["id_cliente"])) {
    $nav_title = $_SESSION["nombre"];
} else {
    $nav_title = "Iniciar Sesión";
}

if(isset($_POST["fav-nav"])) {
    header("location:fav.php");
}

if(isset($_POST["cart-nav"])) {
    header("location:cart.php");
}

if(isset($_POST["cerrar"])) {
    include("../../parts/session_destroy.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soundwave | Home</title>
    <link rel="icon" type="image/x-icon" href="../../../img/icon/logo.ico">
    <link rel="stylesheet" href="../../../css/main.css">

</head>

<body>

<?php
echo nav_cliente();
?>


    <div class="images">

        <div class="example">
            <img class="background-image" src="../../../img/home/shop images/image_shop1.PNG" alt="">
            <div class="fadedbox">
                <div class="title text">Guitarras de todas las marcas</div>
            </div>
        </div>

        <div class="example">
            <img class="background-image" src="../../../img/home/shop images/image_shop2.PNG" alt="">
            <div class="fadedbox">
                <div class="title text">Productos de primera calidad</div>
            </div>
        </div>

        <div class="example">
            <img class="background-image" src="../../../img/home/shop images/image_shop3.PNG" alt="">
            <div class="fadedbox">
                <div class="title text">Abierto 24 horas</div>
            </div>
        </div>

    </div>

    <div class="info">
        <div class="section">
            <div class="menu-section">
                <h1 class="h1-section">¿Quiénes somos?</h1>
                <p class="text-section">Bienvenidos a Soundwave, la tienda de guitarras y dispositivos de sonido líder
                    en la industria. Ofrecemos una amplia variedad de instrumentos musicales de alta calidad y equipos
                    de sonido para todos los niveles, desde principiantes hasta expertos.
                </p>

                <p class="text-section">En Soundwave, nuestra pasión es ayudar a nuestros clientes a encontrar el
                    instrumento perfecto y el equipo de sonido adecuado para sus necesidades. Trabajamos con los mejores
                    fabricantes de guitarras y dispositivos de sonido del mundo para asegurarnos de ofrecer productos de
                    primera calidad.
                </p>

                <p class="text-section">Además, contamos con un equipo de expertos en música y sonido, que están
                    disponibles para brindarte asesoramiento personalizado y ayudarte a tomar las mejores decisiones de
                    compra. Nos enorgullece ofrecer un servicio al cliente excepcional y una experiencia de compra
                    única.
                </p>
            </div>

            <div class="example2">
                <img class="img-section" src="../../../img/home/section1/image_section1.PNG" alt="">
                <div class="fadedbox2">
                    <div class="title text">Busca tu instrumento ideal</div>
                </div>
            </div>
        </div>

        <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 319">
            <path fill="#273036" fill-opacity="1"
                d="M0,64L40,85.3C80,107,160,149,240,138.7C320,128,400,64,480,48C560,32,640,64,720,112C800,160,880,224,960,213.3C1040,203,1120,117,1200,106.7C1280,96,1360,160,1400,192L1440,224L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
            </path>
        </svg>
    </div>


    <div class="section2">
        <div class="section2-2"></div>
        <div class="example2">
            <img class="img-section" src="../../../img/home/section2/image-section2.PNG" alt="">
            <div class="fadedbox2">
                <div class="title text">Encuentra tu sonido perfecto</div>
            </div>
        </div>

        <div class="menu-section2">
            <h1 class="h1-section">¿Cuál es nuestro servicio?</h1>
            <p class="text-section">En Soundwave, también ofrecemos servicios de reparación y mantenimiento de
                instrumentos, así como clases y talleres de música. Nuestro objetivo es ayudar a nuestros clientes a
                alcanzar sus metas musicales, ya sea que estén aprendiendo a tocar un instrumento por primera vez o que
                sean músicos experimentados.
            </p>
            
            <p class="text-section">No busques más allá de Soundwave para todas tus necesidades de guitarras y
                dispositivos de sonido. ¡Ven a visitarnos hoy mismo y descubre por qué somos la tienda favorita de los
                músicos en todo el país!
            </p>
        </div>
    </div>

    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#273036" fill-opacity="1" d="M0,96L40,106.7C80,117,160,139,240,165.3C320,192,400,224,480,202.7C560,181,640,107,720,80C800,53,880,75,960,112C1040,149,1120,203,1200,192C1280,181,1360,107,1400,69.3L1440,32L1440,0L1400,0C1360,0,1280,0,1200,0C1120,0,1040,0,960,0C880,0,800,0,720,0C640,0,560,0,480,0C400,0,320,0,240,0C160,0,80,0,40,0L0,0Z"></path>
    </svg>
    </div>

    <div class="ratings">
        <h1 class="ratings-title">200k+ Opiniones Positivas</h1>
        <div class="comments">
            
            <div class="comment">
                <img class="person" src="../../../img/home/comments/person1.PNG" alt="">
                <div class="comment-section">
                    <img class="stars" src="../../../img/home/comments/5 stars.png" alt="">
                    <p class="opinion">"¡Esta tienda es increíble! Tienen una gran selección de guitarras de alta calidad y los precios son razonables. Además, el personal es muy amable y servicial. Definitivamente recomiendo esta tienda para cualquier músico en busca de una nueva guitarra o equipo de audio."</p>
                </div>
            </div>

            <div class="comment">
                <img class="person" src="../../../img/home/comments/person2.PNG" alt="">
                <div class="comment-section">
                    <img class="stars" src="../../../img/home/comments/5 stars.png" alt="">
                    <p class="opinion">"Tuve una experiencia fantástica comprando mi nueva guitarra aquí. El personal fue muy conocedor y me ayudó a encontrar la guitarra perfecta para mis necesidades. También me dieron buenos consejos sobre cómo cuidar mi guitarra y sacarle el máximo provecho. ¡Gracias!"</p>
                </div>
            </div>

            <div class="comment">
                <img class="person" src="../../../img/home/comments/person3.PNG" alt="">
                <div class="comment-section">
                    <img class="stars" src="../../../img/home/comments/5 stars.png" alt="">
                    <p class="opinion">"No puedo decir suficientes cosas buenas sobre esta tienda. Compré mi guitarra aquí y fue una gran experiencia. El personal es muy amable y servicial, y tienen una gran selección de guitarras de alta calidad. También ofrecen reparación y mantenimiento de guitarras, lo cual es genial.</p>
                </div>
            </div>
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

<script src="../../../code/code.js"></script>
</html>

<style>

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

@media screen and (max-width: 767px) {
    .logo {
        width: 30px;
        height: 30px;
        margin-top: 10px;
    }

    nav {
        width: 300px;
        margin: auto;
    }

    .nav-bar-dark {
        width: 300px;
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
    margin-top: 10px;
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
  width: 80%;
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