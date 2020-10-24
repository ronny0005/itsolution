<?php 
if($protection->Prot_No!=null){
    if($_GET["module"]==4 && ($_GET["action"]==1 || $_GET["action"]==5))
        $texteMenu="Mouvements de transfert";
    if($_GET["module"]==4 && ($_GET["action"]==3 || $_GET["action"]==7))
        $texteMenu="Mouvements d'entrée";
    if($_GET["module"]==4 && ($_GET["action"]==4 || $_GET["action"]==8))
        $texteMenu="Mouvements de sortie";
    if($_GET["module"]==4 && ($_GET["action"]==9 || $_GET["action"]==10))
        $texteMenu="Mouvements de transfert détail";
    if($_GET["module"]==4 && ($_GET["action"]==11 || $_GET["action"]==12))
        $texteMenu="Transfert Emission";
    if($_GET["module"]==4 && ($_GET["action"]==13 || $_GET["action"]==14))
        $texteMenu="Transfert Confirmation";
?>
    <?php
    if($protection->PROT_Right==1 || ($protection->PROT_DEPRECIATION_STOCK!=2)){
        ?>
        <li class="<?php if($_GET["module"]==4 && ($_GET["action"]==1 || $_GET["action"]==5)) echo "active"; ?>"><a href="indexMVC.php?module=4&action=1&type=Transfert">Mouvement Transfert</a></li>
    <?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ENTREE!=2)){
?>
  <li class="<?php if($_GET["module"]==4 && ($_GET["action"]==3 || $_GET["action"]==7)) echo "active"; ?>"><a href="indexMVC.php?module=4&action=3&type=Entree">Mouvement entrée</a></li>
<?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_SORTIE!=2)){
?>
    <li class="<?php if($_GET["module"]==4 && ($_GET["action"]==4 || $_GET["action"]==8)) echo "active"; ?>"><a href="indexMVC.php?module=4&action=4&type=Sortie">Mouvement sortie</a></li>
<?php }
if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_INTERNE_2!=2)){
?>
    <li class="<?php if($_GET["module"]==4 && ($_GET["action"]==9 || $_GET["action"]==10)) echo "active"; ?>"><a href="indexMVC.php?module=4&action=9&type=Transfert_detail">Mouvement Trsft détail</a></li>
<?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DEPRECIATION_STOCK!=2)){
        ?>
        <li class="<?php if($_GET["module"]==4 && ($_GET["action"]==11 || $_GET["action"]==12)) echo "active"; ?>"><a href="indexMVC.php?module=4&action=11&type=Transfert_confirmation">Transfert Emission</a></li>
    <?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DEPRECIATION_STOCK!=2)){
        ?>
        <li class="<?php if($_GET["module"]==4 && ($_GET["action"]==13 || $_GET["action"]==14)) echo "active"; ?>"><a href="indexMVC.php?module=4&action=13&type=Transfert_valid_confirmation">Transfert Confirmation</a></li>
    <?php }
}
?>