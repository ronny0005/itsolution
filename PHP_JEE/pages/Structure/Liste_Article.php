<?php
    $objet = new ObjetCollector();
$sommeil = -1;
if(isset($_GET["sommeil"]))
    $sommeil = $_GET["sommeil"];
$stockFlag = -1;
if(isset($_GET["stockFlag"]))
    $stockFlag = $_GET["stockFlag"];
$prixFlag = -1;
if(isset($_GET["prixFlag"]))
    $prixFlag = $_GET["prixFlag"];
$depot=$_SESSION["DE_No"];
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("article");
    $flagSuppr = $protection->SupprType("article");
    $flagNouveau = $protection->NouveauType("article");

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeArticle.js?d=<?php echo time(); ?>"></script>

<section style="background-color: rgb(19,72,34);margin: 0px;padding: 5px;">
    <h1 class="text-center" style="color: rgb(255,255,255);">LISTE ARTICLE</h1>
</section>
<div class="mt-4">
    <input type="hidden" id="mdp" value="<?= $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?= $_SESSION["login"]; ?>"/>
    <input type="hidden" id="flagInfoLibreArticle" value="<?= $flagInfoLibreArticle; ?>"/>
    <input type="hidden" id="flagPxRevient" value="<?= $flagPxRevient; ?>"/>
    <input type="hidden" id="flagPxAchat" value="<?= $flagPxAchat; ?>"/>
    <input type="hidden" id="DE_No" value="<?= $_SESSION["DE_No"]; ?>"/>
    <input type="hidden" id="protected" value="<?= $protected; ?>"/>
    <input type="hidden" id="supprProtected" value="<?= $flagSuppr; ?>"/>
    <input type="hidden" id="flagCreateur" value="<?= $protection->PROT_Right; ?>"/>
    <input type="hidden" id="Inputsommeil" value="<?= (isset($_GET['sommeil'])) ?  $_GET['sommeil'] : -1 ?>"/>
    <input type="hidden" id="InputprixFlag" value="<?= (isset($_GET['prixFlag'])) ?  $_GET['prixFlag'] : -1 ?>"/>
    <input type="hidden" id="InputstockFlag" value="<?= (isset($_GET['stockFlag'])) ?  $_GET['stockFlag'] : -1 ?>"/>
    <div class="col-md-12">

<fieldset class="entete card p-3">

<div class="form-group">
<form action="listeArticle" method="GET">
    <div class="row">
        <div class="col-4 col-sm-4 col-md-4 col-lg-2">
            <label>Sommeil</label>
            <select id="sommeil" style="" class="form-control">
                <option value="-1" <?php if($sommeil==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($sommeil==1) echo " selected "; ?> >Sommeil</option>
                <option value="0" <?php if($sommeil==-0) echo " selected "; ?> >Non Sommeil</option>
            </select>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2">
            <label>Stock</label>
            <select id="stockFlag" name="stockFlag" class="form-control">
                <option value="-1" <?php if($stockFlag==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($stockFlag==1) echo " selected "; ?> >Oui</option>
                <option value="0" <?php if($stockFlag==-0) echo " selected "; ?> >Non</option>
            </select>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2">
            <label>Px min/max</label>
            <select id="prixFlag" name="prixFlag" class="form-control">
                <option value="-1" <?php if($prixFlag==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($prixFlag==1) echo " selected "; ?> >Oui</option>
                <option value="0" <?php if($prixFlag==-0) echo " selected "; ?> >Non</option>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-4 mt-4">
            <button type="button" class="btn btn-primary" id="imprimer">Export excel</button>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-2 text-right mt-4" style="float:right">
            <a href="ficheArticle"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a>
        </div>

    </div>
    <?php
    if($flagNouveau){ ?>
    <?php } ?>
        </form>

    <?php
    $statut = $_GET["statut"];
    if(isset($_GET["AR_Ref"]) && $statut!=0) {
        $type = "La création ";
        $alert = "alert-success";
        if($statut == 3) {
            $type = "La suppression ";
        }
        if($statut == 4) {
            $alert = "alert-danger";
            $type = "Echec de la suppression ";
        }

        if($statut == 2)
            $type = "La modification ";

        ?>
        <div class="mt-3 alert <?= $alert ?>">
            <?= $type ?>de l'article <?= $_GET["AR_Ref"] ?> a été effectuée !
        </div>
        <?php
    }
    ?>
<div class="table-responsive" style="margin-top: 30px;clear:both">
    <table id="users" class="table table-striped">
        <thead>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Quantité en stock (cumul)</th>
                <?php if($flagPxAchat==0) echo"<th>Prix d'achat</th>"; ?>
                <?php if($flagInfoLibreArticle!=2) echo"<th>Prix de vente</th>"; ?>
                <?php  if($flagPxRevient==0) echo "<th>Montant</th>"; ?>
                <?php if($flagSuppr) echo "<th></th>"; ?>
                <?php if($protection->PROT_Right==1) echo "<th>Créateur</th>"; ?>
        </thead>
    </table>
 </div>
</div>

   
</div>
 
</div>
