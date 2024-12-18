<?php
session_start();

require_once "./data.php";

if(array_key_exists("login", $_POST)) {
    $zadaneJmeno = $_POST["jmeno"];
    $zadaneHeslo = $_POST["heslo"];

    if ($zadaneJmeno == "admin" && $zadaneHeslo == "cici123") {
        $_SESSION["jePrihlasen"] = true;
    }
}

if (array_key_exists("logout", $_GET)) {
    unset($_SESSION["jePrihlasen"]);
    header("Location: ?");
    exit;
}

//tyto formularove operace budeme zpracovavat jen pokud je uzivatel opravu prihlaseny
if(array_key_exists("jePrihlasen", $_SESSION)) {
    
    //uzivatel chce stranku ulozit
    if (array_key_exists("aktualizovat", $_POST)) {
        $obsahStranky = $_POST["obsah-stranky"];
        
        if (array_key_exists("edit", $_GET)) {
            //pokud stranka existuje, tak si ji vytahneme z pole
            $idStranky = $_GET["edit"];
            $aktivniStranka = $poleStranek[$idStranky];
        }else{
            $idStranky = ""; //toto znamena ze se jedna o uplne novou stranku
            //stranka v poli neexistuje, vytvorime novy objekt
            $aktivniStranka = new Stranka("", "", "", "");
        }
        
        //funkce trim odstrani vsehcny mezery pred a za textem
        $noveId = trim($_POST["id-stranky"]);
        $noveId = $_POST["id-stranky"];
        $noveMenu = $_POST["menu-stranky"];
        $novyTitulek = $_POST["titulek-stranky"];
        $novyObrazek = $_POST["obrazek-stranky"];

        //hlidac
        //zda id neni prazdne?
        if ($noveId == "") {
            //id je prazdne logiku ukoncime a presmerujeme uzivatele pryc
            header("Location: ?");
            exit;
        }

        $aktivniStranka->stareId = $idStranky;
        $aktivniStranka->id = $noveId;
        $aktivniStranka->titulek = $novyTitulek;
        $aktivniStranka->menu = $noveMenu;
        $aktivniStranka->obrazek = $novyObrazek;

        $aktivniStranka->zapisDoDB();

        $aktivniStranka->setObsah($obsahStranky);

        header("Location: ?");
        exit;
    }

    //uzivatel chce zobrazit formular pro editovani
    if (array_key_exists("edit", $_GET)) {
        //admin.php?edit=rezervace
        $idStranky = $_GET["edit"];
        //ulozime do promnne obejkt stranky
        $aktivniStranka = $poleStranek[$idStranky];
    }

    //uzivatel chce zacit editovat novou stranku
    if (array_key_exists("nova-stranka", $_POST)) {
        $aktivniStranka = new Stranka("", "", "", "");
    }

     //uzivatel chce smazat stranku
     if (array_key_exists("delete", $_GET)) {
        $idStranky = $_GET["delete"];
        $poleStranek[$idStranky]->smazSe();
        header("Location: ?");
        exit;
     }


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin sekce</title>
</head>
<body>
    <h1>Admin sekce</h1>

    <?php
    if(array_key_exists("jePrihlasen", $_SESSION)) {
        echo "<p>Jste prihlasen!</p>";
        echo "<a href='?logout'>Odhlasit se</a>";

        ?>
        <hr>
        <form action="" method="post">
            <button type="submit" name="nova-stranka">Pridat novou stranku</button>
        </form>
        <?php


        echo "<ul>";
        foreach($poleStranek AS $stranka) {
            echo "<li>
                <a href='?edit={$stranka->id}'>
                    {$stranka->id}
                </a>
                <a href='?delete={$stranka->id}'>
                    [ODSTRANIT]
                </a>
            </li>";
        }
        echo "</ul>";


        if (isset($aktivniStranka)) {
            require "./komponenty/admin-editace-formular.php";
        }else{
            echo "<p>Vyberte jakou stranku chcete editovat.</p>";
        }

    }else{
        ?>
        <form method="post">
            <div>
                <label for="input-jmeno">Jmeno:</label>
                <input type="text" name="jmeno" id="input-jmeno">
            </div>

            <div>
                <label for="input-heslo">Heslo:</label>
                <input type="password" name="heslo" id="input-heslo">
            </div>

            <div>
                <button type="submit" name="login">Prihlasit se</button>
            </div>
        </form>
        <?php
    }

    ?>


    

</body>
</html>