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

$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
$pparametrecial=$protection->getParametrecial();
if($pparametrecial->p_GestionPlanning==1 || $pparametrecial->p_ReportPrixRev==1)
    $flag_minMax = $pparametrecial->p_GestionPlanning;

if($protection->Prot_No!=null) {
    if ($_GET["module"] == 1 && $_GET["action"] == 1)
        $texteMenu = "Accueil";
    if ($_GET["module"] == 7 && ($_GET["action"] == 1 || $_GET["action"] == 2))
        $texteMenu = "Factures d'achat";
    if ($_GET["module"] == 6 && $_GET["action"] == 1)
        $texteMenu = "Caisse";
    if ($_GET["module"] == 1 && $_GET["action"] == 3)
        $texteMenu = "Saisie d'inventaire";
    if ($_GET["module"] == 1 && $_GET["action"] == 6)
        $texteMenu = "Mot de passe";
    if ($protection->PROT_Administrator == 1 || $protection->PROT_Right == 1)
        $admin = 1;
    $vente = $protection->PROT_DOCUMENT_VENTE;
    $qte_negative = $protection->PROT_QTE_NEGATIVE;
    $rglt = $protection->PROT_DOCUMENT_REGLEMENT;
    $flagPxRevient = $protection->PROT_PX_REVIENT;
    $flagPxAchat = $protection->PROT_PX_ACHAT;
    $flagPxVenteRemise = $protection->PROT_SAISIE_PX_VENTE_REMISE;
    $flagDateRglt = $protection->PROT_DATE_RGLT;
    $flagModifClient = $protection->PROT_MODIFICATION_CLIENT;
    $flagRisqueClient = $protection->PROT_RISQUE_CLIENT;
    $flagCtrlTtCaisse = $protection->PROT_CTRL_TT_CAISSE;
    $flagAffichageValCaisse = $protection->PROT_AFFICHAGE_VAL_CAISSE;
    $flagModifSupprComptoir = $protection->PROT_MODIF_SUPPR_COMPTOIR;
    $flagInfoLibreArticle = $protection->PROT_INFOLIBRE_ARTICLE;
    $flagDateMvtCaisse = $protection->PROT_DATE_MVT_CAISSE;
    $flagDateVente = $protection->PROT_DATE_VENTE;
    $flagDateAchat = $protection->PROT_DATE_ACHAT;
    $flagDateStock = $protection->PROT_DATE_STOCK;
    $flagProtApresImpression = $protection->PROT_APRES_IMPRESSION;
    if ($protection->ProfilName == "VENDEUR" || $protection->ProfilName == "GESTIONNAIRE")
        $profil_caisse = 1;
    if ($protection->ProfilName == "COMMERCIAUX")
        $profil_commercial = 1;
    if ($protection->ProfilName == "RAF" || $protection->ProfilName == "GESTIONNAIRE" || $protection->ProfilName == "SUPERVISEUR")
        $profil_special = 1;
    if ($protection->ProfilName == "RAF")
        $profil_daf = 1;
    if ($protection->ProfilName == "SUPERVISEUR")
        $profil_superviseur = 1;
    if ($protection->ProfilName == "GESTIONNAIRE")
        $profil_gestionnaire = 1;
}
?>
