<?php 
$admin=0;
$vente=0;
$reglt=0;
$profil_caisse=0;
$profil_special=0;
$profil_commercial=0;
$profil_daf=0;
$profil_superviseur=0;
$profil_gestionnaire=0;
$qte_negative = 0;
$objet = new ObjetCollector();
$flag_minMax = 0;
$flagPxRevient = 0;
$flagPxAchat = 0;
$flagDateMvtCaisse = 0;
$flagDateVente = 0;
$flagDateAchat = 0;
$flagDateStock = 0;
$flagProtApresImpression = 0;
$flagModifClient = 0;
$flagPxVenteRemise = 0;

$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
$result=$objet->db->requete($objet->getParametrecial());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows[0]->P_GestionPlanning==1 || $protection->getPrixParCatCompta()==1)
    $flag_minMax = $rows[0]->P_GestionPlanning;

if($protection->Prot_No!=""){
    if($_GET["module"]==1 && $_GET["action"]==1)
        $texteMenu="Accueil";
    if($_GET["module"]==1 && $_GET["action"]==2)
        $texteMenu="Règlement client";
    if($_GET["module"]==7 && ($_GET["action"]==1 || $_GET["action"]==2))
        $texteMenu="Factures d'achat";
    if($_GET["module"]==6 && $_GET["action"]==1)
        $texteMenu="Caisse";
    if($_GET["module"]==1 && $_GET["action"]==3)
        $texteMenu="Saisie d'inventaire";
    if($_GET["module"]==1 && $_GET["action"]==6)
        $texteMenu="Mot de passe";
    if($protection ->PROT_Administrator==1 || $protection ->PROT_Right==1)
        $admin=1; 
    $vente=$protection ->PROT_DOCUMENT_VENTE;
    $qte_negative= $protection ->PROT_QTE_NEGATIVE;
    $rglt=$protection ->PROT_DOCUMENT_REGLEMENT;
    $flagPxRevient = $protection ->PROT_PX_REVIENT;
    $flagPxAchat = $protection ->PROT_PX_ACHAT;
    $flagProtCatCompta = $protection->PROT_CATCOMPTA;
    $flagPxVenteRemise = $protection ->PROT_SAISIE_PX_VENTE_REMISE;
    $flagDateRglt = $protection ->PROT_DATE_RGLT;
    $flagModifClient = $protection->PROT_MODIFICATION_CLIENT;
    $flagRisqueClient = $protection ->PROT_RISQUE_CLIENT;
    $flagCtrlTtCaisse = $protection ->PROT_CTRL_TT_CAISSE;
    $flagAffichageValCaisse = $protection ->PROT_AFFICHAGE_VAL_CAISSE;
    $flagModifSupprComptoir = $protection->PROT_MODIF_SUPPR_COMPTOIR;
    $flagInfoLibreArticle = $protection ->PROT_INFOLIBRE_ARTICLE;
    $flagDateMvtCaisse = $protection ->PROT_DATE_MVT_CAISSE;
    $flagDateVente = $protection ->PROT_DATE_VENTE;
    $flagDateAchat = $protection ->PROT_DATE_ACHAT;
    $flagDateStock = $protection ->PROT_DATE_STOCK;
    $flagProtApresImpression = $protection ->PROT_APRES_IMPRESSION;
    if($protection ->ProfilName=="VENDEUR" || $protection ->ProfilName=="GESTIONNAIRE")
    $profil_caisse=1;
    if($protection ->ProfilName=="COMMERCIAUX")
    $profil_commercial=1;
    if($protection ->ProfilName=="RAF" ||$protection ->ProfilName=="GESTIONNAIRE" ||$protection ->ProfilName=="SUPERVISEUR" )
    $profil_special =1;
    if($protection ->ProfilName=="RAF")
        $profil_daf=1;
    if($protection ->ProfilName=="SUPERVISEUR")
        $profil_superviseur=1;
    if($protection ->ProfilName=="GESTIONNAIRE")
        $profil_gestionnaire=1;
//$lien="http://209.126.69.121/ReportServer/Pages/ReportViewer.aspx?%2fEtatFacturation%2fAccueil&rs:Command=Render&droit=$profil_commercial";
$lien="http://209.126.69.121/ReportServer/Pages/ReportViewer.aspx?%2fEtatBiopharma%2fACCUEIL&rs:Command=Render&droit=$profil_commercial";

?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="indexMVC.php?module=1&action=1">Accueil</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div id="navbar1" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <?php
        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE!=2)){
            ?>
            <li class="dropdown <?php if($_GET["module"]==2) echo "active"; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vente <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php include("MenuVente.php"); ?>
                </ul>
            </li>
        <?php }
    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT!=2)){
?>
        <li class="dropdown <?php if($_GET["module"]==7) echo "active"; ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Achat<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <?php include("BarreMenuAchat.php"); ?>
            </ul>
        </li>

<?php }
    if($protection ->PROT_Right==1 || ($protection ->PROT_DOCUMENT_REGLEMENT!=2)){
?>
    <li class="dropdown  <?php if($_GET["module"]==1 && $_GET["action"]==2) echo "active"; ?>">
        <a href="indexMVC.php?module=1&action=2" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Règlement<span class="caret"></span></a>
    <ul class="dropdown-menu">
            <?php include("BarreMenuReglement.php"); ?>
    </ul>
    </li>
    
<?php }
    //if($protection ->PROT_Right==1 || ($protection ->PROT_CLIENT!=2 || $protection->PROT_FAMILLE!=2 || $protection ->PROT_ARTICLE!=2)){
