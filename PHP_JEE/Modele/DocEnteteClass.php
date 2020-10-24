<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DocEnteteClass Extends Objet{
    //put your code here
    public $db,$DO_Domaine,$DO_Type,$DO_Piece,$DO_Date,$DO_Ref,$DO_Tiers
    ,$CO_No,$DO_Period,$DO_Devise,$DO_Cours,$DE_No,$LI_No,$CT_NumPayeur,$DO_Expedit
    ,$DO_NbFacture,$DO_BLFact,$DO_TxEscompte,$DO_Reliquat
    ,$DO_Imprim,$CA_Num,$DO_Coord01,$DO_Coord02,$DO_Coord03
    ,$DO_Coord04,$DO_Souche,$DO_DateLivr,$DO_Condition
    ,$DO_Tarif,$DO_Colisage,$DO_TypeColis,$DO_Transaction
    ,$DO_Langue,$DO_Ecart,$DO_Regime,$N_CatCompta
    ,$DO_Ventile,$AB_No,$DO_DebutAbo,$DO_FinAbo
    ,$DO_DebutPeriod,$DO_FinPeriod,$CG_Num,$DO_Statut
    ,$DO_Heure,$CA_No,$CO_NoCaissier,$DO_Transfere
    ,$DO_Cloture,$DO_NoWeb,$DO_Attente,$DO_Provenance
    ,$CA_NumIFRS,$MR_No,$DO_TypeFrais,$DO_ValFrais,$DO_TypeLigneFrais,$DO_TypeFranco
    ,$DO_ValFranco,$DO_TypeLigneFranco,$DO_Taxe1,$DO_TypeTaux1
    ,$DO_TypeTaxe1,$DO_Taxe2,$DO_TypeTaux2,$DO_TypeTaxe2
    ,$DO_Taxe3,$DO_TypeTaux3,$DO_TypeTaxe3,$DO_MajCpta
    ,$DO_Motif,$CT_NumCentrale,$DO_Contact ,$DO_FactureElec,$DO_TypeTransac
    ,$cbMarq,$cbModification,$cbFlag,$longitude,$latitude,$VEHICULE,$CHAUFFEUR,
    $ttc,$avance,$resteAPayer, $statut,$typeFacture,$cbProt, $cbCreateur,
        //info supp
        $DO_Modif,
        $DO_DateSage,
        $CT_Intitule,$DE_Intitule,$DE_Intitule_dest,$type_fac,$doccurent_type;

    public $table = 'F_DOCENTETE';
    public $lien = 'fdocentete';

    function __construct($id)
    {
        if($id=="") $id=0;
        $this->avance = 0;
        $this->ttc = 0;
        $this->resteAPayer = 0;
        $this->statut="crédit";
        $this->DO_Modif=0;
        $this->cbMarq = $id;
        ini_set("allow_url_fopen", 1);
        $this->data = $this->getApiJson("/document&cbMarq=$id");

        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->DO_Domaine = $this->data[0]->DO_Domaine;
            $this->DO_Type = $this->data[0]->DO_Type;
            $this->DO_Piece = $this->data[0]->DO_Piece;
            $this->DO_Date= $this->formatDate($this->data[0]->DO_Date);
            $this->DO_DateSage = $this->formatDateSage($this->data[0]->DO_Date);
            $this->DO_Ref = $this->data[0]->DO_Ref ;
            $this->DO_Tiers = $this->data[0]->DO_Tiers;
            $this->CO_No = $this->data[0]->CO_No;
            $this->DO_Period = $this->data[0]->DO_Period;
            $this->DO_Devise = $this->data[0]->DO_Devise;
            $this->DO_Cours = $this->data[0]->DO_Cours;
            $this->DE_No = $this->data[0]->DE_No;
            $this->LI_No = $this->data[0]->LI_No;
            $this->CT_NumPayeur= $this->data[0]->CT_NumPayeur;
            $this->DO_Expedit = $this->data[0]->DO_Expedit;
            $this->DO_NbFacture = $this->data[0]->DO_NbFacture;
            $this->DO_BLFact = $this->data[0]->DO_BLFact;
            $this->DO_TxEscompte = $this->data[0]->DO_TxEscompte;
            $this->DO_Reliquat = $this->data[0]->DO_Reliquat;
            $this->DO_Imprim = $this->data[0]->DO_Imprim;
            $this->CA_Num = $this->data[0]->CA_Num;
            $this->DO_Coord01 = $this->data[0]->DO_Coord01;
            $this->DO_Coord02 = $this->data[0]->DO_Coord02;
            $this->DO_Coord03 = $this->data[0]->DO_Coord03;
            $this->DO_Coord04 = $this->data[0]->DO_Coord04;
            $this->DO_Souche = $this->data[0]->DO_Souche;
            $this->DO_DateLivr = $this->data[0]->DO_DateLivr;
            $this->DO_Condition = $this->data[0]->DO_Condition;
            $this->DO_Tarif = $this->data[0]->DO_Tarif;
            $this->DO_Colisage = $this->data[0]->DO_Colisage;
            $this->DO_TypeColis = $this->data[0]->DO_TypeColis;
            $this->DO_Transaction = $this->data[0]->DO_Transaction;
            $this->DO_Langue = $this->data[0]->DO_Langue;
            $this->DO_Ecart = $this->data[0]->DO_Ecart;
            $this->DO_Regime = $this->data[0]->DO_Regime;
            $this->N_CatCompta = $this->data[0]->N_CatCompta =="" ? 0 :$this->data[0]->N_CatCompta;
            $this->DO_Ventile = $this->data[0]->DO_Ventile;
            $this->AB_No = $this->data[0]->AB_No;
            $this->DO_DebutAbo = $this->data[0]->DO_DebutAbo;
            $this->DO_FinAbo = $this->data[0]->DO_FinAbo;
            $this->DO_DebutPeriod = $this->data[0]->DO_DebutPeriod;
            $this->DO_FinPeriod = $this->data[0]->DO_FinPeriod;
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->DO_Statut = $this->data[0]->DO_Statut;
            $this->DO_Heure = $this->data[0]->DO_Heure;
            $this->CA_No = $this->data[0]->CA_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->DO_Transfere = $this->data[0]->DO_Transfere;
            $this->DO_Transfere = $this->data[0]->DO_Transfere;
            $this->DO_Cloture = $this->data[0]->DO_Cloture;
            $this->DO_NoWeb = $this->data[0]->DO_NoWeb;
            $this->DO_Attente= $this->data[0]->DO_Attente;
            $this->DO_Provenance = $this->data[0]->DO_Provenance;
            $this->CA_NumIFRS = $this->data[0]->CA_NumIFRS;
            $this->MR_No = $this->data[0]->MR_No;
            $this->DO_TypeFrais = $this->data[0]->DO_TypeFrais;
            $this->DO_ValFrais = $this->data[0]->DO_ValFrais;
            $this->DO_TypeLigneFrais = $this->data[0]->DO_TypeLigneFrais;
            $this->DO_TypeFranco = $this->data[0]->DO_TypeFranco;
            $this->DO_ValFranco = $this->data[0]->DO_ValFranco;
            $this->DO_TypeLigneFranco = $this->data[0]->DO_TypeLigneFranco;
            $this->DO_Taxe1 = $this->data[0]->DO_Taxe1;
            $this->DO_Taxe2 = $this->data[0]->DO_Taxe2;
            $this->DO_Taxe3 = $this->data[0]->DO_Taxe3;
            $this->DO_TypeTaux1 = $this->data[0]->DO_TypeTaux1;
            $this->DO_TypeTaux2 = $this->data[0]->DO_TypeTaux2;
            $this->DO_TypeTaux3 = $this->data[0]->DO_TypeTaux3;
            $this->DO_TypeTaxe1 = $this->data[0]->DO_TypeTaxe1;
            $this->DO_TypeTaxe2 = $this->data[0]->DO_TypeTaxe2;
            $this->DO_TypeTaxe3 = $this->data[0]->DO_TypeTaxe3;
            $this->DO_MajCpta = $this->data[0]->DO_MajCpta;
            $this->DO_Motif = $this->data[0]->DO_Motif;
            $this->CT_NumCentrale = $this->data[0]->CT_NumCentrale;
            $this->DO_Contact = $this->data[0]->DO_Contact;
            $this->DO_FactureElec = $this->data[0]->DO_FactureElec;
            $this->DO_TypeTransac = $this->data[0]->DO_TypeTransac;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbModification = $this->data[0]->cbModification;
            $this->longitude = $this->data[0]->longitude;
            $this->latitude = $this->data[0]->latitude;
            $this->VEHICULE = $this->data[0]->VEHICULE;
            $this->CHAUFFEUR = $this->data[0]->CHAUFFEUR;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbProt = $this->data[0]->cbProt;
            $this->setDO_Modif();
            $this->avance = $this->AvanceDoPiece();
            $this->ttc = $this->montantRegle();
            $this->resteAPayer = $this->ttc - $this->avance;
            if(sizeof($this->listeLigneFacture())==0)
                $this->statut="crédit";
            else
                if(($this->DO_Domaine == 0 || $this->DO_Domaine == 1) && $this->dr_regle()==1 && $this->resteAPayer==0)
                $this->statut="comptant";
        }
    }


    public function listeFactureSelect($depot,$datedeb,$datefin,$client,$type){
        if($type=="Vente")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,0,6);

        if($type=="VenteC")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,0,7);

        if($type=="VenteT")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,0,67);

        if($type=="VenteRetour")
            return $this->getListeFacture($depot,1,$datedeb ,$datefin,$client,0,6);

        if($type=="VenteRetourT")
            return $this->getListeFacture($depot,1,$datedeb ,$datefin,$client,0,67);

        if($type=="VenteRetourC")
            return $this->getListeFacture($depot,1,$datedeb ,$datefin,$client,0,7);

        if($type=="Avoir")
            return $this->getListeFacture($depot,2,$datedeb ,$datefin,$client,0,6);

        if($type=="Devis")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,0,0);

        if($type=="BonLivraison")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,0,3);

        if($type=="Ticket")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,3,30);

        if($type=="Transfert")
            return $this->listeTransfert($depot, $datedeb, $datefin);

        if($type=="Transfert_confirmation" || $type=="Transfert_valid_confirmation")
            return $this->listeTransfertConfirmation($depot, $datedeb, $datefin);


        if($type=="Transfert_detail")
            return $this->listeTransfertDetail($depot, $datedeb, $datefin);

        if($type=="Entree")
            return $this->listeEntree($depot, $datedeb, $datefin);

        if($type=="Sortie")
            return $this->listeSortie($depot, $datedeb, $datefin);

        if($type=="Achat") {
            return $this->getListeFacture($depot, 0, $datedeb, $datefin, $client, 1, 16);
        }

        if($type=="AchatC")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,1,17);


        if($type=="AchatT")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,1,1617);


        if($type=="AchatRetour")
            return $this->getListeFacture($depot,1,$datedeb ,$datefin,$client,1,16);


        if($type=="AchatRetourC")
            return $this->getListeFacture($depot,1,$datedeb ,$datefin,$client,1,17);


        if($type=="AchatRetourT")
            return $this->getListeFacture($depot,1,$datedeb ,$datefin,$client,1,1617);


        if($type=="PreparationCommande")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,1,11);

        if($type=="AchatPreparationCommande")
            return $this->getListeFacture($depot,0,$datedeb ,$datefin,$client,1,12);
    }

    public function journeeCloture($date,$caNo)
    {
        $valCaNo = 0;
        if($caNo!="")
            $valCaNo = $caNo;
        return $this->getApiString("/journeeCloture&date=$date&caNo=$valCaNo");
    }
        public function removeFacRglt($cbMarqEntete,$rgNo)
    {
        $this->getApiExecute("/removeFacRglt&cbMarqEntete=$cbMarqEntete&rgNo=$rgNo");
    }

    public function maj_docEntete(){
        parent::maj("DO_Domaine" ,$this->DO_Domaine);
        parent::maj("DO_Type" ,$this->DO_Type);
        parent::maj("DO_Piece" ,$this->DO_Piece);
        parent::maj("DO_Date",$this->DO_Date);
        parent::maj("DO_Ref" ,$this->DO_Ref );
        parent::maj("DO_Tiers" ,$this->DO_Tiers );
        parent::maj("CO_No" ,$this->CO_No);
        parent::maj("DO_Period" ,$this->DO_Period);
        parent::maj("DO_Devise" ,$this->DO_Devise);
        if($this->DO_Cours!="")
            parent::maj("DO_Cours" ,$this->DO_Cours);
        parent::maj("DE_No" ,$this->DE_No);
        parent::maj("LI_No" ,$this->LI_No);
        if($this->CT_NumPayeur!="")
            parent::maj("CT_NumPayeur",$this->CT_NumPayeur);
        parent::maj("DO_Expedit" ,$this->DO_Expedit);
        parent::maj("DO_NbFacture" ,$this->DO_NbFacture);
        parent::maj("DO_BLFact" ,$this->DO_BLFact);
        parent::maj("DO_TxEscompte" ,$this->DO_TxEscompte);
        parent::maj("DO_Reliquat" ,$this->DO_Reliquat);
        parent::maj("DO_Imprim" ,$this->DO_Imprim);
        parent::maj("CA_Num" ,$this->CA_Num);
        parent::maj("DO_Coord01" ,$this->DO_Coord01);
        parent::maj("DO_Coord02" ,$this->DO_Coord02);
        parent::maj("DO_Coord03" ,$this->DO_Coord03);
        parent::maj("DO_Coord04" ,$this->DO_Coord04);
        parent::maj("DO_Souche" ,$this->DO_Souche);
        parent::maj("DO_DateLivr" ,$this->DO_DateLivr);
        parent::maj("DO_Condition" ,$this->DO_Condition);
        parent::maj("DO_Tarif" ,$this->DO_Tarif);
        parent::maj("DO_Colisage" ,$this->DO_Colisage);
        parent::maj("DO_TypeColis" ,$this->DO_TypeColis);
        parent::maj("DO_Transaction" ,$this->DO_Transaction);
        parent::maj("DO_Langue" ,$this->DO_Langue);
        parent::maj("DO_Ecart" ,$this->DO_Ecart);
        parent::maj("DO_Regime" ,$this->DO_Regime);
        parent::maj("N_CatCompta" ,$this->N_CatCompta);
        parent::maj("DO_Ventile" ,$this->DO_Ventile);
        parent::maj("AB_No" ,$this->AB_No);
        parent::maj("DO_DebutAbo" ,$this->DO_DebutAbo);
        parent::maj("DO_FinAbo" ,$this->DO_FinAbo);
        parent::maj("DO_DebutPeriod" ,$this->DO_DebutPeriod);
        parent::maj("DO_FinPeriod" ,$this->DO_FinPeriod);
        parent::maj("CG_Num" ,$this->CG_Num);
        parent::maj("DO_Statut" ,$this->DO_Statut);
        parent::maj("DO_Heure" ,$this->DO_Heure);
        parent::maj("CA_No" ,$this->CA_No);
        parent::maj("CO_NoCaissier" ,$this->CO_NoCaissier);
        parent::maj("DO_Transfere" ,$this->DO_Transfere);
        parent::maj("DO_Transfere" ,$this->DO_Transfere);
        parent::maj("DO_Cloture" ,$this->DO_Cloture);
        parent::maj("DO_NoWeb" ,$this->DO_NoWeb);
        parent::maj("DO_Attente",$this->DO_Attente);
        parent::maj("DO_Provenance" ,$this->DO_Provenance);
        parent::maj("CA_NumIFRS" ,$this->CA_NumIFRS);
        parent::maj("MR_No" ,$this->MR_No);
        parent::maj("DO_TypeFrais" ,$this->DO_TypeFrais);
        parent::maj("DO_ValFrais" ,$this->DO_ValFrais);
        parent::maj("DO_TypeLigneFrais" ,$this->DO_TypeLigneFrais);
        parent::maj("DO_TypeFranco" ,$this->DO_TypeFranco);
        parent::maj("DO_ValFranco" ,$this->DO_ValFranco);
        parent::maj("DO_TypeLigneFranco" ,$this->DO_TypeLigneFranco);
        parent::maj("DO_Taxe1" ,$this->DO_Taxe1);
        parent::maj("DO_Taxe2" ,$this->DO_Taxe2);
        parent::maj("DO_Taxe3" ,$this->DO_Taxe3);
        parent::maj("DO_TypeTaux1" ,$this->DO_TypeTaux1);
        parent::maj("DO_TypeTaux2" ,$this->DO_TypeTaux2);
        parent::maj("DO_TypeTaux3" ,$this->DO_TypeTaux3);
        parent::maj("DO_TypeTaxe1" ,$this->DO_TypeTaxe1);
        parent::maj("DO_TypeTaxe2" ,$this->DO_TypeTaxe2);
        parent::maj("DO_TypeTaxe3" ,$this->DO_TypeTaxe3);
        parent::maj("DO_MajCpta" ,$this->DO_MajCpta);
        parent::maj("DO_Motif" ,$this->DO_Motif);
        if($this->CT_NumCentrale!="")
            parent::maj("CT_NumCentrale" ,$this->CT_NumCentrale);
        parent::maj("DO_Contact" ,$this->DO_Contact);
        parent::maj("DO_FactureElec" ,$this->DO_FactureElec);
        parent::maj("DO_TypeTransac" ,$this->DO_TypeTransac);
        parent::maj("cbModification" ,$this->cbModification);
        parent::maj("longitude" ,$this->longitude);
        parent::maj("latitude" ,$this->latitude);
        parent::maj("VEHICULE" ,$this->VEHICULE);
        parent::maj("CHAUFFEUR" ,$this->CHAUFFEUR);
        parent::maj("cbCreateur" ,$this->userName);
        parent::majcbModification();
    }

    public function GetMontantFacture(){
        $query = "  SELECT ISNULL(SUM(DL_MontantTTC),0) MontantTTC
                    FROM F_DOCENTETE E
                    LEFT JOIN F_DOCLIGNE D ON E.DO_Piece = D.DO_Piece AND E.DO_Domaine = D.DO_Domaine AND E.DO_Type = D.DO_Type
                    WHERE E.cbMarq = {$this->cbMarq}
                    ";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->MontantTTC;
    }
    public function dr_regle(){
        return $this->getApiString("/drRegle&cbMarq={$this->cbMarq}");
    }
    public function getEnteteTable($typeFac,$doSouche){
        return $this->getApiString("/getEnteteTable&typeFac=$typeFac&doSouche=$doSouche");
    }
    public function doImprim(){
        return $this->getApiJson("/doImprim&cbMarq={$this->cbMarq}");
    }
    public function maj_collaborateur($coNo){
        return $this->getApiJson("/majCollaborateur&coNo=$coNo&cbMarq={$this->cbMarq}");
    }
    public function maj_affaire($caNum){
        return $this->getApiJson("/majAffaire&caNum=$caNum&cbMarq={$this->cbMarq}");
    }

    public function saisieComptableCaisse($cbMarq,$trans){
        return $this->getApiJson("/saisieComptableCaisse&cbMarq=$cbMarq&trans=$trans");
    }

    public function saisieComptable($cbMarq,$trans){
        return $this->getApiJson("/saisieComptable&cbMarq=$cbMarq&trans=$trans");
    }

    public function saisieCompteAnal($cbMarq,$insert)
    {
        return $this->getApiJson("/saisieCompteAnal&cbMarq=$cbMarq&insert=$insert");
    }

    public function getDocReglByDO_Piece() {
        $query = "SELECT  * 
                  FROM    F_DOCREGL 
                  WHERE   DO_Piece='{$this->DO_Piece}' AND DO_Domaine='{$this->DO_Domaine}' AND DO_Type='{$this->DO_Type}'";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows;
    }


    public function getDocumentConfirmation($listDepot) {
        $query = "SELECT  cbMarqEntete 
                  FROM    Z_LIGNE_CONFIRMATION A 
                  INNER JOIN F_DOCENTETE B ON A.cbMarqEntete = B.cbMarq
                  WHERE B.DE_No IN ({$listDepot})
                  GROUP BY cbMarqEntete";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $list = array();
        foreach ($rows as $row){
            array_push($list,new DocEnteteClass($row->cbMarqEntete,$this->db));
        }
        return $list;
    }

    public function getLignetConfirmation() {
        $query = "SELECT  A.Prix as DL_PrixUnitaire
                         ,AR_Design as DL_Design
                         ,A.AR_Ref
                         ,A.DL_Qte
,0 AS DL_Remise
,0 AS DL_Taxe1
,0 AS DL_Taxe2
,0 AS DL_Taxe3
,A.cbMarq
     ,0 as idSec
     ,cbMarqLigneFirst
,ROUND(A.Prix*DL_Qte,2) DL_MontantHT
                  FROM    Z_LIGNE_CONFIRMATION A
                  INNER JOIN F_ARTICLE B ON A.AR_Ref=B.AR_Ref
                  WHERE   cbMarqEntete='{$this->cbMarq}'";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows ;
    }

    public function entete_document($type_fac,$do_souche){
        return $this->getApiString("/getEnteteDocument&typeFac=$type_fac&doSouche=$do_souche");
    }

    public function getLigneFacture() {
            return $this->getApiJson("/getLigneFacture&cbMarq={$this->cbMarq}");
    }

    public function testCorrectLigneA()
    {
        return $this->getApiJson("/testCorrectLigneA&cbMarq={$this->cbMarq}");
    }

    public function enteteTransfertDetail($cbMarq)
    {
        return $this->getApiJson("/enteteTransfertDetail&cbMarq={$cbMarq}");
    }

    public function getLigneTransfert_detail()
    {
        return $this->getApiJson("/getLigneTransfertDetail&doPiece={$this->DO_Piece}");
    }



    public function GetMontantReglee(){
        $query = "  SELECT ISNULL(SUM(DL_MontantTTC),0) MontantTTC
                    FROM F_DOCENTETE E                    
                    LEFT JOIN F_DOCREGL D ON E.DO_Piece = D.DO_Piece AND E.DO_Domaine = D.DO_Domaine AND E.DO_Type = D.DO_Type
                    WHERE E.cbMarq = {$this->cbMarq}
                    ";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->MontantTTC;
    }


    public function getFLivraisonByCTNum($ct_num) {
        return "SELECT ISNULL((SELECT Max(LI_No) FROM ".$this->db->baseCompta.".dbo.F_LIVRAISON WHERE CT_Num ='" . $ct_num . "'),0) AS LI_No";
    }

    public function addDocenteteTransfertDetailProcess($do_pieceParam,$do_domaine,$do_type,$do_date, $do_ref, $depot, $longitude, $latitude,$dcCol){
        $CT_Num = '41TRANSFERTDETAIL';
        $comptet = new ComptetClass($CT_Num);
        if($do_type==40) {
            $do_piece = $do_pieceParam;
        }
        else {
            $do_piece = $this->objetCollection->getEnteteDocument($do_domaine, $do_type, 0, "Transfert_detail");
        }
        $result = $this->db->requete($this->objetCollection->getEnteteTable(4,1,$dcCol));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
            $docEntete = new DocEnteteClass(0);
            $docEntete->defaultValue();
            $docEntete->setValueMvtEntree();
            $docEntete->DO_Domaine = $do_domaine;
            $docEntete->DO_Type = $do_type;
            $docEntete->DO_Piece = $do_piece;
            $docEntete->latitude = $latitude;
            $docEntete->longitude =  $longitude;
            $docEntete->DO_Ref = $do_ref;
            $docEntete->DO_Tiers = $CT_Num;
            $docEntete->CA_Num = "";
            $docEntete->DO_Date = $do_date;
            $docEntete->DO_DateLivr = '1900-01-01';
            $docEntete->DE_No = $depot;
            $docEntete->type_fac = "Transfert_detail";
            $docEntete->setValueMvt();

            $docEntete->insert_docEntete();
            return $do_piece;
        }
    }

    public function setDefaultValueVente($client){
        if(($this->DO_Domaine ==0 && $this->DO_Type >=0 && $this->DO_Type <=7)|| $this->DO_Domaine ==3) {
            $this->DO_Tiers = $client->CT_Num;
            $this->AB_No = 0;
            $this->CA_No = 0;
            if($client->CA_Num!="")
                $this->CA_Num = $client->CA_Num;
            if($client->CG_NumPrinc!="")
                $this->CG_Num = $client->CG_NumPrinc;
            if($client->CT_BLFact!="")
                $this->DO_BLFact = $client->CT_BLFact;
            $this->DO_Cloture = 0;
            $this->DO_Colisage = 1;
            if($client->N_Condition!="")
                $this->DO_Condition = $client->N_Condition;
            $this->DO_Coord01 = "";
            $this->DO_Coord02 = "";
            $this->DO_Coord03 = "";
            $this->DO_Coord04 = "";
            $this->DO_DateLivr = "1900-01-01" ;
            $this->DO_DebutAbo  = "1900-01-01";
            $this->DO_DebutPeriod  = "1900-01-01";
            if($client->N_Devise!="")
                $this->DO_Devise = $client->N_Devise;
            $this->DO_Ecart = 0;
            if($client->N_Expedition!="")
                $this->DO_Expedit = $client->N_Expedition;
            $this->DO_FinAbo  = "1900-01-01";
            $this->DO_FinPeriod  = "1900-01-01";
            $this->DO_Imprim = 0;
            if($client->CT_Langue!="")
                $this->DO_Langue = $client->CT_Langue;
            if($client->CT_Facture!="")
                $this->DO_NbFacture = $client->CT_Facture;
            if($client->N_Period!="")
                $this->DO_Period = $client->N_Period;
            $this->DO_Ref ="";
            $this->DO_Reliquat =0;
            $this->DO_Souche=0;
            $this->DO_Statut = 2;
            if($client->N_CatTarif=="")
                $this->DO_Tarif = 0;
            else
                $this->DO_Tarif = $client->N_CatTarif;
            $this->DO_Transfere = 0 ;
            if($client->CT_Taux02!="")
                $this->DO_TxEscompte = $client->CT_Taux02;
            if($client->CT_NumPayeur!="")
                $this->CT_NumPayeur = $client->CT_NumPayeur;
            $this->DO_Tiers = $client->CT_Num;
            $this->DO_TypeColis = 1;
            $this->DO_Ventile = 0;
            if($client->N_CatCompta!="")
                $this->N_CatCompta = $client->N_CatCompta;
            if($client->CO_No!="")
                $this->CO_No = $client->CO_No;
            $this->CO_NoCaissier = 0;
            $this->DO_Attente = 0;
            $this->DO_NoWeb = "";
            $this->DO_Regime = "";
            $this->DO_Transaction = "";
        }
    }

    public function setDefaultValueAchat($client){
        if($this->DO_Domaine ==1 && $this->DO_Type >=10 && $this->DO_Type <=17) {
            $this->DO_Tiers = $client->CT_Num;
            $this->AB_No = 0;
            $this->CA_No = 0;
            if($client->CA_Num!="")
                $this->CA_Num = $client->CA_Num;
            if($client->CG_NumPrinc!="")
                $this->CG_Num = $client->CG_NumPrinc;
            $this->DO_BLFact = 0;
            $this->DO_Cloture = 0;
            $this->DO_Colisage = 1;
            if($client->N_Condition!="")
                $this->DO_Condition = $client->N_Condition;
            $this->DO_Coord01 = "";
            $this->DO_Coord02 = "";
            $this->DO_Coord03 = "";
            $this->DO_Coord04 = "";
            $this->DO_DateLivr = "1900-01-01" ;
            $this->DO_DebutAbo  = "1900-01-01";
            $this->DO_DebutPeriod  = "1900-01-01";
            if($client->N_Devise!="")
                $this->DO_Devise = $client->N_Devise;
            $this->DO_Ecart = 0;
            $this->DO_Expedit = 1;
            $this->DO_FinAbo  = "1900-01-01";
            $this->DO_FinPeriod  = "1900-01-01";
            $this->DO_Imprim = 0;
            if($client->CT_Langue!="")
                $this->DO_Langue = $client->CT_Langue;
            if($client->CT_Facture!="")
                $this->DO_NbFacture = $client->CT_Facture;
            $this->DO_Period = 1;
            $this->DO_Ref ="";
            $this->DO_Reliquat =0;
            $this->DO_Souche=0;
            $this->DO_Statut = 2;
            $this->DO_Tarif = 1;
            $this->DO_Transfere = 0 ;
            if($client->CT_Taux02!="")
                $this->DO_TxEscompte = $client->CT_Taux02;
            if($client->CT_NumPayeur!="")
                $this->CT_NumPayeur = $client->CT_NumPayeur;
            if($client->CT_Num!="")
                $this->DO_Tiers = $client->CT_Num;
            $this->DO_TypeColis = 1;
            $this->DO_Ventile = 0;
            if($client->N_CatCompta!="")
                $this->N_CatCompta = $client->N_CatCompta;
            if($client->CO_No!="")
                $this->CO_No = $client->CO_No;
            $this->CO_NoCaissier = 0;
            $this->DO_Attente = 0;
            $this->DO_NoWeb = "";
            $this->DO_Regime = "";
            $this->DO_Transaction = "";
        }
    }

    public function getDateEcgetTiersheance($ctNum,$date){
        return $this->getApiJson("/getDateEcgetTiersheance&ctNum=$ctNum&date=$date");
    }

    public function getDateEcgetTiersheanceSelect($mrNo,$N_Reglement,$date){
        return $this->getApiJson("/getDateEcgetTiersheanceSelect&mrNo=$mrNo&nReglement=$N_Reglement&date=$date");
    }


    public function setDefaultValueStock(){
        if($this->DO_Domaine ==2 /*&& $this->DO_Type =10 && $this->DO_Type >=17*/) {
            //$this->DO_Tiers = $client->CT_Num;
            $this->AB_No = 0;
            $this->CA_No = 0;
            $this->CA_Num = "";
            $this->CG_Num = "NULL";
            $this->DE_No = 0;
            $this->DO_BLFact = 0;
            $this->DO_Cloture = 0;
            $this->DO_Colisage = 1;
            $this->DO_Condition = 0;
            $this->DO_Coord01 = "";
            $this->DO_Coord02 = "";
            $this->DO_Coord03 = "";
            $this->DO_Coord04 = "";
            $this->DO_DateLivr = "1900-01-01" ;
            $this->DO_DebutAbo  = "1900-01-01";
            $this->DO_DebutPeriod  = "1900-01-01";
            $this->DO_Devise = 0;
            $this->DO_Ecart = 0;
            $this->DO_Expedit = 0;
            $this->DO_FinAbo  = "1900-01-01";
            $this->DO_FinPeriod  = "1900-01-01";
            $this->DO_Imprim = 0;
            $this->DO_Langue = 0;
            $this->DO_NbFacture = 0;
            $this->DO_Period = 0;
            $this->DO_Ref ="";
            $this->DO_Reliquat =0;
            $this->DO_Souche=0;
            $this->DO_Statut = 0;
            $this->DO_Tarif = 0;
            $this->DO_Transfere = 0 ;
            $this->DO_TxEscompte = 0;
            $this->CT_NumPayeur = 0;
            $this->DO_Tiers = 0;
            $this->DO_TypeColis = 1;
            $this->DO_Ventile = 0;
            $this->N_CatCompta = 0;
            $this->CO_No = 0;
            $this->CO_NoCaissier = 0;
            $this->DO_Attente = 0;
            $this->DO_NoWeb = "";
            $this->DO_Regime = "";
            $this->DO_Transaction = "";
        }
    }

    public function setTypeFac($typefac){
        $this->type_fac = $typefac;
        if($typefac=="Vente"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 6;
            $this->doccurent_type = 6;
        }
        if($typefac=="Retour" ){
            $this->DO_Domaine = 0;
            $this->DO_Type = 6;
            $this->doccurent_type = 7;
        }
        if($typefac=="Avoir"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 6;
            $this->doccurent_type = 8;
        }

        if($typefac=="BonLivraison"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 3;
            $this->doccurent_type = 3;
        }

        if($typefac=="VenteC"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 7;
            $this->doccurent_type = 6;
        }

        if($typefac=="AchatC"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 17;
            $this->doccurent_type = 6;
        }

        if($typefac=="AchatRetourC"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 17;
            $this->doccurent_type = 7;
        }

        if($typefac=="AchatRetour"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 16;
            $this->doccurent_type = 7;
        }

        if($typefac=="Devis"){
            $this->DO_Domaine = 0;
            $this->DO_Type = 0;
            $this->doccurent_type = 0;
        }

        if($typefac=="PreparationCommande"){
            $this->DO_Domaine  = 1;
            $this->DO_Type = 11;
            $this->doccurent_type =1;
        }

        if($typefac=="Entree"){
            $this->DO_Domaine  = 2;
            $this->DO_Type = 20;
            $this->doccurent_type =0;
            $this->DO_Souche =0;
        }

        if($typefac=="Sortie"){
            $this->DO_Domaine  = 2;
            $this->DO_Type = 21;
            $this->doccurent_type =1;
            $this->DO_Souche =0;
        }

        if($typefac=="Transfert"){
            $this->DO_Domaine  = 2;
            $this->DO_Type = 23;
            $this->doccurent_type =3;
            $this->DO_Souche =0;
        }

        if($typefac=="Transfert_confirmation"){
            $this->DO_Domaine  = 4;
            $this->DO_Type = 42;
            $this->doccurent_type =2;
            $this->DO_Souche =0;
        }

        if($typefac=="Achat"){
            $this->DO_Domaine = 1;
            $this->DO_Type = 16;
            $this->doccurent_type =6;
        }

        if($typefac=="AchatPreparationCommande"){
            $this->DO_Domaine = 1;
            $this->doccurent_type =6;
            $this->DO_Type = 12;
        }

        if($typefac=="Ticket") {
            $this->DO_Domaine = 3;
            $this->doccurent_type =6;
            $this->DO_Type = 30;
        }
    }

    public function getTypeFac(){

        if($this->DO_Domaine == 0 && $this->DO_Type == 6){
            $this->type_fac = "Vente";
        }

        if($this->DO_Domaine == 0 && $this->DO_Type == 6 && $this->DO_Provenance == 1){
            $this->type_fac = "Retour";
        }
        if($this->DO_Domaine == 0 && $this->DO_Type == 16 && $this->DO_Provenance == 1){
            $this->type_fac = "AchatRetour";
        }
        if($this->DO_Domaine == 0 && $this->DO_Type == 17 && $this->DO_Provenance == 1){
            $this->type_fac = "AchatRetourC";
        }

        if($this->DO_Domaine = 0 && $this->DO_Type = 6 && $this->DO_Provenance == 2){
            $this->type_fac = "Avoir";
        }

        if($this->DO_Domaine == 0 && $this->DO_Type == 3){
            $this->type_fac = "BonLivraison";
        }

        if($this->DO_Domaine == 0 && $this->DO_Type == 7){
            $this->type_fac = "VenteC";
        }

        if($this->DO_Domaine = 1 && $this->DO_Type = 17){
            $this->type_fac = "AchatC";
        }

        if($this->DO_Domaine == 0 && $this->DO_Type == 0){
            $this->type_fac = "Devis";
        }

        if($this->DO_Domaine = 1 && $this->DO_Type = 11){
            $this->type_fac = "PreparationCommande";
        }

        if($this->DO_Domaine == 2 && $this->DO_Type == 20){
            $this->type_fac = "Entree";
        }

        if($this->DO_Domaine == 2 && $this->DO_Type == 21){
            $this->type_fac = "Sortie";
        }

        if($this->DO_Domaine == 2 && $this->DO_Type == 23){
            $this->type_fac = "Transfert";
        }

        if($this->DO_Domaine == 1 && $this->DO_Type == 16){
            $this->type_fac = "Achat";
        }

        if($this->DO_Domaine == 1 && $this->DO_Type == 12){
            $this->type_fac = "AchatPreparationCommande";
        }

        if($this->DO_Domaine == 3 && $this->DO_Type == 30){
            $this->type_fac = "Ticket";
        }
    }

    public function enteteList($cbMarq){

    }

    public function setInfoAjoutEntete(){
        if($this->type_fac == "BonCommande" || $this->type_fac == "BonLivraison"
            || $this->type_fac == "Devis"
            || $this->type_fac == "Vente") {
            $this->DO_Transaction = 11;
            $this->DO_Regime = 21;
            $this->DO_Provenance = 0;
        }

        if($this->type_fac == "Achat" || $this->type_fac == "AchatRetour" || $this->type_fac == "AchatPreparationCommande"
            || $this->type_fac == "PreparationCommande" ) {
            $this->DO_Transaction = 11;
            $this->DO_Regime = 11;
            $this->DO_Provenance = 0;
        }

        if($this->type_fac == "Entree" || $this->type_fac == "Sortie" || $this->type_fac == "Transfert" || $this->type_fac == "Transfert_detail") {
            $this->DO_Transaction = 0;
            $this->DO_Regime = 0;
            $this->DO_Provenance = 0;
            $this->DO_Condition  = 0;
        }

        if($this->type_fac == "Retour" || $this->type_fac == "AchatRetour")
            $this->DO_Provenance = 1;
        if($this->type_fac == "Avoir")
            $this->DO_Provenance = 2;
        if($this->type_fac == "Achat"|| $this->type_fac == "AchatRetour"|| $this->type_fac == "PreparationCommande")
            $this->DO_Regime = 11;
        if($this->type_fac == "Avoir"|| $this->type_fac == "Retour"|| $this->type_fac == "AchatRetour"){
            $this->DO_Transaction = 21;
            $this->DO_Regime = 25;
        }
    }

    public function insert_docEntete(){

        $query="BEGIN 
                SET NOCOUNT ON;
                INSERT INTO [dbo].[F_DOCENTETE]
                ([DO_Domaine], [DO_Type], [DO_Date], [DO_Ref]
                , [DO_Tiers], [CO_No], [DO_Period], [DO_Devise]
                , [DO_Cours], [DE_No], [LI_No]
                , [CT_NumPayeur], [DO_Expedit], [DO_NbFacture], [DO_BLFact]
                , [DO_TxEscompte], [DO_Reliquat], [DO_Imprim], [CA_Num]
                , [DO_Coord01], [DO_Coord02], [DO_Coord03], [DO_Coord04]
                , [DO_Souche], [DO_DateLivr], [DO_Condition], [DO_Tarif]
                , [DO_Colisage], [DO_TypeColis], [DO_Transaction], [DO_Langue]
                , [DO_Ecart], [DO_Regime], [N_CatCompta], [DO_Ventile]
                , [AB_No], [DO_DebutAbo], [DO_FinAbo], [DO_DebutPeriod]
                , [DO_FinPeriod], [CG_Num], [DO_Statut], [DO_Heure]
                , [CA_No], [CO_NoCaissier]
                , [DO_Transfere], [DO_Cloture], [DO_NoWeb], [DO_Attente]
                , [DO_Provenance], [CA_NumIFRS], [MR_No], [DO_TypeFrais]
                , [DO_ValFrais], [DO_TypeLigneFrais], [DO_TypeFranco], [DO_ValFranco]
                    , [DO_TypeLigneFranco], [DO_Taxe1], [DO_TypeTaux1], [DO_TypeTaxe1]
                    , [DO_Taxe2], [DO_TypeTaux2], [DO_TypeTaxe2], [DO_Taxe3]
                    , [DO_TypeTaux3], [DO_TypeTaxe3], [DO_MajCpta], [DO_Motif]
                        , [CT_NumCentrale], [DO_Contact], [DO_FactureElec], [DO_TypeTransac]
                        , [cbProt], [cbCreateur], [cbModification], [cbReplication]
                        , [cbFlag], [VEHICULE], [CHAUFFEUR]
                        , [longitude], [latitude],[DO_Piece])
                        VALUES
                        (/*DO_Domaine*/{$this->DO_Domaine},/*DO_Type*/{$this->DO_Type},/*DO_Date*/'{$this->DO_Date}',/*DO_Ref*/LEFT('{$this->DO_Ref}',17)
                            ,/*DO_Tiers*/'{$this->DO_Tiers}',/*CO_No*/{$this->CO_No},/*DO_Period*/{$this->DO_Period},/*DO_Devise*/{$this->DO_Devise}
                            ,/*DO_Cours*/(SELECT D_Cours FROM P_Devise WHERE cbIndice = {$this->DO_Devise}),/*DE_No*/'{$this->DE_No}',/*LI_No*/ {$this->LI_No}
                        ,/*CT_NumPayeur*/(CASE WHEN '{$this->CT_NumPayeur}'='' OR '{$this->CT_NumPayeur}'='NULL' THEN NULL ELSE '{$this->CT_NumPayeur}' END)   
                        ,/*DO_Expedit*/{$this->DO_Expedit},/*DO_NbFacture*/{$this->DO_NbFacture},/*DO_BLFact*/{$this->DO_BLFact}
                        ,/*DO_TxEscompte*/{$this->DO_TxEscompte},/*DO_Reliquat*/{$this->DO_Reliquat},/*DO_Imprim*/{$this->DO_Imprim},/*CA_Num*/CASE WHEN '{$this->CA_Num}'='' OR '{$this->CA_Num}'='0' THEN null else '{$this->CA_Num}' END
                        ,/*DO_Coord01*/'{$this->DO_Coord01}',/*DO_Coord02*/'{$this->DO_Coord02}',/*DO_Coord03*/'{$this->DO_Coord03}',/*DO_Coord04*/'{$this->DO_Coord04}'
                        ,/*DO_Souche*/{$this->DO_Souche},/*DO_DateLivr*/'{$this->DO_DateLivr}',/*DO_Condition*/1,/*DO_Tarif*/(CASE WHEN '{$this->DO_Tarif}'='' THEN NULL ELSE '{$this->DO_Tarif}' END)
                        ,/*DO_Colisage*/{$this->DO_Colisage},/*DO_TypeColis*/{$this->DO_TypeColis},/*DO_Transaction*/{$this->DO_Transaction},/*DO_Langue*/{$this->DO_Langue}
                        ,/*DO_Ecart*/0,/*DO_Regime*/{$this->DO_Regime},/*N_CatCompta*/ {$this->N_CatCompta} ,/*DO_Ventile*/{$this->DO_Ventile}
                        ,/*AB_No*/{$this->AB_No},/*DO_DebutAbo*/'{$this->DO_DebutAbo}',/*DO_FinAbo*/'{$this->DO_FinAbo}',/*DO_DebutPeriod*/'{$this->DO_DebutPeriod}'
                        ,/*DO_FinPeriod*/'{$this->DO_FinPeriod}',/*CG_Num*/(CASE WHEN '{$this->CG_Num}'='' OR '{$this->CG_Num}'='NULL' THEN NULL ELSE '{$this->CG_Num}' END)
						,/*DO_Statut*/{$this->DO_Statut},/*DO_Heure*/'000' + CAST(DATEPART(HOUR, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(MINUTE, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(SECOND, GETDATE()) as VARCHAR(2))
                        ,/*CA_No*/{$this->CA_No},/*CO_NoCaissier*/" .$this->CO_NoCaissier. ",/*DO_Transfere*/{$this->DO_Transfere}
                        ,/*DO_Cloture*/{$this->DO_Cloture},/*DO_NoWeb*/'{$this->DO_NoWeb}',/*DO_Attente*/{$this->DO_Attente},/*DO_Provenance*/{$this->DO_Provenance}
                        ,/*CA_NumIFRS*/'{$this->CA_NumIFRS}',/*MR_No*/{$this->MR_No},/*DO_TypeFrais*/{$this->DO_TypeFrais},/*DO_ValFrais*/{$this->DO_ValFrais}
                        ,/*DO_TypeLigneFrais*/{$this->DO_TypeLigneFrais},/*DO_TypeFranco*/{$this->DO_TypeFranco},/*DO_ValFranco*/{$this->DO_ValFranco},/*DO_TypeLigneFranco*/{$this->DO_TypeLigneFranco}
                        ,/*DO_Taxe1*/{$this->DO_Taxe1},/*DO_TypeTaux1*/{$this->DO_TypeTaux1},/*DO_TypeTaxe1*/{$this->DO_TypeTaxe1},/*DO_Taxe2*/{$this->DO_Taxe2}
                        ,/*DO_TypeTaux2*/{$this->DO_TypeTaux2},/*DO_TypeTaxe2*/{$this->DO_TypeTaxe2},/*DO_Taxe3*/{$this->DO_Taxe3},/*DO_TypeTaux3*/{$this->DO_Taxe3}
                        ,/*DO_TypeTaxe3*/{$this->DO_TypeTaxe3},/*DO_MajCpta*/{$this->DO_MajCpta},/*DO_Motif*/'{$this->DO_Motif}',/*CT_NumCentrale*/NULL
                        ,/*DO_Contact*/'{$this->DO_Contact}',/*DO_FactureElec*/{$this->DO_FactureElec},/*DO_TypeTransac*/{$this->DO_TypeTransac},/*cbProt*/{$this->cbProt}
                        ,/*cbCreateur*/'{$this->userName}',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/{$this->cbFlag}
                        ,/*VEHICULE*/'{$this->VEHICULE}',/*CHAUFFEUR*/'{$this->CHAUFFEUR}',/*longitude*/{$this->longitude},/*latitude*/{$this->latitude},/*DO_Piece*/'{$this->DO_Piece}' );
                        select @@IDENTITY as cbMarq;
                END";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->cbMarq;
    }

    public function setDO_Modif(){
        $this->DO_Modif=$this->getApiString("/setDoModif&cbMarq={$this->cbMarq}");
    }

    public function listeLigneFacture(){
        return $this->getApiJson("/listeLigneFacture&cbMarq={$this->cbMarq}");
    }


    public function getLastPieceInv()
    {
        $query = "SELECT(CONCAT('i',RIGHT(CONCAT('0000000',CAST(RIGHT((SELECT RIGHT(ISNULL(MAX(DO_Piece),0),6)
                FROM F_DOCENTETE
                WHERE DO_Piece LIKE 'i%'
                AND DO_Domaine=2 AND DO_Type=20),7) as INT)+1),7) )) as DO_Piece";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->DO_Piece;
    }

    public function getLastPieceInv21()
    {
        $query = "SELECT(CONCAT('i',RIGHT(CONCAT('0000000',CAST(RIGHT((SELECT RIGHT(ISNULL(MAX(DO_Piece),0),6)
                FROM F_DOCENTETE
                WHERE DO_Piece LIKE 'i%'
                AND DO_Domaine=2 AND DO_Type=21),7) as INT)+1),7) )) as DO_Piece";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->DO_Piece;
    }


    public function addDocenteteEntreeInventaireProcess($do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude)
    {
        $do_piece = $this->getLastPieceInv();
        $cbMarq =$this->addDocenteteEntreeMagasin(20, $do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude, $do_piece);
        return $cbMarq ;
    }

    public function addDocenteteEntreeInventaireProcess21($do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude)
    {
        $do_piece = $this->getLastPieceInv21();
        $this->addDocenteteEntreeMagasin(21, $do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude, $do_piece);
        return $do_piece;
    }

    public function addDocenteteEntreeMagasin($type, $do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude, $do_piece)
    {
        $requete = "
            BEGIN 
            SET NOCOUNT ON;
            INSERT INTO [dbo].[F_DOCENTETE]" .
            "([DO_Domaine], [DO_Type], [DO_Date], [DO_Ref]" .
            ", [DO_Tiers], [CO_No], [cbCO_No], [DO_Period], [DO_Devise]" .
            ", [DO_Cours], [DE_No], [cbDE_No], [LI_No], [cbLI_No]" .
            ", [CT_NumPayeur], [DO_Expedit], [DO_NbFacture], [DO_BLFact]" .
            ", [DO_TxEscompte], [DO_Reliquat], [DO_Imprim], [CA_Num]" .
            ", [DO_Coord01], [DO_Coord02], [DO_Coord03], [DO_Coord04]" .
            ", [DO_Souche], [DO_DateLivr], [DO_Condition], [DO_Tarif]" .
            ", [DO_Colisage], [DO_TypeColis], [DO_Transaction], [DO_Langue]" .
            ", [DO_Ecart], [DO_Regime], [N_CatCompta], [DO_Ventile]" .
            ", [AB_No], [DO_DebutAbo], [DO_FinAbo], [DO_DebutPeriod]" .
            ", [DO_FinPeriod], [CG_Num], [DO_Statut], [DO_Heure]" .
            ", [CA_No], [cbCA_No], [CO_NoCaissier], [cbCO_NoCaissier]" .
            ", [DO_Transfere], [DO_Cloture], [DO_NoWeb], [DO_Attente]" .
            ", [DO_Provenance], [CA_NumIFRS], [MR_No], [DO_TypeFrais]" .
            ", [DO_ValFrais], [DO_TypeLigneFrais], [DO_TypeFranco], [DO_ValFranco]" .
            "    , [DO_TypeLigneFranco], [DO_Taxe1], [DO_TypeTaux1], [DO_TypeTaxe1]" .
            "    , [DO_Taxe2], [DO_TypeTaux2], [DO_TypeTaxe2], [DO_Taxe3]" .
            "    , [DO_TypeTaux3], [DO_TypeTaxe3], [DO_MajCpta], [DO_Motif]" .
            "        , [CT_NumCentrale], [DO_Contact], [DO_FactureElec], [DO_TypeTransac]" .
            "        , [cbProt], [cbCreateur], [cbModification], [cbReplication]" .
            "        , [cbFlag], [longitude], [latitude],[DO_Piece])" .
            "        VALUES" .
            "            (/*DO_Domaine*/2,/*DO_Type*/$type,/*DO_Date*/'" . $do_date . "',/*DO_Ref*/'" . $do_ref . "'" .
            "            ,/*DO_Tiers*/'" . $do_tiers . "',/*CO_No*/0,/*cbCO_No*/NULL,/*DO_Period*/0,/*DO_Devise*/0" .
            "            ,/*DO_Cours*/0,/*DE_No*/0,/*cbDE_No*/NULL,/*LI_No*/0,/*cbLI_No*/NULL" .
            "            ,/*CT_NumPayeur*/NULL,/*DO_Expedit*/0,/*DO_NbFacture*/0,/*DO_BLFact*/0" .
            "            ,/*DO_TxEscompte*/0,/*DO_Reliquat*/0,/*DO_Imprim*/0,/*CA_Num*/''" .
            "            ,/*DO_Coord01*/'',/*DO_Coord02*/'',/*DO_Coord03*/'',/*DO_Coord04*/''" .
            "            ,/*DO_Souche*/0,/*DO_DateLivr*/'" . $do_date . "',/*DO_Condition*/0,/*DO_Tarif*/0" .
            "            ,/*DO_Colisage*/1,/*DO_TypeColis*/1,/*DO_Transaction*/0,/*DO_Langue*/0" .
            "            ,/*DO_Ecart*/0,/*DO_Regime*/0,/*N_CatCompta*/0,/*DO_Ventile*/0" .
            "            ,/*AB_No*/0,/*DO_DebutAbo*/'1900-01-01',/*DO_FinAbo*/'1900-01-01',/*DO_DebutPeriod*/'1900-01-01'" .
            "            ,/*DO_FinPeriod*/'1900-01-01',/*CG_Num*/NULL,/*DO_Statut*/0,/*DO_Heure*/'000' + CAST(DATEPART(HOUR, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(MINUTE, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(SECOND, GETDATE()) as VARCHAR(2))" .
            "           ,/*CA_No*/0,/*cbCA_No*/NULL,/*CO_NoCaissier*/0,/*cbCO_NoCaissier*/NULL,/*DO_Transfere*/0" .
            "            ,/*DO_Cloture*/0,/*DO_NoWeb*/'',/*DO_Attente*/0,/*DO_Provenance*/0" .
            "            ,/*CA_NumIFRS*/'',/*MR_No*/0,/*DO_TypeFrais*/0,/*DO_ValFrais*/0" .
            "            ,/*DO_TypeLigneFrais*/0,/*DO_TypeFranco*/0,/*DO_ValFranco*/0,/*DO_TypeLigneFranco*/0" .
            "            ,/*DO_Taxe1*/0,/*DO_TypeTaux1*/0,/*DO_TypeTaxe1*/0,/*DO_Taxe2*/0" .
            "            ,/*DO_TypeTaux2*/0,/*DO_TypeTaxe2*/0,/*DO_Taxe3*/0,/*DO_TypeTaux3*/0" .
            "            ,/*DO_TypeTaxe3*/0,/*DO_MajCpta*/0,/*DO_Motif*/'',/*CT_NumCentrale*/NULL" .
            "            ,/*DO_Contact*/'',/*DO_FactureElec*/0,/*DO_TypeTransac*/0,/*cbProt*/0" .
            "            ,/*cbCreateur*/'AND',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0" .
            "            ,/*longitude*/" . $longitude . ",/*latitude*/" . $latitude . ",/*DO_Piece*/'$do_piece');
            SELECT @@identity cbMarq;
            END;";
        $result= $this->db->query($requete);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->cbMarq;
    }

    public function canTransform()
    {
        $isTransform = 0;
        $listeArticle ="";
        $rows = $this->listeLigneFacture();
        if ($rows != null) {
            foreach ($rows as $row) {
                $docLigne = new DocLigneClass($row->cbMarq);
                $result = $this->db->requete($this->objetCollection->isStock($this->DE_No, $docLigne->AR_Ref));
                $rows_stk = $result->fetchAll(PDO::FETCH_OBJ);
                $qteStock = 0;
                if ($rows_stk != null) $qteStock = $rows_stk[0]->AS_QteSto;
                if (ROUND($qteStock, 2) - ROUND($docLigne->DL_Qte, 2) >= 0) {

                } else{
                    $listeArticle = $listeArticle.$docLigne->AR_Ref.", ";
                    $isTransform = 1;
                }
            }
        }
        if($isTransform==1)
            return $listeArticle;
    }

    public function redirectToListe($type){
        return "listeFacture-$type";
    }

    public function getListeFacture($de_no,$do_provenance, $datedeb, $datefin,$client,$do_domaine,$do_type){
        return $this->getApiJson( "/getListeFacture&doProvenance=$do_provenance&doType=$do_type&doDomaine=$do_domaine&deNo=$de_no&dateDeb=$datedeb&dateFin=$datefin&client=$client");
    }




