<?php
$objet = new ObjetCollector(); 
$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$collaborateur=0;
$modif=0;
$client = "";
$totalht=0;
$totalqte=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";

$dateEntete="";
if($_GET["type"]=="Transfert"){
    $do_domaine = 2;
    $do_type = 23;
}   
if($_GET["type"]=="Transfert_detail"){
    $do_domaine = 4;
    $do_type = 41;
}   
if($_GET["type"]=="Entree"){
    $do_domaine = 2;
    $do_type = 20;
}    
if($_GET["type"]=="Sortie"){
    $do_domaine = 2;
    $do_type = 21;
}    

$type = $_GET["type"];

$result=$objet->db->requete($objet->getParametre($_SESSION["id"]));     
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}else{ 
    $souche=$rows[0]->CA_Souche;
    $co_no=$rows[0]->CO_No;
    $depot_no=$rows[0]->DE_No;
}   

    $depot_no = $_SESSION["DE_No"];
    if(isset($_GET["depot"]))
        $depot_no =$_GET["depot"];
    if(isset($_GET["depot"]))
        $depot_no =$_GET["depot"];
    
    // Données liées au client
    if(isset($_GET["client"])){
        $client=$_GET["client"];
        $comptet = new ComptetClass($_GET["client"]);
        $cat_tarif=$comptet->N_CatTarif;
        $cat_compta=$comptet->N_CatCompta;
        $libcat_tarif=$comptet->LibCatTarif;
        $libcat_compta=$comptet->LibCatCompta;
    }
$cbMarq=0;
    // Création de l'entete de document
    if(isset($_GET["entete"])){
        $entete = $_GET["entete"];
        if($type=="Transfert_detail") {
            $result = $objet->db->requete($objet->getDoPieceTrsftDetail($entete));
        }
        else 
            $result=$objet->db->requete($objet->getDoPiece($entete,$do_domaine,$do_type));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            $cbMarq = $rows[0]->cbMarq;
            $reference=$rows[0]->DO_Ref;
            $depot=$rows[0]->DE_No;
            if($type!="Transfert_detail")
            $collaborateur=$rows[0]->DO_Tiers;
            if($type=="Transfert_detail")
                $depot_dest = $rows[0]->DE_No_dest;
        }

    }
$type = $_GET["type"];

?>
<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/script_Mouvement.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
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
include("pages/enteteMvt_detail.php");
include("pages/ligneMvt_detail.php");
include("pages/piedMvt.php");
?>