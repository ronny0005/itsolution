<?php
$login = "";
if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
    include("../Modele/Objet.php");
    include("../Modele/LogFile.php");
    include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ArticleClass.php");
    include("../Modele/DepotClass.php");
    include("../Modele/ProtectionClass.php");
    include("../Send/class.phpmailer.php");
$objet = new ObjetCollector();
$login = $_SESSION["login"];
$mobile="";
}

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    $docLigne = new DocLigneClass(0);
        if($_GET["quantite"]!="") {
            $qte = $_GET["quantite"];
            $prix = $_GET["prix"];
            $typefac = $_GET["type_fac"];
            $remise = $_GET["remise"];
            $cbMarq = $_GET["cbMarq"];
            $id_sec = $_GET["id_sec"];
            $cbMarqEntete = $_GET["cbMarqEntete"];
            if (isset($_GET["machineName"]))
                $machine = $_GET["machineName"];
            $ref_article = $_GET["designation"];
            echo json_encode($docLigne->ajoutLigneTransfert($qte, $prix, $typefac, $cbMarq, $cbMarqEntete, $_SESSION["id"], $_GET["acte"], $ref_article, $machine));
        }
}

?>