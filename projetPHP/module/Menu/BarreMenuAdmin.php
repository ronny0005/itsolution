<?php 
//$objet = new ObjetCollector();

//$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
if($protection->Prot_No!=""){
    if($_GET["module"]==8 && ($_GET["action"]==1||$_GET["action"]==4))
        $texteMenu="Utilisateurs";
    if($_GET["module"]==8 && ($_GET["action"]==2||$_GET["action"]==3))
        $texteMenu="Droits";
    if($_GET["module"]==8 && ($_GET["action"]==5))
        $texteMenu="Profils";
    if($_GET["module"]==8 && ($_GET["action"]==6))
        $texteMenu="Code client";
    if($_GET["module"]==8 && ($_GET["action"]==7))
        $texteMenu="Envoi mail";
    if($_GET["module"]==8 && ($_GET["action"]==8))
        $texteMenu="Envoi SMS";
    if($_GET["module"]==8 && ($_GET["action"]==9))
        $texteMenu="Compte SMS";
    if($_GET["module"]==8 && ($_GET["action"]==10))
        $texteMenu="Configuration accès";
    if($_GET["module"]==8 && ($_GET["action"]==11))
        $texteMenu="Configuration Profil-utilisateur";
    if($_GET["module"]==8 && ($_GET["action"]==13))
        $texteMenu="Fusion article";
    if($_GET["module"]==8 && ($_GET["action"]==14))
        $texteMenu="Fusion client";
    if($_GET["module"]==8 && ($_GET["action"]==15))
        $texteMenu="Calendrier connexion";

    if($protection->PROT_Right==1){
    ?>
    <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==1||$_GET["action"]==4)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=1">Utilisateur</a></li>
    <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==2||$_GET["action"]==3)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=2">Profils</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==5)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=5">Droits</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==7)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=7">Envoi mail</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==8)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=8">Envoi SMS</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==9)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=9">Compte SMS</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==10)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=10">Configuration accès</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==11)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=11">Configuration profil utilisateur</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==12)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=12">Deconnexion totale</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==13)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=13">Fusion article</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==14)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=14">Fusion client</a></li>
        <li class="<?php if($_GET["module"]==8 && ($_GET["action"]==15)) echo "active"; ?>"><a href="indexMVC.php?module=8&action=15">Calendrier connexion</a></li>
<?php }
}
?>