<?php
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$objet = new ObjetCollector();
$depot=0;
$datedeb=date("dmy");
$datefin=date("dmy");
$client='0';

$depotUserClass = new DepotUserClass(0,$objet->db);
$rows=$depotUserClass->getDepotUser($_SESSION["id"]);
if(sizeof($rows)>1)
    $depot = 0;
if(sizeof($rows)==1)
    $depot = $rows[0]->DE_No;
if(isset($_POST["datedebut"]) && $_POST["datedebut"]!="")
    $datedeb=$_POST["datedebut"];
if(isset($_POST["datefin"]) && $_POST["datefin"]!="")
    $datefin=$_POST["datefin"];
if(isset($_POST["depot"]))
    $depot=$_POST["depot"];
if(isset($_POST["client"]) && !empty($_POST["client"]))
    $client=$_POST["client"];
if(isset($_POST["type"]))
    $type=$_POST["type"];
else
    $type=$_GET["type"];
$admin=0;
if($protection->PROT_Administrator==1 || $protection->PROT_Right==1)
    $admin=1;

$typeListe= "documentVente";
$typeDoc = 0;
if($type=="Sortie" || $type=="Entree" || $type=="Transfert" || $type=="TransfertDetail"|| $type=="Transfert_confirmation" || $type=="Transfert_valid_confirmation")
    $typeListe = "documentStock";
if($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatRetour" || $type=="PreparationCommande" || $type=="AchatPreparationCommande") {
    $typeListe = "documentAchat";
    $typeDoc = 1;
}


$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$protected = $protection->protectedType($type);

$protectedSuppression = $protection->SupprType($typeListe);
$protectedNouveau = $protection->NouveauType($type);
$action=0;
if(isset($_GET["action"])) $action = $_GET["action"];
if(isset($_GET["module"])) $module = $_GET["module"];
$titre="";

function lienfinal($entete,$type,$cbMarq,$do_domaine,$do_type,$protectedDocP){
    if($type!="VenteDevise" && $type!="Retour" && $type!="Avoir") {
        if ($do_domaine == 0 && $do_type == 6)
            $type = "Vente";
    }

    if($do_domaine ==0 && $do_type==7)
        $type="VenteC";

    if($type!="AchatRetour" && $type!="AchatRetourC" && $type!="AchatRetourT") {
        if ($do_domaine == 1 && $do_type == 16)
            $type = "Achat";
    }
    if($do_domaine ==1 && $do_type==17)
        $type="AchatC";
    if($do_domaine ==3 && $do_type==30)
        $type="Ticket";

    if($type=="BonLivraison" ||$type == "Retour" ||$type == "Vente" ||$type == "VenteDevise" ||$type == "VenteC"||$type == "VenteT"||$type == "RetourC"||$type == "RetourT" ||$type == "AchatC" ||$type == "AchatT" || $type == "Achat"
        ||$type == "AchatRetourC" ||$type == "AchatRetourT" || $type == "AchatRetour"|| $type == "PreparationCommande"|| $type == "AchatPreparationCommande"){
        return lien($entete, $type, $cbMarq) ;//. $complement;
    }
    else {
        if($protectedDocP==0)
            return lien($entete, $type, $cbMarq); //. "&visu=1";
        else
            return lien($entete, $type, $cbMarq); //. "&modif=1";
    }
}

function lien ($entete,$type,$cbMarq){
    $lienentete="";
    $lienfinal="";
    if($entete!="")
        $lienentete="-$cbMarq";
    if($type !="Entree" && $type !="Sortie" && $type !="Transfert" && $type !="Transfert_detail" && $type !="Emission" && $type !="Confirmation")
        $lienfinal = "Document-Facture$type{$lienentete}";
    else
        $lienfinal = "Document-Mvt$type{$lienentete}";

    return $lienfinal;
}

// Liste des dépots
$listeDepot ="";
$depotUserClass = new DepotUserClass();
$rows=$depotUserClass->getDepotUser($protection->Prot_No);
if(sizeof($rows)>1){
    $listeDepot = "<option value='0'";
    if('0'== $depot) $listeDepot = $listeDepot." selected ";
    $listeDepot = $listeDepot.">TOUS LES DEPOTS</option>";
}

