<?php 

//$objet = new ObjetCollector();

//$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
if($protection->Prot_No!=""){
    if($_GET["module"]==1 && $_GET["action"]==2)
        $texteMenu="Règlement client";
    if($_GET["module"]==1 && $_GET["action"]==4)
        $texteMenu="Règlement fournisseur";
    if($_GET["module"]==1 && $_GET["action"]==5)
        $texteMenu="Bon de caisse";
if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_REGLEMENT!=2)){
    ?>
    <li class="<?php if($_GET["module"]==1 && $_GET["action"]==2) echo "active"; ?>"><a href="indexMVC.php?module=1&action=2&typeRegl=Client">Règlement client</a></li>
<?php }
    if($protection->PROT_Right==1 || ($protection->PROT_SAISIE_REGLEMENT_FOURNISSEUR!=2)){
?>
  <li class="<?php if($_GET["module"]==1 && $_GET["action"]==4) echo "active"; ?>"><a href="indexMVC.php?module=1&action=4&typeRegl=Fournisseur">Règlement fournisseur</a></li>
<?php }
    if($protection->PROT_Right==1 || ($protection->PROT_GENERATION_RGLT_CLIENT!=2)){
        ?>
        <li class="<?php if($_GET["module"]==1 && $_GET["action"]==5) echo "active"; ?>"><a href="indexMVC.php?module=1&action=5&typeRegl=Collaborateur">Bon de caisse</a></li>
    <?php }
}
?>