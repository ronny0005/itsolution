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
    $mobile="";
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
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif") {

    if ($_GET["quantite"] != "") {
        $qte = $_GET["quantite"];
        $qte = str_replace(" ", "", $_GET["quantite"]);
        $prix = $_GET["prix"];
        $remise = $_GET["remise"];
        $aprix = 0;
        $cbMarq = $_GET["cbMarq"];
        $cbMarqEntete = $_GET["cbMarqEntete"];
        $type_fac = $_GET["type_fac"];
        $type_rem = "P";
        $type_remise = 0;
        $login = "";
        $docEntete = new DocEnteteClass($cbMarqEntete, $objet->db);
        if (isset($_GET["userName"])) $login = $_GET["userName"];
        $machine = "";
        if (isset($_GET["machineName"])) $machine = $_GET["machineName"];
        if (isset($_GET["PROT_No"])) {
            $protection = new ProtectionClass("", "", $objet->db);
            $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
            $isVisu = $docEntete->isVisu($_SESSION["id"],"Entree");
            if (!$isVisu) {
                if ($_GET["acte"] == "ajout_ligne") {
                    $ref_article = $_GET["designation"];
                    $docligne = new DocLigneClass(0, $objet->db);
                    echo $docligne->addDocligneEntreeMagasinProcess($ref_article, $cbMarqEntete, $qte, "1", "0", $prix, $type_fac, $machine,$_GET["PROT_No"]);
                } else {
                    $docligne = new DocLigneClass($cbMarq, $objet->db);
                    echo $docligne->modifDocligneFactureMagasin($qte, $prix, $type_fac,$_GET["PROT_No"],$cbMarqEntete);
                }
            }
        }
    }
}

?>