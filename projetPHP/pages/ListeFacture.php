<?php
$depot=$_SESSION["DE_No"];
$datedeb=date("dmy");
$datefin=date("dmy");

$client='0';
if(isset($_POST["datedebut"]) && $_POST["datedebut"]!="")
    $datedeb=$_POST["datedebut"];
if(isset($_POST["datefin"]) && $_POST["datefin"]!="")
    $datefin=$_POST["datefin"];

$depotUserClass = new DepotUserClass(0,$objet->db);
$rows=$depotUserClass->getDepotUser($_SESSION["id"]);
if(sizeof($rows)>1)
    $depot = 0;
if(sizeof($rows)==1)
    $depot = $rows[0]->DE_No;

if(isset($_POST["depot"]))
    $depot=$_POST["depot"];
$clientLibelle="";

if(isset($_POST["type"]))
    $type=$_POST["type"];
else
    $type=$_GET["type"];

$clientLibelle="TOUT LES CLIENTS";
if($type=="Achat"||$type=="AchatT"||$type=="AchatC"
    || $type=="AchatRetour"||$type=="AchatRetourT"||$type=="AchatRetourC"
    || $type=="AchatPreparationCommande"||$type=="PreparationCommande")
    $clientLibelle="TOUT LES FOURNISSEURS";

if(isset($_POST["CT_Num"]) && !empty($_POST["CT_Num"])) {
    $client = $_POST["CT_Num"];
    $comptet = new ComptetClass($client,"none",$objet->db);
    $clientLibelle = $comptet->CT_Intitule;

    if($client==-1){
        $clientLibelle="TOUT LES CLIENTS";
        if($type=="Achat"||$type=="AchatT"||$type=="AchatC"
                || $type=="AchatRetour"||$type=="AchatRetourT"||$type=="AchatRetourC"
                || $type=="AchatPreparationCommande"||$type=="PreparationCommande")
            $clientLibelle="TOUT LES FOURNISSEURS";
    }
}

$admin=0;

if($protection->PROT_Administrator==1 || $protection->PROT_Right==1)
    $admin=1;

$typeListe= "documentVente";
if($type=="Sortie" || $type=="Entree" || $type=="Transfert" || $type=="TransfertDetail"|| $type=="Transfert_confirmation" || $type=="Transfert_valid_confirmation")
    $typeListe = "documentStock";
if($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatRetour" || $type=="PreparationCommande" || $type=="AchatPreparationCommande")
    $typeListe = "documentAchat";
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
$protected = $protection->protectedType($type);

$protectedSuppression = $protection->SupprType($typeListe);
$protectedNouveau = $protection->NouveauType($type);
$action=0;
if(isset($_GET["action"])) $action = $_GET["action"];
if(isset($_GET["module"])) $module = $_GET["module"];
$titre="";

function lienfinal($statut,$avance,$entete,$type,$depot,$admini,$cbMarq,$do_domaine,$do_type,$do_modif,$administrateur,$protectedDocP,$flagProtApresImpressionP,$do_imprim){
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
        return lien($entete, $depot, $type, $cbMarq) ;//. $complement;
    }
    else {
        if($protectedDocP==0)
            return lien($entete, $depot, $type, $cbMarq); //. "&visu=1";
        else
            return lien($entete, $depot, $type, $cbMarq); //. "&modif=1";
    }
}

