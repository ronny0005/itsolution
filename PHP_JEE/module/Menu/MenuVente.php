<?php 
if($protection->Prot_No!=null){
    if($_GET["module"]==2 && ($_GET["action"]==3||$_GET["action"]==1))
        $texteMenu="Factures de vente";
    if($_GET["module"]==2 && ($_GET["action"]==2||$_GET["action"]==4))
        $texteMenu="Devis";
    if($_GET["module"]==2 && ($_GET["action"]==5||$_GET["action"]==6))
        $texteMenu="Bon de livraison";
    if($_GET["module"]==2 && ($_GET["action"]==7||$_GET["action"]==8))
        $texteMenu="Factures d'avoir";
    if($_GET["module"]==2 && ($_GET["action"]==9||$_GET["action"]==10))
        $texteMenu="Facture de retour";
    if($_GET["module"]==2 && ($_GET["action"]==11||$_GET["action"]==12))
        $texteMenu="Vente de devise";
    if($_GET["module"]==2 && ($_GET["action"]==13||$_GET["action"]==14))
        $texteMenu="Ticket";
    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE!=2)){
    ?>
    <li class="<?php if($_GET["module"]==2 && ($_GET["action"]==3||$_GET["action"]==1)) echo "active"; ?>" ><a href="indexMVC.php?module=2&action=1&type=Vente">Facture de vente</a></li>
    <?php }
        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_DEVIS!=2)){
    ?>
        <li class="<?php if($_GET["module"]==2 && ($_GET["action"]==2||$_GET["action"]==4)) echo "active"; ?>"><a href="indexMVC.php?module=2&action=2&type=Devis">Devis</a></li>
    <?php }
        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_BLIVRAISON!=2)){
    ?>
        <li class="<?php if($_GET["module"]==2 && ($_GET["action"]==5||$_GET["action"]==6)) echo "active"; ?>"><a href="indexMVC.php?module=2&action=5&type=BonLivraison">Bon de livraison</a></li>
    <?php }
     if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_AVOIR!=2)){
    ?>
        <li class="<?php if($_GET["module"]==2 && ($_GET["action"]==7||$_GET["action"]==8)) echo "active"; ?>"><a href="indexMVC.php?module=2&action=7&type=Avoir">Avoir</a></li>
    <?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_RETOUR!=2)){
        ?>
        <li class="<?php if($_GET["module"]==2 && ($_GET["action"]==9||$_GET["action"]==10)) echo "active"; ?>"><a href="indexMVC.php?module=2&action=9&type=Retour">Retour</a></li>
    <?php }
    if(($protection->PROT_Right==1 || ($protection->PROT_VENTE_COMPTOIR!=2))){
        ?>
        <li class="<?php if($_GET["module"]==2 && ($_GET["action"]==13||$_GET["action"]==14)) echo "active"; ?>"><a href="indexMVC.php?module=2&action=13&type=Ticket">Ticket</a></li>
    <?php }
}
?>