if($rows==null){
}else{
    $var = 0;
    foreach($rows as $row) {
        $listeDepot = $listeDepot."<option value={$row->DE_No}";
        if ($row->DE_No == $depot)
            $listeDepot= $listeDepot." selected";
        $listeDepot = $listeDepot.">{$row->DE_Intitule}</option>";
        $var++;
    }
}


// affiche le filtre sur le tiers
$afficheListeTiers =" style ='display:none' ";
$libTiers = "Client";
$libToutTiers = "TOUS LES CLIENTS";

$libClient="";
$libClient="TOUS LES CLIENTS";
if($type=="Achat"||$type=="AchatT"||$type=="AchatC"
    || $type=="AchatRetour"||$type=="AchatRetourT"||$type=="AchatRetourC"
    || $type=="AchatPreparationCommande"||$type=="PreparationCommande")
    $libClient="TOUS LES FOURNISSEURS";

if(isset($_POST["client"]))
    $client = $_POST["client"];
if(isset($_POST["libClient"]))
    $libClient = $_POST["libClient"];
if($type=="Vente" || $type=="Ticket" || $type=="VenteC" || $type=="BonLivraison" || $type=="Devis" || $type=="Retour" || $type=="Avoir"
    || $type=="Achat" || $type=="AchatT"|| $type=="AchatC" || $type=="RetourT"|| $type=="RetourC") {
    $afficheListeTiers = "";
    if ($type == "Achat" || $type == "AchatC" || $type == "AchatRetour" || $type == "AchatRetourC" || $type == "AchatPreparationCommande" || $type == "PreparationCommande") {
        $libTiers = "Fournisseur";
        $libToutTiers = "TOUS LES FOURNISSEURS";
    }
}

// Nouvealle facture
$afficheBoutonNouveau = " style='display:none' ";
if($protectedNouveau && ($type!="VenteC" || $type!="RetourC"))
    $afficheBoutonNouveau="";

// type de facture
$listeTypeFacture="";
$afficheTypeFacture = " style='display:none' ";
if($type=="Vente" || $type=="VenteC" || $type=="VenteT" || $type=="RetourT" || $type=="RetourC" || $type=="Retour"){
    $afficheTypeFacture = "";
    $selected="";
    $value="";
    if($type=="VenteT" || $type=="Vente" || $type=="VenteC")
        $value="VenteT";
    else
        $value="RetourT";
    if($type=="VenteT" || $type=="RetourT")
        $selected=" selected ";
    $listeTypeFacture="<option value='$value' $selected>Tous</option>";

    $selected="";
    $value="";
    if($type=="VenteT" || $type=="Vente" || $type=="VenteC")
        $value="Vente";
    else
        $value="Retour";

    if($type=="Vente" || $type=="Retour")
        $selected=" selected ";
    $listeTypeFacture=$listeTypeFacture."<option value='$value' $selected>Facture</option>";

    $selected="";
    $value="";
    if($type=="VenteT" || $type=="Vente" || $type=="VenteC")
        $value="VenteC";
    else
        $value="RetourC";

    if($type=="VenteC" || $type=="RetourC")
        $selected=" selected ";
    $listeTypeFacture=$listeTypeFacture."<option value='$value' $selected>Facture comptabilisée</option>";
}


if($type=="Achat" || $type=="AchatC"|| $type=="AchatT"
    || $type=="AchatRetour" || $type=="AchatRetourC"|| $type=="AchatRetourT" ){
    $afficheTypeFacture = "";
         $valueT = "AchatT";
            $value = "Achat";
            $valueC = "AchatC";
            $selected="";
            $selectedC="";
            $selectedT="";
    if($type=="AchatRetourT") {$valueT = "AchatRetourT"; $selectedT="selected";}
    if($type=="AchatRetour") {$value = "AchatRetour";$selected="selected";}
    if($type=="AchatRetourC") {$valueC = "AchatRetourC";$selectedC="selected";}
    if($type=="AchatT") {$selectedT="selected";}
    if($type=="Achat") {$selected="selected";}
    if($type=="AchatC") {$selectedC="selected";}
    $listeTypeFacture=$listeTypeFacture."<option value='$valueT' $selectedT>Tous</option>";
    $listeTypeFacture=$listeTypeFacture."<option value='$value' $selected >Facture</option>";
    $listeTypeFacture=$listeTypeFacture."<option value='$valueC' $selectedC >Facture comptabilisée</option>";

}


?>
