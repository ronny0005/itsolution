<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/scriptFactureVente.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
//$objet = new ObjetCollector();
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
$result=$objet->db->requete($objet->getParametre($_SESSION["id"]));     
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}else{ 
    $souche=$rows[0]->CA_Souche;
    $co_no=$rows[0]->CO_No;
    $depot_no=$rows[0]->DE_No;
    $caisse=$rows[0]->CA_No;
}   
    $depot_no = $_SESSION["DE_No"];
    if(isset($_GET["depot"]))
        $depot_no =$_GET["depot"];
    
    // Données liées au client
    $nomdepot="";
    // Création de l'entete de document
$isModif = 1;
$isVisu = 1;
$isLigne = 0;
$isSecurite = 0;
$isSecurite = $protection->IssecuriteAdmin(0);
    $docEntete = new DocEnteteClass(0,$objet->db);
    if(isset($_GET["cbMarq"])){
        $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
        $do_imprim = $docEntete->DO_Imprim;
        $client = new ComptetClass($docEntete->DO_Tiers,$objet->db);
        $cat_tarif = $docEntete->DO_Tarif;
        $total_regle = $docEntete->ttc;
        $avance=$docEntete->avance;
        $reste_a_payer=$docEntete->resteAPayer;
        $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
        if(sizeof($docEntete->listeLigneFacture())>1)
            $isLigne=1;
    }
    $type=$_GET["type"];
    if($type!="Devis") {
        $isModif = $docEntete->isModif($protection->PROT_Administrator, $protection->PROT_Right, $protection->protectedType($type), $flagProtApresImpression,$isSecurite);
        $isVisu = $docEntete->isVisu($protection->PROT_Administrator, $protection->protectedType($type), $flagProtApresImpression,$isSecurite);
    }else{
        $isModif =1;
        $isVisu = 0;
    }
    if($protection->ProtectAdmin==1)
        $admin=0;
    $protected = $protection->PROT_Right;
?>
<div id="milieu">    
    <div class="container">
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<div class="col-md-12">
    <?php
include("pages/enteteFacture.php");
?>
<?php
include("pages/ligneFacture.php");
?>
<?php
include("pages/piedFacture.php");
?>
</div>

        