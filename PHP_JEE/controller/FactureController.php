<?php
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$objet = new ObjetCollector();

$cat_tarif=0;
$cat_compta=0;
$protected=0;
$flagNouveau = 1;
$flagProtected = 0;
$flagSuppr = 1;
$entete="";
$affaire="";
$souche="";
$co_no=0;
if($profil_commercial==1)
$co_no= $_SESSION["CO_No"];
$depot_no=0;
$modif=0;
$client = "";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
$dateEntete="";
$total_regle=0;
$avance=0;
$reste_a_payer = 0;
$caisse = 0;
$do_statut=2;
$cocheTransfert = 0;

if($_GET["type"]=="Devis"){
$qte_negative=0;
}
if($_GET["type"]=="PreparationCommande"){
$qte_negative=0;
}
if($_GET["type"]=="AchatPreparationCommande"){
$qte_negative=0;
}

$do_imprim = 0;
$souche=0;
$co_no=0;
$depot_no=0;
$caisse=0;
$depot_no = $_SESSION["DE_No"];
if(isset($_GET["depot"]))
$depot_no =$_GET["depot"];

// Données liées au client
$nomdepot="";
// Création de l'entete de document
$isModif = 1;
$isVisu = 1;
$isLigne = 0;
$docEntete = new DocEnteteClass(0);
if(isset($_GET["cbMarq"])){
$docEntete = new DocEnteteClass($_GET["cbMarq"]);
$do_imprim = $docEntete->DO_Imprim;
$client = new ComptetClass($docEntete->DO_Tiers);
$cat_tarif = $client->N_CatTarif;
$total_regle = $docEntete->ttc;
$avance=$docEntete->avance;
$reste_a_payer=$docEntete->resteAPayer;
if(sizeof($docEntete->listeLigneFacture())>1)
$isLigne=1;
}
$type=$_GET["type"];
$isModif = $docEntete->isModif($_SESSION["id"],$type);
$isVisu = $docEntete->isVisu($_SESSION["id"],$type);
$protected = $protection->PROT_Right;

if($docEntete->DO_Modif==1 && $isVisu)
    echo "<div class=\"alert alert-danger\">La date limite de modification du document est dépassée !</div>";

$readonly = false ;
$styleTicket = "";
//if($type == "Ticket" && !isset($_GET["visu"]) && !isset($_GET["modif"])) {
if($type == "Ticket" && (!isset($_GET["cbMarq"]))) {
    $readonly = true;
    $styleTicket ="pointer-events: none;";
}

$protectDate = 0;
if(!($type=="Vente" || $type=="VenteC" || $type=="BonLivraison" || $type=="Retour") && $flagDateVente!=0)
    $protectDate=1;
