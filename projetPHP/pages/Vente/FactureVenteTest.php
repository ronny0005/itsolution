<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/scriptFactureVente.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
$objet = new ObjetCollector();
$do_domaine = 0;
$do_type = 0;
$souche=0;
$co_no=0;
$depot_no=0;
$caisse=0;

if($_GET["type"]=="Vente" || $_GET["type"]=="Retour" || $_GET["type"]=="Avoir"){
    $do_domaine = 0;
    $do_type = 6;
}
if($_GET["type"]=="BonLivraison"){
    $do_domaine = 0;
    $do_type = 3;
}
if($_GET["type"]=="VenteC"){
    $do_domaine = 0;
    $do_type = 7;
}
if($_GET["type"]=="AchatC"){
    $do_domaine = 1;
    $do_type = 17;
}
if($_GET["type"]=="Devis"){
    $do_domaine = 0;
    $do_type = 0;
}
if($_GET["type"]=="Achat"){
    $do_domaine = 1;
    $do_type = 16;
}
if($_GET["type"]=="PreparationCommande"){
    $do_domaine = 1;
    $do_type = 11;
}
if($_GET["type"]=="AchatPreparationCommande"){
    $do_domaine = 1;
    $do_type = 12;
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
    $docEntete = new DocEnteteClass(0);
    if(isset($_GET["cbMarq"]) ){
        $entete = $_GET["entete"];
        $docEntete = new DocEnteteClass($_GET["cbMarq"]);
        $do_imprim = $docEntete->DO_Imprim;
        $client = new ComptetClass($docEntete->DO_Tiers);
        $cat_tarif = $client->N_CatTarif;
        $result=$objet->db->requete($objet->montantRegle($entete,$do_domaine,$do_type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            $total_regle=$rows[0]->montantRegle;
        }
        $result=$objet->db->requete($objet->AvanceDoPiece($entete,$do_domaine,$do_type));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            $avance=$rows[0]->avance_regle;
        }
        $reste_a_payer=$total_regle - $avance;
    }
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        $protected = $rows[0]->PROT_Right;
    }
    $type=$_GET["type"];
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

        