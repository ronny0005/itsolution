<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ProtectionClass extends Objet{
    //put your code here
    public $db,$PROT_User,$PROT_Pwd,$ProfilName,$PROT_Administrator,$PROT_Email,$ProtectAdmin,$PROT_UserProfil,$PROT_Description,$PROT_Right,$Prot_No,$PROT_PwdStatus,$cbMarq,
        $PROT_CLIENT,$PROT_FOURNISSEUR,$PROT_COLLABORATEUR,$PROT_FAMILLE,$PROT_ARTICLE,$PROT_DOCUMENT_STOCK,
        $PROT_DOCUMENT_ACHAT ,$PROT_DOCUMENT_VENTE,$PROT_PX_ACHAT,$PROT_PX_REVIENT,$PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE,
        $PROT_DATE_VENTE,$PROT_DATE_ACHAT,$PROT_DATE_COMPTOIR,$PROT_DATE_RGLT,$PROT_DOCUMENT_VENTE_DEVIS,
        $PROT_DOCUMENT_VENTE_FACTURE,$PROT_DOCUMENT_VENTE_BLIVRAISON,$PROT_DOCUMENT_VENTE_RETOUR,$PROT_DOCUMENT_VENTE_AVOIR,
        $PROT_DOCUMENT_ENTREE , $PROT_DATE_STOCK, $PROT_DOCUMENT_SORTIE,$PROT_DOCUMENT_REGLEMENT ,$PROT_MVT_CAISSE,$PROT_QTE_NEGATIVE,
        $PROT_SAISIE_REGLEMENT_FOURNISSEUR,$PROT_DEPRECIATION_STOCK,$PROT_SAISIE_REGLEMENT,$PROT_DEPOT,$PROT_RISQUE_CLIENT,
        $PROT_SAISIE_INVENTAIRE,$PROT_AFFICHAGE_VAL_CAISSE ,$PROT_CTRL_TT_CAISSE,$PROT_INFOLIBRE_ARTICLE,$PROT_DATE_MVT_CAISSE
        ,$PROT_GENERATION_RGLT_CLIENT,$PROT_DOCUMENT_ACHAT_FACTURE,$PROT_MODIF_SUPPR_COMPTOIR,$PROT_APRES_IMPRESSION
        ,$PROT_TICKET_APRES_IMPRESSION,$PROT_AVANT_IMPRESSION, $PROT_DOCUMENT_INTERNE_2,$PROT_MODIFICATION_CLIENT
        ,$PROT_ETAT_INVENTAIRE_PREP,$PROT_ETAT_LIVRE_INV,$PROT_ETAT_STAT_ARTICLE_PAR_ART,$PROT_ETAT_STAT_ARTICLE_PAR_FAM
        ,$PROT_ETAT_STAT_ARTICLE_PALMARES,$PROT_ETAT_MVT_STOCK,$PROT_ETAT_CLT_PAR_FAM_ART,$PROT_ETAT_CLT_PAR_ARTICLE,$PROT_ETAT_PALMARES_CLT
        ,$PROT_ETAT_STAT_FRS_FAM_ART,$PROT_ETAT_STAT_FRS,$PROT_DOCUMENT_ACHAT_RETOUR,$PROT_GEN_ECART_REGLEMENT,$PROT_ETAT_STAT_CAISSE_ARTICLE
        ,$PROT_ETAT_STAT_CAISSE_FAM_ARTICLE,$PROT_ETAT_CAISSE_MODE_RGLT,$PROT_ETAT_RELEVE_CPTE_CLIENT,$PROT_ETAT_STAT_COLLAB_PAR_TIERS
        ,$PROT_OUVERTURE_TOUTE_LES_CAISSES,$PROT_ETAT_STAT_COLLAB_PAR_ARTICLE,$PROT_ETAT_STAT_COLLAB_PAR_FAMILLE,$PROT_ETAT_STAT_FRS_PAR_FAMILLE
        ,$PROT_ETAT_STAT_FRS_PAR_ARTICLE,$PROT_ETAT_STAT_ACHAT_ANALYTIQUE,$PROT_ETAT_RELEVE_ECH_CLIENT,$PROT_ETAT_RELEVE_ECH_FRS
        ,$PROT_VENTE_COMPTOIR,$PROT_CLOTURE_CAISSE,$PROT_SAISIE_PX_VENTE_REMISE,$PROT_TARIFICATION_CLIENT,$PROT_CBCREATEUR;
    public $table = 'F_PROTECTIONCIAL';
    public $lien = 'fprotectioncial';


    function __construct($nom,$mdp)
    {
        $objhigher = $this->getApiJson("/user={$this->formatString($nom)}&mdp={$this->formatString($mdp)}");

        if(isset($objhigher))
            $this->initParam($objhigher);
    }

    public function getDepotUser($protNo)
    {
        return $this->getApiJson("/getDepotUser&protNo=$protNo");
    }

    public function allProfil(){
        return $this->getApiJson("/allProfil");
    }


    public function getNumContribuable()
    {
        $this->lien = "pdossier";
        return $this->getApiJson("/all");
    }

    public function getUserList()
    {
        return $this->getApiJson("/getUserList");
    }



    public function initParam($rows)
    {
        if (isset($rows)) {
            $this->cbMarq = $rows->cbMarq;
            $this->PROT_User = $rows->PROT_User;
            $this->PROT_Pwd = $rows->PROT_Pwd;
            $this->ProfilName = $rows->ProfilName;
            $this->PROT_PwdStatus = $rows->PROT_PwdStatus;
            $this->PROT_Administrator = $rows->PROT_Administrator;
            $this->PROT_Description = $rows->PROT_Description;
            $this->PROT_Right = $rows->PROT_Right;
            $this->Prot_No = $rows->Prot_No;
            $this->PROT_No = $rows->Prot_No;
            $this->PROT_CLIENT = $rows->PROT_CLIENT;
            $this->PROT_Email = $rows->PROT_Email;
            $this->ProtectAdmin = $rows->ProtectAdmin;
            $this->PROT_UserProfil = $rows->PROT_UserProfil;
            $this->PROT_FOURNISSEUR = $rows->PROT_FOURNISSEUR;
            $this->PROT_COLLABORATEUR = $rows->PROT_COLLABORATEUR;
            $this->PROT_FAMILLE = $rows->PROT_FAMILLE;
            $this->PROT_ARTICLE = $rows->PROT_ARTICLE;
            $this->PROT_OUVERTURE_TOUTE_LES_CAISSES = $rows->PROT_OUVERTURE_TOUTE_LES_CAISSES;
            $this->PROT_MODIFICATION_CLIENT = $rows->PROT_MODIFICATION_CLIENT;
            $this->PROT_APRES_IMPRESSION = $rows->PROT_APRES_IMPRESSION;
            $this->PROT_AVANT_IMPRESSION = $rows->PROT_AVANT_IMPRESSION;
            $this->PROT_TICKET_APRES_IMPRESSION = $rows->PROT_TICKET_APRES_IMPRESSION;
            $this->PROT_GENERATION_RGLT_CLIENT = $rows->PROT_GENERATION_RGLT_CLIENT;
            $this->PROT_DOCUMENT_STOCK = $rows->PROT_DOCUMENT_STOCK;
            $this->PROT_DOCUMENT_ACHAT = $rows->PROT_DOCUMENT_ACHAT;
            $this->PROT_TARIFICATION_CLIENT = $rows->PROT_TARIFICATION_CLIENT;
            $this->PROT_MODIF_SUPPR_COMPTOIR = $rows->PROT_MODIF_SUPPR_COMPTOIR;
            $this->PROT_DOCUMENT_ACHAT_FACTURE = $rows->PROT_DOCUMENT_ACHAT_FACTURE;
            $this->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE = $rows->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE;
            $this->PROT_DOCUMENT_INTERNE_2 = $rows->PROT_DOCUMENT_INTERNE_2;
            $this->PROT_DOCUMENT_VENTE = $rows->PROT_DOCUMENT_VENTE;
            $this->PROT_PX_ACHAT = $rows->PROT_PX_ACHAT;
            $this->PROT_DEPRECIATION_STOCK = $rows->PROT_DEPRECIATION_STOCK;
            $this->PROT_PX_REVIENT = $rows->PROT_PX_REVIENT;
            $this->PROT_DATE_STOCK = $rows->PROT_DATE_STOCK;
            $this->PROT_DATE_VENTE = $rows->PROT_DATE_VENTE;
            $this->PROT_DATE_ACHAT = $rows->PROT_DATE_ACHAT;
            $this->PROT_DATE_COMPTOIR = $rows->PROT_DATE_COMPTOIR;
            $this->PROT_VENTE_COMPTOIR= $rows->PROT_VENTE_COMPTOIR;
            $this->PROT_DATE_RGLT = $rows->PROT_DATE_RGLT;
            $this->PROT_GEN_ECART_REGLEMENT = $rows->PROT_GEN_ECART_REGLEMENT;
            $this->PROT_ETAT_STAT_CAISSE_ARTICLE = $rows->PROT_ETAT_STAT_CAISSE_ARTICLE;
            $this->PROT_ETAT_STAT_CAISSE_FAM_ARTICLE = $rows->PROT_ETAT_STAT_CAISSE_FAM_ARTICLE;
            $this->PROT_ETAT_CAISSE_MODE_RGLT = $rows->PROT_ETAT_CAISSE_MODE_RGLT;
            $this->PROT_DOCUMENT_VENTE_DEVIS = $rows->PROT_DOCUMENT_VENTE_DEVIS;
            $this->PROT_DOCUMENT_VENTE_FACTURE = $rows->PROT_DOCUMENT_VENTE_FACTURE;
            $this->PROT_DOCUMENT_VENTE_BLIVRAISON = $rows->PROT_DOCUMENT_VENTE_BLIVRAISON;
            $this->PROT_DOCUMENT_VENTE_RETOUR = $rows->PROT_DOCUMENT_VENTE_RETOUR;
            $this->PROT_DOCUMENT_VENTE_AVOIR = $rows->PROT_DOCUMENT_VENTE_AVOIR;
            $this->PROT_DOCUMENT_ACHAT_RETOUR = $rows->PROT_DOCUMENT_ACHAT_RETOUR;
            $this->PROT_DOCUMENT_ENTREE = $rows->PROT_DOCUMENT_ENTREE;
            $this->PROT_DOCUMENT_SORTIE = $rows->PROT_DOCUMENT_SORTIE;
            $this->PROT_DOCUMENT_REGLEMENT = $rows->PROT_DOCUMENT_REGLEMENT;
            $this->PROT_MVT_CAISSE = $rows->PROT_MVT_CAISSE;
            $this->PROT_QTE_NEGATIVE = $rows->PROT_QTE_NEGATIVE;
            $this->PROT_SAISIE_INVENTAIRE = $rows->PROT_SAISIE_INVENTAIRE;
            $this->PROT_SAISIE_REGLEMENT = $rows->PROT_SAISIE_REGLEMENT;
            $this->PROT_SAISIE_REGLEMENT_FOURNISSEUR = $rows->PROT_SAISIE_REGLEMENT_FOURNISSEUR;
            $this->PROT_DEPOT = $rows->PROT_DEPOT;
            $this->PROT_RISQUE_CLIENT = $rows->PROT_RISQUE_CLIENT;
            $this->PROT_AFFICHAGE_VAL_CAISSE = $rows->PROT_AFFICHAGE_VAL_CAISSE;
            $this->PROT_CTRL_TT_CAISSE = $rows->PROT_CTRL_TT_CAISSE;
            $this->PROT_INFOLIBRE_ARTICLE = $rows->PROT_INFOLIBRE_ARTICLE;
            $this->PROT_DATE_MVT_CAISSE = $rows->PROT_DATE_MVT_CAISSE;
            $this->PROT_ETAT_INVENTAIRE_PREP = $rows->PROT_ETAT_INVENTAIRE_PREP;
            $this->PROT_ETAT_LIVRE_INV = $rows->PROT_ETAT_LIVRE_INV;
            $this->PROT_ETAT_STAT_ARTICLE_PAR_ART = $rows->PROT_ETAT_STAT_ARTICLE_PAR_ART;
            $this->PROT_ETAT_STAT_ARTICLE_PAR_FAM = $rows->PROT_ETAT_STAT_ARTICLE_PAR_FAM;
            $this->PROT_ETAT_STAT_ARTICLE_PALMARES = $rows->PROT_ETAT_STAT_ARTICLE_PALMARES;
            $this->PROT_ETAT_MVT_STOCK = $rows->PROT_ETAT_MVT_STOCK;
            $this->PROT_ETAT_CLT_PAR_FAM_ART = $rows->PROT_ETAT_CLT_PAR_FAM_ART;
            $this->PROT_ETAT_CLT_PAR_ARTICLE = $rows->PROT_ETAT_CLT_PAR_ARTICLE;
            $this->PROT_ETAT_PALMARES_CLT = $rows->PROT_ETAT_PALMARES_CLT;
            $this->PROT_ETAT_STAT_FRS_FAM_ART = $rows->PROT_ETAT_STAT_FRS_FAM_ART;
            $this->PROT_ETAT_STAT_FRS = $rows->PROT_ETAT_STAT_FRS;
            $this->PROT_ETAT_RELEVE_CPTE_CLIENT = $rows->PROT_ETAT_RELEVE_CPTE_CLIENT;
            $this->PROT_ETAT_STAT_COLLAB_PAR_TIERS = $rows->PROT_ETAT_STAT_COLLAB_PAR_TIERS;
            $this->PROT_ETAT_STAT_COLLAB_PAR_ARTICLE = $rows->PROT_ETAT_STAT_COLLAB_PAR_ARTICLE;
            $this->PROT_ETAT_STAT_COLLAB_PAR_FAMILLE = $rows->PROT_ETAT_STAT_COLLAB_PAR_FAMILLE;
            $this->PROT_ETAT_RELEVE_ECH_CLIENT = $rows->PROT_ETAT_RELEVE_ECH_CLIENT;
            $this->PROT_ETAT_RELEVE_ECH_FRS = $rows->PROT_ETAT_RELEVE_ECH_FRS;
            $this->PROT_SAISIE_PX_VENTE_REMISE = $rows->PROT_SAISIE_PX_VENTE_REMISE;
            $this->PROT_CBCREATEUR = $rows->PROT_CBCREATEUR;
            $this->PROT_CLOTURE_CAISSE = $rows->PROT_CLOTURE_CAISSE;
        }
    }

    public function connexionProctectionByProtNo($prot_no){
        $this->initParam($this->getApiJson("/connexionProctectionByProtNo&protNo=$prot_no"));
    }

    public function majProtectioncial($depot,$depotPrincipal){
        parent::maj('PROT_User', $this->PROT_User);
        parent::maj('PROT_Description', $this->PROT_Description);
        parent::maj('PROT_Pwd', $this->PROT_Pwd);
        parent::maj('PROT_Email', $this->PROT_Email);
        parent::maj('PROT_Right', $this->PROT_Right);
        parent::maj('PROT_PwdStatus', $this->PROT_PwdStatus);
        if($depot!=0)
            $this->ajoutDepotUser($this->PROT_No,implode( ",",$depot));
        if($depotPrincipal!=0)
            $this->setDepotUser($this->PROT_No,implode( ",",$depotPrincipal));

    }

    public function createUser() {
        return $this->getApiJson("/createUser/protUser={$this->PROT_User}&protPwd={$this->PROT_Pwd}&protDescription={$this->PROT_Description}&protRight={$this->PROT_Right}&protEmail={$this->PROT_Email}&protUserProfil={$this->PROT_UserProfil}&ProtPwdStatus={$this->PROT_PwdStatus}");
    }

    public function getInfoRAFControleur(){
        return"";

        $this->initParam($this->getApiJson("/getInfoRAFControleur"));


    }

    function visuMenu ($value){
        if($value=="Vente" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE!=2)))
             return "";
        if($value=="Devis" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE_DEVIS!=2)))
            return "";
        if($value=="BonLivraison" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE_BLIVRAISON!=2)))
            return "";
        if($value=="VenteAvoir" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE_AVOIR!=2)))
            return "";
        if($value=="VenteRetour" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE_RETOUR!=2)))
            return "";
        if($value=="Ticket" && (($this->PROT_Right==1 || ($this->PROT_VENTE_COMPTOIR!=2))))
            return "";

        if($value=="Achat" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ACHAT_FACTURE!=2)))
            return "";
        if($value=="PreparationCommande" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)))
            return "";
        if($value=="AchatPreparationCommande" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)))
            return "";
        if($value=="AchatRetour" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ACHAT_RETOUR!=2)))
            return "";

        if($value=="Transfert" && ($this->PROT_Right==1 || ($this->PROT_DEPRECIATION_STOCK!=2)))
            return"";
        if($value=="Entree" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ENTREE!=2)))
            return"";
        if($value=="Sortie" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_SORTIE!=2)))
            return"";
        if($value=="Transfert_detail" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_INTERNE_2!=2)))
            return"";
        if($value=="Transfert_confirmation" && ($this->PROT_Right==1 || ($this->PROT_DEPRECIATION_STOCK!=2)))
            return"";
        if($value=="Transfert_valid_confirmation" && ($this->PROT_Right==1 || ($this->PROT_DEPRECIATION_STOCK!=2)))
            return"";

        return "style='display: none'";
    }

    function lienMenu ($value){
        if($value=="Vente" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE!=2)))
            return "listeFacture-Vente";
        if($value=="Devis" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE_DEVIS!=2)))
            return "listeFacture-Devis";
        if($value=="BonLivraison" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE_BLIVRAISON!=2)))
            return "listeFacture-BonLivraison";
        if($value=="VenteAvoir" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE_AVOIR!=2)))
            return "listeFacture-VenteAvoir";
        if($value=="VenteRetour" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_VENTE_RETOUR!=2)))
            return "listeFacture-VenteRetour";
        if(($value=="Ticket" && ($this->PROT_Right==1 || ($this->PROT_VENTE_COMPTOIR!=2))))
            return "listeFacture-Ticket";

        if($value=="Achat" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ACHAT_FACTURE!=2)))
            return "listeFacture-Achat";
        if($value=="PreparationCommande" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)))
            return "listeFacture-PreparationCommande";
        if($value=="AchatPreparationCommande" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)))
            return "listeFacture-AchatPreparationCommande";
        if($value=="AchatRetour" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ACHAT_RETOUR!=2)))
            return "listeFacture-AchatRetour";

        if($value=="Transfert" && ($this->PROT_Right==1 || ($this->PROT_DEPRECIATION_STOCK!=2)))
            return "listeFacture-Transfert";
        if($value=="Entree" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_ENTREE!=2)))
            return "listeFacture-Entree";
        if($value=="Sortie" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_SORTIE!=2)))
            return "listeFacture-Sortie";
        if($value=="Transfert_detail" && ($this->PROT_Right==1 || ($this->PROT_DOCUMENT_INTERNE_2!=2)))
            return "listeFacture-Transfert_detail";
        if($value=="Transfert_confirmation" && ($this->PROT_Right==1 || ($this->PROT_DEPRECIATION_STOCK!=2)))
            return "listeFacture-Transfert_confirmation";
        if($value=="Transfert_valid_confirmation" && ($this->PROT_Right==1 || ($this->PROT_DEPRECIATION_STOCK!=2)))
            return "listeFacture-Transfert_valid_confirmation";
        return "";
    }

    function lienMenuNouveau ($value){
        if($value=="Vente")
            return "Document-FactureVente";
        if($value=="Devis")
            return "Document-FactureDevis";
        if($value=="BonLivraison")
            return "Document-FactureBonLivraison";
        if($value=="VenteAvoir")
            return "Document-FactureAvoir";
        if($value=="VenteRetour")
            return "Document-FactureVenteRetour";
        if($value=="Ticket")
            return "Document-Ticket";

        if($value=="Achat")
            return "Document-FactureAchat";
        if($value=="PreparationCommande")
            return "Document-FacturePreparationCommande";
        if($value=="AchatPreparationCommande")
            return "Document-FactureAchatPreparationCommande";
        if($value=="AchatRetour")
            return "Document-FactureAchatRetour";

        if($value=="Transfert")
            return "Document-MvtTransfert";
        if($value=="Entree")
            return "Document-MvtEntree";
        if($value=="Sortie")
            return "Document-MvtSortie";
        if($value=="Transfert_detail")
            return "Document-MvtTransfert_detail";
        if($value=="Transfert_confirmation")
            return "Document-MvtTransfert_confirmation";
        if($value=="Transfert_valid_confirmation")
            return "Document-MvtTransfert_valid_confirmation";

        return "";
    }

    function afficheClientListe($type){
        if(!($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="Sortie" || $type=="Entree" ||$type=="Transfert" || $type=="Transfert_detail" ||
            $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande"))
            return "";
        return "style='display:none'";
    }
    function afficheFournisseurListe($type){
        if($type=="Achat" || $type=="AchatC" || $type=="AchatT" ||
            $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande")
            return "";
        return "style='display:none'";
    }

    function afficheDepotListe($type){
        if(!($type=="Achat" || $type=="AchatC" || $type=="AchatT" ||
                $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande")
            || $type=="Entree"|| $type=="Sortie")
            return "";
        return "style='display:none'";
    }

    function afficheDepotDestListe($type){
        if($type=="Transfert_detail" || $type=="Transfert" || $type=="Transfert_valid_confirmation" || $type=="Transfert_confirmation")
            return "";
        return "style='display:none'";
    }

    function afficheTransformListe($type){
        if(($type=="BonLivraison" || $type=="Devis") && ($this->isAdministrator() || ($this->protectedType($type))))
            return "";
        return "style='display:none'";
    }


    function afficheStatutListe($type){
        if($type=="BonLivraison" || $type=="Vente" || $type=="Ticket" || $type=="Retour" || $type=="VenteT" || $type=="VenteC" || $type=="RetourT" || $type=="RetourC" || $type=="AchatC" || $type=="Achat"  || $type=="AchatT"
            || $type=="AchatRetourC" || $type=="AchatRetour"  || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande")
            return "";
        return "style='display:none'";
    }

    function afficheModifListe($type){
        if(($type=="BonLivraison" || $type=="Devis") && (($this ->isAdministrator()) || ($this->protectedType($type))))
            return "";
        return "style='display:none'";
    }

    function isAdministrator(){
        if(($this ->PROT_Administrator==1 || $this->PROT_Right==1))
            return true;
        return false;
    }
    function listeFactureNom ($value){
        if($value=="Vente" || $value=="VenteC" || $value=="VenteT")
            return "Document de vente";
        if($value=="Devis")
            return "Document de devis";
        if($value=="BonLivraison")
            return "Document de bon de livraison";
        if($value=="VenteAvoir")
            return "Document d'avoir de vente";
        if($value=="VenteRetour")
            return "Document de retour de vente";
        if($value=="Ticket")
            return "Document ticket";

        if($value=="Achat"  || $value=="AchatC" || $value=="AchatT")
            return "Document d'achat";
        if($value=="PreparationCommande")
            return "Document de préparation de commande";
        if($value=="AchatPreparationCommande")
            return "Document d'achat préparation de commande";
        if($value=="AchatRetour")
            return "Document de retour d'achat ";

        if($value=="Transfert")
            return "Document de transfert";
        if($value=="Entree")
            return "Document d'entrée";
        if($value=="Sortie" )
            return "Document de sortie";
        if($value=="Transfert_detail")
            return "Document de transfert détail";
        if($value=="Transfert_confirmation")
            return "Document confirmation de transfert";
        if($value=="Transfert_valid_confirmation")
            return "Document validation confirmation transfert";

        return "";
    }

    public function decrypteMdp($mdp)
    {
        $mdp = str_replace("›", "1", $mdp);
        $mdp = str_replace("˜", "2", $mdp);
        $mdp = str_replace("™", "3", $mdp);
        $mdp = str_replace("ž", "4", $mdp);
        $mdp = str_replace("Ÿ", "5", $mdp);
        $mdp = str_replace("œ", "6", $mdp);
        $mdp = str_replace(" ", "7", $mdp);
        $mdp = str_replace("’", "8", $mdp);
        $mdp = str_replace("“", "9", $mdp);
        $mdp = str_replace("š", "0", $mdp);
        $mdp = str_replace("ë", "A", $mdp);
        $mdp = str_replace("è", "B", $mdp);
        $mdp = str_replace("é", "C", $mdp);
        $mdp = str_replace("î", "D", $mdp);
        $mdp = str_replace("ï", "E", $mdp);
        $mdp = str_replace("ì", "F", $mdp);
        $mdp = str_replace("í", "G", $mdp);
        $mdp = str_replace("â", "H", $mdp);
        $mdp = str_replace("ã", "I", $mdp);
        $mdp = str_replace("à", "J", $mdp);
        $mdp = str_replace("æ", "L", $mdp);
        $mdp = str_replace("ç", "M", $mdp);
        $mdp = str_replace("ä", "N", $mdp);
        $mdp = str_replace("å", "O", $mdp);
        $mdp = str_replace("ú", "P", $mdp);
        $mdp = str_replace("û", "Q", $mdp);
        $mdp = str_replace("ø", "R", $mdp);
        $mdp = str_replace("ù", "S", $mdp);
        $mdp = str_replace("þ", "T", $mdp);
        $mdp = str_replace("ÿ", "U", $mdp);
        $mdp = str_replace("ü", "V", $mdp);
        $mdp = str_replace("ý", "W", $mdp);
        $mdp = str_replace("ò", "X", $mdp);
        $mdp = str_replace("ó", "Y", $mdp);
        $mdp = str_replace("ð", "Z", $mdp);
        $mdp = str_replace("C", "é", $mdp);
        $mdp = str_replace("B", "è", $mdp);
        $mdp = str_replace("M", "ç", $mdp);
        $mdp = str_replace("J", "à", $mdp);
        $mdp = str_replace("E", "ï", $mdp);
        $mdp = str_replace("Ë", "a", $mdp);
        $mdp = str_replace("È", "b", $mdp);
        $mdp = str_replace("É", "c", $mdp);
        $mdp = str_replace("Î", "d", $mdp);
        $mdp = str_replace("Ï", "e", $mdp);
        $mdp = str_replace("Ì", "f", $mdp);
        $mdp = str_replace("Í", "g", $mdp);
        $mdp = str_replace("Â", "h", $mdp);
        $mdp = str_replace("Ã", "i", $mdp);
        $mdp = str_replace("À", "j", $mdp);
        $mdp = str_replace("Æ", "l", $mdp);
        $mdp = str_replace("Ç", "m", $mdp);
        $mdp = str_replace("Ä", "n", $mdp);
        $mdp = str_replace("Å", "o", $mdp);
        $mdp = str_replace("Ú", "p", $mdp);
        $mdp = str_replace("Û", "q", $mdp);
        $mdp = str_replace("Ø", "r", $mdp);
        $mdp = str_replace("Ù", "s", $mdp);
        $mdp = str_replace("Þ", "t", $mdp);
        $mdp = str_replace("ß", "u", $mdp);
        $mdp = str_replace("Ü", "v", $mdp);
        $mdp = str_replace("Ý", "w", $mdp);
        $mdp = str_replace("Ò", "x", $mdp);
        $mdp = str_replace("Ó", "y", $mdp);
        $mdp = str_replace("Ð", "z", $mdp);
        $mdp = str_replace("c", "É", $mdp);
        $mdp = str_replace("b", "È", $mdp);
        $mdp = str_replace("m", "Ç", $mdp);
        $mdp = str_replace("j", "À", $mdp);
        $mdp = str_replace("e", "Ï", $mdp);
        //sha1($mdp);
        //md5($mdp);
        return $mdp;
    }

    public function getDelai(){
        $lien = $this->lien;
        $this->lien="ppreference";
        $var = $this->getApiJson("/info")->pr_DelaiPreAlert;
        $this->lien = $lien ;
        return $var;
    }

    public function getSoucheDepotGrpSouche($prot_no,$type){
        return $this->getApiJson("/getSoucheDepotGrpSouche&protNo=$prot_no&type=$type");
    }

    public function ajoutUser($securiteAdmin,$depot,$depotPrincipal){
        $protNo = $this->getApiJson("/ajoutUser&username={$this->formatString($this->PROT_User)}&description={$this->formatString($this->PROT_Description)}&password={$this->formatString($this->PROT_Pwd)}&email={$this->formatString($this->PROT_Email)}&protRight={$this->PROT_Right}&protUserProfil={$this->PROT_UserProfil}&protPwdStatus={$this->PROT_PwdStatus}&securiteAdmin=$securiteAdmin&protNo=".$_SESSION["id"]."&depot=$depot");
        $this->setDepotUser($this->PROT_No,implode( ",",$depotPrincipal));
    }

    public function ajoutDepotUser($protNo,$depot){
        $this->getApiExecute("/ajoutDepotUser&protNo=$protNo&depot=$depot");
    }

    public function setDepotUser($protNo,$depot){
        $this->getApiExecute("/setDepotUser&protNo=$protNo&depot=$depot");
    }

    public function alerteDocumentCatComptaTaxe(){
        $rows = $this->getApiJson("/alerteDocumentCatComptaTaxe");
        if($rows!=null) {
            $html = "<h1>Liste des documents Cat Compta HT avec taxe {$this->db->db}</h1><br/><br/>";
            $html = $html."<tr><th>Do Domaine</th><th>Do Type</th><th>DO Piece</th><th>cbMarq</th>";
            foreach($rows as $row){
                $html = $html."<tr><td>{$row->DO_Domaine}</td><td>{$row->DO_Type}</td><td>{$row->DO_Piece}</td><td>{$row->cbMarq}</td>";
            }
        }
        return $html;
    }


    public function getSoucheDepotCaisse($prot_no,$type,$souche,$ca_no,$depot,$ca_num){
        return $this->getApiJson("/getSoucheDepotCaisse&protNo=$prot_no&type=$type&doSouche=$souche&caNo=$ca_no&deNo=$depot&caNum={$this->formatString($ca_num)}");
    }

    public function getSoucheDepotGrpAffaire($prot_no,$type,$sommeil=-1){
        return $this->getApiJson("/getSoucheDepotGrpAffaire&protNo=$prot_no&type=$type&sommeil=$sommeil");
    }

    public function getAffaire($sommeil=-1) {
        $this->lien = "fcomptea";
        return $this->getApiJson("/affaire&sommeil=$sommeil");
    }

    public function getAllProfils() {
        return $this->getApiJson("/getAllProfils");
    }

    public function getSoucheAchat(){
        $this->lien = "psouche";
        return $this->getApiJson("/soucheAchat");
    }

    public function getSoucheInterne(){
        $this->lien = "psouche";
        return $this->getApiJson("/soucheInterne");
    }

    public function getSoucheVente(){
        $this->lien = "psouche";
        return $this->getApiJson("/soucheVente");
    }

    public function getPSoucheAchat($cbIndice){
        $this->lien = "psouche";
        return $this->getApiJson("/getPSoucheAchat/cbIndice=$cbIndice");
    }

    public function getPSoucheInterne($cbIndice){
        $this->lien = "psouche";
        return $this->getApiJson("/getPSoucheInterne/cbIndice=$cbIndice");
    }

    public function getPSoucheVente($cbIndice){
        $this->lien = "psouche";
        return $this->getApiJson("/getPSoucheVente/cbIndice=$cbIndice");
    }

    public function getCoNo(){
        return $this->getApiString("/getCoNo&protNo={$this->PROT_No}");
    }

    public function deconnexionTotale(){
        $query="dbcc cbsqlxp(free);
                delete from cbnotification;
                delete from cbregmessage;
                delete from cbusersession;";
        $this->db->query($query);
    }

    public function protectionListeFacture($type){
        if($this->PROT_Right==1 || $this->setvalue($type)!=2)
            return true;
        return false;
    }

    public function setvalue($type){
        $val = 0;
        if($type =="famille")
            $val=$this->PROT_FAMILLE;
        if($type =="client")
            $val=$this->PROT_CLIENT;
        if($type =="fournisseur")
            $val=$this->PROT_FOURNISSEUR;
        if($type =="collaborateur")
            $val=$this->PROT_COLLABORATEUR;
        if($type =="depot")
            $val=$this->PROT_DEPOT;
        if($type =="article")
            $val=$this->PROT_ARTICLE;
        if($type =="Vente" || $type =="VenteC" || $type =="VenteT")
            $val=$this->PROT_DOCUMENT_VENTE_FACTURE;
        if($type =="Achat" || $type =="AchatC" || $type =="AchatT")
            $val=$this->PROT_DOCUMENT_ACHAT_FACTURE;
        if($type =="AchatRetour")
            $val=$this->PROT_DOCUMENT_ACHAT_RETOUR;
        if($type =="AchatPreparationCommande" || $type =="PreparationCommande")
            $val=$this->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE;
        if($type =="Devis")
            $val=$this->PROT_DOCUMENT_VENTE_DEVIS;
        if($type =="Retour")
            $val=$this->PROT_DOCUMENT_VENTE_RETOUR;
        if($type =="Avoir")
            $val=$this->PROT_DOCUMENT_VENTE_AVOIR;
        if($type =="BonLivraison")
            $val=$this->PROT_DOCUMENT_VENTE_BLIVRAISON;
        if($type =="Entree")
            $val=$this->PROT_DOCUMENT_ENTREE;
        if($type =="Sortie")
            $val=$this->PROT_DOCUMENT_SORTIE;
        if($type =="Transfert")
            $val=$this->PROT_DEPRECIATION_STOCK;
        if($type=="Transfert_detail")
            $val=$this->PROT_DOCUMENT_INTERNE_2;
        if($type =="ReglementClient")
            $val=$this->PROT_SAISIE_REGLEMENT;
        if($type =="ReglementFournisseur")
            $val=$this->PROT_SAISIE_REGLEMENT_FOURNISSEUR;
        if($type =="MvtCaisse")
            $val=$this->PROT_MVT_CAISSE;
        if($type =="documentVente")
            $val=$this->PROT_DOCUMENT_VENTE;
        if($type =="documentAchat")
            $val=$this->PROT_DOCUMENT_ACHAT;
        if($type =="documentStock")
            $val=$this->PROT_DOCUMENT_STOCK;
        if($type =="infoLibreArticle")
            $val=$this->PROT_INFOLIBRE_ARTICLE;
        return $val;
    }

    public function protectedType($type){
        // if($this->PROT_Administrator==0 || $this->PROT_Right==0) {
        $val = $this->setvalue($type);
        if ($val != 0 && $val != 3)
            return 0;
        // }else return 0;
        return 1;

    }

    public function supprType($type){
        //    if($this->PROT_Administrator==0 && $this->PROT_Right==0) {
        $val = $this->setvalue($type);
        if ($val != 0)
            return 0;
        //    }else return 0;
        return 1;

    }

    public function nouveauType($type){
        $val=$this->setvalue($type);

        if($val==2 || $val==1)
            return 0;
        return 1;
    }

    public function majGescom(){
        if($this->PROT_UserProfil==0){
            $cbprofiluser='NULL';
        }else $cbprofiluser=$profiluser;
        $sql= "UPDATE ".$this->db->baseCompta.".[dbo].[F_PROTECTIONCPTA]
                SET [PROT_User] ='".$this->PROT_User."',cbModification=GETDATE()
                   ,[PROT_Pwd] ='".$this->crypteMdp($this->PROT_Pwd)."'
                   ,[PROT_Description] ='".$this->PROT_Description."'
                   ,[PROT_Right] =".$this->PROT_Right."
                   ,[PROT_EMail] ='".$this->PROT_EMail."'
                   ,PROT_PwdStatus =".$this->PROT_PwdSatus."
                   ,[PROT_DatePwd] =GETDATE()
                 WHERE PROT_User='".$username."'";

        $sql2 = "UPDATE F_PROTECTIONCIAL
                SET [PROT_User] ='".$username."',cbModification=GETDATE()
                   ,[PROT_Pwd] ='".$this->crypteMdp($password)."'
                   ,[PROT_Description] ='".$description."'
                   ,[PROT_Right] =".$groupeid."
                   ,[PROT_EMail] ='".$email."'
                   ,[PROT_UserProfil] =".$profiluser."
                   ,[cbPROT_UserProfil] =".$cbprofiluser."
                   ,PROT_PwdStatus =".$changepass."
                   ,[PROT_DatePwd] =GETDATE()
                 WHERE PROT_No=$id";
        return $sql.";".$sql2.";";
    }

    public function getUser(){
        $query="SELECT PROT_No,Prot_User 
                FROM F_Protectioncial";
        $result=$this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProtectionListTitre(){
        $query="SELECT PROT_Cmd TE_No,Libelle_Cmd TE_Intitule 
                FROM LIB_CMD
                WHERE Parent=-1";
        $result=$this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProtectionListElement($idParent){
        $query="SELECT PROT_Cmd TE_No,Libelle_Cmd TE_Intitule 
                FROM LIB_CMD
                WHERE Parent=$idParent AND Actif=1
                ORDER BY PROT_Cmd";
        $result=$this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserAdminMain(){
        $query="select *,CASE WHEN userName='' THEN ProfilName ELSE userName END Prot_User
                from (
                SELECT 0 as position,PROT_No,0 PROT_No_User,PROT_User as ProfilName,'' as userName
                FROM F_Protectioncial
                WHERE PROT_UserProfil=0
                union
                SELECT ROW_NUMBER() OVER (ORDER BY A.Prot_No,A.PROT_User),A.Prot_No,B.Prot_No Prot_No_User,A.PROT_User,B.Prot_User--PROT_No,Prot_User 
                FROM F_Protectioncial A
                LEFT JOIN F_PROTECTIONCIAL B ON A.PROT_No=B.PROT_UserProfil
                WHERE A.PROT_UserProfil=0
                AND B.Prot_User is not null
                ) A
                order by 2,1";
        $result=$this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProfilAdminMain(){
        $query="select *,CASE WHEN userName='' THEN ProfilName ELSE userName END Prot_User
                from (
                SELECT 0 as position,PROT_No,0 PROT_No_User,PROT_User as ProfilName,'' as userName
                FROM F_Protectioncial
                WHERE PROT_UserProfil=0
                ) A
                order by 2,1";
        $result=$this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getUtilisateurAdminMain(){
        return $this->getApiJson("/getUtilisateurAdminMain");
    }


    public function getDataUser($prot_no){
        $query = "  SELECT A.PROT_Cmd TE_No,Libelle_Cmd TE_Intitule,CASE WHEN ISNULL(B.Prot_No,0)=0 THEN 0 ELSE 1 END Prot_No,EPROT_Right
                    FROM LIB_CMD A
                    LEFT JOIN (SELECT * FROM F_EPROTECTIONCIAL WHERE Prot_No=$prot_no) B on A.PROT_Cmd=B.EPROT_Cmd
                    WHERE Actif=1 
                    ORDER BY A.PROT_Cmd";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getDataUserNo($te_no,$prot_no){
        $query = "  SELECT A.PROT_Cmd TE_No,TypeFlag,Libelle_Cmd TE_Intitule,CASE WHEN ISNULL(B.Prot_No,0)=0 THEN 0 ELSE 1 END Prot_No,EPROT_Right
                    FROM LIB_CMD A
                    LEFT JOIN (SELECT * FROM F_EPROTECTIONCIAL WHERE Prot_No=$prot_no) B on A.PROT_Cmd=B.EPROT_Cmd
                    WHERE Actif=1 AND $te_no = A.PROT_Cmd
                    ORDER BY A.PROT_Cmd";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getPrixParCatCompta(){
        $query = "  SELECT P_ReportPrixRev
                    FROM P_PARAMETRECIAL";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->P_ReportPrixRev;
    }

    public function getDataUserProfil($prot_no){
        $query = "  SELECT A.PROT_No TE_No,A.PROT_User TE_Intitule,CASE WHEN ISNULL(B.Prot_No,0)=0 THEN 0 ELSE 1 END Prot_No
                    FROM F_PROTECTIONCIAL A
                    LEFT JOIN (SELECT * FROM F_PROTECTIONCIAL WHERE PROT_No=$prot_no) B on A.PROT_No=B.PROT_UserProfil
                    WHERE A.PROT_UserProfil=0
                    ORDER BY A.PROT_No";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }


    public function updateEProtection($prot_no,$eprot_cmd,$prot_right){
        $query = "IF $prot_right=-1 
              DELETE FROM F_EPROTECTIONCIAL
                    WHERE PROT_No = $prot_no AND EPROT_Cmd = $eprot_cmd
              ELSE IF EXISTS(SELECT 1 FROM F_EPROTECTIONCIAL WHERE PROT_No = $prot_no AND EPROT_Cmd = $eprot_cmd)
                    UPDATE F_EPROTECTIONCIAL SET EPROT_Right = $prot_right, cbModification = GETDATE()
                        WHERE PROT_No = $prot_no AND EPROT_Cmd = $eprot_cmd;
                    ELSE
                        INSERT INTO F_EPROTECTIONCIAL(PROT_No,EPROT_Cmd,EPROT_Right,cbCreateur,cbModification)
                            VALUES($prot_no,$eprot_cmd,$prot_right,'COLU',GETDATE())";
        $this->db->query($query);
    }

    public function updateProfil($prot_no,$prot_no_profil){
        $query = "UPDATE F_PROTECTIONCIAL SET PROT_UserProfil= $prot_no_profil, cbModification = GETDATE()
                        WHERE PROT_No = $prot_no;";
        $this->db->query($query);
    }

    public function majCompta(){

    }

    public function insertIntoZ_Calendar_user($PROT_No,$ID_JourDebut,$ID_JourFin,$ID_HeureDebut,$ID_MinDebut,$ID_HeureFin,$ID_MinFin){
        $query ="INSERT INTO [dbo].[Z_CALENDAR_USER]
                               ([PROT_No]
                               ,[ID_JourDebut]
                               ,[ID_JourFin]
                               ,[ID_HeureDebut]
                               ,[ID_MinDebut]
                               ,[ID_HeureFin]
                               ,[ID_MinFin])
                 VALUES
                       (/*PROT_No*/$PROT_No
                       ,/*ID_JourDebut*/$ID_JourDebut
                       ,/*ID_JourFin*/$ID_JourFin
                       ,/*ID_HeureDebut*/$ID_HeureDebut
                       ,/*ID_MinDebut*/$ID_MinDebut
                       ,/*ID_HeureFin*/$ID_HeureFin
                       ,/*ID_MinFin*/$ID_MinFin)";
        $this->db->query($query);
    }


    public function deleteZ_Calendar_user($PROT_No){
        $query ="DELETE FROM  [dbo].[Z_CALENDAR_USER] WHERE PROT_No = $PROT_No";
        $this->db->query($query);
    }

    public function getZ_Calendar_user($PROT_No,$i){
        $query ="SELECT *
                 FROM Z_CALENDAR_USER
                 WHERE PROT_No=$PROT_No AND ($i=0 OR ($i<>0 AND ID_JourDebut=$i))";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        return $row;

    }

    public function majZ_Calendar_user($PROT_No,$ID_JourDebut,$ID_JourFin,$ID_HeureDebut,$ID_MinDebut,$ID_HeureFin,$ID_MinFin){
        $query ="UPDATE [dbo].[Z_CALENDAR_USER] SET ID_JourDebut = $ID_JourDebut
                               ,ID_JourFin = $ID_JourFin
                               ,ID_HeureDebut = $ID_HeureDebut
                               ,ID_MinDebut = $ID_MinDebut
                               ,ID_HeureFin = $ID_HeureFin
                               ,ID_MinFin = $ID_MinFin
                 WHERE PROT_No = $PROT_No";
        $this->db->query($query);
    }
    public function updateLastLogin(){
        $this->getApiExecute("/updateLastLogin/{$this->Prot_No}");
    }


    public function isCalendarUser($PROT_No){
        $this->lien = "zCalendarUser";
        return $this->getApiString("/isCalendarUser/$PROT_No");
    }
    public function canConnect($PROT_No,$jour,$heure){
        $this->lien = "zCalendarUser";
        return $this->getApiString("/canConnect/$PROT_No/$jour/$heure");
    }

    public function alerteTransfert(){
        $query = "  SELECT *
                    FROM(   SELECT A.DO_PIECE,A.do_date,A.AR_REF,count(*)nb,E.cbMarq
                            FROM F_DOCLIGNE A 
                            INNER JOIN F_DOCENTETE E ON A.DO_Domaine = E.DO_Domaine AND A.DO_Type = E.DO_Type AND A.DO_Piece=E.DO_Piece
                            where A.do_piece like 'MT%'
                            group by A.DO_PIECE,A.do_date,A.AR_REF,E.cbMarq)a
                    where nb%2=1 AND cbMarq NOT IN (SELECT cbMarqEntete FROM Z_LIGNE_CONFIRMATION GROUP BY cbMarqEntete)";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $html = "";
        if($rows!=null) {
            $html = "<h1>Liste des transferts à une ligne {$this->db->db}</h1><br/><br/>";
            $html = $html."<tr><th>N° Document</th><th>Date</th><th>Référence</th><th>Nombre de ligne</th>";
            foreach($rows as $row){
                $html = $html."<tr><td>{$row->DO_PIECE}</td><td>{$row->do_date}</td><td>{$row->AR_REF}</td><td>{$row->nb}</td>";
            }
        }
        return $html;
    }


    public function alerteStock(){
        $query = "  SELECT A.AR_Ref,A.DE_No,A.DL_Qte,B.AS_QteSto
                    FROM (
                    SELECT AR_Ref,DE_No,SUM(CASE WHEN DL_MvtStock=1 THEN ABS(DL_Qte)
                    WHEN DL_MvtStock =3 THEN -DL_Qte ELSE 0 END) DL_Qte
                    FROM F_DOCLIGNE
                    GROUP BY AR_Ref,DE_No)A
                    INNER JOIN F_ARTSTOCK B ON A.AR_Ref=B.AR_Ref AND A.DE_No=B.DE_No
                    WHERE DL_Qte<>AS_QteSto";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $html = "";
        if($rows!=null) {
            $html = "<h1>Liste des articles en écart de stock {$this->db->db}</h1><br/><br/>";
            $html = $html."<tr><th>Référence</th><th>Depot</th><th>Quantité</th><th>Stock</th>";
            foreach($rows as $row){
                $html = $html."<tr><td>{$row->AR_Ref}</td><td>{$row->DE_No}</td><td>{$row->DL_Qte}</td><td>{$row->AS_QteSto}</td>";
            }
        }

        return $html;
    }


    public function getParametrecial()
    {
        $this->lien="pparametrecial";
        return $this->getApiJson("/getPParametrecial");
    }

    public function __toString() {
        return "";
    }

}