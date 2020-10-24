<?php 

//$objet = new ObjetCollector();

//$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
if($protection->Prot_No!=""){
    if($_GET["module"]==7 && ($_GET["action"]==2||$_GET["action"]==1))
        $texteMenu="Factures d'achat";
    if($_GET["module"]==7 && ($_GET["action"]==3||$_GET["action"]==4))
        $texteMenu="Préparation commande";
    if($_GET["module"]==7 && ($_GET["action"]==5||$_GET["action"]==6))
        $texteMenu="Achat + Préparation commande";
    if($_GET["module"]==7 && ($_GET["action"]==7||$_GET["action"]==8))
        $texteMenu="Achat retour";

    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_FACTURE!=2)){
        ?>
        <li class="<?php if($_GET["module"]==7 && ($_GET["action"]==1||$_GET["action"]==2)) echo "active"; ?>"><a href="indexMVC.php?module=7&action=1&type=Achat">Facture d'achat</a></li>
    <?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)){
        ?>
        <li class="<?php if($_GET["module"]==7 && ($_GET["action"]==3||$_GET["action"]==4)) echo "active"; ?>"><a href="indexMVC.php?module=7&action=3&type=PreparationCommande">Préparation commande</a></li>
    <?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)){
        ?>
        <li class="<?php if($_GET["module"]==7 && ($_GET["action"]==5||$_GET["action"]==6)) echo "active"; ?>"><a href="indexMVC.php?module=7&action=5&type=AchatPreparationCommande">Achat + Préparation commande</a></li>
    <?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_RETOUR!=2)){
        ?>
        <li class="<?php if($_GET["module"]==7 && ($_GET["action"]==7||$_GET["action"]==8)) echo "active"; ?>"><a href="indexMVC.php?module=7&action=7&type=AchatRetour">Achat retour</a></li>
    <?php }
}
?>