?>
    <li class="dropdown <?php if($_GET["module"]==3) echo "active"; ?>">
          <a href="indexMVC.php?module=3&action=3" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Structure <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php include("MenuStructure.php"); ?>
          </ul>
        </li>
<?php //}
//    if($protection ->PROT_Right==1 || ($protection ->PROT_COLLABORATEUR!=2)){
    ?>
        <li class="dropdown <?php if($_GET["module"]==9) echo "active"; ?>">
              <a href="indexMVC.php?module=9&action=1" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Comptabilité <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php include("MenuComptabilite.php"); ?>
              </ul>
            </li>
    <?php
//}
    if($protection ->PROT_Right==1 || ($protection ->PROT_DOCUMENT_STOCK!=2)){
?>
    <li class="dropdown <?php if($_GET["module"]==4) echo "active"; ?>">
          <a href="indexMVC.php?module=4&action=1&type=Transfert" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mouvements<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php include("BarreMenuMouvement.php"); ?>
          </ul>
        </li>
<?php }?>
    <li class="dropdown <?php if($_GET["module"]==5) echo "active"; ?>">
        <a href="indexMVC.php?module=9&action=1" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Etats<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php include("BarreMenuEtat.php"); ?>
        </ul>
    </li>
<?php
if($protection ->PROT_MVT_CAISSE!=2 || $protection ->PROT_Right==1){
?>
        <li class="<?php if($_GET["module"]==6) echo "active"; ?>"><a href="indexMVC.php?module=6&action=1">Caisse</a></li>
    
<?php 
}
if($protection ->PROT_Right==1){
?>
    <li class="dropdown <?php if($_GET["module"]==8) echo "active"; ?>">
        <a href="indexMVC.php?module=8&action=1" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administration<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php include("BarreMenuAdmin.php"); ?>
        </ul>
    </li>
<?php
}
if($protection ->PROT_Right==1 ||$protection ->PROT_SAISIE_INVENTAIRE!=2){
?>
    <li class="<?php if($_GET["module"]==1 && $_GET["action"]==3) echo "active"; ?>"><a href="indexMVC.php?module=1&action=3">Saisie d'inventaire</a></li>
<?php }
?>
      <li class="<?php if($_GET["module"]==1 && $_GET["action"]==4) echo "active"; ?>"><a href="indexMVC.php?module=1&action=6">Mot de passe</a></li>
    </ul>
        <ul class="nav navbar-nav navbar-right">
            <li style="padding: 10px 15px;padding-top: 15px;padding-bottom: 15px;">Bienvenue <span id="userName" ><?php echo $_SESSION["login"]; ?>
                </li> 
        <li><a href="index.php?action=logout">Déconnexion <i class="fa fa-sign-out"></i></a></li>
      </ul>
        <span id="machineName" style="visibility:hidden; width:1px"><?php echo gethostname(); ?></span>
        <input type="hidden" id="PROT_No" value="<?= $protection->Prot_No; ?>"
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php 
}
?>
