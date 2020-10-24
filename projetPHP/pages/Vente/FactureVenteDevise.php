<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/scriptFactureVenteDevise.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
$objet = new ObjetCollector(); 
$cat_tarif=0;
$cat_compta=0;
$protected=0;
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_noSrc=0;
$depot_noDest=0;
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

if($_GET["type"]=="VenteDevise"){
    $do_domaine = 0;
    $do_type = 6;
}

$docEntete = new DocEnteteClass(0);
$docAchat = new DocEnteteClass(0);
if(isset($_GET["cbMarq"])){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    $docligne = new DocLigneClass($docEntete->listeLigneFacture()[0]->cbMarq);
    if($docEntete->DO_Devise!=0 && $docEntete->DO_Coord04!="") {
        $docEnteteAchat = $docEntete->getDocumentByDOPiece($docEntete->DO_Coord04,1,16);
        $docligneAchat = new DocLigneClass($docEnteteAchat->listeLigneFacture()[0]->cbMarq);
    }
}
$result=$objet->db->requete($objet->getParametre($_SESSION["id"]));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}else{ 
    $souche=$rows[0]->CA_Souche;
    $co_no=$rows[0]->CO_No;
    $depot_noSrc=$rows[0]->DE_No;
    $caisse=$rows[0]->CA_No;
}   
    $depot_no = $_SESSION["DE_No"];
    if(isset($_GET["depot"]))
        $depot_noSrc =$_GET["depot"];
    
    // Données liées au client
    $nomdepot="";
    // Création de l'entete de document
    $docEntete = new DocEnteteClass(0);
    if(isset($_GET["cbMarq"]) ){
        $entete = $_GET["entete"];
        $docEntete = new DocEnteteClass($_GET["cbMarq"]);
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
        <div class="err" id="add_err"></div>
        <form id="form-entete" class="form-horizontal" action="indexMVC.php?module=2&action=3" method="GET" >
            <div style="clear:both;width:150px">
                <label>Date</label>
                <input type="text" class="form-control" id="dateDevise" name="dateDevise" value="<?php if(isset($_GET["cbMarq"]))echo $docEntete->getDO_DateC(); ?>"/>
            </div>
            <fieldset class="entete">
                <legend class="entete">Entete</legend>
                <div style="float: left;" class="form-group">
                <div class="form-group col-lg-3" style="float: left;">
                    <label>Client</label>
                    <select class="form-control" name="clientSource" id="clientSource">
                        <?php
                        if($clientSrc=="")
                            $clientSrc = new ComptetClass(0);
                        foreach($clientSrc->allClients() as $row){
                            echo "<option value=".$row->CT_Num."";
                            if(isset($_GET["cbMarq"]))
                                if($row->CT_Num==$docEntete->DO_Tiers) echo " selected";
                            echo ">".$row->CT_Intitule."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label>Depot</label>
                    <select class="form-control" name="depotSource" id="depotSource">
                        <?php
                        $result=$objet->db->requete($objet->depot());
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        $depot="";
                        if($rows==null){
                        }else{
                            foreach($rows as $row) {
                                echo "<option value=" . $row->DE_No . "";
                                if(isset($_GET["cbMarq"]))
                                    if($row->DE_No==$docEntete->DE_No) echo " selected";
                                echo ">" . $row->DE_Intitule . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3" style="float: left">
                    <label>Article</label>
                    <select class="form-control" id="articleSource" name="articleSource" placeholder="">
                        <?php
                            if(isset($_GET["cbMarq"])) {
                                $article = new ArticleClass($docligne->AR_Ref);
                                echo "<option value='".$docligne->AR_Ref."'>".$article->AR_Ref." - ".$article->AR_Design."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label>Prix de vente</label>
                    <input class="form-control" type="text" name="prixVenteSource" id="prixVenteSource" value="<?php if(isset($_GET["cbMarq"])) echo ROUND($docligne->DL_PrixUnitaire,2); ?>" />
                </div>
                <div class="form-group col-lg-2">
                    <label>Qte</label>
                    <input class="form-control" type="text" name="qteSource" id="qteSource" value="<?php if(isset($_GET["cbMarq"])) echo ROUND($docligne->DL_Qte,2); ?>" />
                    <input class="form-control" type="hidden" name="qteSourceMax" id="qteSourceMax" value="" />
                </div>
                <div class="form-group col-lg-3">
                    <label>Total FCFA</label>
                    <input class="form-control" type="text" name="totalSource" id="totalSource" value="<?php if(isset($_GET["cbMarq"])) echo ROUND($docligne->DL_MontantTTC,2); ?>" disabled/>
                </div>
            </div>
            </fieldset>

            <fieldset class="entete">
                <legend class="entete">Entete</legend>
            <div style="float: left;" class="form-group">
                <div class="form-group col-lg-3" style="float: left;">
                    <label>Devise</label>
                    <select class="form-control" name="devise" id="devise">
                        <option value="0" <?php if(isset($_GET["cbMarq"])) if($docEntete->DO_Devise==0) echo "selected"; ?>>FCFA</option>
                        <option value="1" <?php if(isset($_GET["cbMarq"])) if($docEntete->DO_Devise==1) echo "selected"; ?>>Euro</option>
                    </select>
                </div>

                <div class="form-group col-lg-3">
                    <label>Prix de vente</label>
                    <input class="form-control" type="text" name="prixVenteDest" id="prixVenteDest" value="<?php if(isset($_GET["cbMarq"])) if($docEntete->DO_Coord04!="") echo ROUND($docligneAchat->DL_PrixUnitaire,2); ?>" disabled/>
                </div>
                <div class="form-group col-lg-3">
                    <label>Qte</label>
                    <input class="form-control" type="text" name="qteDest" id="qteDest" value="<?php if(isset($_GET["cbMarq"])) if($docEntete->DO_Coord04!="") echo ROUND($docligneAchat->DL_Qte,2); ?>" disabled/>
                </div>
                <div class="form-group col-lg-3">
                    <label>Total FCFA</label>
                    <input class="form-control" type="text" name="totalDest" id="totalDest" value="<?php if(isset($_GET["cbMarq"])) if($docEntete->DO_Coord04!="") echo ROUND($docligneAchat->DL_MontantTTC,2); ?>" disabled/>
                </div>
            </div>
            </fieldset>
            <div class="col-md-3">
                <input type="button" class="btn btn-primary" id="valider" value="Valider"></input>
            </div>
        </form>
</div>