if(($type=="Achat" || $type=="AchatC" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande" || $type=="AchatPreparationCommande") && $flagDateAchat!=0)
    $protectDate=1;

//flag tiers
$client = new ComptetClass($docEntete->DO_Tiers);
$libclient = "Client";
$clientDisabled = "";
if($type!="Achat" && $type!="AchatC" && $type!="AchatRetour" && $type!="AchatRetourC" && $type!="PreparationCommande" && $type!="AchatPreparationCommande") {
    if($type=="Ticket" || (($type=="Vente" || $type=="VenteC" || $type=="VenteT") && $flagModifClient!=0) || $readonly
        || isset($_GET["cbMarq"]))
        $clientDisabled= "disabled";
}else{
    $libclient = "Fournisseur";
    if($type=="Ticket" || (($type=="Vente" || $type=="VenteC" || $type=="VenteT") && $flagModifClient!=0) || $readonly
        || isset($_GET["cbMarq"]))
        $clientDisabled= "disabled";
}

//cat tarif
$accesCatTarif = "";
$listeCatTarif = "";
if($protection->PROT_TARIFICATION_CLIENT!=0 || $isVisu) $accesCatTarif = "disabled";
$cattarif = new CatTarifClass(0);
foreach($cattarif->allCatTarif() as $row){
    $listeCatTarif = $listeCatTarif."<option value='{$row->cbIndice}'";
    if($row->cbIndice==$cat_tarif)
        $listeCatTarif = $listeCatTarif." selected";
    $listeCatTarif = $listeCatTarif. ">{$row->CT_Intitule}</option>";
}

//Cat compta
$accessCatCompta = "";
if ((isset($_GET["cbMarq"]) && $isLigne == 1) || $isVisu)
    $accessCatCompta = "disabled";

$listeCatCompta = "";
$catComptaClass = new CatComptaClass(0);
if($type=="Achat" || $type=="AchatC" ||$type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande")
    $rows=$catComptaClass->getCatComptaAchat();
else
    $rows=$catComptaClass->getCatCompta();
if($rows==null){
}else{
    foreach($rows as $row){
        $listeCatCompta = $listeCatCompta."<option value='{$row->idcompta}'";
        if($row->idcompta==$docEntete->N_CatCompta) $listeCatCompta = $listeCatCompta." selected";
        $listeCatCompta = $listeCatCompta.">{$row->marks}</option>";
    }
}

//Souche
$accessSouche = "";
$listeSouche="";
if(isset($_GET["cbMarq"]) || $isVisu) $accessSouche = "disabled";
$accesAffaire = ($isVisu || $readonly || (isset($_GET["cbMarq"]))) ? "disabled" : "";
if($admin==1 && $type!="Retour" && $type!="BonLivraison"&& $type!="Devis")
    $listeSouche= $listeSouche."<option value=''></option>";
$isPrincipal = 0;
if($admin==0){

    $isPrincipal = 1;
    $rows = $protection->getSoucheDepotGrpSouche($protection->Prot_No,$type);
}else{
    if($type=="Achat" || $type=="AchatC" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande" || $type=="AchatPreparationCommande" )
        $rows = $protection->getSoucheAchat();
    else
        $rows = $protection->getSoucheVente();
}
if($rows==null){
}else{
    foreach($rows as $row){
        if ($isPrincipal == 0) {
            $listeSouche = $listeSouche."<option value='{$row->cbIndice}'";
            if($row->cbIndice==$docEntete->DO_Souche) $listeSouche = $listeSouche." selected";
            $listeSouche = $listeSouche. ">{$row->S_Intitule}</option>";
        } else {
            if ($row->IsPrincipal == 1) {
                $listeSouche = $listeSouche."<option value=".$row->cbIndice."";
                if($row->cbIndice==$docEntete->DO_Souche) $listeSouche = $listeSouche." selected";
                $listeSouche = $listeSouche.">{$row->S_Intitule}</option>";
            }
        }
    }
}

// affaire
$accessAffaire = "";
$listeAffaire = "";
if($isVisu || $readonly || (isset($_GET["cbMarq"])))
    $accessAffaire = "disabled";

if($admin!=0){
    $listeAffaire = $listeAffaire."<option value=''></option>";
}

if($admin==0){
    $isPrincipal = 1;
    $rows = $protection->getSoucheDepotGrpAffaire($_SESSION["id"],$type,0);
}else{
    $rows = $protection->getAffaire(0);
}
if($rows==null){
}else{
    foreach($rows as $row)
        if ($isPrincipal == 0) {
            $listeAffaire = $listeAffaire."<option value='{$row->CA_Num}'";
            if($row->CA_Num==$docEntete->CA_Num) $listeAffaire = $listeAffaire. " selected ";
            $listeAffaire =  $listeAffaire. ">{$row->CA_Intitule}</option>";
        } else {
            if ($row->IsPrincipal == 1) {
                $listeAffaire = $listeAffaire."<option value='{$row->CA_Num}'";
                if($row->CA_Num==$docEntete->CA_Num) $listeAffaire = $listeAffaire." selected ";
                $listeAffaire = $listeAffaire.">{$row->CA_Intitule}</option>";
            }
        }
}

//Date
$accesDate = "";
$valueDate ="";
if($docEntete->DO_Date!="")
    $valueDate =$docEntete->DO_DateSage;
if(isset($_GET["cbMarq"]) || (!isset($_GET["cbMarq"]) && $protectDate!=0))
    $accesDate = "disabled";
else if($readonly)
    $accesDate = "disabled";

//Depot
$accesDepot = "";
if($isVisu || $readonly || (isset($_GET["cbMarq"])))
    $accesDepot ="disabled";

$isPrincipal = 0;
if($admin==0){
    $isPrincipal = 1;
    $depotUserClass = new DepotUserClass();
    $rows=$depotUserClass->getDepotUser($protection->Prot_No);
}
else{
    $depotClass= new DepotClass(0);
    $rows = $depotClass->alldepotShortDetail();
}

$depot="";
$listeDepot="";
if($rows==null){
}else{

    foreach($rows as $row) {
        if ($isPrincipal == 0) {
            $listeDepot = $listeDepot."<option value='{$row->DE_No}'";
            if ($row->DE_No == $docEntete->DE_No) $listeDepot= $listeDepot. " selected";
            $listeDepot = $listeDepot.">{$row->DE_Intitule}</option>";
        } else {
            if ($row->IsPrincipal == 1) {
                $listeDepot = $listeDepot."<option value='{$row->DE_No}'";
                if ($row->DE_No == $docEntete->DE_No) $listeDepot = $listeDepot." selected";
                $listeDepot = $listeDepot.">{$row->DE_Intitule}</option>";
            }
        }
    }
}

// Collaborateur
$accesCollaborateur = "";
$listeCollaborateur ="";
if ($readonly || $isVisu)
    $accesCollaborateur = "disabled";

$collaborateur = new CollaborateurClass(0);
if($_GET["type"]=="Achat" || $type=="AchatC" || $_GET["type"]=="AchatRetour" || $type=="AchatRetourC" || $_GET["type"]=="PreparationCommande" || $type=="AchatPreparationCommande" ){
    $rows =  $collaborateur->allAcheteur(1);
}else{
    $rows =  $collaborateur->allVendeur();
}

foreach($rows as $row){
    $listeCollaborateur = $listeCollaborateur."<option value='{$row->CO_No}'";
    if($row->CO_No==$docEntete->CO_No) $listeCollaborateur = $listeCollaborateur." selected";
    $listeCollaborateur = $listeCollaborateur.">{$row->CO_Nom}</option>";
}

$accesCaisse = "";
$listeCaisse= "";
if ($readonly || isset($_GET["cbMarq"]) || $isVisu)
    $accesCaisse = "disabled";

$isPrincipal = 0;
$caisseClass = new CaisseClass(0);
if($admin==0){
    $isPrincipal = 1;
    $rows = $caisseClass->getCaisseDepot($protection->Prot_No);
}else{
    $listeCaisse = $listeCaisse. "<option value=''";
    if($docEntete->CA_No=="") $listeCaisse = $listeCaisse." selected ";
    $listeCaisse = $listeCaisse. "></option>";
    $rows = $caisseClass->allCaisse();
}
if($rows==null){
}else{
    foreach($rows as $row){
        if ($isPrincipal == 0) {
            $listeCaisse = $listeCaisse."<option value='{$row->CA_No}'";
            if($type=="Achat" || $type=="AchatC" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande" || $type=="AchatPreparationCommande" ){
                if(isset($_GET["entete"]) && $row->CA_No==$docEntete->CA_No) $listeCaisse = $listeCaisse." selected";
            }else{
                if($row->CA_No==$docEntete->CA_No) $listeCaisse = $listeCaisse." selected";
            }
            $listeCaisse = $listeCaisse.">{$row->CA_Intitule}</option>";
        } else {
            if ($row->IsPrincipal == 1) {

                $listeCaisse = $listeCaisse."<option value='{$row->CA_No}'";
                if($type=="Achat" || $type=="AchatC" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="PreparationCommande" || $type=="AchatPreparationCommande" ){
                    if(isset($_GET["entete"]) && $row->CA_No==$docEntete->CA_No) $listeCaisse = $listeCaisse." selected";
                }else{
                    if($row->CA_No==$docEntete->CA_No) $listeCaisse = $listeCaisse." selected";
                }
                $listeCaisse = $listeCaisse.">{$row->CA_Intitule}</option>";
            }
        }
    }
}

//reference

$valueRef = $docEntete->DO_Ref;
$accessReference = "" ;
if($isVisu) $accessReference ="readonly";

//statut
$accessStatut = "";
$listeStatut ="";
if ($readonly || $isVisu)
    $accessStatut = "disabled";

if( $type!="AchatRetour" && $type!="AchatRetourC" && $type!="Achat" && $type!="AchatC" && $type!="PreparationCommande" && $type!="AchatPreparationCommande" ) {
    $typeparam = $type;
    if($type=="VenteRetour") $typeparam ="Retour";
    $rows = $docEntete->getStatutVente($typeparam);
}
else {
    $typeach = $type;
    if($type=="AchatPreparationCommande") $typeach ="PreparationCommande";
    if($type=="AchatRetour") $typeach ="Retour";

    $rows = $docEntete->getStatutAchat($typeach);
}
if($rows==null){
}else{
    foreach($rows as $row){
        $listeStatut  = $listeStatut ."<option value='{$row->Val}'";
        if($row->Val==$docEntete->DO_Statut) $listeStatut = $listeStatut ." selected ";
        $listeStatut = $listeStatut .">{$row->Lib}</option>";
    }
}

// ligne référence
$accessARRef = "";
if (!isset($_GET["cbMarq"]) || $isVisu) $accessARRef = "disabled";

//Désignation
$accessDesignation = "";
if (!isset($_GET["cbMarq"]) || $isVisu) $accessDesignation = "disabled";

//Quantité
$accessQte = "";
$libQte="Qté";
if(!isset($_GET["cbMarq"]) || $isVisu) $accessQte  = "disabled";

//Prix
$accessPrix = "";
if ($flagPxVenteRemise != 0)
    $accessPrix =" readonly ";


//Remise

$accessRemise = "";
if($flagPxVenteRemise!=0) $accessRemise= " readonly ";

//PU ttc
$accessPUTTC = "";

if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0)) {
    $accessPUTTC = "style='display:none'";
    $accessPrix ="style='display:none'";
}
$accessMontantHT = "";
if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
    $accessMontantHT ="style='display:none'";
$accessMontantTTC = "";
if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
    $accessMontantTTC ="style='display:none'";

// Liste règlement
$listeReglement = "";
$creglement  = new ReglementClass(0);
$rows = $creglement->getReglementByClientFacture($docEntete->cbMarq);
if($rows==null){
    $listeReglement = "";
}else{
    foreach ($rows as $row){
        $date=date("d-m-Y", strtotime($row->RG_Date));
        $dr_date=date("d-m-Y", strtotime($row->DR_Date));
        if($date=="01-01-1970" || $date=="01-01-1900") $date="";
        if($dr_date=="01-01-1970" || $dr_date=="01-01-1900") $dr_date="";
        $listeReglement =  $listeReglement ."<tr>
                                                    <td>$date</td>
                                                    <td>$dr_date</td>
                                                    <td>{$row->RG_Libelle}</td>
                                                    <td>{$objet->formatChiffre(round($row->RG_Montant))}</td>
                                                    <td>{$objet->formatChiffre(round($row->CUMUL))}</td>
                                                    </tr>";
    }
}

// liste saisie
$accessListeSaisie = "style='display:none'";
if($type=="PreparationCommande" || $type=="AchatPreparationCommande")
    $accessListeSaisie = "";

$bloqueReglement = 0;
if($type=="Vente" && $protection->PROT_GEN_ECART_REGLEMENT!=0) {
    $bloqueReglement =1;
}

?>