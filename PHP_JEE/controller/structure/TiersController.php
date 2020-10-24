<?php

$intitule = "";
$adresse = "";
$compteg = "";
$codePostal = "";
$depot = 0;
$co_no = 0;
$region= "";
$ville="";
$nsiret="";
$identifiant="";
$tel="";
$mode_reglement="";
$catcompta="";
$affaire="";
$cattarif="";
$MR_No=0;
$protected = 0;
$flagNouveau = 0;
$flagProtected = 0;
$flagSuppr = 0;
$cbMarqTiers = 0;
$ctSommeil = 0;
$ctEncours = "";
$CT_ControlEnc = 0;
$objet = new ObjetCollector();

$comptet = new ComptetClass(0);


$type = "client";
//if($_GET["action"]==9) $type="fournisseur";
//if($_GET["action"]==17) $type="salarie";
if($_GET["type"]==1)
    $type= "fournisseur";
if($_GET["type"]==2)
    $type= "salarie";
$ncompte = $comptet->getCodeAuto($type);
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
if($type=="client"){
    $flagProtected = $protection->protectedType($type);
    $flagSuppr = $protection->SupprType($type);
    $flagNouveau = $protection->NouveauType($type);
}
if($type=="fournisseur" || $type=="salarie"){
    $flagProtected = $protection->protectedType($type);
    $flagSuppr = $protection->SupprType($type);
    $flagNouveau = $protection->NouveauType($type);
}

if(isset($_GET["CT_Num"])){
    $comptet = new ComptetClass($_GET["CT_Num"]);
//            $mode_reglement
        $ncompte = $comptet->CT_Num;
        $intitule = $comptet->CT_Intitule;
        $adresse = $comptet->CT_Adresse;
        $compteg = $comptet->CG_NumPrinc;
        $codePostal = $comptet->CT_CodePostal;
        $depot = $comptet->DE_No;
        $co_no = $comptet->CO_No;
        $region= $comptet->CT_CodeRegion;
        $ville= $comptet->CT_Ville;
        $nsiret= $comptet->CT_Siret;
        $identifiant= $comptet->CT_Identifiant;
        $tel= $comptet->CT_Telephone;
        $catcompta= $comptet->N_CatCompta;
        $cattarif= $comptet->N_CatTarif;
        $MR_No = $comptet->MR_No;
        $affaire = $comptet->CA_Num;
        $cbMarqTiers = $comptet->cbMarq;
        $ctSommeil = $comptet->CT_Sommeil;
        $ctEncours = $comptet->CT_Encours;
        $CT_ControlEnc = $comptet->CT_ControlEnc;
}

if(isset($_GET["ajouter"]) ||isset($_GET["modifier"]) ){
    $ncompte = $_GET["CT_Num"];
    $intitule = $_GET["CT_Intitule"];
    $adresse = $_GET["CT_Adresse"];
    $compteg = $_GET["CG_NumPrinc"];
    $codePostal = $_GET["CT_CodePostal"];
    $region= $_GET["CT_CodeRegion"];
    $ville= $_GET["CT_Ville"];
    $nsiret= $_GET["CT_Siret"];
    $identifiant= $_GET["CT_Identifiant"];
    $tel= $_GET["CT_Telephone"];
    $catcompta= $_GET["N_CatCompta"];
    $cattarif= $_GET["N_CatTarif"];
    $depot= $_GET["depot"];
    $affaire = $_GET["CA_Num"];
}
?>