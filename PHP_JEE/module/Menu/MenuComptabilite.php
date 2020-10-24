
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==1||$_GET["action"]==2)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=1">Plan comptable</a></li>
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==3||$_GET["action"]==4)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=3">Plan analytique</a></li>
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==5||$_GET["action"]==6)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=5">Taxe</a></li>
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==7||$_GET["action"]==8)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=7">Journaux</a></li>
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==9||$_GET["action"]==10)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=9">Banque</a></li>
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==11||$_GET["action"]==12)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=11">Modèle de règlement</a></li>
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==13||$_GET["action"]==14)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=13">Saisie comptable</a></li>
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==15)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=15">Contrôle de caisse</a></li>
<li class="<?php if($_GET["module"]==9 && ($_GET["action"]==16)) echo "active"; ?>"><a href="indexMVC.php?module=9&action=16">Mise à jour Comptable</a></li>
<?php
if(($protection->PROT_Right==1 || ($protection->PROT_CLOTURE_CAISSE!=2))) {
    ?>
    <li class="<?php if ($_GET["module"] == 9 && ($_GET["action"] == 18)) echo "active"; ?>">
        <a href="clotureDeCaisse">Clotûre de caisse</a>
    </li>
    <?php
}
?>