<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author Test
 */

class Etat {
    public $RapportsSSRS = "";

    public function __construct(){
        $settings = parse_ini_file(__DIR__."\..\config\db.config", 1);
        $this->RapportsSSRS= "Rapport{$settings["db_name"]}";
    }

    public function doAction($action) {
        $objet = new ObjetCollector();
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($protection->Prot_No !=null && isset($_SESSION)){
            switch($action) {
                case 1 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_MVT_STOCK == 0))
                        $this->Mouvement_stk();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 2 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_INVENTAIRE_PREP == 0))
                        $this->inventaire_prep();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 3 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_MVT_STOCK == 0))
                        $this->equation_stk();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 4 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0))
                        $this->stat_articleAgence();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 5 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_PALMARES_CLT==0))
                        $this->stat_clientAgence();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 6 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->echeance_client();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 7 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->reglement_client();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 8 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->releveComtpeClient();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 9 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->etatCaisse();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 10 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->etatDette();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 11 :
                    if($protection->PROT_Right==1 || (1==1))
                        $this->stat_collaborateur();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 12 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_LIVRE_INV == 0))
                        $this->livret_inventaire();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 13 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_COLLAB_PAR_ARTICLE == 0))
                        $this->stat_collaborateur_article();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 14 :
                    if($protection->PROT_Right==1 || ($protection->PROT_RISQUE_CLIENT == 0))
                        $this->vrst_distant();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 15 :
                    if($protection->PROT_Right==1 || ($protection->PROT_RISQUE_CLIENT == 0))
                        $this->vrst_bancaire();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 16 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->etat_fondCaisse();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 17 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->etat_dette_detail();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 18 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->stat_article_achatCA();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 19 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->stat_article_achat();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 20 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_FRS==0))
                        $this->stat_article_fournisseur();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 21 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->balance_tiers();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 22 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->ech_tiers();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 23 :
                    if($protection->PROT_Right==1 || (0==0))
                        $this->etat_reaprovisionneemnt();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 24 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->Caisse_dexploitation();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 25 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->etatTransfertCaisse();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 26 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->echeance_client2();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 27 :
                    if($protection->PROT_Right==1)
                        $this->etatStockGrandDepot();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 28 :
                    $this->etatCompteResultat();
                    break;
                case 29 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0))
                        $this->etatCentralRapArticle();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 30 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                        $this->echeance_client_age();
                    else
                        header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 31 :
                    //if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                    $this->Ecriture_comptable();
                    //else
                    //     header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 32 :
                    //if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                    $this->grand_livre_tiers_commercial();
                    //else
                    //     header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 33 :
                    //if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                    $this->articleAbsentBoutique();
                    //else
                    //     header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 34 :
                    //if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                    $this->articleDormant();
                    //else
                    //     header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;

                case 35 :
                    //if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                    $this->BalanceAnalytique();
                    //else
                    //     header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;

                case 36 :
                    //if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                    $this->BalanceDesComptes();
                    //else
                    //     header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;

                case 37 :
                    //if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                    $this->GrandLivreAnalytique();
                    //else
                    //     header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 38 :
                    //if($protection->PROT_Right==1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0))
                    $this->EtatJournal();
                    //else
                    //     header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 39 :
                    if($protection->PROT_Right==1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0))
                        $this->statClientParArticle();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;

                default :
                    $this->Mouvement_stk(); // On décide ce que l'on veut faire
            }
        } else
            header('Location: accueil');
    }

    public function statClientParArticle(){
        $query = "/".$this->RapportsSSRS."/Rapports/Statistique client par article";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function Ecriture_comptable() {
        $query = "/".$this->RapportsSSRS."/Rapports/Ecriture comptable";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }
    public function Mouvement_stk() {
        $query = "/".$this->RapportsSSRS."/Rapports/Mouvement_de_stock";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }
    public function etatTransfertCaisse() {
        $query = "/".$this->RapportsSSRS."/Rapports/Transfert caisse";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function Caisse_dexploitation() {
        $query = "/".$this->RapportsSSRS."/Rapports/Caisse d'exploitation";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function inventaire_prep() {
        $query =  "/".$this->RapportsSSRS."/Rapports/Inventaire_preparatoire";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function equation_stk() {
        $query = "/".$this->RapportsSSRS."/Rapports/Equation_du_stock";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");

    }

    public function stat_articleAgence() {
        $query = "/".$this->RapportsSSRS."/Rapports/Statistique article par agence";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function stat_clientAgence() {
        $query = "/".$this->RapportsSSRS."/Rapports/Statistique client par agence";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function echeance_client() {
        $query = "/".$this->RapportsSSRS."/Rapports/Echeance client";//$_REQUEST["reportName"];
        if(isset($_GET["typeTiers"]))
            if($_GET["typeTiers"]==1)
                $query = "/".$this->RapportsSSRS."/Rapports/Echeance fournisseur";//$_REQUEST["reportName"];
            else
                $query = "/".$this->RapportsSSRS."/Rapports/Echeance client";//$_REQUEST["reportName"];
        if(isset($_POST["reportName"]))
            $query = $_POST["reportName"];//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function echeance_client_age() {
        $query = "/".$this->RapportsSSRS."/Rapports/Echeance client age";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function grand_livre_tiers_commercial() {
        $query = "/".$this->RapportsSSRS."/Rapports/Grand livre tiers commercial";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }


    public function echeance_client2() {
        $query = "/".$this->RapportsSSRS."/Rapports/Echeance client";//$_REQUEST["reportName"];
        if(isset($_GET["typeTiers"]))
            if($_GET["typeTiers"]==1)
                $query = "/".$this->RapportsSSRS."/Rapports/Echeance fournisseur";//$_REQUEST["reportName"];
            else
                $query = "/".$this->RapportsSSRS."/Rapports/Echeance client";//$_REQUEST["reportName"];
        if(isset($_POST["reportName"]))
            $query = $_POST["reportName"];//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function reglement_client() {
        $query = "/".$this->RapportsSSRS."/Rapports/Règlement client";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function releveComtpeClient() {
        $query = "/".$this->RapportsSSRS."/Relevé compte client";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etatCaisse() {
        $query = "/".$this->RapportsSSRS."/Rapports/Etat caisse";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etatDette() {
            $query = "/".$this->RapportsSSRS."/Rapports/Etat des dettes";//$_REQUEST["reportName"];
            include("pages/Etat/etatSSRS.php");
    }

    public function stat_collaborateur() {
        $query = "/".$this->RapportsSSRS."/Rapports/Statistique collaborateur par client";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function stat_collaborateur_article() {
        $query = "/".$this->RapportsSSRS."/Rapports/Statistique collaborateur par article";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function livret_inventaire() {
        $dateIndique = 1;
        $query = "/".$this->RapportsSSRS."/Rapports/Livre d'inventaire";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function vrst_distant() {
        $query = "/".$this->RapportsSSRS."/Rapports/Versement distant";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function vrst_bancaire() {
        $query = "/".$this->RapportsSSRS."/Rapports/Versement bancaire";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etat_fondCaisse() {
        $query = "/".$this->RapportsSSRS."/Rapports/Controle des reports de fond de caisse";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etat_dette_detail() {
               $query = "/".$this->RapportsSSRS."/Rapports/Etat des dettes detail";//$_REQUEST["reportName"];
               include("pages/Etat/etatSSRS.php");
    }

    public function stat_article_achat() {
        $query = "/".$this->RapportsSSRS."/Rapports/Statistique des achats";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function stat_article_achatCA() {
         $query = "/".$this->RapportsSSRS."/Rapports/Statistique des achats analytique";//$_REQUEST["reportName"];
         include("pages/Etat/etatSSRS.php");
    }

    public function stat_article_fournisseur() {
        $query = "/".$this->RapportsSSRS."/Rapports/Statistique article par fournisseur";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function balance_tiers() {
        $query = "/".$this->RapportsSSRS."/Rapports/Balance des tiers commercial";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function ech_tiers() {
        $query = "/".$this->RapportsSSRS."/Rapports/Echeance client";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etat_reaprovisionneemnt() {
        $query = "/".$this->RapportsSSRS."/Rapports/Etat réaprovisionnement";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function etatStockGrandDepot() {
        $query = "/".$this->RapportsSSRS."/Rapports/Stock_grand_depot";
        include("pages/Etat/etatSSRS.php");
    }
    public function etatCompteResultat() {
        $query = "/".$this->RapportsSSRS."/Rapports/Etat du compte du résultat";
        include("pages/Etat/etatSSRS.php");
    }
    public function etatCentralRapArticle() {
        $query = "/".$this->RapportsSSRS."/Rapports/Centrale_rap_article";
        include("pages/Etat/etatSSRS.php");
    }

    public function articleAbsentBoutique() {
        $query = "/".$this->RapportsSSRS."/Rapports/Article Absent Boutique";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function articleDormant() {
        $query = "/".$this->RapportsSSRS."/Rapports/Articles dormants";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }


    public function BalanceAnalytique(){
        $query = "/".$this->RapportsSSRS."/Rapports/Balance analytique";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function BalanceDesComptes(){
        $query = "/".$this->RapportsSSRS."/Rapports/Balance des comptes";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function GrandLivreAnalytique(){
        $query = "/".$this->RapportsSSRS."/Rapports/Grand livre analytique";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }

    public function EtatJournal(){
        $query = "/".$this->RapportsSSRS."/Rapports/Etat journal";//$_REQUEST["reportName"];
        include("pages/Etat/etatSSRS.php");
    }
}
?>
