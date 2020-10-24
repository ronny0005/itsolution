<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DocLigneClass Extends Objet
{
    //put your code here
    public $db, $DO_Domaine, $DO_Type, $CT_Num, $DO_Piece, $DL_PieceBC, $DL_PieceBL, $DO_Date, $DL_DateBC
    , $DL_DateBL, $DL_Ligne, $DO_Ref, $DL_TNomencl, $DL_TRemPied, $DL_TRemExep, $AR_Ref, $DL_Design
    , $DL_Qte, $DL_QteBC, $DL_QteBL, $DL_PoidsNet, $DL_PoidsBrut, $DL_Remise01REM_Valeur, $DL_Remise01REM_Type, $DL_Remise02REM_Valeur
    , $DL_Remise02REM_Type, $DL_Remise03REM_Valeur, $DL_Remise03REM_Type, $DL_PrixUnitaire
    , $DL_PUBC, $DL_Taxe1, $DL_TypeTaux1, $DL_TypeTaxe1, $DL_Taxe2, $DL_TypeTaux2, $DL_TypeTaxe2, $CO_No
    , $AG_No1, $AG_No2, $DL_PrixRU, $DL_CMUP, $DL_MvtStock, $DT_No, $AF_RefFourniss, $EU_Enumere
    , $EU_Qte, $DL_TTC, $DE_No, $DL_NoRef, $DL_TypePL, $DL_PUDevise, $DL_PUTTC, $DL_No
    , $DO_DateLivr, $CA_Num, $cbCA_Num, $DL_Taxe3, $DL_TypeTaux3, $DL_TypeTaxe3, $DL_Frais, $DL_Valorise
    , $AR_RefCompose, $DL_NonLivre, $AC_RefClient, $DL_MontantHT, $DL_MontantTTC, $DL_FactPoids, $DL_Escompte, $DL_PiecePL
    , $DL_DatePL, $DL_QtePL, $DL_NoColis, $DL_NoLink, $RP_Code, $DL_QteRessource, $DL_DateAvancement, $cbMarq
    , $cbCreateur, $cbModification, $USERGESCOM, $NOMCLIENT, $DATEMODIF, $ORDONATEUR_REMISE, $MACHINEPC, $GROUPEUSER
    , $cag, $mag, $carat, $eau, $divise, $purity, $pureway, $oz, $cioj, $DL_PUTTC_Rem0, $DL_PrixUnitaire_Rem0, $DL_PUTTC_Rem
    , $DL_PrixUnitaire_Rem, $DL_Remise, $MT_Taxe1, $MT_Taxe2, $MT_Taxe3;
    public $table = 'F_DOCLIGNE';
    public $lien = 'fdocligne';

    function __construct($id)
    {
        $this->data = $this->getApiJson("/cbMarq=$id");
        $this->cbMarq = 0;
        if ($this->data!=NULL && sizeof($this->data) > 0) {
            $this->DO_Domaine = $this->data[0]->DO_Domaine;
            $this->DO_Type = $this->data[0]->DO_Type;
            $this->CT_Num = $this->data[0]->CT_Num;
            $this->DO_Piece = $this->data[0]->DO_Piece;
            $this->DL_PieceBC = $this->data[0]->DL_PieceBC;
            $this->DL_PieceBL = $this->data[0]->DL_PieceBL;
            $this->DO_Date = $this->data[0]->DO_Date;
            $this->DL_DateBC = $this->data[0]->DL_DateBC;
            $this->DL_DateBL = $this->data[0]->DL_DateBL;
            $this->DL_Ligne = $this->data[0]->DL_Ligne;
            $this->DO_Ref = $this->data[0]->DO_Ref;
            $this->DL_TNomencl = $this->data[0]->DL_TNomencl;
            $this->DL_TRemPied = $this->data[0]->DL_TRemPied;
            $this->DL_TRemExep = $this->data[0]->DL_TRemExep;
            $this->AR_Ref = $this->data[0]->AR_Ref;
            $this->DL_Design = $this->data[0]->DL_Design;
            $this->DL_Qte = $this->data[0]->DL_Qte;
            $this->DL_QteBC = $this->data[0]->DL_QteBC;
            $this->DL_QteBL = $this->data[0]->DL_QteBL;
            $this->DL_PoidsNet = $this->data[0]->DL_PoidsNet;
            $this->DL_PoidsBrut = $this->data[0]->DL_PoidsBrut;
            $this->DL_Remise01REM_Valeur = $this->data[0]->DL_Remise01REM_Valeur;
            $this->DL_Remise01REM_Type = $this->data[0]->DL_Remise01REM_Type;
            $this->DL_Remise02REM_Valeur = $this->data[0]->DL_Remise02REM_Valeur;
            $this->DL_Remise02REM_Type = $this->data[0]->DL_Remise02REM_Type;
            $this->DL_Remise03REM_Valeur = $this->data[0]->DL_Remise03REM_Valeur;
            $this->DL_Remise03REM_Type = $this->data[0]->DL_Remise03REM_Type;
            $this->DL_PrixUnitaire = $this->data[0]->DL_PrixUnitaire;
            $this->DL_PUBC = $this->data[0]->DL_PUBC;
            $this->DL_Taxe1 = $this->data[0]->DL_Taxe1;
            $this->DL_TypeTaux1 = $this->data[0]->DL_TypeTaux1;
            $this->DL_TypeTaxe1 = $this->data[0]->DL_TypeTaxe1;
            $this->DL_Taxe2 = $this->data[0]->DL_Taxe2;
            $this->DL_TypeTaux2 = $this->data[0]->DL_TypeTaux2;
            $this->DL_TypeTaxe2 = $this->data[0]->DL_TypeTaxe2;
            $this->CO_No = $this->data[0]->CO_No;
            $this->AG_No1 = $this->data[0]->AG_No1;
            $this->AG_No2 = $this->data[0]->AG_No2;
            $this->DL_PrixRU = $this->data[0]->DL_PrixRU;
            $this->DL_CMUP = $this->data[0]->DL_CMUP;
            $this->DL_MvtStock = $this->data[0]->DL_MvtStock;
            $this->DT_No = $this->data[0]->DT_No;
            $this->AF_RefFourniss = $this->data[0]->AF_RefFourniss;
            $this->EU_Enumere = $this->data[0]->EU_Enumere;
            $this->EU_Qte = $this->data[0]->EU_Qte;
            $this->DL_TTC = $this->data[0]->DL_TTC;
            $this->DE_No = $this->data[0]->DE_No;
            $this->DL_NoRef = $this->data[0]->DL_NoRef;
            $this->DL_TypePL = $this->data[0]->DL_TypePL;
            $this->DL_PUDevise = $this->data[0]->DL_PUDevise;
            $this->DL_PUTTC = $this->data[0]->DL_PUTTC;
            $this->DL_No = $this->data[0]->DL_No;
            $this->DO_DateLivr = $this->data[0]->DO_DateLivr;
            $this->CA_Num = $this->data[0]->CA_Num;
            $this->DL_Taxe3 = $this->data[0]->DL_Taxe3;
            $this->DL_TypeTaux3 = $this->data[0]->DL_TypeTaux3;
            $this->DL_TypeTaxe3 = $this->data[0]->DL_TypeTaxe3;
            $this->DL_Frais = $this->data[0]->DL_Frais;
            $this->DL_Valorise = $this->data[0]->DL_Valorise;
            $this->AR_RefCompose = $this->data[0]->AR_RefCompose;
            $this->DL_NonLivre = $this->data[0]->DL_NonLivre;
            $this->AC_RefClient = $this->data[0]->AC_RefClient;
            $this->DL_MontantHT = $this->data[0]->DL_MontantHT;
            $this->DL_MontantTTC = $this->data[0]->DL_MontantTTC;
            $this->DL_FactPoids = $this->data[0]->DL_FactPoids;
            $this->DL_Escompte = $this->data[0]->DL_Escompte;
            $this->DL_PiecePL = $this->data[0]->DL_PiecePL;
            $this->DL_DatePL = $this->data[0]->DL_DatePL;
            $this->DL_QtePL = $this->data[0]->DL_QtePL;
            $this->DL_NoColis = $this->data[0]->DL_NoColis;
            $this->DL_NoLink = $this->data[0]->DL_NoLink;
            $this->RP_Code = $this->data[0]->RP_Code;
            $this->DL_QteRessource = $this->data[0]->DL_QteRessource;
            $this->DL_DateAvancement = $this->data[0]->DL_DateAvancement;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->NOMCLIENT = $this->data[0]->NOMCLIENT;
            $this->DATEMODIF = $this->data[0]->DATEMODIF;
            $this->ORDONATEUR_REMISE = $this->data[0]->ORDONATEUR_REMISE;
            $this->MACHINEPC = $this->data[0]->MACHINEPC;
            $this->GROUPEUSER = $this->data[0]->GROUPEUSER;
            $this->initRemise();
            $this->setcbCreateurName();
        }
    }


    public function getcbCreateurName(){
        return $this->userName;
    }

    public function setcbCreateurName(){
        $this->userName= $this->getApiString("/getcbCreateurName&cbMarq={$this->cbMarq}"); //converts to an object
    }

    public function initRemise()
    {
        $rows  = $this->getApiJson("/initRemise&cbMarq={$this->cbMarq}");
        $this->DL_PUTTC_Rem0 = $rows[0]->DL_PUTTC_Rem0;
        $this->DL_PrixUnitaire_Rem0 = $rows[0]->DL_PrixUnitaire_Rem0;
        $this->DL_PUTTC_Rem = $rows[0]->DL_PUTTC_Rem;
        $this->DL_PrixUnitaire_Rem = $rows[0]->DL_PrixUnitaire_Rem;
        $this->DL_Remise = $rows[0]->DL_Remise;
        $this->MT_Taxe1 = $rows[0]->MT_Taxe1;
        $this->MT_Taxe2 = $rows[0]->MT_Taxe2;
        $this->MT_Taxe3 = $rows[0]->MT_Taxe3;
    }

    public function getLigneFacture($cbMarq)
    {
        return $this->getApiJson("/getLigneFacture&cbMarq=$cbMarq");
    }


    public function getLigneFactureElementByCbMarq()
    {
        $query = "SELECT  DO_Domaine, DO_Type,DO_Date,DL_PUTTC,DL_NoColis,DE_No,cbMarq,DO_Piece,AR_Ref
                        ,DL_Qte,DL_Design,DL_PrixUnitaire,DL_CMUP,DL_Taxe1,DL_Taxe2,DL_Taxe3,DL_MontantTTC
                        ,DL_MontantHT,DL_Ligne
                        ,CASE WHEN DL_Remise01REM_Type=0 THEN ''  
                              WHEN DL_Remise01REM_Type=1 THEN cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'%' 
                              ELSE cast(cast(DL_Remise01REM_Valeur as numeric(9,2)) as varchar(10))+'U' END DL_Remise  
                FROM F_DOCLIGNE  WHERE cbMarq ={$this->cbMarq}";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function modifDocligneFactureMagasin($DL_Qte, $prix, $type_fac,$protNo,$cbMarqEntete)
    {
        return $this->ajout_ligneFacturation($DL_Qte," ",$cbMarqEntete,$type_fac,0,$prix," "," ","modif_ligne",$protNo);
    }


    public function getLigneConfirmation($cbMarq)
    {
        $query = "SELECT  * 
                FROM    Z_LIGNE_CONFIRMATION 
                WHERE   cbMarq =$cbMarq";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0];
    }

    public function verifSupprAjout(){
        return $this->getApiJson("/verifSupprAjout&cbMarq={$this->cbMarq}");
    }

    public function ligneConfirmationVisuel($cbMarqEntete)
    {
        echo "
        <table class='table table-striped'>
            <thead>
                <th><input type='checkbox' name='checkAll' id='checkAll'/></th>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>Prix</th>
            </thead>
            <tbody>";
        $docEntete = new DocEnteteClass($cbMarqEntete, $this->db);
        $list = $docEntete->getLignetConfirmation();
        foreach ($list as $row) {
            echo "<tr>
                            <td><input type='checkbox' name='itemCheck' id='itemCheck'/></td>
                            <td>{$row->AR_Ref}</td>
                            <td>{$row->AR_Design}</td>
                            <td><input type='text' name='qte' id='qte' value='{$this->objetCollection->formatChiffre($row->DL_Qte)}' class='form-control'/></td>
                            <td>{$this->objetCollection->formatChiffre($row->Prix)}<span id='cbMarq' style='display: none'>{$row->cbMarq}</span></td>
                            </tr>";
        }
        echo "
            </tbody>
        </table>";
    }

    public function getEnteteByDOPieceDOType($do_piece, $do_domaine, $do_type)
    {
        $query = "SELECT *,CONVERT(char(10), CAST(DO_Date AS DATE),126) AS DO_DateC 
                FROM F_DOCENTETE 
                WHERE DO_Domaine=$do_domaine AND DO_Type = $do_type AND DO_Piece='$do_piece'";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ)[0];
    }

    public function addDocligneEntreeMagasinProcess21($AR_Ref, $DO_Piece, $DL_Qte, $MvtStock, $DE_No, $prix, $login)
    {
        $AR_PrixAch = 0;
        $AR_Design = "";
        $AR_PrixVen = 0;
        $montantHT = 0;
        $AR_UniteVen = 0;
        $U_Intitule = "";
        $DO_Date = "";
        $DO_Domaine = "";
        $DO_Type = "";
        $article = new ArticleClass($AR_Ref, $this->db);
        $AR_Design = str_replace("'", "''", $article->AR_Design);
        $AR_Ref = $article->AR_Ref;
        $AR_PrixAch = $prix;
        $AR_UniteVen = $article->AR_UniteVen;
        $montantHT = ROUND($AR_PrixAch * $DL_Qte, 2);
        $result = $this->db->requete($this->objetCollection->getUnite($AR_UniteVen));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $U_Intitule = $rows[0]->U_Intitule;
        }
        $rows = $this->getEnteteByDOPieceDOType($DO_Piece, 2, 21);
        if ($rows != null) {
            $DO_Date = $rows->DO_DateC;
            $do_ref = $rows->DO_Ref;
            $DO_Domaine = $rows->DO_Domaine;
            $DO_Type = $rows->DO_Type;
            $cbMarq = $this->insertDocligneEntreeMagasin($DO_Domaine, $DO_Type, $DE_No, $DO_Piece, $DO_Date, $AR_Ref, $AR_Design, $DL_Qte, $do_ref, $AR_PrixAch, $MvtStock, $U_Intitule, $DE_No, $montantHT, "", $login, "", "");
        }
    }

    public function insertDocligneEntreeMagasin($do_domaine, $do_type, $ct_num, $do_piece, $do_date, $ar_ref, $ar_design, $dl_qte, $do_ref, $ar_prixach, $mvtstock, $u_intitule, $de_no, $montantht, $ca_num, $login, $type_fac, $machine)
    {
        $requete = "
              BEGIN
              SET NOCOUNT ON;
              INSERT INTO [dbo].[F_DOCLIGNE]" .
            "    ([DO_Domaine], [DO_Type], [CT_Num], [DO_Piece], [DL_PieceBC], [DL_PieceBL], [DO_Date], [DL_DateBC]" .
            "    , [DL_DateBL], [DL_Ligne], [DO_Ref], [DL_TNomencl], [DL_TRemPied], [DL_TRemExep], [AR_Ref], [DL_Design]" .
            "    , [DL_Qte], [DL_QteBC], [DL_QteBL], [DL_PoidsNet], [DL_PoidsBrut], [DL_Remise01REM_Valeur], [DL_Remise01REM_Type], [DL_Remise02REM_Valeur]" .
            "    , [DL_Remise02REM_Type], [DL_Remise03REM_Valeur], [DL_Remise03REM_Type], [DL_PrixUnitaire]" .
            "    , [DL_PUBC], [DL_Taxe1], [DL_TypeTaux1], [DL_TypeTaxe1], [DL_Taxe2], [DL_TypeTaux2], [DL_TypeTaxe2], [CO_No]" .
            "    , [cbCO_No], [AG_No1], [AG_No2], [DL_PrixRU], [DL_CMUP], [DL_MvtStock], [DT_No], [cbDT_No]" .
            "    , [AF_RefFourniss], [EU_Enumere], [EU_Qte], [DL_TTC], [DE_No], [cbDE_No], [DL_NoRef], [DL_TypePL]" .
            "    , [DL_PUDevise], [DL_PUTTC], [DL_No], [DO_DateLivr], [CA_Num], [DL_Taxe3], [DL_TypeTaux3], [DL_TypeTaxe3]" .
            "    , [DL_Frais], [DL_Valorise], [AR_RefCompose], [DL_NonLivre], [AC_RefClient], [DL_MontantHT], [DL_MontantTTC], [DL_FactPoids]" .
            "    , [DL_Escompte], [DL_PiecePL], [DL_DatePL], [DL_QtePL], [DL_NoColis], [DL_NoLink], [cbDL_NoLink], [RP_Code]" .
            "    , [DL_QteRessource], [DL_DateAvancement], [cbProt], [cbCreateur], [cbModification], [cbReplication], [cbFlag],[USERGESCOM],[DATEMODIF])" .
            "VALUES" .
            "    (/*DO_Domaine*/$do_domaine,/*DO_Type*/$do_type,/*CT_Num*/'" . $ct_num . "',/*DO_Piece*/'" . $do_piece . "'" .
            "    ,/*DL_PieceBC*/'',/*DL_PieceBL*/'',/*DO_Date*/'" . $do_date . "',/*DL_DateBC*/'1900-01-01'" .
            "    ,/*DL_DateBL*/'" . $do_date . "',/*DL_Ligne*/ (SELECT (1+COUNT(*))*10000 FROM F_DOCLIGNE WHERE DO_PIECE='" . $do_piece . "' AND DO_Domaine=$do_domaine AND DO_Type=$do_type),/*DO_Ref*/'" . $do_ref . "',/*DL_TNomencl*/0" .
            "    ,/*DL_TRemPied*/0,/*DL_TRemExep*/0,/*AR_Ref*/'" . $ar_ref . "',/*DL_Design*/'" . $ar_design . "'" .
            "   ,/*DL_Qte*/" . $dl_qte . ",/*DL_QteBC*/" . $dl_qte . ",/*DL_QteBL*/0,/*DL_PoidsNet*/0" .
            "    ,/*DL_PoidsBrut*/0,/*DL_Remise01REM_Valeur*/0" .
            "    ,/*DL_Remise01REM_Type*/0,/*DL_Remise02REM_Valeur*/0" .
            "    ,/*DL_Remise02REM_Type*/0,/*DL_Remise03REM_Valeur*/0" .
            "   ,/*DL_Remise03REM_Type*/0,/*DL_PrixUnitaire*/" . $ar_prixach .
            "    ,/*DL_PUBC*/0,/*DL_Taxe1*/0,/*DL_TypeTaux1*/0,/*DL_TypeTaxe1*/0,/*DL_Taxe2*/0,/*DL_TypeTaux2*/0" .
            "    ,/*DL_TypeTaxe2*/0,/*CO_No*/0,/*cbCO_No*/NULL,/*AG_No1*/0" .
            "    ,/*AG_No2*/0,/*DL_PrixRU*/$ar_prixach,/*DL_CMUP*/$ar_prixach,/*DL_MvtStock*/'$mvtstock'" .
            "    ,/*DT_No*/0,/*cbDT_No*/NULL,/*AF_RefFourniss*/''" .
            "    ,/*EU_Enumere*/'$u_intitule',/*EU_Qte*/$dl_qte,/*DL_TTC*/0,/*DE_No*/'$de_no',/*cbDE_No*/'" . $de_no . "',/*DL_NoRef*/''" .
            "    ,/*DL_TypePL*/0,/*DL_PUDevise*/0" .
            "    ,/*DL_PUTTC*/$ar_prixach,/*DL_No*/ISNULL((SELECT MAX(DL_No) FROM F_DOCLIGNE),0)+1,/*DO_DateLivr*/'1900-01-01',/*CA_Num*/''" .
            "    ,/*DL_Taxe3*/0,/*DL_TypeTaux3*/0,/*DL_TypeTaxe3*/0," .
            "   /*DL_Frais*/0,/*DL_Valorise*/1,/*AR_RefCompose*/NULL" .
            "    ,/*DL_NonLivre*/0,/*AC_RefClient*/'',/*DL_MontantHT*/" . $montantht . ",/*DL_MontantTTC*/" . $montantht .
            "    ,/*DL_FactPoids*/0,/*DL_Escompte*/0,/*DL_PiecePL*/'',/*DL_DatePL*/'1900-01-01'" .
            "    ,/*DL_QtePL*/0,/*DL_NoColis*/'',/*DL_NoLink*/0,/*cbDL_NoLink*/NULL" .
            "    ,/*RP_Code*/NULL,/*DL_QteRessource*/0,/*DL_DateAvancement*/'1900-01-01',/*cbProt*/0" .
            "    ,/*cbCreateur*/'AND',/*cbModification*/GETDATE()" .
            "    ,/*cbReplication*/0,/*cbFlag*/0,/*USERGESCOM*/'$login',/*DATEMODIF*/GETDATE());
          select @@IDENTITY as cbMarq;
          END";

        $result = $this->db->query($requete);
        return $result->fetchAll(PDO::FETCH_OBJ)[0]->cbMarq;
    }

    public function deleteConfirmationbyCbmarq($cbMarq)
    {
        $query = "DELETE FROM Z_LIGNE_CONFIRMATION WHERE cbMarq='$cbMarq'";
        $this->db->query($query);
    }

    public function initVariables()
    {
        $this->DL_PieceBC = '';
        $this->DL_PieceBL = '';
        $this->DL_DateBC = '1900-01-01';
        $this->DL_TNomencl = 0;
        $this->DL_TRemPied = 0;
        $this->DL_TRemExep = 0;
        $this->DL_QteBL = 0;
        $this->DL_PoidsNet = 0;
        $this->DL_PoidsBrut = 0;
        $this->DL_Remise01REM_Valeur = 0;
        $this->DL_Remise01REM_Type = 0;
        $this->DL_Remise02REM_Valeur = 0;
        $this->DL_Remise02REM_Type = 0;
        $this->DL_Remise03REM_Valeur = 0;
        $this->DL_Remise03REM_Type = 0;
        $this->DL_PUBC = 0;
        $this->DL_Taxe1 = 0;
        $this->DL_TypeTaux1 = 0;
        $this->DL_TypeTaxe1 = 0;
        $this->DL_Taxe2 = 0;
        $this->DL_TypeTaux2 = 0;
        $this->DL_TypeTaxe2 = 0;
        $this->CO_No = 0;
        $this->AG_No1 = 0;
        $this->AG_No2 = 0;
        $this->DT_No = 0;
        $this->AF_RefFourniss = '';
        $this->EU_Enumere = '';
        $this->DL_TTC = 0;
        $this->DL_NoRef = 1;
        $this->DL_TypePL = 0;
        $this->DL_PUDevise = 0;
        $this->DL_No = 0;
        $this->DO_DateLivr = '1900-01-01';
        $this->CA_Num = '';
        $this->DL_Taxe3 = 0;
        $this->DL_TypeTaux3 = 0;
        $this->DL_TypeTaxe3 = 0;
        $this->DL_Frais = 0;
        $this->DL_Valorise = 1;
        $this->DL_NonLivre = 0;
        $this->AC_RefClient = '';
        $this->DL_FactPoids = 0;
        $this->DL_Escompte = 0;
        $this->DL_PiecePL = '';
        $this->DL_DatePL = '1900-01-01';
        $this->DL_QtePL = 0;
        $this->DL_NoColis = '';
        $this->DL_NoLink = 0;
        $this->DL_QteRessource = 0;
        $this->DL_DateAvancement = '1900-01-01';
        $this->cbProt = 0;
        $this->cbReplication = 0;
        $this->cbFlag = 0;
    }

    public function maj_docLigne()
    {
        parent::maj("DL_PieceBC", $this->DL_PieceBC);
        parent::maj("DL_PieceBL", $this->DL_PieceBL);
        parent::maj("DO_Date", $this->DO_Date);
        parent::maj("DL_DateBC", $this->DL_DateBC);
        parent::maj("DL_DateBL", $this->DL_DateBL);
        parent::maj("DL_Ligne", $this->DL_Ligne);
        parent::maj("DO_Ref", $this->DO_Ref);
        parent::maj("DL_TNomencl", $this->DL_TNomencl);
        parent::maj("DL_TRemPied", $this->DL_TRemPied);
        parent::maj("DL_TRemExep", $this->DL_TRemExep);
        parent::maj("DL_Qte", $this->DL_Qte);
        parent::maj("DL_QteBC", $this->DL_QteBC);
        parent::maj("DL_QteBL", $this->DL_QteBL);
        parent::maj("DL_PoidsNet", $this->DL_PoidsNet);

        parent::maj("DL_PoidsBrut", $this->DL_PoidsBrut);
        parent::maj("DL_Remise01REM_Valeur", $this->DL_Remise01REM_Valeur);
        parent::maj("DL_Remise01REM_Type", $this->DL_Remise01REM_Type);
        parent::maj("DL_Remise02REM_Valeur", $this->DL_Remise02REM_Valeur);
        parent::maj("DL_Remise02REM_Type", $this->DL_Remise02REM_Type);
        parent::maj("DL_Remise03REM_Valeur", $this->DL_Remise03REM_Valeur);
        parent::maj("DL_Remise03REM_Type", $this->DL_Remise03REM_Type);
        parent::maj("DL_PrixUnitaire", $this->DL_PrixUnitaire);
        parent::maj("DL_PUBC", $this->DL_PUBC);
        parent::maj("DL_Taxe1", $this->DL_Taxe1);
        parent::maj("DL_TypeTaux1", $this->DL_TypeTaux1);
        parent::maj("DL_TypeTaxe1", $this->DL_TypeTaxe1);
        parent::maj("DL_Taxe2", $this->DL_Taxe2);
        parent::maj("DL_TypeTaux2", $this->DL_TypeTaux2);
        parent::maj("DL_TypeTaxe2", $this->DL_TypeTaxe2);
//        parent::maj("AG_No1", $this->AG_No1);
//        parent::maj("AG_No2", $this->AG_No2);
        parent::maj("DL_PrixRU", $this->DL_PrixRU);
        parent::maj("DL_CMUP", $this->DL_CMUP);
        parent::maj("DL_MvtStock", $this->DL_MvtStock);
        parent::maj("AF_RefFourniss", $this->AF_RefFourniss);
        parent::maj("EU_Enumere", $this->EU_Enumere);
        parent::maj("EU_Qte", $this->EU_Qte);
        parent::maj("DL_TTC", $this->DL_TTC);
        parent::maj("DL_NoRef", $this->DL_NoRef);
        parent::maj("DL_TypePL", $this->DL_TypePL);
        parent::maj("DL_PUDevise", $this->DL_PUDevise);
        parent::maj("DL_PUTTC", $this->DL_PUTTC);
        parent::maj("DL_No", $this->DL_No);
        parent::maj("DO_DateLivr", $this->DO_DateLivr);
        parent::maj("DL_Taxe3", $this->DL_Taxe3);
        parent::maj("DL_TypeTaux3", $this->DL_TypeTaux3);
        parent::maj("DL_TypeTaxe3", $this->DL_TypeTaxe3);
        parent::maj("DL_Frais", $this->DL_Frais);
        parent::maj("DL_Valorise", $this->DL_Valorise);
        parent::maj("AR_RefCompose", $this->AR_RefCompose);
        parent::maj("DL_NonLivre", $this->DL_NonLivre);
        parent::maj("AC_RefClient", $this->AC_RefClient);
        parent::maj("DL_MontantHT", $this->DL_MontantHT);
        parent::maj("DL_MontantTTC", $this->DL_MontantTTC);
        parent::maj("DL_FactPoids", $this->DL_FactPoids);
        parent::maj("DL_Escompte", $this->DL_Escompte);
        parent::maj("DL_PiecePL", $this->DL_PiecePL);
        parent::maj("DL_DatePL", $this->DL_DatePL);
        parent::maj("DL_QtePL", $this->DL_QtePL);
        parent::maj("DL_NoColis", $this->DL_NoColis);
        parent::maj("DL_NoLink", $this->DL_NoLink);
        //parent::maj("RP_Code", $this->RP_Code);

        parent::maj("DL_QteRessource", $this->DL_QteRessource);
        parent::maj("DL_DateAvancement", $this->DL_DateAvancement);
        parent::maj("cbCreateur", $this->userName);
        parent::majcbModification();
        $this->majUSERGESCOM();
    }

    public function majUSERGESCOM()
    {
        $query = "UPDATE F_DOCLIGNE SET USERGESCOM=(SELECT PROT_User FROM F_PROTECTIONCIAL WHERE PROT_No={$this->userName})
                WHERE cbMarq ={$this->cbMarq}";
        $this->db->query($query);

    }

    public function getcbMarqEntete()
    {
        return $this->getApiString("/getCbMarqEntete&cbMarq={$this->cbMarq}");
    }

    public function addDocligneTransfertDetailProcess($qte, $prix, $qteDest, $prixDest, $cbMarq, $cbMarqEntete, $protNo,$acte,$arRef,$arRefDest,$machineName)
    {
        return $this->getApiJson("/ajoutLigneTransfertDetail&qte=$qte&prix=$prix&qteDest=$qteDest&prixDest=$prixDest&cbMarq=$cbMarq&cbMarqEntete=$cbMarqEntete&protNo=$protNo&acte=$acte&arRef={$this->formatString($arRef)}&arRefDest={$this->formatString($arRefDest)}&machineName={$this->formatString($machineName)}");
    }

    public function ajout_ligneFacturation($qteG, $ARRefG, $cbMarqEntete, $typeFacG, $cattarifG, $prixG, $remiseG, $machinepcG, $acte,$protNo)
    {
        return $this->getApiString("/ajoutLigne&cbMarq={$this->cbMarq}&protNo=$protNo&dlQte={$this->formatAmount($qteG)}&arRef={$this->formatString($ARRefG)}&cbMarqEntete=$cbMarqEntete&typeFacture=$typeFacG&catTarif=$cattarifG&dlPrix={$this->formatAmount($prixG)}&dlRemise={$this->formatString($remiseG)}&machineName={$this->formatString($machinepcG)}&acte=$acte&entete_prev=");
    }

    public function supprTransfertDetail($cbMarq,$cbMarqSec)
    {
        $this->getApiExecute("/supprTransfertDetail&cbMarq=$cbMarq&cbMarqSec=$cbMarqSec");
    }
    public function logStock($action, $ref_article, $deNoG,$protNo)
    {
        $article = new ArticleClass($ref_article, $this->db);
        $row = $article->isStock($deNoG);
        if ($row != null) {
            $log = new LogFile();
            $log->user = $protNo;
            $log->writeStock($action, $ref_article, $deNoG, $row[0]->AS_QteSto, $row[0]->AS_MontSto);
        }
    }

    public function logMvt($action, $cbMarqEntete, $DE_No, $AR_Ref, $Qte, $Prix, $Remise, $Montant,$protNo)
    {
        $log = new LogFile();
        $log->user = $protNo;
        $docEntete = new DocEnteteClass($cbMarqEntete);
        $log->writeFacture($action, $docEntete->DO_Type, $docEntete->DO_Piece, $DE_No, $docEntete->DO_Domaine, $AR_Ref, $Qte, $Prix, $Remise, $Montant);
    }

    public function supprLigneFacture($cbMarq,$cbMarqSec,$typeFacture,$protNo){
        $this->getApiExecute("/supprLigneFacture&cbMarq=$cbMarq&cbMarqSec=$cbMarqSec&typeFacture=$typeFacture&protNo=$protNo");
    }

    public function addDocligneEntreeMagasinProcess($AR_Ref, $cbMarqEntete, $DL_Qte, $MvtStock, $mvtEntree, $prix, $type_fac, $machine, $protNo)
    {
        return $this->ajout_ligneFacturation($DL_Qte,$AR_Ref,$cbMarqEntete,$type_fac,0,$prix,"",$machine,"ajout_ligne",$protNo);
    }

    public function addDocligneSortieMagasinProcess($AR_Ref, $cbMarqEntete, $DL_Qte, $typefac, $machine, $protNo)
    {
        return $this->ajout_ligneFacturation($DL_Qte,$AR_Ref,$cbMarqEntete,$typefac,0,0,"",$machine,"ajout_ligne",$protNo);
    }

    public function ajoutLigneTransfert($qte,$prix,$typeFacture,$cbMarq,$cbMarqEntete,$protNo,$acte,$arRef,$machineName){
        return $this->getApiJson("/ajoutLigneTransfert&qte=$qte&prix=$prix&typeFacture=$typeFacture&cbMarq=$cbMarq&cbMarqEntete=$cbMarqEntete&protNo=$protNo&acte=$acte&arRef={$this->formatString($arRef)}&machineName={$this->formatString($machineName)}");
    }

    public function addDocligneTransfertProcess($AR_Ref, $prix, $DL_Qte, $MvtStock, $machine, $cbMarqEntete, $protNo, $cbFirst)
    {
        $docEntete = new DocEnteteClass($cbMarqEntete, $this->db);
        $CT_Num = $docEntete->DO_Tiers;
        $DE_No = $docEntete->DE_No;
        $U_Intitule = "";
        $article = new ArticleClass($AR_Ref, $this->db);
        $AR_PrixAch = $prix;
        $AR_Design = str_replace("'", "''", $article->AR_Design);
        $AR_UniteVen = $article->AR_UniteVen;
        if ($AR_PrixAch == "") $AR_PrixAch = 0;
        $montantHT = round(($AR_PrixAch) * $DL_Qte, 2);
        $result = $this->db->requete($this->objetCollection->getUnite($AR_UniteVen));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $U_Intitule = $rows[0]->U_Intitule;
        }

        if ($MvtStock == 1)
            $DE_No = $docEntete->DO_Tiers;
        else {
            $isStock = $article->isStock($docEntete->DE_No);
            $AR_PrixAch = $isStock[0]->AS_MontSto / $isStock[0]->AS_QteSto;
        }

        $DO_Date = $docEntete->getDO_DateC();
        $this->initVariables();
        $this->DL_MvtStock = $MvtStock;
        $this->DO_Domaine = $docEntete->DO_Domaine;
        $this->DO_Type = $docEntete->DO_Type;
        $this->CT_Num = $CT_Num;
        $this->DO_Piece = $docEntete->DO_Piece;
        $this->DO_Date = $DO_Date;
        $this->DO_Ref = $docEntete->DO_Ref;
        $this->AR_Ref = $AR_Ref;
        $this->DL_Design = $AR_Design;
        $this->DL_Qte = $DL_Qte;
        $this->DL_QteBC = $DL_Qte;
        $this->EU_Qte = $DL_Qte;
        $this->DL_Remise01REM_Valeur = 0;
        $this->DL_PrixUnitaire = round($AR_PrixAch, 2);
        $this->DL_Taxe1 = 0;
        $this->DL_Taxe2 = 0;
        $this->DL_Taxe3 = 0;
        $this->CO_No = 0;
        $this->DL_PrixRU = round($AR_PrixAch, 2);
        $this->EU_Enumere = $U_Intitule;
        $this->DE_No = $DE_No;
        $this->DL_PUTTC = round($AR_PrixAch, 2);
        $this->CA_Num = $docEntete->CA_Num;
        $this->DL_MontantHT = $montantHT;
        $this->DL_MontantTTC = $montantHT;
        $this->DL_Remise01REM_Type = 0;
        $this->DL_QtePL = 0;
        $this->DL_QteBL = 0;
        $this->DL_TypePL = 0;
        $this->DL_TTC = 0;
        $this->DL_TypeTaux1 = 0;
        $this->DL_TypeTaux2 = 0;
        $this->DL_TypeTaux3 = 0;
        $this->DL_TypeTaxe1 = 0;
        $this->DL_TypeTaxe2 = 0;
        $this->DL_TypeTaxe3 = 0;
        $this->DL_PieceBL = '';
        $this->DL_DateBC = '1900-01-01';
        $this->DL_DateBL = $DO_Date;
        $this->DL_CMUP = round($AR_PrixAch, 2);
        $this->DL_DatePL = '1900-01-01';
        $this->MACHINEPC = $machine;
        $this->userName = $protNo;
        $cbmarqligne = $this->insertDocligneMagasin();
        $this->logMvt("ajout_ligne", $cbMarqEntete, $docEntete->DE_No, $AR_Ref, $DL_Qte, $this->DL_PrixUnitaire, 0, $this->DL_MontantTTC,$protNo);

        $DE_No = $docEntete->DO_Tiers;
        if ($MvtStock == 3) $DE_No = $docEntete->DE_No;
        $article = new ArticleClass($AR_Ref, $this->db);
        $isStock = $article->isStock($DE_No);
        $isStockRepart = $article->isStock($docEntete->DE_No);
        if ($MvtStock == 1) {
            $qteTransfert = $DL_Qte;
            $montantTransfert = round($AR_PrixAch, 2) * $DL_Qte;
            $this->logStock("ajout_ligne", $AR_Ref, $DE_No,$protNo);
            if ($isStock == null)
                $article->insertF_ArtStock($DE_No, $montantTransfert, $qteTransfert);
            else
                $article->updateArtStock($DE_No, $qteTransfert, $montantTransfert,"ajout_ligne",$protNo);
            $this->logStock("ajout_ligne", $AR_Ref, $DE_No,$protNo);
        } else {
            $prixSource = $isStockRepart[0]->AS_MontSto;
            $qteSource = $isStockRepart[0]->AS_QteSto;
            $value = round($prixSource / $qteSource, 2);
            $qteTransfert = -$DL_Qte;
            $montantTransfert = $value * -$DL_Qte;
            $this->logStock("ajout_ligne", $AR_Ref, $DE_No,$protNo);
            $article->updateArtStock($DE_No, $qteTransfert, $montantTransfert,"ajout_ligne",$protNo);
            $this->logStock("ajout_ligne", $AR_Ref, $DE_No,$protNo);
        }
        return new DocLigneClass($cbmarqligne, $this->db);
    }

    public function modifiePrix($AR_Ref, $AR_Design, $pxAch, $pxVen, $prix, $pxMin, $DO_Piece, $user)
    {
        $textMail = "";
        $textSms = "";
        $titreMail = "";
        if ($prix < $pxAch) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix d'achat " . $this->objetCollection->formatChiffre($pxAch) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $textSms = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix d'achat " . $this->objetCollection->formatChiffre($pxAch) . "."
                . "Le document a été saisie par $user.";
            $titreMail = "Prix de revient inférieur au prix d'achat";
        }
        /*if($prix<$pxVen) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix de vente " . $this->objetCollection->formatChiffre($pxVen) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $titreMail="Prix de revient inférieur au prix de vente";
        }*/
        if ($prix < $pxMin) {
            $textMail = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix minimum " . $this->objetCollection->formatChiffre($pxMin) . ".<br/>
                          Le document a été saisie par $user.<br/><br/>
                                                Cordialement.<br/><br/>";
            $textSms = "Le prix de l'article $AR_Ref - $AR_Design " . $this->objetCollection->formatChiffre($prix) . " lié à la facture $DO_Piece est inférieur au prix minimum " . $this->objetCollection->formatChiffre($pxAch) . "."
                . "Le document a été saisie par $user.";
            $titreMail = "Prix de revient inférieur au prix minimum";
        }

        if ($textMail != "") {
            $result = $this->db->requete($this->getCollaborateurEnvoiMail("Prix modifié"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $email = $row->CO_EMail;
                    if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                        $this->objetCollection->envoiMailComplete($textMail, $titreMail, $email);
                    }
                }
            }
            $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiSMS("Prix modifié"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $telephone = $row->CO_Telephone;
                    if (($telephone != "" || $telephone != null)) {
                        $contactD = new ContatDClass(1);
                        $contactD->sendSms($telephone, $textSms);
                    }
                }
            }
        }
    }


    public function getCollaborateurEnvoiMail($intitule, $depot = 0)
    {
        return "SELECT CO_No,CO_Nom,CO_Prenom,CO_EMail,CO_Telephone,PROT_User
                FROM [Z_LiaisonEnvoiMailUser] A
                INNER JOIN F_PROTECTIONCIAL B ON A.PROT_No=B.PROT_No
                INNER JOIN F_COLLABORATEUR C ON C.CO_Nom=B.PROT_User
                INNER JOIN [dbo].[Z_TypeEnvoiMail] D ON D.TE_No=A.TE_No
                WHERE ((TE_Intitule ='$intitule' AND TE_Intitule <>'Prix modifié') OR ('$intitule' ='Prix modifié' AND EXISTS (SELECT DE_No 
																					FROM Z_DEPOTUSER B 
																					WHERE A.Prot_No=B.Prot_No AND DE_No=$depot))) 
                GROUP BY CO_No,CO_Nom,CO_Prenom,CO_EMail,CO_Telephone,PROT_User";
    }

    public function commandeStock($DE_No, $AR_Ref, $AR_Design)
    {
        $AS_QteMini = 0;
        $AS_QteMaxi = 0;
        $this->alerteCumulStock();
        $result = $this->db->requete($this->objetCollection->isStock($DE_No, $AR_Ref));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            $AS_QteSto = $rows[0]->AS_QteSto;
            $AS_QteMini = $rows[0]->AS_QteMini;
            $AS_QteMaxi = $rows[0]->AS_QteMaxi;
            $qteCommande = $AS_QteMaxi - $AS_QteSto;
            if ($AS_QteMini != 0 && $AS_QteMaxi != 0) {
                if ($AS_QteSto <= $AS_QteMini) {
                    $result = $this->db->requete($this->getCollaborateurEnvoiMail("Stock épuisé", $DE_No));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            $email = $row->CO_EMail;
                            if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                                //
                                $nom = $row->CO_Prenom . " " . $row->CO_Nom;
                                $corpsMail = "Le stock de l'article $AR_Ref - $AR_Design est en dessous de la limite (" . $this->objetCollection->formatChiffre($AS_QteSto) . ")
                                                              La commande de " . $this->objetCollection->formatChiffre($qteCommande) . " pièces doit être passé.<br/><br/>
                                                Cordialement.<br/><br/>";
                                $this->objetCollection->envoiMailComplete($corpsMail, "Stock de l'article $AR_Ref", $email);
                            }
                        }
                    }

                    $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiSMS("Stock épuisé"));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            $telephone = $row->CO_Telephone;
                            if (($telephone != "" || $telephone != null)) {
                                $contactD = new ContatDClass(1);
                                $textSms = "Le stock de l'article $AR_Ref - $AR_Design est en dessous de la limite (" . $this->objetCollection->formatChiffre($AS_QteSto) . ")
                                                              . La commande de " . $this->objetCollection->formatChiffre($qteCommande) . " pièces doit être passé.";
                                $contactD->sendSms($telephone, $textSms);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getZLigneConfirmation($cbMarq){
        $query = "SELECT *
                    FROM Z_LIGNE_CONFIRMATION
                    WHERE cbMarq=$cbMarq";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0];
    }

    public function majQteZLigneConfirmation($cbMarq,$qte){
        $query = "UPDATE Z_LIGNE_CONFIRMATION SET DL_Qte=$qte 
                    WHERE cbMarq=$cbMarq";
        $this->db->query($query);
    }

    public function alerteCumulStock(){
        $result = $this->db->requete($this->objetCollection->cumulStock());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $tableHtml="<table style='border-collapse:collapse;'>
                        <thead> <th style='border:1px solid black;'>Dépot</th>
                                <th style='border:1px solid black;'>Article</th>
                                <th style='border:1px solid black;'>Stock</th>
                                <th style='border:1px solid black;'>Qté min</th>
                                <th style='border:1px solid black;'>Qté à commander</th>
                        </thead><tbody>";
        if ($rows != null) {
            $alerte = $rows[0]->Alerte;
            if($alerte<0){

                $result = $this->db->requete($this->objetCollection->cumulStockDetail());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows != null) {
                    foreach ($rows as $row) {
                        $tableHtml = $tableHtml."<tr>
                                                    <td style='text-align:center;border:1px solid black;'>".$row->DE_Intitule."</td>
                                                    <td style='text-align:center;border:1px solid black;'>".$row->AR_Design."</td>
                                                    <td style='text-align:center;border:1px solid black;'>".$this->objetCollection->formatChiffre($row->AS_QteSto)."</td>
                                                    <td style='text-align:center;border:1px solid black;'>".$this->objetCollection->formatChiffre($row->AS_QteMini)."</td>
                                                    <td style='text-align:center;border:1px solid black;'>".$this->objetCollection->formatChiffre($row->QteACommander)."</td>
                                                </tr>";
                    }
                    $tableHtml = $tableHtml."</tbody>";
                }
                $tableHtml = $tableHtml."</table>";
                $result = $this->db->requete($this->getCollaborateurEnvoiMail("Stock cumul"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                            $nom = $row->CO_Prenom . " " . $row->CO_Nom;
                            $corpsMail = "Le stock de l'ensemble des articles des dépôts est en dessous de la limite.
                                            Retrouvez ci dessous la liste des articles dont le stock est en dessous du stock minimum<br/><br/>
                                                              $tableHtml <br/><br/>
                                                              
                                                Cordialement.<br/><br/>";
                            $this->objetCollection->envoiMailComplete($corpsMail, "Stock Cumulé", $email);
                        }
                    }
                }
            }
        }
    }

    public function  getPrixClientHT($ar_ref, $catcompta, $cattarif, $prix,$rem,$qte,$fournisseur) {
        return $this->getApiJson("/getPrixClientHT&arRef={$this->formatString($ar_ref)}&catCompta=$catcompta&catTarif=$cattarif&prix=$prix&rem=$rem&qte=$qte&fournisseur=$fournisseur");
    }

    public function  getPrixClientAch($ar_ref, $catcompta, $cattarif,$ct_num="") {
        return $this->getApiJson("/getPrixClientAch&arRef={$this->formatString($ar_ref)}&catCompta=$catcompta&catTarif=$cattarif&ctNum={$this->formatString($ct_num)}");
    }

    public function __toString() {
        return "";
    }


}