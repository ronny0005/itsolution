<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $flagNouveau = 1;
    $flagProtected = 0;
    $flagSuppr = 1;
    $sommeil = -1;
    if(isset($_GET["sommeil"]))
        $sommeil = $_GET["sommeil"];
    $type = "client";
    $titre = "Liste client";

    if($_GET["type"]==1) {
        $type = "fournisseur";
        $titre = "Liste fournisseur";
    }
    if($_GET["type"]==2) {
        $type = "salarie";
        $titre = "Liste salarié";
    }

    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    if($type=="client"){
        $flagProtected = $protection->protectedType($type);
        $flagSuppr = $protection->SupprType($type);
        $flagNouveau = $protection->NouveauType($type);
    }
    if($type=="fournisseur" || $type=="salarie"){
        $flagProtected = $protection->protectedType($type);
        $flagSuppr = $protection->SupprType($type);
        $flagNouveau = $protection->NouveauType($type);
    }

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeClient.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>

<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        <?= $titre ?>
    </h3>
</section>


<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
    <input type="hidden" id="protected" value="<?php echo $protected; ?>"/>
    <input type="hidden" id="supprProtected" value="<?php echo $flagSuppr; ?>"/>
    <input type="hidden" id="flagCreateur" value="<?php echo $protection->PROT_Right; ?>"/>

    <div class="col-md-12">

<fieldset class="card p-3 entete">
    <legend class="entete">
<?php
$lien = "listeTiers";
$fiche = "FicheTiers";
if($type=="client") {
    echo "Liste client";
}
if($type=="fournisseur") {
    echo "Liste fournisseur";
//    $lien = "listeFournisseur";
}
if($type=="salarie") {
    echo "Liste salarié";
//    $lien = "listeSalarie";
}
?>
    </legend>
    <div class="form-group card p-3">
        <form action="indexMVC.php?module=2&action=2" method="GET">
            <input type="hidden" id="typeTiers" name="typeTiers" value="<?= $type ?>" />
            <input type="hidden" id="typeTiersNum" name="typeTiersNum" value="<?= $_GET["type"] ?>" />
            <input type="hidden" id="lienTiers" name="lienTiers" value="<?= $lien ?>" />
            <input type="hidden" id="ficheTiers" name="ficheTiers" value="<?= $fiche ?>" />
            <input type="hidden" id="CT_Num" name="CT_Num" value="<?= (isset($_GET["CT_Num"])) ? $_GET["CT_Num"] : ""  ?>" />
            <table style="margin-bottom: 20px;width:100%">
            <thead>
                <tr>
                    <td>
                        <select id="sommeil" style="width:100px" class="form-control">
                            <option value="-1" <?php if($sommeil==-1) echo " selected "; ?> >Tout</option>
                            <option value="1" <?php if($sommeil==1) echo " selected "; ?> >Sommeil</option>
                            <option value="0" <?php if($sommeil==-0) echo " selected "; ?> >Non Sommeil</option>
                        </select>
                    </td>
                <?php if($flagNouveau){ ?><td style="float:right"><a href="FicheTiers-<?= $_GET["type"] ?>"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
                </tr>
            </table>
        </form>
        <?php
        $statut = $_GET["statut"];
        if(isset($_GET["CT_Num"]) && $statut!=0) {
            $type = "La création ";
            $alert = "alert-success";
            if($statut == 3) {
                $alert = "alert-danger";
                $type = "La suppression ";
            }

            if($statut == 2)
                $type = "La modification ";

            ?>
            <div class="alert <?= $alert ?>">
                <?= $type ?>du tiers <?= $_GET["CT_Num"] ?> a été effectuée !
            </div>
            <?php
        }
        ?>
        <table cellpadding="1" cellspacing="1" id="users" class="display table table-striped" width="100%">
                <thead>
                    <th>Num</th>
                    <th>Intitulé</th>
                    <th>CG Num</th>
                    <th>Cat. Tarif</th>
                    <th>Cat. Compta</th>
                    <?php if($flagSuppr) echo "<th></th>"; ?>
                    <?php if($protection->PROT_Right==1) echo "<th>Créateur</th>"; ?>
                </thead>
        </table>
     </div>
</div>
 
</div>
