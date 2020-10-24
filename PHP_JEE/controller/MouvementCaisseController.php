<?php
$CA_Num="-1";
$objet = new ObjetCollector();
$flagDateMvtCaisse = 0;

$datedeb= date("dmy");
$datefin= date("dmy");
$ca_no=-1;
$type=-1;
$protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
$flagCtrlTtCaisse = $protection->PROT_CTRL_TT_CAISSE;
$flagDateMvtCaisse = $protection->PROT_DATE_MVT_CAISSE;
$flagAffichageValCaisse = $protection->PROT_AFFICHAGE_VAL_CAISSE;

$admin=0;
if($protection->PROT_Right==1)
    $admin=1;

$caisse = new CaisseClass(0);
if($admin==0){
    $isPrincipal = 1;
    $rows = $caisse->getCaisseDepot($_SESSION["id"]);
    foreach($rows as $row)
        if($row->IsPrincipal==2)
            $ca_no = $row->CA_No;
}else{
    $rows = $caisse->listeCaisseShort();
}

if($ca_no==-1)
    if(sizeof($rows)>0)
        $ca_no = $rows[0]->CA_No;

$creglement = new ReglementClass(0);
$datapost = 0;
$modif= 0;
if(isset($_POST["RG_Modif"]))
    $modif = $_POST["RG_Modif"];

if(isset($_POST["dateReglementEntete_deb"])) {
    $datedeb = $_POST["dateReglementEntete_deb"];
    $datapost=1;
}
if(isset($_POST["dateReglementEntete_fin"]))
    $datefin = $_POST["dateReglementEntete_fin"];

if(isset($_POST["caisseComplete"]))
    $ca_no = $_POST["caisseComplete"];

if(isset($_POST["type_mvt_ent"]))
    $type = $_POST["type_mvt_ent"];
if(isset($_POST["libelle"])){
    $montant = str_replace(" ","",$_POST["montant"]);
    $login = $_SESSION["id"];
    $CA_Num="";
    if(isset($_POST["CA_Num"]))
        $CA_Num=$_POST["CA_Num"];
    $libelle = str_replace("'", "''", $_POST['libelle']);
    $rg_typereg=0;
    if(isset($_POST['rg_typereg']))
        $rg_typereg = $_POST['rg_typereg'];
    if($rg_typereg==6) $libelle=$libelle;
    $creglement->insertMvtCaisse($montant,$login,$CA_Num,$libelle,$rg_typereg,$_POST["CA_No"],$_POST['CG_NumBanque'],$modif,$creglement->formatSageToSqlDate($_POST['date']),$modif,$_POST['CA_No_Dest'],$_POST["CG_Analytique"],$_POST["rg_typeregModif"],$_POST["journalRec"],$_POST["RG_NoDestLigne"]);
}


?>
