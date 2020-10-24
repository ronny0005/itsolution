<?php 
if($protection->Prot_No!=null){
    if($_GET["module"]==3 && ($_GET["action"]==3||$_GET["action"]==1))
        $texteMenu="Article";
    if($_GET["module"]==3 && ($_GET["action"]==4||$_GET["action"]==2))
        $texteMenu="Client";
    if($_GET["module"]==3 && ($_GET["action"]==8||$_GET["action"]==9))
        $texteMenu="Fournisseur";
    if($_GET["module"]==3 && $_GET["action"]==5)
        $texteMenu="Catalogue";
    if($_GET["module"]==3 && ($_GET["action"]==6||$_GET["action"]==7)) 
        $texteMenu="Famille";
    if($_GET["module"]==3 && ($_GET["action"]==10||$_GET["action"]==11))         
        $texteMenu="Dépôt";
    if($_GET["module"]==3 && ($_GET["action"]==12||$_GET["action"]==13))         
        $texteMenu="Collaborateur";
    if($_GET["module"]==3 && ($_GET["action"]==14||$_GET["action"]==15))
        $texteMenu="Caisse";
    if($_GET["module"]==3 && ($_GET["action"]==16||$_GET["action"]==17))
        $texteMenu="Salarié";
    if($_GET["module"]==9 && ($_GET["action"]==1||$_GET["action"]==2))         
        $texteMenu="Comptabilité";
    if($_GET["module"]==9 && ($_GET["action"]==3||$_GET["action"]==4))         
        $texteMenu="Analytique";
    if($_GET["module"]==9 && ($_GET["action"]==5||$_GET["action"]==6))         
        $texteMenu="Taxe";
    if($_GET["module"]==9 && ($_GET["action"]==7||$_GET["action"]==8))         
        $texteMenu="Journaux";
    if($_GET["module"]==9 && ($_GET["action"]==9||$_GET["action"]==10))         
        $texteMenu="Banque";
    if($_GET["module"]==9 && ($_GET["action"]==11||$_GET["action"]==12))         
        $texteMenu="Modèle de règlement";
    if($_GET["module"]==9 && ($_GET["action"]==13||$_GET["action"]==14))
        $texteMenu="Saisie journal";
    if($_GET["module"]==3 && ($_GET["action"]==18||$_GET["action"]==19))
        $texteMenu="Rabais remises et ristournes clients";
 ?>
    <?php
    if($protection->PROT_Right==1 || ($protection->PROT_ARTICLE!=2)){
    ?>
    <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==3||$_GET["action"]==1)) echo "active"; ?>"><a href="indexMVC.php?module=3&action=3">Article</a></li> 
<?php }
    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)){
?>
    <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==4||$_GET["action"]==2)) echo "active"; ?>"><a href="indexMVC.php?module=3&action=4">Client</a></li>
<?php }
if($protection->PROT_Right==1 || ($protection->PROT_FOURNISSEUR!=2)){
    ?>
    <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==8||$_GET["action"]==9)) echo "active"; ?>"><a href="indexMVC.php?module=3&action=8">Fournisseur</a></li>
<?php }
    if($protection->PROT_Right==1 | ($protection->PROT_FAMILLE!=2)){
?>
    <li class="<?php if($_GET["module"]==3 && $_GET["action"]==5) echo "active"; ?>"><a href="indexMVC.php?module=3&action=5">Catalogue</a></li>
<?php }
    if($protection->PROT_Right==1 || ($protection->PROT_FAMILLE!=2)){
?>
    <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==6||$_GET["action"]==7)) echo "active"; ?>"><a href="indexMVC.php?module=3&action=6">Famille</a></li>
<?php }
if($protection->PROT_Right==1 || ($protection->PROT_DEPOT!=2)){
?>
    <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==10||$_GET["action"]==11)) echo "active"; ?>" ><a href="indexMVC.php?module=3&action=10">Depot</a></li>
<?php }  
if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)){
?>
    <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==12||$_GET["action"]==13)) echo "active"; ?>" ><a href="indexMVC.php?module=3&action=12">Collaborateur</a></li>
<?php }
if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)){
?>
    <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==14||$_GET["action"]==15)) echo "active"; ?>" ><a href="indexMVC.php?module=3&action=14">Caisse</a></li>
<?php }
    if($protection->PROT_Right==1 || ($protection->PROT_FOURNISSEUR!=2)){
        ?>
        <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==16||$_GET["action"]==17)) echo "active"; ?>"><a href="indexMVC.php?module=3&action=16">Salarié</a></li>
    <?php }
    if($protection->PROT_Right==1 || ($protection->PROT_FOURNISSEUR!=2)){
        ?>
        <li class="<?php if($_GET["module"]==3 && ($_GET["action"]==18||$_GET["action"]==19)) echo "active"; ?>"><a href="indexMVC.php?module=3&action=18">Rabais remises et ristournes clients</a></li>
    <?php }
}
?>