<?php
    $objet = new ObjetCollector();
$sommeil = 0;
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
<div class="corps">
    <input type="hidden" id="mdp" value="<?= $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?= $_SESSION["login"]; ?>"/>
    <input type="hidden" id="flagInfoLibreArticle" value="<?= $flagInfoLibreArticle; ?>"/>
    <input type="hidden" id="flagPxRevient" value="<?= $flagPxRevient; ?>"/>
    <input type="hidden" id="flagPxAchat" value="<?= $flagPxAchat; ?>"/>
    <input type="hidden" id="DE_No" value="<?= $_SESSION["DE_No"]; ?>"/>
    <input type="hidden" id="protected" value="<?= $flagProtected; ?>"/>
    <input type="hidden" id="supprProtected" value="<?= $flagSuppr; ?>"/>
    <input type="hidden" id="flagCreateur" value="<?= $protection->PROT_Right; ?>"/>

    <div class="col-md-12">

<fieldset class="entete">
<legend class="entete">Liste article</legend>

<div class="form-group">
<form action="indexMVC.php?module=2&action=2" method="GET">
    <div class="row">
        <div class="col-md-2">
            <label>Sommeil</label>
            <select id="sommeil" style="" class="form-control">
                <option value="-1" <?php if($sommeil==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($sommeil==1) echo " selected "; ?> >Oui</option>
                <option value="0" <?php if($sommeil==-0) echo " selected "; ?> >Non</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Stock</label>
            <select id="stockFlag" name="stockFlag" class="form-control">
                <option value="-1" <?php if($stockFlag==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($stockFlag==1) echo " selected "; ?> >Oui</option>
                <option value="0" <?php if($stockFlag==-0) echo " selected "; ?> >Non</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Prix min/max</label>
            <select id="prixFlag" name="prixFlag" class="form-control">
                <option value="-1" <?php if($prixFlag==-1) echo " selected "; ?> >Tout</option>
                <option value="1" <?php if($prixFlag==1) echo " selected "; ?> >Oui</option>
                <option value="0" <?php if($prixFlag==-0) echo " selected "; ?> >Non</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="button" class="btn btn-primary" id="imprimer" value="Exporter excel"/>
        </div>
        <div style="float:right">
            <a href="indexMVC.php?module=3&action=1"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a>
        </div>

    </div>
    <?php
    if($flagNouveau){ ?>
    <?php } ?>
        </form>
<div class="err" id="add_err"></div>
<table cellpadding="1" cellspacing="1" id="users" class="display" width="100%">
    <thead style="background-color: #dbdbed;color:black">
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
