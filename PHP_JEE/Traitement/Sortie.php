<?php
$login = "";
if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ArticleClass.php");
    include("../Modele/ProtectionClass.php");
$objet = new ObjetCollector();
$login = $_SESSION["login"];
$mobile = "";
}
$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$modif=0;
$client = "";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    if($_GET["quantite"]!=""){
        $qte=$_GET["quantite"];
        $prix = $_GET["prix"];
        $remise = $_GET["remise"];
        $cbMarq =  $_GET["cbMarq"];
        $typefac = $_GET["type_fac"];
        $cbMarqEntete = $_GET["cbMarqEntete"];
        $type_rem="P";
        $type_remise = 0;
        $login ="";
        if(isset($_GET["userName"]))
            $login = $_GET["userName"];
        $machine ="";
        if(isset($_GET["machineName"]))
            $machine = $_GET["machineName"];
        $docEntete = new DocEnteteClass($cbMarqEntete);
        if (isset($_GET["PROT_No"])) {
            $protection = new ProtectionClass("", "");
            $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
            $isVisu = $docEntete->isVisu($_SESSION["id"],"Sortie");
            if (!$isVisu) {
                if ($_GET["acte"] == "ajout_ligne") {
                    $ref_article = $_GET["designation"];
                    $docligne = new DocLigneClass(0, $objet->db);
                    echo $docligne->addDocligneSortieMagasinProcess($ref_article, $cbMarqEntete, $qte, $typefac, $machine,$_GET["PROT_No"]);
                } else {
                    $docligne = new DocLigneClass($cbMarq, $objet->db);
                    echo $docligne->modifDocligneFactureMagasin($qte, $prix, $typefac,$_GET["PROT_No"],$cbMarqEntete);
                }
            }
        }
    }
}

?>