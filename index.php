<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,200;9..40,400;9..40,1000&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/src/SVG/mancuerna_roja.svg" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/styles.css">
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>IRON</title>
</head>
<body>
    <header id="header">
        <h1>Cargando</h1>
    </header>
    <main id="main">
            <section class="nav"> 
                <img src="./src/SVG/logo_letra_blanco.svg" alt="">
                
                <button class="abrir-menu" id="abrir"><i class="bi bi-list"></i> </button>
            </section>

            <section class="menu" id="menu">
                <div class="options-menu" id="options_menu">
                    <button class="cerrar-menu" id="cerrar"><i class="bi bi-x-lg"></i></button>
                    <div class="links">
                        </br>
                        <?php 
                            if (isset($_SESSION['user_name'])){
                                echo '<a href="/logout.php">LOG OUT</a>';
                            }else{
                                echo '<a href="/login.php">LOG IN</a>';
                            }
                        ?> 
                        </br>
                        <a class="link" href="#Nosotros">US</a>
                        </br>
                        <a class="link" href="#Contactos">CONTACT</a>
                        </br>
                        <a class="update" id="update">UPDATE STATS</a>
                    </div>
                </div>
            </section>
            
            <section class="information">
                <div class="first_view">
                    <img class="mancuerna" src="./src/SVG/mancuerna_roja.svg" alt="">
                    <img class="escul2" src="./src/img/sculpture/escul2.png" alt="" width="100px" height="100px">
                    
                    <a class="start" href="/login.php"><h1>GET STARTED</h1></a>   
                    <p class="info">MORE INFO</p>
                    <p class="arrow"><i class="bi bi-arrow-down"></i></p>
                </div>



                <div class="second_view">
                    <h1>QUE </br>
                        ES  </br>
                        IRON
                    </h1>

                    <img class="escul1" src="./src/img/sculpture/escul1.png" alt="">

                    <p>
                    Iron es una aplicación 
                    dirigida al FanBase del mundo del hierro. Esta aplicación pretende llevar tu progreso en el gimnasio y ayudarte mejorar dependiendo de tus objetivos con diferentes
                    formulas y ayuda de profesionales en el sector del desarrollo físico. Prometemos mantenerte 
                    motivado con un sistema de progreso basado en niveles
                    como si de un videojuego se
                    tratase, a medidas que vas progresando tu nivel y ranking aumentaran haciéndote un
                    hueco así en el mundo del bodybiulding. Cada nivel tendrá 
                    su recompensa respectiva ("descuentos, equipación, entre muchos mas").
                    </p>
                </div>
            </section>
    </main>
    <script src="./src/JS/jsload.js"></script>
    <script src="./src/JS/menu_index.js"></script>
    

</body>
</html>