<?php
$instanceDB = new PDO(
    "mysql:host=127.0.0.1:3306;dbname=penzion;charset=utf8mb4",
    "root",
    "",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);


class Stranka {
    public $stareId = "";
    public $id;
    public $titulek;
    public $menu;
    public $obrazek;

    function __construct($argId, $argTitulek, $argMenu, $argObrazek) {
        $this->id = $argId;
        $this->titulek = $argTitulek;
        $this->menu = $argMenu;
        $this->obrazek = $argObrazek;
    }

    function getObsah () {
        if ($this->id == "") {
            return "";
        }else{
            $prikaz = $GLOBALS["instanceDB"]->prepare("SELECT * FROM stranka WHERE id=?");
            $prikaz->execute(array($this->id));
            $zaznam = $prikaz->fetch(PDO::FETCH_ASSOC);

            return $zaznam["obsah"];

        }
    }

    function setObsah($argNovyObsah) {
        $prikaz = $GLOBALS["instanceDB"]->prepare("UPDATE stranka SET obsah=? WHERE id=?");
        $prikaz->execute(array($argNovyObsah, $this->id));

    }

    function zapisDoDB() {

        if ($this->stareId == "") {
            //insert

            $prikaz = $GLOBALS["instanceDB"]->prepare("SELECT * FROM stranka ORDER BY poradi DESC");
            $prikaz->execute();
            $zaznam = $prikaz->fetch();
            if ($zaznam == null) {
                $poradi = 0;
            }else{
                $poradi = $zaznam["poradi"] + 1;
            }

            $prikaz = $GLOBALS["instanceDB"]->prepare("INSERT INTO stranka SET id=?,titulek=?, menu=?, obrazek=?, poradi=?");
            $prikaz->execute(array($this->id, $this->titulek, $this->menu, $this->obrazek, $poradi));
        }else{
            //update
            $prikaz = $GLOBALS["instanceDB"]->prepare("UPDATE stranka SET id=?, titulek=?, menu=?, obrazek=? WHERE id=?");
            $prikaz->execute(array($this->id, $this->titulek, $this->menu, $this->obrazek, $this->stareId));
        }
        
    }

    function smazSe() {
        $prikaz = $GLOBALS["instanceDB"]->prepare("DELETE FROM stranka WHERE id=?");
        $prikaz->execute(array($this->id));
    }

}

$prikaz = $instanceDB->prepare("SELECT * FROM stranka ORDER BY poradi");
$prikaz->execute();
$poleZaznamu = $prikaz->fetchAll(PDO::FETCH_ASSOC);

$poleStranek = [];
foreach($poleZaznamu AS $zaznam) {
    $poleStranek[$zaznam["id"]] = new Stranka($zaznam["id"], $zaznam["titulek"], $zaznam["menu"], $zaznam["obrazek"]);
}



$poleStranek = array(
    "domu" => new Stranka("domu", "Primapenzion", "Domů", "primapenzion-main.jpg"),
    "galerie" => new Stranka("galerie", "Fotogalerie", "Foto", "primapenzion-room.jpg"),
    "rezervace" => new Stranka("rezervace", "Rezervace", "Chci pokoj", "primapenzion-room2.jpg"),
    "kontakt" => new Stranka("kontakt", "Kontakt", "Napište nám", "primapenzion-sea.jpg"),
    "404" => new Stranka("404", "Stranka neexistuje", "", "primapenzion-pool-min.jpg"),
);
*/









/*
$poleStranek = [
    "domu" => [
        "id" => "domu",
        "titulek" => "Primapenzion",
        "menu" => "Domů",
        "obrazek" => "primapenzion-main.jpg"
    ],
    "galerie" => [
        "id" => "galerie",
        "titulek" => "Fotogalerie",
        "menu" => "Foto",
        "obrazek" => "primapenzion-room.jpg"
    ],
    "rezervace" => [
        "id" => "rezervace",
        "titulek" => "Rezervace",
        "menu" => "Chci pokoj",
        "obrazek" => "primapenzion-room2.jpg"
    ],
    "kontakt" => [
        "id" => "kontakt",
        "titulek" => "Kontakt",
        "menu" => "Napište nám",
        "obrazek" => "primapenzion-sea.jpg"
    ],
    "404" => [
        "id" => "404",
        "titulek" => "Stranka neexistuje",
        "menu" => "",
        "obrazek" => "primapenzion-pool-min.jpg"
    ]
];
*/