public function setValueMvtEntree (){
    $this->CO_No=0;$this->cbCO_No=NULL;$this->DO_Period=0;$this->DO_Devise=0
    ;$this->DO_Cours=0;$this->DE_No=0;$this->cbDE_No=NULL;$this->LI_No=0;$this->cbLI_No=NULL
    ;$this->CT_NumPayeur=NULL;$this->DO_Expedit=0;$this->DO_NbFacture=0;$this->DO_BLFact=0
    ;$this->DO_TxEscompte=0;$this->DO_Reliquat=0;$this->DO_Imprim=0;$this->CA_Num=''
    ;$this->DO_Coord01='';$this->DO_Coord02='';$this->DO_Coord03='';$this->DO_Coord04=''
    ;$this->DO_Souche=0;$this->DO_Condition=0;$this->DO_Tarif=0
    ;$this->DO_Colisage=1;$this->DO_TypeColis=1;$this->DO_Transaction=0;$this->DO_Langue=0
    ;$this->DO_Ecart=0;$this->DO_Regime=0;$this->N_CatCompta=0;$this->DO_Ventile=0
    ;$this->AB_No=0;$this->DO_DebutAbo='1900-01-01';$this->DO_FinAbo='1900-01-01';$this->DO_DebutPeriod='1900-01-01'
    ;$this->DO_FinPeriod='1900-01-01';$this->CG_Num=NULL;$this->DO_Statut=0;
    ;$this->CA_No=0;$this->cbCA_No=NULL;$this->CO_NoCaissier=0;$this->cbCO_NoCaissier=NULL;$this->DO_Transfere=0
    ;$this->DO_Cloture=0;$this->DO_NoWeb='';$this->DO_Attente=0;$this->DO_Provenance=0
    ;$this->CA_NumIFRS='';$this->MR_No=0;$this->DO_TypeFrais=0;$this->DO_ValFrais=0
    ;$this->DO_TypeLigneFrais=0;$this->DO_TypeFranco=0;$this->DO_ValFranco=0;$this->DO_TypeLigneFranco=0
    ;$this->DO_Taxe1=0;$this->DO_TypeTaux1=0;$this->DO_TypeTaxe1=0;$this->DO_Taxe2=0
    ;$this->DO_TypeTaux2=0;$this->DO_TypeTaxe2=0;$this->DO_Taxe3=0;$this->DO_TypeTaux3=0
    ;$this->DO_TypeTaxe3=0;$this->DO_MajCpta=0;$this->DO_Motif='';$this->CT_NumCentrale=NULL
    ;$this->DO_Contact='';$this->DO_FactureElec=0;$this->DO_TypeTransac=0;$this->cbProt=0
    ;$this->cbReplication=0;$this->cbFlag=0;
}
    public function listeTransfert($do_tiers, $datedeb, $datefin){
        return $this->getApiJson("/getlisteTransfert&client={$this->formatString($do_tiers)}&dateDeb=$datedeb&dateFin=$datefin");
    }
    public function listeTransfertConfirmation($do_tiers, $datedeb, $datefin){
        $query = "SELECT PROT_User,DO_Imprim,CASE WHEN ABS(DATEDIFF(d,GETDATE(),E.DO_Date))>= (select PR_DelaiPreAlert
from P_PREFERENCES) THEN 1 ELSE 0 END DO_Modif,E.cbModification,E.cbMarq,E.DO_Type,E.DO_Domaine,E.DO_Piece,E.DO_Ref,ISNULL(MAX(E.N_CatCompta),1) N_CatCompta,CAST(CAST(E.DO_Date AS DATE) AS VARCHAR(10)) AS DO_Date,E.DO_Tiers as CT_Num, ISNULL(SUM(L.DL_MontantTTC),0) AS ttc,
                MAX(DS.DE_Intitule) AS CT_Intitule,MAX(DS.DE_Intitule) AS DE_Intitule_dest,MAX(DE.DE_Intitule) AS DE_Intitule,0 as avance,MAX(latitude) latitude,MAX(longitude) longitude,'' as statut
                 FROM  F_DOCENTETE E 
                 LEFT JOIN F_DOCLIGNE L on E.DO_Piece=L.DO_Piece AND E.DO_Domaine= L.DO_Domaine AND E.DO_Type=L.DO_Type
                 INNER JOIN F_DEPOT DE ON DE.DE_No=E.DE_No 
                 INNER JOIN F_DEPOT DS ON DS.DE_No=E.DO_Tiers
                 INNER JOIN (SELECT cbMarqEntete FROM Z_LIGNE_CONFIRMATION GROUP BY cbMarqEntete) LC ON LC.cbMarqEntete =E.cbMarq
                 LEFT JOIN F_PROTECTIONCIAL P ON E.cbCreateur = CAST(P.PROT_No AS VARCHAR(5))
                WHERE ('0' = '$do_tiers' OR (E.DE_No ='$do_tiers' OR E.DO_Tiers ='$do_tiers'))
                  AND CAST(E.DO_Date as DATE) BETWEEN '$datedeb' AND '$datefin'
                 GROUP BY PROT_User,DO_Imprim,E.cbModification,E.cbMarq,E.DO_Type,E.DO_Domaine,E.DO_Piece,E.DO_Ref,E.DO_Date,E.DO_Tiers
                ORDER BY E.cbMarq ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }



    public function listeEntree($do_tiers, $datedeb, $datefin){
        return $this->getApiJson("/getlisteEntree&client={$this->formatString($do_tiers)}&dateDeb=$datedeb&dateFin=$datefin");
    }

    public function addDocenteteTransfertProcess($do_date, $do_ref, $do_tiers, $ca_num,$depot, $longitude, $latitude,$typefac="Transfert",$protNo){
        return $this->getApiJson("/AjoutMvtStock&typeFacture=$typefac&latitude=$latitude&longitude=$longitude&doRef=$do_ref&caNum=$ca_num&doTiers=$do_tiers&doDate=$do_date&deNo=$depot&protNo=$protNo");
    }

    public function addDocenteteMouvement($do_date, $do_ref, $do_tiers, $ca_num,$depot, $longitude, $latitude,$typefac,$protNo){
        return $this->getApiJson("/AjoutMvtStock&typeFacture=$typefac&latitude=$latitude&longitude=$longitude&doRef=$do_ref&caNum=$ca_num&doTiers=$do_tiers&doDate=$do_date&deNo=$depot&protNo=$protNo");
    }

    public function getFactureByPieceTypeFac(){
        $query = "SELECT cbMarq
                    FROM F_DOCENTETE
                    WHERE DO_Type=".$this->DO_Type." AND DO_Domaine=".$this->DO_Domaine." AND DO_Piece='".$this->DO_Piece."'";
        $result= $this->db->query($query);
        foreach($result->fetchAll(PDO::FETCH_OBJ) as $res){
            return new DocEnteteClass($res->cbMarq);
        }
    }

    public function getStatutAchat($type){
        return $this->getApiJson("/statutAchat&type=$type");
    }


    public function getStatutVente($type){
        return $this->getApiJson("/statutVente&type=$type");
    }

    public function     addDocenteteEntreeProcess($do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude){
        $this->setTypeFac("Entree");
        $do_piece=$this->getEnteteDocument(0);
        if($do_piece!="") {
            $this->updateEnteteTable(0);
            $docEntete = new DocEnteteClass(0);
            $docEntete->defaultValue();
            $docEntete->setValueMvtEntree();
            $docEntete->DO_Domaine = 2;
            $docEntete->DO_Type = 20;
            $docEntete->DO_Piece = $do_piece;
            $docEntete->latitude = $latitude;
            $docEntete->longitude = $longitude;
            $docEntete->DO_Ref = $do_ref;
            $docEntete->DO_Tiers = $do_tiers;
            $docEntete->CA_Num = $ca_num;
            $docEntete->DO_Date = $do_date;
            $docEntete->type_fac = "Entree";
            $docEntete->setValueMvt();
            $docEntete->setuserName("","");
            $docEntete->insert_docEntete();
            $nextDO_Piece = $this->getEnteteDispo();
            $this->updateEnteteTable($nextDO_Piece);
        }
            return $do_piece;
    }

    public function addDocenteteSortieProcess($do_date, $do_ref, $do_tiers, $ca_num, $longitude, $latitude){
        $this->setTypeFac("Sortie");
        $do_piece=$this->getEnteteDocument(0);
        if($do_piece!="") {
            $docEntete = new DocEnteteClass(0);
            $docEntete->defaultValue();
            $docEntete->setValueMvtEntree();
            $docEntete->DO_Domaine = 2;
            $docEntete->DO_Type = 21;
            $docEntete->DO_Piece = $do_piece;
            $docEntete->latitude = $latitude;
            $docEntete->longitude =  $longitude;
            $docEntete->DO_Ref = $do_ref;
            $docEntete->DO_Tiers = $do_tiers;
            $docEntete->CA_Num = $ca_num;
            $docEntete->DO_Date = $do_date;
            $docEntete->DO_DateLivr = "1900-01-01";
            $docEntete->type_fac = "Sortie";
            $docEntete->setValueMvt();
            $docEntete->DO_Condition = 0;
            $docEntete->setuserName("","");
            $docEntete->insert_docEntete();
            $nextDO_Piece = $this->getEnteteDispo();
            $this->updateEnteteTable($nextDO_Piece);
        }
        return $do_piece;

    }


    public function getZFactReglSuppr()
    {
        return $this->getApiString("/getZFactReglSuppr/{$this->cbMarq}");
    }

    public function ajoutEntete($do_pieceG,$typeFacG,$doDate,$doDateEch,$affaireG,$client,$protNo,$mobile,$machine_pc,$doCoord2,$doCoord3,$doCoord4,$doStatut,$latitude,$longitude,$de_no,$catTarif,$catCompta,$souche,$ca_no,$co_no,$reference){
        $DO_Coord02 = (isset($doCoord2) && $doCoord2!="") ? $doCoord2 : "%20";
        $DO_Coord03 = (isset($doCoord3) && $doCoord3!="") ? $doCoord3 : "%20";
        $DO_Coord04 = (isset($doCoord4) && $doCoord4!="") ? $doCoord4 : "%20";
        $do_piece = (isset($do_pieceG)) ? $do_pieceG : "%20";
        $affaire = ($affaireG=="null" || $affaireG=="0") ? "%20" : $affaireG;
        $date_ech = (isset($doDateEch)) ? $doDateEch : $doDate;
        $user = (isset($username) && strcmp(trim($mobile),"android")) ? $username : "%20";
        $machine = (isset($machine_pc)) ? $machine_pc : "%20";
        $reference = ($reference=="") ? " " :$reference ;
        $client = ($client=="") ? "%20" : $client ;
        $ca_no = ($ca_no=="") ? 0 : $ca_no;
        $type_fac=$typeFacG;
        $docEntete = new DocEnteteClass(0);

        $url = "/ajoutEntete&protNo=$protNo&doPiece={$this->formatString($do_piece)}&typeFacture=$type_fac&doDate=$doDate&doSouche=$souche&caNum={$this->formatString($affaire)}&ctNum={$this->formatString($client)}&machineName={$this->formatString($machine_pc)}&doCoord01=$DO_Coord04&doCoord02=$DO_Coord02&doCoord03=$DO_Coord03&doCoord04=$DO_Coord04&doStatut=$doStatut&catTarif=$catTarif&catCompta=$catCompta&deNo=$de_no&caNo=$ca_no&coNo=$co_no&reference={$this->formatString($reference)}&longitude=$longitude&latitude=$latitude";
        $docEntete = $this->getApiJson($url);
        $data = array();
        if($docEntete!=null)
            $data = array('entete' => $docEntete[0]->DO_Piece,'cbMarq' => $docEntete[0]->cbMarq,'DO_Cours' => $docEntete[0]->DO_Cours);
        return $data;
    }

    public function getLigneTransfert(){
        return $this->getApiJson("/getLigneTransfert&cbMarq={$this->cbMarq}");
    }

    public function getLigneFactureTransfert() {
        return $this->getApiJson("/getLigneFactureTransfert&cbMarq={$this->cbMarq}");
    }

    public function transBLFacture($cbMarq,$conserv,$typeTrans,$reference,$date,$protNo){
        return $this->getApiJson("/transBLFacture&cbMarq=$cbMarq&conserv=$conserv&typeTrans=$typeTrans&reference=$reference&date=$date&protNo=$protNo");
    }

    public function deleteEntete(){
        $result = $this->db->requete( "
            DELETE FROM F_DOCREGL WHERE DO_Piece='".$this->DO_Piece."' AND DO_Domaine=".$this->DO_Domaine." 
            AND DO_Type=".$this->DO_Type.";");
        $this->delete();
    }

    public function addDocenteteFactureProcess($CT_Num, $CO_No, $ref, $date, $N_Reglement,$de_no,$cat_tarif,$cat_compta,$souche,$ca_no,$affaire,$type_fac,$do_statut,$latitude,$longitude,$date_ech,$do_piece,$DO_Cood2,$DO_Coord03,$DO_Coord04,$mobile,$user) {
        $this->setTypeFac($type_fac);
        $do_piece=$this->getEnteteDocument($souche);
        $client = new ComptetClass($CT_Num,"all",$this->db);
        $ct_type= 1;
        if($this->DO_Domaine==0) $ct_type= 0;
        $rows = $this->ajoutEnteteTransaction($CT_Num,$ct_type,$ca_no,$date_ech,$type_fac);
        $date_ech = $rows[0]->dateEchCalcule;
        $li_no = $rows[0]->li_no;
        $co_nocaissier = $rows[0]->coNoCaissier;
        $vehicule = "";
        $ca_num = $affaire;
        $this->defaultValue();
        $this->setDefaultValueVente($client);
        $this->setDefaultValueAchat($client);
        $this->setInfoAjoutEntete();
        $this->DO_Date = $date;
        $this->DO_Ref = $ref;
        $this->CO_No = $CO_No;
        $this->DE_No = $de_no;
        $this->LI_No = $li_no;
        $this->CA_Num = $ca_num;
        $this->DO_Souche = $souche;
        $this->N_CatCompta = $cat_compta;
        $this->CA_No = $ca_no;
        $this->CO_NoCaissier = $co_nocaissier;
        $this->VEHICULE = $vehicule;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->DO_Piece = $do_piece;
        $this->DO_Statut = $do_statut;
        $this->DO_Coord02 = $DO_Cood2;
        $this->DO_Coord03 = $DO_Coord03;
        $this->DO_Coord04 = $DO_Coord04;
        $this->setuserName($user,$mobile);
        $this->cbMarq = $this->insert_docEntete();
        $nextDO_Piece = $this->getEnteteDispo();
        $this->updateEnteteTable($nextDO_Piece);
        if($type_fac=="Vente" || $type_fac=="Ticket"  || $type_fac=="AchatRetour" || $type_fac=="Achat" || $type_fac=="PreparationCommande" || $type_fac=="AchatPreparationCommande")
            $this->db->requete($this->objetCollection->addDocRegl($this->DO_Domaine, $this->DO_Type, $this->DO_Piece, 0, $N_Reglement,$date_ech));
        return $this->cbMarq;
    }

    public function ajoutEnteteTransaction($ct_num,$ct_type,$CA_No,$dateEch,$type_fac){
        $query="DECLARE @ctNum AS VARCHAR(35) = '{$ct_num}'
                DECLARE @ctType AS INT = {$ct_type}
                DECLARE @coNoCaissier AS INT
                DECLARE @CA_No AS INT = {$CA_No}
                declare @dateEchCalcule as VARCHAR(10)
                declare @type_fac as VARCHAR(50) = '{$type_fac}'
                declare @date_ech as date
                declare @nbjour as int
                declare @datecivil as date
                declare @date as date
                declare @day as int
                declare @val as int
                declare @condition as int 
                declare @li_no as int 
                set @date_ech = '{$dateEch}' 
                
                SELECT @condition = ER_Condition,@nbjour = ER_NbJour, @val = ER_JourTb01
                FROM F_EMODELER E
                INNER JOIN P_REGLEMENT P ON E.N_Reglement = P.R_Code
                WHERE MR_No = (SELECT MR_No
                                FROM F_COMPTET
                                WHERE CT_Type = @ctType AND CT_Num=@ctNum)
                
                set @date = (select dateadd(day,@nbjour,@date_ech))
                set @datecivil = (select dateadd(month,(@nbjour/30),@date_ech))
                set @day = CASE WHEN @val=0 THEN 1 ELSE @val END
                
                SELECT @dateEchCalcule = (CASE WHEN @condition = 0 THEN JourNet WHEN @condition = 1 THEN FinMoisCivil WHEN @condition = 2 THEN FinMois END)
                FROM (
                SELECT
                (SELECT CAST(CASE WHEN @val=0 THEN @date ELSE DATEADD(day,@day-1,CAST(YEAR(@date) AS VARCHAR(4))+'-'+RIGHT(CAST(MONTH(@date)+1 AS VARCHAR(2)),2)+'-01') END AS DATE)AS DATE) AS JourNet,
                (SELECT CASE WHEN @val = 0 THEN EOMONTH(DATEADD(day,@day,EOMONTH(@datecivil)))
                ELSE DATEADD(day,@day,EOMONTH(@datecivil)) END) FinMoisCivil,
                (SELECT CASE WHEN @val = 0 THEN CAST(EOMONTH(@date) AS VARCHAR(10))
                ELSE DATEADD(day,@day,EOMONTH(@date)) END) FinMois)A
                
                SELECT @coNoCaissier = CO_NoCaissier 
                FROM F_CAISSE
                WHERE CA_No=@CA_No
                    
                SELECT @li_no = LI_No
                FROM F_LIVRAISON
                WHERE CT_Num=@ctNum AND @type_fac<>'Achat'
                
                SELECT ISNULL(@dateEchCalcule,@date_ech) dateEchCalcule,ISNULL(@li_no,0) li_no,ISNULL(@coNoCaissier,0) coNoCaissier
";
        $result = $this->db->requete($query);
        $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
        if($rowsTour!=null)
            return $rowsTour;
        return null;
    }

    public function updateEnteteTable($nextDO_Piece)
    {
        $query = "UPDATE F_DOCCURRENTPIECE SET DC_Piece='{$nextDO_Piece}',cbModification=GETDATE() WHERE DC_Domaine={$this->DO_Domaine} AND DC_Souche={$this->DO_Souche} AND DC_IdCol={$this->doccurent_type}";
        $this->db->requete($query);
    }


    public function getEnteteDocument($do_souche){
        $this->DO_Piece = $this->getEnteteTable($do_souche);
        $do_piece = $this->getEnteteDispo();
        return $do_piece;
    }

    public function montantRegle() {
        return $this->getApiJson("/montantRegle&cbMarq={$this->cbMarq}");
    }

    public function AvanceDoPiece() {
        return $this->getApiJson("/avanceDoPiece&cbMarq={$this->cbMarq}");
    }

    public function isVisu($protNo,$typeFacture)
    {
		return $this->getApiJson("/isVisu&cbMarq={$this->cbMarq}&protNo={$protNo}&typeFacture={$typeFacture}");
    }

    public function isModif($protNo,$typeFacture){
        return $this->getApiJson("/isModif&cbMarq={$this->cbMarq}&protNo={$protNo}&typeFacture={$typeFacture}");
    }

    public function getFactureCORecouvrement($collab,$ctNum){
        return $this->getApiJson("/getFactureCORecouvrement&collab={$collab}&ctNum={$ctNum}");
    }

    public function activeMenu($module,$action,$type){
        if($type=="Vente"  && $module==2 && ($action == 3 || $action==1))
            return "active";
        if($type=="Devis"  && $module==2 && ($action == 3 || $action==1))
            return "active";
        if($type=="BonLivraison" && $module==2 && ($action == 3 || $action==1))
            return "active";
        if($type=="VenteAvoir" && $module==2 && ($action == 3 || $action==1))
            return "active";
        if($type=="VenteRetour" && $module==2 && ($action == 3 || $action==1))
            return "active";
        if($type=="Ticket" && $module==2 && ($action == 3 || $action==1))
            return "active";

        if($type=="Achat"  && $module==2 && ($action == 1 || $action==2))
            return "active";
        if($type=="PreparationCommande" && $module==2 && ($action == 1 || $action==2))
            return "active";
        if($type=="AchatPreparationCommande" && $module==2 && ($action == 1 || $action==2))
            return "active";
        if($type=="AchatRetour" && $module==2 && ($action == 1 || $action==2))
            return "active";

        if($type=="listeArticle" && $module==3 && ($action == 3 || $action == 1))
            return "active";
        if($type=="listeClient" && $module==3 &&  ($action == 4 || $action == 2))
            return "active";
        if($type=="listeFournisseur" && $module==3 &&  ($action == 4 || $action == 2))
            return "active";
        if($type=="listeFamille" && $module==3  &&  ($action == 7 || $action == 6))
            return "active";
        if($type=="listeDepot" && $module==3  &&  ($action == 11 || $action == 10))
            return "active";
        if($type=="listeCollaborateur" && $module==3  &&  ($action == 13 || $action == 12))
            return "active";
        if($type=="listeCaisse" && $module==3  &&  ($action == 15 || $action == 14))
            return "active";
        if($type=="listeSalarie" && $module==3  &&  ($action == 4 || $action == 2))
            return "active";
        if($type=="RabaisRemiseRistourne" && $module==3  &&  ($action == 4 || $action == 2))
            return "active";

        if($type=="ClotureCaisse" && $module==9 && $action == 18)
            return "active";
        if($type=="majComptable" && $module==9 && $action == 16)
            return "active";
        if($type=="majAnalytique" && $module==9 && $action == 17)
            return "active";
        if($type=="InterrogationLettrage" && $module==9 && $action == 19)
            return "active";
        if($type=="InterrogationTiers" && $module==9 && $action == 19)
            return "active";



        return "";
    }
    public function getEnteteDispo(){
        $dopiece = $this->DO_Piece;
        $rowsTour = $this->getEnteteByDOPiece($dopiece);
        while($rowsTour!=null){
            $dopiece = $this->incrementeDOPiece($dopiece);
            $rowsTour = $this->getEnteteByDOPiece($dopiece);
        }
        if($this->DO_Type==30){
            $rowsTour = $this->getEnteteTicketByDOPiece();
            $dopiece = $rowsTour+1;
        }
        return $dopiece;
    }

    public function ResteARegler($avance)
    {
        return $this->getApiJson("/resteARegler&cbMarq={$this->cbMarq}&avance=$avance");
    }


    public function getEnteteTicketByDOPiece() {
        $result = $this->db->requete( "SELECT ISNULL(Max(DO_Piece),0) DO_Piece 
                FROM(
                SELECT CAST(DO_Piece AS INT) AS DO_Piece
                FROM F_DOCENTETE 
                WHERE DO_Domaine={$this->DO_Domaine} AND DO_Type = {$this->DO_Type}
                UNION
                SELECT TA_Piece AS DO_Piece
                FROM F_TICKETARCHIVE)A");
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null)
            return $rows[0]->DO_Piece;
        return 0;
    }

    public function incrementeDOPiece($var){
        preg_match_all('!\d+!', $var, $matches);
        $len = strlen($matches[0][0]);
        if(strlen($var)<2)
            return $var+1;
        else
            return substr($var, 0,strlen($var)-$len).substr("00000".($matches[0][0]+1),-$len);
    }

    public function getEnteteByDOPiece($dopiece) {
        $result = $this->db->requete("SELECT *,CONVERT(char(10), CAST(DO_Date AS DATE),126) AS DO_DateC 
                FROM F_DOCENTETE 
                WHERE DO_Piece='{$dopiece}' AND DO_Domaine='{$this->DO_Domaine}' AND (({$this->DO_Type}=6 AND (DO_Type IN(6,7))) 
                OR ({$this->DO_Type}=16 AND (DO_Type IN(16,17))) OR (DO_Type NOT IN (16,6) AND {$this->DO_Type}=DO_Type ))");
        $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
        if($rowsTour!=null)
            return $rowsTour[0]->DO_Piece;
        return null;
    }

    public function getDocumentByDOPiece($do_piece,$DO_Domaine,$DO_Type) {
        $result = $this->db->requete("SELECT cbMarq 
                FROM F_DOCENTETE 
                WHERE DO_Piece='$do_piece' AND DO_Domaine=$DO_Domaine AND $DO_Type=DO_Type");
        $rowsTour = $result->fetchAll(PDO::FETCH_OBJ);
        if($rowsTour!=null)
            return new DocEnteteClass($rowsTour[0]->cbMarq);
        return null;
    }
/*
    public function getEnteteTable($souche){
        $query = "SELECT ISNULL((SELECT DC_Piece
                from F_DOCCURRENTPIECE D
                WHERE DC_Domaine='{$this->DO_Domaine}' AND DC_Souche=$souche AND DC_IdCol='{$this->doccurent_type}'),0) as DC_Piece";
        $result = $this->db->requete($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null)
            return $rows[0]->DC_Piece;
        return null;
    }
*/
    public function getDO_DateC(){
        $result = $this->db->requete("SELECT CONVERT(char(10), CAST(DO_Date AS DATE),126) AS DO_DateC
                                        from F_DOCENTETE
                                        WHERE DO_Domaine=".$this->DO_Domaine." AND DO_Type=".$this->DO_Type." AND DO_Piece='".$this->DO_Piece."'");
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null)
            return $rows[0]->DO_DateC;
    }

    public function listeTransfertDetail($do_tiers, $datedeb, $datefin){
        return $this->getApiJson("/getlisteTransfertDetail&client={$this->formatString($do_tiers)}&dateDeb=$datedeb&dateFin=$datefin");

    }


    public function listeSortie($do_tiers, $datedeb, $datefin){
        return $this->getApiJson("/getlisteSortie&client={$this->formatString($do_tiers)}&dateDeb=$datedeb&dateFin=$datefin");
    }

    function majEnteteComptable($doPiece,$doDomaine,$doType,$doTypeCible){
        $this->getApiExecute("/majEnteteComptable&doType=$doType&doDomaine=$doDomaine&doPiece=$doPiece&doTypeCible=$doTypeCible");
    }


    public function getListeFactureMajComptable($typeTransfert, $datedeb, $datefin,$doPiecedeb,$doPiecefin,$souche,$etatPiece,$catCompta,$caisse){
        $query = "
                    DECLARE @doDomaine INT = 0
                            ,@doType INT =  0
                            ,@dateDeb VARCHAR(20) = '$datedeb'
                            ,@dateFin VARCHAR(20) = '$datefin'
                            ,@doPieceDeb VARCHAR(20) = '$doPiecedeb'
                            ,@doPieceFin VARCHAR(20) = '$doPiecefin'
                            ,@doSouche INT = '$souche'
                            ,@catCompta INT = $catCompta
                            ,@caisse INT = $caisse
                            ,@typeTransfert INT = $typeTransfert
                            ,@etatPiece INT = $etatPiece
                            
                    SELECT @doDomaine = CASE WHEN @typeTransfert = 2 THEN 1 ELSE 0 END
                    SELECT @doType = CASE WHEN @typeTransfert = 2 THEN 
                                        CASE WHEN @etatPiece = 1 THEN 17 ELSE 16 END 
                                    ELSE 
                                        CASE WHEN @etatPiece = 1 THEN 7 ELSE 6 END
                    SELECT @doDomaine = CASE WHEN @typeTransfert = 2 THEN 1 ELSE 0 END
                            
                      SELECT cbMarq,DO_Domaine,DO_Type,DO_Piece 
                      FROM F_DOCENTETE
                      WHERE DO_Domaine=@doDomaine AND DO_Type=@doType
                      AND (@dateDeb='' OR DO_Date>=@dateDeb)
                      AND (@dateFin='' OR DO_Date<=@dateFin)
                      AND (@doPieceDeb='' OR DO_Piece>=@doPieceDeb)
                      AND (@doPieceFin='' OR DO_Piece<=@doPieceFin)
                      AND (@doSouche='-1' OR DO_Souche=@doSouche)
                      AND (@catCompta='0' OR N_CatCompta>=@catCompta)
                      AND (@caisse='0' OR CA_No =@caisse)";

        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            $docEntete = new DocEnteteClass($resultat->cbMarq);
            array_push($this->list,$docEntete);
        }
        return $this->list;
    }


    public function getEnteteByRG_No($RG_No){
        $query = "  SELECT A.*
                    FROM F_DOCENTETE A
                    INNER JOIN F_REGLECH B ON A.DO_Domaine=B.DO_Domaine AND A.DO_Type=B.DO_Type AND A.DO_Piece =B.DO_Piece 
                    WHERE RG_No = $RG_No";
        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            $docEntete = new DocEnteteClass($resultat->cbMarq);
            array_push($this->list,$docEntete);
        }
        return $this->list;
    }

    public function HeaderListeFacture($type,$admin,$protected,$protectedSuppression,$cbCeateur){
        $header = Array("Numéro Piece","Référence","Date");

        if(!($type=="Achat" || $type=="AchatC" || $type=="AchatT" ||
            $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande"))
                array_push($header ,"Client");
        if(!($type=="Achat" || $type=="AchatC" || $type=="AchatT" ||
                $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande")
                    || $type=="Entree"|| $type=="Sortie")
            array_push($header ,"Dépot");
        if($type=="Achat" || $type=="AchatC" || $type=="AchatT" ||
                        $type=="AchatRetour" || $type=="AchatRetourC" || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande") {
            array_push($header, "Fournisseur");
            array_push($header, "Dépot");
        }
        if($type=="Transfert_detail" || $type=="Transfert" || $type=="Transfert_valid_confirmation" || $type=="Transfert_confirmation") {
            array_push($header, "Dépot source");
            array_push($header, "Dépot dest.");
        }
        array_push($header, "Total TTC");

        if($type=="BonLivraison" || $type=="Vente" || $type=="Ticket" || $type=="Retour" || $type=="VenteT" || $type=="VenteC" || $type=="RetourT" || $type=="RetourC" || $type=="AchatC" || $type=="Achat"  || $type=="AchatT"
                        || $type=="AchatRetourC" || $type=="AchatRetour"  || $type=="AchatRetourT" || $type=="PreparationCommande"|| $type=="AchatPreparationCommande"){
            array_push($header, "Montant réglé");
            array_push($header, "Statut");
        }

        if(($type=="BonLivraison" || $type=="Devis") && ($admin==1 || ($protected)))
            array_push($header, "");

        if($protectedSuppression)
            array_push($header, "");
        if($cbCeateur!=2)
            array_push ($header,"Créateur");
        $final ="";
    }

    public function __toString() {
        return "";
    }

}