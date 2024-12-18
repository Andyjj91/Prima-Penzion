<?php
require_once "./data.php";

//vychozi stranka, homepage
$idStranky = array_keys($poleStranek)[0];

//zjisitme jakou stranku uzivatel chce zobrazit
if (array_key_exists("stranka", $_GET)) {

    if (array_key_exists($_GET["stranka"], $poleStranek)) {
        $idStranky = $_GET["stranka"];
    }else{
        $idStranky = "404";
    }
    
}


?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $poleStranek[$idStranky]->titulek; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>

<body>

    <header>
        <div class="container">

            <div class="headerTop">
                <a class="odkaz" href="tel:+420606123456">+420 / 606 123 456</a>
                <div class="ikony">
                    <a href="#" target="_blank">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" target="_blank">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>

            <a class="logo" href="index.html">prima<br>penzion</a>

            <?php require "./komponenty/menu.php" ?>

        </div>

        <img src="img/<?php echo $poleStranek[$idStranky]->obrazek; ?>" alt="PrimaPenzion">

    </header>



    <!-- sem budeme vkladat obsah -->
    <?php

        echo $poleStranek[$idStranky]->getObsah();

        //require "./{$idStranky}.html";
        //echo file_get_contents("./galerie.html");

    ?>

    <footer>

        <div class="pata">

            <?php require "./komponenty/menu.php" ?>

            <a class="logo" href="index.html">prima<br>penzion</a>

            <div class="pataInfo">
                <p>
                    <i class="fa-solid fa-map-pin"></i>
                    <a class="odkaz" href="https://maps.app.goo.gl/AXDodHC6DvrgCKN76" target="_blank">
                        <strong>PrimaPenzion</strong>, Jablonského 2, Praha 7
                    </a>
                </p>
                <p>
                    <i class="fa-solid fa-phone"></i>
                    <a class="odkaz" href="tel:+420606123456">+420 / 606 123 456</a>
                </p>
                <p>
                    <i class="fa-solid fa-envelope"></i>
                    <span>info@primapenzion.cz</span>
                </p>
            </div>


            <div class="ikony">
                <a href="#" target="_blank">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="#" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" target="_blank">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>

        </div>

        <div class="copy">
            &copy; <strong>Primapenzion</strong> 2024
        </div>
        

    </footer>

</body>

</html>