function lien ($entete,$depot,$type,$cbMarq){
    $lienentete="";
    $lienfinal="";
    if($entete!="")
        $lienentete="&cbMarq=".$cbMarq;//."&entete=".$entete;
    if($type=="Vente")
        $lienfinal = "indexMVC.php?module=2&action=3".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="VenteC")
        $lienfinal = "indexMVC.php?module=2&action=3".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="VenteT")
        $lienfinal = "indexMVC.php?module=2&action=3".$lienentete."&type=Vente&depot=".$depot;
    if($type=="BonLivraison")
        $lienfinal = "indexMVC.php?module=2&action=6".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Avoir")
        $lienfinal = "indexMVC.php?module=2&action=8".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Retour")
        $lienfinal = "indexMVC.php?module=2&action=10".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="RetourT")
        $lienfinal = "indexMVC.php?module=2&action=10".$lienentete."&type=Retour&depot=".$depot;
    if($type=="RetourC")
        $lienfinal = "indexMVC.php?module=2&action=10".$lienentete."&type=".$type."&depot=".$depot;

    if($type=="Devis")
        $lienfinal = "indexMVC.php?module=2&action=4".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Transfert")
        $lienfinal = "indexMVC.php?module=4&action=5".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Transfert_confirmation")
        $lienfinal = "indexMVC.php?module=4&action=12".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Transfert_valid_confirmation")
        $lienfinal = "indexMVC.php?module=4&action=14".$lienentete."&type=".$type."&depot=".$depot;

    if($type=="Transfert_detail")
        $lienfinal = "indexMVC.php?module=4&action=10".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Entree")
        $lienfinal = "indexMVC.php?module=4&action=7".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Sortie")
        $lienfinal = "indexMVC.php?module=4&action=8".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Achat")
        $lienfinal = "indexMVC.php?module=7&action=2".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="AchatC")
        $lienfinal = "indexMVC.php?module=7&action=2".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="AchatT")
        $lienfinal = "indexMVC.php?module=7&action=2".$lienentete."&type=Achat&depot=".$depot;

    if($type=="AchatRetour")
        $lienfinal = "indexMVC.php?module=7&action=8".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="AchatRetourT")
        $lienfinal = "indexMVC.php?module=7&action=8".$lienentete."&type=AchatRetour&depot=".$depot;
    if($type=="AchatRetourC")
        $lienfinal = "indexMVC.php?module=7&action=8".$lienentete."&type=".$type."&depot=".$depot;

    if($type=="PreparationCommande")
        $lienfinal = "indexMVC.php?module=7&action=4".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="AchatPreparationCommande")
        $lienfinal = "indexMVC.php?module=7&action=6".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="VenteDevise")
        $lienfinal = "indexMVC.php?module=2&action=12".$lienentete."&type=".$type."&depot=".$depot;
    if($type=="Ticket")
        $lienfinal = "indexMVC.php?module=2&action=14".$lienentete."&type=".$type."&depot=".$depot;
    return $lienfinal;
}
$docEntete = new DocEnteteClass(0,$objet->db);
?>
    <script src="js/script_listeFacture.js?d=<?php echo time(); ?>"></script>
    </head>
    <body>
    <div id="milieu">
        <div class="container">
            <div class="container clearfix">
                <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
                    <?= $texteMenu; ?>
                </h4>
            </div>
            <div class="corps"><?= $titre; ?>
                <div class="form-row">
                    <form action="#" method="POST">
                        <input type="hidden" value="<?= $_SESSION["DE_No"];?>" id="de_no" />
                        <input type="hidden" value="<?= $module; ?>" name="module"/>
                        <input type="hidden" value="<?= $action; ?>" name="action"/>
                        <input type="hidden" id="flagDelai" value="<?= $protection->getDelai(); ?>"/>
                        <input type="hidden" value="<?= sizeof($_POST) ?>" name="post" id="post"/>
                        <input type="hidden" value="<?= $protection->PROT_CBCREATEUR; ?>" name="PROT_CbCreateur" id="PROT_CbCreateur"/>
                        <?php if($type!="Vente" && $type!="VenteC" && $type!="RetourC"){
                            ?><input type="hidden" value="<?php echo $type; ?>" name="type"/><?php } ?>
                            <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                                <label>Début : </label>
                                <input type="text" class="form-control" maxlength="6" name="datedebut" value="<?php if(isset($_POST["datedebut"])) echo $datedeb; ?>" id="datedebut" placeholder="Date" />
                            </div>
                            <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                                <label>Fin : </label>
                                <input type="text" class="form-control" maxlength="6" name="datefin" value="<?php if(isset($_POST["datefin"])) echo $datefin; ?>" id="datefin" placeholder="Date" />
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                <label>Dépôt : </label>
                                <select class="form-control" name="depot" id="depot">
                        <?php
                                    $rows=$depotUserClass->getDepotUser($protection->Prot_No);
                                    if(sizeof($rows)>1){
                                        echo "<option value='0'";
                                        if('0'== $depot) echo " selected ";
                                        echo">TOUT LES DEPOTS</option>";
                                    }
                                    if($rows==null){
                                    }else{
                                        $var = 0;
                                        foreach($rows as $row) {
                                            echo "<option value='{$row->DE_No}'";
                                            if ($row->DE_No == $depot) echo " selected";
                                            echo ">{$row->DE_Intitule}</option>";
                                            $var++;
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <?php
                            if($type=="Vente" || $type=="Ticket" || $type=="VenteC"  || $type=="VenteT" || $type=="BonLivraison" || $type=="Devis" || $type=="Retour" || $type=="Avoir"
                                || $type=="Achat" || $type=="AchatT"|| $type=="AchatC" || $type=="RetourT"|| $type=="RetourC"){
                                ?>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <?php
                                    $libTiers = "Client";
                                    $libToutTiers = "TOUS LES CLIENTS";
                                    if($type=="Achat" ||$type=="AchatC"|| $type=="AchatRetour" ||$type=="AchatRetourC"||$type=="AchatPreparationCommande"||$type=="PreparationCommande") {
                                        $libTiers = "Fournisseur";
                                        $libToutTiers = "TOUS LES FOURNISSEURS";
                                    }
                                    ?>
                                    <label><?= $libTiers; ?> : </label>
                                    <input type="hidden" class="form-control" name="CT_Num" id="CT_Num" value="<?= $client ?>"/>
                                    <input type="text" class="form-control" name="client" id="client" value="<?= $clientLibelle ?>" />
                                </div>
                            <?php }
                            if($type=="Vente" || $type=="VenteC" || $type=="VenteT" || $type=="RetourT" || $type=="RetourC" || $type=="Retour"){
                                $valueT = "VenteT";
                                $value = "Vente";
                                $valueC = "VenteC";
                                if ($_GET["action"] == 9 && $_GET["module"] == 2) {
                                    $valueT = "RetourT";
                                    $value = "Retour";
                                    $valueC = "RetourC";
                                }
                                $selected="";
                                $selectedC="";
                                $selectedT="";
                                if($type=="RetourT") {$selectedT="selected";}
                                if($type=="Retour") {$selected="selected";}
                                if($type=="RetourC") {$selectedC="selected";}
                                if($type=="VenteT") {$selectedT="selected";}
                                if($type=="Vente") {$selected="selected";}
                                if($type=="VenteC") {$selectedC="selected";}
                                ?>
                                <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                    <label>&nbsp;</label>
                                    <select style="" id="type" name="type" class="form-control">
                                            <option value="<?= $valueT ?>" <?= $selectedT ?>>Tous</option>
                                            <option value="<?= $value ?>" <?= $selected ?>>Facture</option>
                                            <option value="<?= $valueC ?>" <?= $selectedC ?>>Facture comptabilisée</option>
                                        </select>
                                </div>
                            <?php }
                            ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <label>&nbsp;</label>
                                <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
                            </div>
<?php
                            if($protectedNouveau && ($type!="VenteC" || $type!="RetourC")){ ?>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                    <label>&nbsp;</label>
                                    <a href="<?= $docEntete->redirectToNouveau($type) ?>" id="nouveau" class="btn btn-primary">Nouveau</a>
                                </div>
                    <?php   } ?>

                </div>
                <?php
                if($type=="Achat" || $type=="AchatC"|| $type=="AchatT"
                    || $type=="AchatRetour" || $type=="AchatRetourC"|| $type=="AchatRetourT" ){
                    ?>
                    <div class="form-group" >
                        <div style="float:right">
                            <select style="width:100px" id="type" name="type" class="form-control">
                                <?php
                                $valueT = "AchatT";
                                $value = "Achat";
                                $valueC = "AchatC";
                                if($_GET["action"]==7){
                                    $valueT = "AchatRetourT";
                                    $value = "AchatRetour";
                                    $valueC = "AchatRetourC";
                                }
                                $selected="";
                                $selectedC="";
                                $selectedT="";
                                if($type=="AchatRetourT") {$valueT = "AchatRetourT"; $selectedT="selected";}
                                if($type=="AchatRetour") {$value = "AchatRetour";$selected="selected";}
                                if($type=="AchatRetourC") {$valueC = "AchatRetourC";$selectedC="selected";}
                                if($type=="AchatT") {$valueT = "Achat"; $selectedT="selected";}
                                if($type=="Achat") {$value = "Achat";$selected="selected";}
                                if($type=="AchatC") {$valueC = "AchatC";$selectedC="selected";}
                                ?>
                                <option value="<?= $valueT ?>" <?= $selectedT ?>>Tous</option>
                                <option value="<?= $value ?>" <?= $selected ?>>Facture</option>
                                <option value="<?= $valueC ?>" <?= $selectedC ?>>Facture comptabilisée</option>
                            </select>
                        </div>
                    </div>
                <?php }
                ?>
                </form>


                <div style="clear:both" class="table-responsive">
                    <table id="table" class="table table-striped" cellspacing="0" width="100%">
                        <thead class="">
                        <tr>
                            <th>Numéro Pièce</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <?php if($module==2) echo"<th>Client</th>";
                            if($module==2 || $type=="Entree"|| $type=="Sortie") echo "<th>Dépot</th>";
                            if($type=="Achat" || $type=="AchatC" || $type=="AchatT" ||
                                $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande") echo"<th>Fournisseur</th>
        <th>Dépot</th>";
                            if($type=="Transfert_detail" || $type=="Transfert" || $type=="Transfert_valid_confirmation" || $type=="Transfert_confirmation") echo"<th>Dépot source</th>
        <th>Dépot dest.</th>";
                            ?>
                            <th>Total TTC</th>
                            <?php if($type=="BonLivraison" || $type=="Vente" || $type=="Ticket" || $type=="Retour" || $type=="VenteT" || $type=="VenteC" || $type=="RetourT" || $type=="RetourC" || $type=="AchatC" || $type=="Achat"  || $type=="AchatT"
                            || $type=="AchatRetourC" || $type=="AchatRetour"  || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande") echo "<th>Montant r&eacute;gl&eacute;</th>
        <th>Statut</th>"; ?>
                            <?php if(($type=="BonLivraison" || $type=="Devis") && ($admin==1 || ($protected))) echo "<th></th>"; ?>
                            <?php if($protectedSuppression) echo "<th></th>"; ?>
                            <th></th>
                            <?php
                            if($protection->PROT_CBCREATEUR!=2)
                                echo "<th>Créateur</th>";
                            ?>
                        </tr>
                        </thead>


                        <tbody>
                        <?php

                        $listFacture = Array();
                        if($type=="Vente"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,6,$_SESSION["id"]);
                        }
                        if($type=="VenteDevise"){
                            $listFacture = $docEntete->getListeFacture($depot,4,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,6,$_SESSION["id"]);
                        }

                        if($type=="VenteC"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,7,$_SESSION["id"]);
                        }
                        if($type=="VenteT"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,67,$_SESSION["id"]);
                        }
                        if($type=="Retour"){
                            $listFacture = $docEntete->getListeFacture($depot,1,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,6,$_SESSION["id"]);
                        }
                        if($type=="RetourT"){
                            $listFacture = $docEntete->getListeFacture($depot,1,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,67,$_SESSION["id"]);
                        }
                        if($type=="RetourC"){
                            $listFacture = $docEntete->getListeFacture($depot,1,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,7,$_SESSION["id"]);
                        }
                        if($type=="Avoir"){
                            $listFacture = $docEntete->getListeFacture($depot,2,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,6,$_SESSION["id"]);
                        }
                        if($type=="Devis"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,0,$_SESSION["id"]);
                        }
                        if($type=="BonLivraison"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,0,3,$_SESSION["id"]);
                        }
                        if($type=="Ticket"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,3,30,$_SESSION["id"]);
                        }
                        if($type=="Transfert"){
                            $listFacture = $docEntete->listeTransfert($depot, $objet->getDate($datedeb), $objet->getDate($datefin),$_SESSION["id"]);
                        }
                        if($type=="Transfert_confirmation" || $type=="Transfert_valid_confirmation"){
                            $listFacture = $docEntete->listeTransfertConfirmation($depot, $objet->getDate($datedeb), $objet->getDate($datefin),$_SESSION["id"]);
                        }

                        if($type=="Transfert_detail"){
                            $listFacture = $docEntete->listeTransfertDetail($depot, $objet->getDate($datedeb), $objet->getDate($datefin),$_SESSION["id"]);
                        }
                        if($type=="Entree"){
                            $listFacture = $docEntete->listeEntree($depot, $objet->getDate($datedeb), $objet->getDate($datefin),$_SESSION["id"]);
                        }
                        if($type=="Sortie"){
                            $listFacture = $docEntete->listeSortie($depot, $objet->getDate($datedeb), $objet->getDate($datefin),$_SESSION["id"]);
                        }

                        if($type=="Achat"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,16,$_SESSION["id"]);
                        }

                        if($type=="AchatC"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,17,$_SESSION["id"]);
                        }

                        if($type=="AchatT"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,1617,$_SESSION["id"]);
                        }

                        if($type=="AchatRetour"){
                            $listFacture = $docEntete->getListeFacture($depot,1,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,16,$_SESSION["id"]);
                        }

                        if($type=="AchatRetourC"){
                            $listFacture = $docEntete->getListeFacture($depot,1,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,17,$_SESSION["id"]);
                        }

                        if($type=="AchatRetourT"){
                            $listFacture = $docEntete->getListeFacture($depot,1,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,1617,$_SESSION["id"]);
                        }

                        if($type=="PreparationCommande"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,11,$_SESSION["id"]);
                        }
                        if($type=="AchatPreparationCommande"){
                            $listFacture = $docEntete->getListeFacture($depot,0,$objet->getDate($datedeb) ,$objet->getDate($datefin),$client,1,12,$_SESSION["id"]);
                        }
                        $ajout="";
                        if(isset($_POST["datedebut"]))
                            $ajout=$ajout."&datedebut=".$_POST["datedebut"];
                        if(isset($_POST["datefin"]))
                            $ajout=$ajout."&datefin=".$_POST["datefin"];
                        if(isset($_POST["depot"]))
                            $ajout=$ajout."&depot=".$_POST["depot"];

                        $i=0;
                        $classe="";
                        if(sizeof($listFacture)==0){

                        }else{
                        foreach ($listFacture as $row){
                        $message="";
                        $avance="";
                        $total = round($row->ttc);
                        if($type=="Ticket" || $type=="BonLivraison" || $type=="Retour" || $type=="Vente" || $type=="VenteC" || $type=="VenteT" || $type=="RetourC" || $type=="RetourT"
                            || $type=="Achat" || $type=="AchatC"  || $type=="AchatT" || $type=="AchatRetour" || $type=="AchatRetourC"  || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande"){
                            $avance = round($row->avance);
                            if($avance==null) $avance = 0;
                            $message =$row->statut;
                        }
                        $i++;
                        $date = new DateTime($row->DO_Date);
                        ?>
                        <tr data-toggle="tooltip" data-placement="top" title="<?= $row->PROT_User ?>"
                            class='facture <?= $classe ?>' id='article_<?= $row->DO_Piece ?>'>
                            <td id='entete'><a href='<?= lienfinal($message,$avance,$row->DO_Piece,$type,$depot,$admin,$row->cbMarq,$row->DO_Domaine,$row->DO_Type,$row->DO_Modif,$admin,$protected,$flagProtApresImpression,$row->DO_Imprim) ?>'><?= $row->DO_Piece ?></a></td>
                            <td><?= $row->DO_Ref ?></td>
                            <td style='display:none' id='cbMarq'><?= $row->cbMarq ?></td>
                            <td style='display:none' id='DL_PieceBL'><?= $row->DL_PieceBL ?></td>
                            <td style='display:none' id='cbCreateur'><?= $row->PROT_User ?></td>
                            <td><?= $date->format('d-m-Y') ?></td>
                            <?php
                            if($module==2 || $type=="Achat" || $type=="AchatC" || $type=="AchatT"
                                || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande")
                                echo "<td>{$row->CT_Intitule}</td>";
                            if($module==2 || $module==7 || $type=="Entree"|| $type=="Sortie")
                                echo "<td>{$row->DE_Intitule}</td>";
                            if($type=="Transfert_detail" || $type=="Transfert" || $type=="Transfert_confirmation" || $type=="Transfert_valid_confirmation")
                                echo"<th>{$row->DE_Intitule}</th>
                                        <th>{$row->DE_Intitule_dest}</th>";
                            ?>
                            <td><?= $objet->formatChiffre($total) ?></td>
                            <?php
                            if($type=="Ticket" || $type=="BonLivraison" || $type=="Vente" || $type=="Retour"
                                || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="AchatT" || $type=="VenteT"  || $type=="VenteC" || $type=="RetourT"  || $type=="RetourC" || $type=="Achat" || $type=="AchatC" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande")
                                echo "<td>{$objet->formatChiffre($avance)}</td>"
                                    . "<td id='statut'>{$message}</td>";
                            if(($type=="BonLivraison" || $type=="Devis") && ($admin==1 || ($protected))) echo '<td><input type="button" class="btn btn-primary" value="Convertir en facture" id="transform"/></td>';
                            if(($protectedSuppression)){
                                echo "<td id='supprFacture'>";
                                if(($type=="Ticket" || $type=="BonLivraison" || $type=="Vente" || $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="AchatT" || $type=="VenteT" || $type=="VenteC" || $type=="Achat" || $type=="AchatC" || $type=="Entree"|| $type=="Sortie"|| $type=="Transfert"|| $type=="Transfert_valid_confirmation" || $type=="Transfert_confirmation" || $type=="Transfert_detail") && $avance==0)
                                    echo "<i class='fa fa-trash-o'></i></td>";
                            }
                            echo "<td>";
                            if($row->DO_Imprim ==1)
                                echo "<i class='fa fa-print'></i>";
                            echo "</td>";
                            if($protection->PROT_CBCREATEUR!=2)
                                echo "<td>{$row->PROT_User}</td>";
                            echo "</tr>";
                            }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center" id="menu_transform">
        <div class="form-group col-lg-4">
            <label>Type<br/></label>
            <select id="type_trans" name="type_trans" class="form-control">
                <option value="6">Facture</option>
                <?php
                if($type=="Devis")
                    echo "<option value='3'>Bon de livraison</option>";
                ?>
            </select>
        </div>
        <div class="form-group col-lg-4">
            <label>Choisisser une nouvelle date</label>
            <input class="form-control" type="text" id="date_transform"/>
        </div>
        <div class="form-group col-lg-4">
            <label>Choisisser une nouvelle référence</label>
            <input class="form-control" type="text" id="reference"/>
        </div>
    </div>