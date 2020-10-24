<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ReglementClass Extends Objet{
    //put your code here
    public $db,$RG_No,$CT_NumPayeur,$cbCT_NumPayeur,$RG_Date
    ,$RG_Reference,$RG_Libelle,$RG_Montant,$RG_MontantDev
    ,$N_Reglement,$RG_Impute,$RG_Compta,$EC_No
    ,$cbEC_No,$RG_Type,$RG_Cours,$N_Devise
    ,$JO_Num,$CG_NumCont,$cbCG_NumCont,$RG_Impaye
    ,$CG_Num,$cbCG_Num,$RG_TypeReg,$RG_Heure
    ,$RG_Piece,$cbRG_Piece,$CA_No,$cbCA_No
    ,$CO_NoCaissier,$cbCO_NoCaissier,$RG_Banque,$RG_Transfere
    ,$RG_Cloture,$RG_Ticket,$RG_Souche,$CT_NumPayeurOrig
    ,$cbCT_NumPayeurOrig,$RG_DateEchCont,$CG_NumEcart,$cbCG_NumEcart
    ,$JO_NumEcart,$RG_MontantEcart,$RG_NoBonAchat,$cbProt
    ,$cbMarq,$cbCreateur,$cbModification,$cbReplication
    ,$cbFlag,$DO_Modif,$RG_DateSage;
    public $table = 'F_CREGLEMENT';
    public $lien ="fcreglement";

    function __construct($id)
    {
        $this->data = $this->getApiJson("/rgNo=$id");
        if($id!=0)
            if (sizeof($this->data) > 0) {
            $this->RG_No = $this->data[0]->RG_No;
            $this->CT_NumPayeur = $this->data[0]->CT_NumPayeur;
            $this->RG_Date = substr($this->data[0]->RG_Date,0,10);
            $this->RG_Reference = $this->data[0]->RG_Reference;
            $this->RG_Libelle = $this->data[0]->RG_Libelle;
            $this->RG_DateSage = $this->formatDateSage(substr($this->data[0]->RG_Date,0,10));
            $this->RG_Montant = $this->data[0]->RG_Montant;
            $this->RG_MontantDev = $this->data[0]->RG_MontantDev;
            $this->N_Reglement = $this->data[0]->N_Reglement;
            $this->RG_Impute = $this->data[0]->RG_Impute;
            $this->RG_Compta = $this->data[0]->RG_Compta;
            $this->EC_No = $this->data[0]->EC_No;
            $this->RG_Type = $this->data[0]->RG_Type;
            $this->RG_Cours = $this->data[0]->RG_Cours;
            $this->N_Devise = $this->data[0]->N_Devise;
            $this->JO_Num = $this->data[0]->JO_Num;
            $this->CG_NumCont = $this->data[0]->CG_NumCont;
            $this->RG_Impaye = $this->data[0]->RG_Impaye;
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->RG_TypeReg = $this->data[0]->RG_TypeReg;
            $this->RG_Heure = $this->data[0]->RG_Heure;
            $this->RG_Piece = $this->data[0]->RG_Piece;
            $this->CA_No = $this->data[0]->CA_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->RG_Banque = $this->data[0]->RG_Banque;
            $this->RG_Transfere = $this->data[0]->RG_Transfere;
            $this->RG_Cloture = $this->data[0]->RG_Cloture;
            $this->RG_Ticket = $this->data[0]->RG_Ticket;
            $this->RG_Souche = $this->data[0]->RG_Souche;
            $this->CT_NumPayeurOrig = $this->data[0]->CT_NumPayeurOrig;
            $this->RG_DateEchCont = $this->data[0]->RG_DateEchCont;
            $this->CG_NumEcart = $this->data[0]->CG_NumEcart;
            $this->JO_NumEcart = $this->data[0]->JO_NumEcart;
            $this->RG_MontantEcart = $this->data[0]->RG_MontantEcart;
            $this->RG_NoBonAchat = $this->data[0]->RG_NoBonAchat;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->setDO_Modif();
        }
    }

    public function getReglementByClientFacture($cbMarq) {
        return $this->getApiJson("/getReglementByClientFacture&cbMarq=$cbMarq");
    }

    public function regle($cbMarq,$typeFacture,$protNo,$valideRegle,$valideRegltImprime,$mttAvance,$montantTotal,$modeReglement,$dateRglt,$libRglt){
        $this->getApiString("/regle&cbMarq=$cbMarq&typeFacture=$typeFacture&protNo=$protNo&valideRegle=$valideRegle&valideRegltImprime=$valideRegltImprime&mttAvance={$this->formatAmount($mttAvance)}&montantTotal={$this->formatAmount($montantTotal)}&modeReglement=$modeReglement&dateRglt=$dateRglt&libRglt={$this->formatString($libRglt)}");
    }

    public function formatDateSage($val){
        $date = DateTime::createFromFormat('Y-m-d', $val);
        return $date->format('dmy');
    }

    public function updateImpute(){
        $this->getApiExecute("/updateImpute&rgNo={$this->RG_No}");
    }

    public function getMajAnalytique($dateDeb,$dateFin,$statut,$caNum=''){		
		return $this->getApiJson("/getMajAnalytique&dateDeb=$dateDeb&dateFin=$dateFin&caNum=$caNum&statut=$statut");
    }

    public function setMajAnalytique($datedeb,$datefin,$caNum){
		return $this->getApiJson("/setMajAnalytique&dateDeb=$datedeb&dateFin=$datefin&caNum=$caNum&cbCreateur={$this->userName}");
    }

    public function majReglement($protNo,$bonCaisse,$rgNo,$rgLibelle,$montant,$rgDate,$joNum,$ctNum,$coNo){
        $this->getApiExecute("/modifReglementTiers&protNo=$protNo&coNo=$coNo&bonCaisse=$bonCaisse&rgNo=$rgNo&rgLibelle={$this->formatString($rgLibelle)}&montant=$montant&rgDate=$rgDate&joNum={$this->formatString($joNum)}&ctNum={$this->formatString($ctNum)}");
    }

    public function addEcheance($protNo,$rgNo,$typeRegl,$cbMarqEntete,$montant){
        $this->getApiExecute("/addEcheance&protNo=$protNo&rgNo=$rgNo&typeRegl=$typeRegl&cbMarqEntete=$cbMarqEntete&montant=$montant");
    }

    public function insertMvtCaisse($rgMontant,$protNo,$caNum,$libelle,$rgTypeReg,$caNo,$cgNumBanque,$isModif,$rgDate,$joNum,$caNoDest,$cgAnalytique,$rgTyperegModif,$journalRec,$rgNoDest){
        $this->getApiExecute("/insertMvtCaisse&rgMontant=$rgMontant&protNo=$protNo&caNum=$caNum&libelle={$this->formatString($libelle)}&rgTypeReg=$rgTypeReg&caNo=$caNo&cgNumBanque=$cgNumBanque&isModif=$isModif&rgDate=$rgDate&joNum=$joNum&caNoDest=$caNoDest&cgAnalytique=$cgAnalytique&rgTyperegModif=$rgTyperegModif&journalRec=$journalRec&rgNoDest=$rgNoDest");
    }

    public function  insertF_Reglement(){
        $requete = "BEGIN 
                SET NOCOUNT ON;
				DECLARE @CT_NumPayeur AS VARCHAR(50) = ?
						,@RG_Libelle AS VARCHAR(150) = ? 
						,@RG_Date AS VARCHAR(150) = ? 
						,@RG_Reference AS VARCHAR(150) = ? 
						,@RG_Libelle AS VARCHAR(150) = ? 
						,@RG_Montant AS VARCHAR(150) = ? 
						,@RG_MontantDev AS VARCHAR(150) = ? 
						,@RG_Impute AS INT = ? 
						,@RG_Compta AS INT = ? 
						,@EC_No AS INT = ? 
						,@N_Devise AS INT = ? 
						,@JO_Num AS VARCHAR(150) = ? 
						,@CG_NumCount AS VARCHAR(150) = ? 
						,@CG_Impaye AS INT = ? 
						,@CG_Num AS VARCHAR(150) = ? 
						,@RG_TypeReg AS INT = ? 
						,@RG_Heure AS VARCHAR(150) = ? 
						,@RG_Piece AS VARCHAR(150) = ? 
						,@CA_No AS INT = ? 
						,@RG_Banque AS INT = ? 
						,@RG_Transfere AS INT = ? 
						,@RG_Cloture AS INT = ? 
						,@RG_Ticket AS INT = ? 
						,@RG_Souche AS VARCHAR(150) = ? 
						,@CT_NumPayeurOrig AS VARCHAR(150) = ? 
						,@RG_DateEchCont AS VARCHAR(150) = ? 
						,@CG_NumEcart AS VARCHAR(150) = ? 
						,@JO_NumEcart AS VARCHAR(150) = ? 
						,@RG_MontantEcart AS VARCHAR(150) = ? 
						,@RG_NoBonAchat AS VARCHAR(150) = ? 
						,@CG_NumEcart AS VARCHAR(150) = ? 
						,@cbCreateur AS VARCHAR(150) = ? 
						
                IF NOT EXISTS ( SELECT 1 
                                FROM F_CREGLEMENT 
                                WHERE RG_Libelle = @RG_Libelle 
                                AND RG_Date=@RG_Date 
                                AND RG_Montant=@RG_Montant 
                                AND RG_Type=@RG_Type 
                                AND RG_TypeReg = @RG_TypeReg
                                AND CA_No=@CA_No ) 
                INSERT INTO [dbo].[F_CREGLEMENT] 
                 ([RG_No],[CT_NumPayeur],[RG_Date],[RG_Reference] 
                 ,[RG_Libelle],[RG_Montant],[RG_MontantDev],[N_Reglement] 
                 ,[RG_Impute],[RG_Compta],[EC_No] 
                 ,[RG_Type],[RG_Cours],[N_Devise],[JO_Num] 
                 ,[CG_NumCont],[RG_Impaye],[CG_Num],[RG_TypeReg] 
                 ,[RG_Heure],[RG_Piece],[CA_No] 
                 ,[CO_NoCaissier],[RG_Banque],[RG_Transfere] 
                 ,[RG_Cloture],[RG_Ticket],[RG_Souche],[CT_NumPayeurOrig] 
                 ,[RG_DateEchCont],[CG_NumEcart],[JO_NumEcart],[RG_MontantEcart] 
                 ,[RG_NoBonAchat],[cbProt],[cbCreateur],[cbModification] 
                 ,[cbReplication],[cbFlag]) 
                 VALUES 
                (/*RG_No*/ISNULL((SELECT MAX(RG_No)+1 FROM F_CREGLEMENT),0),/*CT_NumPayeur*/
                    (CASE WHEN @CT_NumPayeur ='' THEN '' 
                        WHEN @CT_NumPayeur = 'NULL' THEN NULL ELSE @CT_NumPayeur END)
                    ,/*RG_Date*/@RG_Date,/*RG_Reference*/@RG_Reference 
                   ,/*RG_Libelle*/@RG_Libelle,/*RG_Montant*/ @RG_Montant
                   ,/*RG_MontantDev*/@RG_MontantDev,/*N_Reglement*/@N_Reglement
                   ,/*RG_Impute*/@RG_Impute,/*RG_Compta*/@RG_Compta
                   ,/*EC_No*/@EC_No,/*RG_Type*/@RG_Type,/*RG_Cours*/@RG_Cours
                   ,/*N_Devise*/@N_Devise,/*JO_Num*/@JO_Num
                   ,/*CG_NumCont*/(CASE WHEN @CG_NumCont ='' OR @CG_NumCont = 'NULL' THEN NULL ELSE @CG_NumCont END)
                    ,/*RG_Impaye*/@RG_Impaye
                   ,/*CG_Num*/(CASE WHEN @CG_Num ='' OR @CG_Num = 'NULL' THEN NULL ELSE @CG_Num END),/*RG_TypeReg*/ @RG_TypeReg,
                /*RG_Heure, char(9),*/(SELECT '000' + CAST(DATEPART(HOUR, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(MINUTE, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(SECOND, GETDATE()) as VARCHAR(2))),
                /*RG_Piece*/(CASE WHEN @RG_TypeReg=2 THEN '' ELSE 
                (SELECT(ISNULL((SELECT TOP 1 CR_Numero01 AS valeur FROM P_COLREGLEMENT ORDER BY cbMarq DESC),1)) as VAL) END)
               ,/*CA_No*/(SELECT CASE WHEN @CA_No=0 THEN NULL ELSE @CA_No END)
               ,/*CO_NoCaissier*/(SELECT CASE WHEN @CO_NoCaissier =0 THEN NULL ELSE @CO_NoCaissier END)
               ,/*RG_Banque*/@RG_Banque,/*RG_Transfere*/@RG_Transfere 
               ,/*RG_Cloture*/@RG_Cloture,/*RG_Ticket*/@RG_Ticket
               ,/*RG_Souche*/@RG_Souche,/*CT_NumPayeurOrig*/(CASE WHEN @CT_NumPayeurOrig ='' THEN '' 
                    WHEN @CT_NumPayeurOrig = 'NULL' THEN NULL ELSE @CT_NumPayeurOrig END)
                ,/*RG_DateEchCont*/@RG_DateEchCont,/*CG_NumEcart*/
                (CASE WHEN @CG_NumEcart ='' OR @CG_NumEcart = 'NULL' THEN NULL ELSE @CG_NumEcart END),/*JO_NumEcart*/
                (CASE WHEN @JO_NumEcart ='' THEN '' 
                    WHEN @JO_NumEcart = 'NULL' THEN NULL ELSE @JO_NumEcart END),/*RG_MontantEcart*/@RG_MontantEcart
               ,/*RG_NoBonAchat*/@RG_NoBonAchat,/*cbProt*/0,/*cbCreateur*/@userName,/*cbModification*/GETDATE()
               ,/*cbReplication*/@cbReplication,/*cbFlag*/0);";
        $result= $this->db->query($requete);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->RG_No;
    }

    public function setDO_Modif(){
		$this->DO_Modif=$this->getApiJson("/setDO_Modif&rgNo={$this->RG_No}");
    }

    function typeCaisse($val){
        if($val==5) return "Entrée";
        if($val==4) return "Sortie";
        if($val==2) return "Fond de caisse";
        if($val==16) return "Transfert caisse";
        if($val==6) return "Vrst bancaire";
    }

public function afficheMvtCaisse($rows,$flagAffichageValCaisse,$flagCtrlTtCaisse){
        $i=0;
        $classe="";
        $sommeMnt = 0;
        if($rows==null){
            echo "<tr id='reglement_' class='reglement'><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $rg_banque = $row->RG_Banque;
                $rg_type = $row->RG_Type;
                $rg_typereg = $row->RG_TypeReg;
                if($rg_typereg==4){
                    if($rg_banque==1 && $rg_type==4)
                        $rg_typereg = 3;
                }
                if($rg_typereg==4){
                    if($rg_banque==1 && $rg_type==2)
                        $rg_typereg = 6;
                }
                $i++;
                $fichier="";
                if($row->Lien_Fichier!=null)
                    $fichier="<a target='_blank' class='fa fa-download' href='upload/files/{$row->Lien_Fichier}'></a>";
                $montant = round($row->RG_Montant);
                if($row->RG_TypeReg==3 || $row->RG_TypeReg==4)
                    $montant =$montant*-1;
                if($i%2==0) $classe = "info";
                else $classe="";
                echo "<tr class='reglement $classe' id='reglement_{$row->RG_No}'>
                                                <td style='color:blue;text-decoration:underline' id='RG_No'>{$row->RG_No}</a></td>
                                                <td id='RG_Piece'>{$row->RG_Piece}</td>
                                                <td id='RG_Date'>{$this->formatDateAffichage($row->RG_Date)}</td>
                                                <td id='RG_Libelle'>{$row->RG_Libelle}</td>
                                                <td id='RG_Montant'>{$this->formatChiffre($montant)}</td>
                                                <td style='display:none' id='RG_MontantHide'>$montant</td>
                                                <td style='display:none' id='CA_No'>{$row->CA_No}</td>
                                                <td style='display:none' id='CA_No_DestLigne'>{$row->CA_No_Dest}</td>
                                                <td style='display:none' id='RG_No_Source'>{$row->RG_No_Source}</td>
                                                <td style='display:none' id='RG_No_Dest'>{$row->RG_No_Dest}</td>
                                                <td style='display:none' id='JO_NumLigne'>{$row->JO_Num}</td>
                                                <td id='CA_Intitule'>{$row->CA_Intitule}</td>
                                                <td id='CO_Nom'><span id='RG_No' style='visibility:hidden'>{$row->RG_No}</span>{$row->CO_Nom}</td>
                                                    <td id='RG_TypeReg'>{$this->typeCaisse($rg_typereg)}</td>
                                                <td style='display:none' id='RG_TypeRegLigne'>$rg_typereg</td>";

                if($flagAffichageValCaisse==0) echo "<td id='RG_Modif'><i class='fa fa-pencil fa-fw'></i></td>";
                if($flagCtrlTtCaisse==0) echo "<td id='RG_Suppr'><i class='fa fa-trash-o'></i></td>";
                if($rg_banque==1 && $rg_type==4)
                    echo "<td>$fichier</td><td><input type='checkbox'  id='check_vrst' checked disabled/></td>";
                else
                    if($rg_typereg==3)
                        echo "<td>$fichier</td><td><input type='checkbox' id='check_vrst' disabled/></td>";
                    else "<td></td>";

                echo "<td style='display:none' id='CG_NumLigne'>{$row->CG_Num}</td>";
                echo "<td style='display:none' id='CG_NumIntituleLigne'>{$row->CG_Intitule}</td>";

                echo "<td style='display:none' id='CA_NumLigne'>{$row->CA_Num}</td>";
                echo "<td style='display:none' id='CA_NumIntituleLigne'>{$row->CA_IntituleText}</td>";

                echo "<td style='display:none' id='RG_DateLigne'>".date("dmy", strtotime($row->RG_Date))."</td>";
                echo "</tr>";
                $sommeMnt = $sommeMnt + $montant;
            }
            echo "<tr class='reglement' style='background-color:grey;color:white'><td id='rgltTotal'><b>Total</b></td><td></td><td></td><td></td><td><b>{$this->formatChiffre($sommeMnt)}</b></td><td></td><td></td><td></td><td></td><td></td></tr>";
        }
    }

    public function listeReglementCaisse($datedeb,$datefin,$ca_no,$type){
       return $this->getApiJson("/listeReglementCaisse&dateDeb=$datedeb&dateFin=$datefin&caNo=$ca_no&type=$type&protNo=".$_SESSION['id']);
    }

    public function initVariables(){
        $this->RG_Reference="";
        $this->RG_MontantDev=0;
        $this->RG_Compta=0;
        $this->EC_No=0;
        $this->cbEC_No=NULL;
        $this->RG_Cours=0;
        $this->N_Devise=0;
        $this->CG_NumCont=null;
        $this->RG_Impaye='1900-01-01';
        $this->RG_Transfere = 0;
        $this->RG_Cloture=0;
        $this->RG_Souche=0;
        $this->CG_NumEcart=NULL;
        $this->JO_NumEcart=NULL;
        $this->RG_MontantEcart=0;
        $this->RG_NoBonAchat=0;
        $this->cbProt=0;
        $this->cbCreateur='AND';
        $this->cbReplication=0;
        $this->cbFlag=0;
    }

    public function listeTypeReglement()
    {
        $this->lien = "preglement";
        return $this->getApiJson("/all");
    }

    function getModeleReglement() {
        $this->lien ="fmodeler";
        return $this->getApiJson("/all");
    }


    public function maj_reglement(){
        if($this->CT_NumPayeur=="") {
            parent::majNull('CT_NumPayeur');
            //    parent::majNull('cbCG_NumCont');
        }
        else {
            parent::maj('CT_NumPayeur', $this->CT_NumPayeur);
            //    parent::maj('cbCG_NumCont', $this->cbCG_NumCont);
        }
        parent::maj('RG_Date' , $this->RG_Date);
        parent::maj('RG_Reference' , $this->RG_Reference);
        parent::maj('RG_Libelle' , $this->RG_Libelle);
        parent::maj('RG_Montant' , $this->RG_Montant);
        parent::maj('RG_MontantDev' , $this->RG_MontantDev);
        parent::maj('N_Reglement' , $this->N_Reglement);
        parent::maj('RG_Impute' , $this->RG_Impute);
        parent::maj('RG_Compta' , $this->RG_Compta);
        parent::maj('EC_No' , $this->EC_No);
        parent::maj('cbEC_No' , $this->cbEC_No);
        parent::maj('RG_Type' , $this->RG_Type);
        parent::maj('RG_Cours' , $this->RG_Cours);
        parent::maj('N_Devise' , $this->N_Devise);
        parent::maj('JO_Num' , $this->JO_Num);
        if($this->CG_NumCont=="") {
            parent::majNull('CG_NumCont');
        //    parent::majNull('cbCG_NumCont');
        }
        else {
            parent::maj('CG_NumCont', $this->CG_NumCont);
        //    parent::maj('cbCG_NumCont', $this->cbCG_NumCont);
        }
        parent::maj('RG_Impaye' , $this->RG_Impaye);
        if($this->CG_Num=="") {
            parent::majNull('CG_Num');
        //    parent::majNull('cbCG_Num');
        }
        else {
            parent::maj('CG_Num', $this->CG_Num);
        //    parent::maj('cbCG_Num', $this->CG_Num);
        }
        parent::maj('RG_TypeReg' , $this->RG_TypeReg);
        parent::maj('RG_Heure' , $this->RG_Heure);
        parent::maj('RG_Piece' , $this->RG_Piece);
        parent::maj('CA_No' , $this->CA_No);
        parent::maj('cbCA_No' , $this->cbCA_No);
        parent::maj('CO_NoCaissier' , $this->CO_NoCaissier);
        parent::maj('cbCO_NoCaissier' , $this->cbCO_NoCaissier);
        parent::maj('RG_Banque' , $this->RG_Banque);
        parent::maj('RG_Transfere' , $this->RG_Transfere);
        parent::maj('RG_Cloture' , $this->RG_Cloture);
        parent::maj('RG_Ticket' , $this->RG_Ticket);
        parent::maj('RG_Souche' , $this->RG_Souche);
        if($this->CT_NumPayeurOrig=="") {
            parent::majNull('CT_NumPayeurOrig');
            //parent::maj('CT_NumPayeurOrig' , $this->CT_NumPayeurOrig);
        }
        else {
            parent::maj('CT_NumPayeurOrig', $this->CT_NumPayeurOrig);
            //        parent::maj('CT_NumPayeurOrig' , $this->CT_NumPayeurOrig);
        }
        parent::maj('RG_DateEchCont' , $this->RG_DateEchCont);
        if($this->CG_NumEcart=="") {
            parent::majNull('CG_NumEcart');
            //    parent::majNull('cbCG_NumCont');
        }
        else {
            parent::maj('CG_NumEcart' , $this->CG_NumEcart);
            //    parent::maj('cbCG_NumCont', $this->cbCG_NumCont);
        }
        parent::maj('JO_NumEcart' , $this->JO_NumEcart);
        parent::maj('RG_MontantEcart' , $this->RG_MontantEcart);
        parent::maj('RG_NoBonAchat' , $this->RG_NoBonAchat);
        parent::maj('cbProt' , $this->cbProt);
        parent::maj('cbCreateur' , $this->userName);
        parent::maj('cbModification' , $this->cbModification);
        parent::maj('cbReplication' , $this->cbReplication);
        parent::maj('cbFlag' , $this->cbFlag);
        $this->majcbModification();
    }

    public function majcbNull()
    {
        $requete = "INSERT INTO [dbo].[F_CREGLEMENT] WHERE RG_No=".$this->RG_No;
        $this->db->query($requete);

    }

    public function supprRgltAssocie()
    {
		$this->getApiJson("/supprRgltAssocie&rgNo={$this->RG_No}");
    }


    public function supprReglement()
    {
		$this->getApiJson("/supprReglement&rgNo={$this->RG_No}");
    }

    public function supprReglementTiers($mvtCaisse,$rgNo,$protNo){
        $this->getApiJson("/supprReglementTiers&mvtCaisse=$mvtCaisse&rgNo=$rgNo&protNo=$protNo");
    }

    public function remboursementRglt($date,$montant){
		$this->getApiExecute("/remboursementRglt/rgNo={$this->RG_No}&date=$date&montant=$montant");
    }

    public function getFactureRGNo($rg_no){
        return $this->getApiJson("/getFactureRGNo&rgNo=$rg_no");
    }

    public function insertZ_RGLT_BONDECAISSE($RG_No,$RG_NoLier){
        return $this->getApiJson("/insertZ_RGLT_BONDECAISSE&rgNo=$RG_No&rgNoLier=$RG_NoLier");
        $requete ="";
        $this->db->query($requete);
    }

    public function insertCaNum($rgNo,$caNum){
		$this->getApiJson("/insertCaNum&rgNo=$rgNo&caNum=$caNum");
    }
	
    public function insertF_ReglementVrstBancaire($rgNo,$rgNoCache){
		$this->getApiJson("/insertF_ReglementVrstBancaire&rgNo=$rgNo&rgNoCache=$rgNoCache");
    }

    public function deleteF_ReglementVrstBancaire($rgNo){
		$this->getApiJson("/deleteF_ReglementVrstBancaire&rgNo=$rgNo");
    }

    public function insertZ_REGLEMENT_ANALYTIQUE($RG_No, $CA_Num){
        $requete = "INSERT INTO Z_REGLEMENT_ANALYTIQUE(CA_Num,RG_No,cbModification,cbCreateur) VALUES ('$CA_Num',$RG_No,GETDATE(),'".$this->userName."')";
        $this->db->query($requete);
    }

    public function majZ_REGLEMENT_ANALYTIQUE($RG_No, $CA_Num){
        $requete = "UPDATE Z_REGLEMENT_ANALYTIQUE SET CA_Num='$CA_Num',cbModification=GETDATE(),cbCreateur='".$this->userName."' WHERE RG_No = $RG_No";
        $this->db->query($requete);
    }

    public function isImpute(){
        $query ="
                SELECT A.RG_No,RG_Montant-isnull(RC_Montant,0) as MontantImpute,
                CASE WHEN RG_Montant-isnull(RC_Montant,0) = 0 THEN 1 ELSE 0 END isImpute
                FROM F_CREGLEMENT A
                LEFT JOIN (
                SELECT A.RG_No,SUM(RC_Montant) AS RC_Montant
                FROM(	SELECT RG_No,sum(RC_Montant) AS RC_Montant 
                        FROM F_REGLECH
                        GROUP BY RG_No
                UNION
                SELECT A.RG_No,SUM(ISNULL(ABS(C.RG_Montant),0)) 
                FROM F_CREGLEMENT A
                INNER JOIN Z_RGLT_BONDECAISSE B ON A.RG_No = B.RG_No_RGLT
                INNER JOIN F_CREGLEMENT C ON B.RG_No = C.RG_No
                GROUP BY A.RG_No) A GROUP BY RG_No)B ON A.RG_No = B.RG_No
                WHERE A.RG_No =".$this->RG_No;
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getReglementByClient($ct_num,$ca_no,$type,$treglement,$datedeb,$datefin,$caissier,$collab,$typeSelectRegl=0) {
        $treglementParam = 0;
        if($treglement!="")
            $treglementParam = $treglement;
        return $this->getApiJson("/getReglementByClient&dateDeb={$datedeb}&dateFin={$datefin}&rgImpute={$type}&ctNum={$ct_num}&collab={$collab}&nReglement={$treglementParam}&caNo={$ca_no}&coNoCaissier={$caissier}&rgType={$typeSelectRegl}");
    }

    public function addCReglementFacture($cbMarqEntete, $montant,$rg_type,$mode_reglement,$caisse,$date_reglt,$lib_reglt,$date_ech,$protNo) {
        $docEntete = new DocEnteteClass($cbMarqEntete,$this->db);
        $DO_Date = $date_reglt;
        $CT_Num = $docEntete->DO_Tiers;
        $DE_No = $docEntete->DE_No;
        $CA_Num = $docEntete->CA_Num;
        $DO_Ref = $docEntete->DO_Ref;
        if(isset($_SESSION)){
            $protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
            $co_noProt = $protection->getCoNo();
            if($co_noProt == null)
                $CO_No = $docEntete->CO_No;
            else {
                $CO_No = $co_noProt;
            }
        }else {
            $CO_No = $docEntete->CO_No;
        }
        $cg_num = $docEntete->CG_Num;
        $DO_Devise = $docEntete->DO_Devise !="" ? $docEntete->DO_Devise : 0 ;
        $DO_Cours = $docEntete->DO_Cours !="" ? $docEntete->DO_Cours : 0 ;
        $DO_Domaine = $docEntete->DO_Domaine;
        $DO_Type = $docEntete->DO_Type;
        $caisseVal = new CaisseClass($caisse,$this->db);
        if($caisseVal->CA_No==""){
            $co_nocaissier = 0;
            $ca_no = 0;
            $jo_num = "";
        }else {
            $co_nocaissier = $caisseVal->CO_NoCaissier;
            $ca_no = $caisseVal->CA_No;
            $jo_num = $caisseVal->JO_Num;
        }
        $ticket = 0;
        if($DO_Type==30) $ticket = 1;
        $creglement = new ReglementClass(0,$this->db);
        $creglement->initVariables();
        $creglement->RG_Date = $DO_Date;
        $creglement->CT_NumPayeur = $CT_Num;
        $creglement->CA_No = $ca_no;
        $creglement->CG_Num = $cg_num;
        $creglement->RG_Reference = $DO_Ref;
        //$caisse = new CaisseClass($creglement->CA_No);
        $creglement->JO_Num = $jo_num;
        $creglement->CO_NoCaissier = $CO_No;
        $creglement->setuserName("","");
        $creglement->RG_Montant = $montant;
        $creglement->RG_Libelle = $lib_reglt;
        $creglement->RG_Impute = 1;
        $creglement->RG_Type = $rg_type;
        $creglement->N_Reglement = $mode_reglement;
        $creglement->RG_TypeReg=0;
        $creglement->RG_Ticket=$ticket;
        $creglement->RG_Banque=0;
        $creglement->N_Devise = $DO_Devise;
        $creglement->RG_Cours = $DO_Cours;
        $creglement->RG_DateEchCont=$DO_Date;
        $creglement->userName = $protNo;
        $rg_no = $creglement->insertF_Reglement();
        $this->objetCollection->incrementeCOLREGLEMENT();
        $rows = $docEntete->getDocReglByDO_Piece();
        $record = $rows;
        if(!isset($rows[0]->DR_No)){
            $result = $this->db->requete($this->objetCollection->addDocRegl($docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece, 0, $mode_reglement,$date_reglt));
            $rows = $docEntete->getDocReglByDO_Piece();
        }
        $dr_no = $rows[0]->DR_No;
        $montantTTC = $docEntete->montantRegle();
        $montantTTC_regle = $docEntete->AvanceDoPiece();
        $reste_a_regler = $montantTTC - $montantTTC_regle;
        if(($reste_a_regler>=0 && $montant>$reste_a_regler) || ($reste_a_regler<0 && $montant<$reste_a_regler)){
            $result = $this->db->requete($this->objetCollection->addReglEch($rg_no, $dr_no, $docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece, round($reste_a_regler,2)));
        }else{
            $result = $this->db->requete($this->objetCollection->addReglEch($rg_no, $dr_no, $docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece, round($montant,2)));
            if($montant==$reste_a_regler){
                $this->db->requete($this->objetCollection->updateDrRegle($dr_no));
                $this->db->requete($this->objetCollection->updateImpute($rg_no));
            }
        }$this->db->requete($this->objetCollection->updateDateRegle($dr_no,$date_ech));
        return $rg_no;
    }


    public function addReglement($protNo/*$_GET["mobile"]*/,$jo_num/*$_GET["JO_Num"]*/,$rg_no_lier/*$_GET["RG_NoLier"]*/,$ct_num /*$_GET['CT_Num']*/
                                ,$ca_no/*$_GET["CA_No"]*/,$boncaisse /*$_GET["boncaisse"]*/,$libelle /*$_GET['libelle']*/,$caissier /*$_GET['caissier']*/
                                ,$date/*$_GET['date']*/,$modeReglementRec /*$_GET["mode_reglementRec"]*/
                                ,$montant /*$_GET['montant']*/,$impute/*$_GET['impute']*/,$RG_Type /*$_GET['RG_Type']*/,$afficheData=true,$typeRegl=""){
        $admin = 0;
        $limitmoinsDate = "";
        $limitplusDate = "";
        $protectionClass = new ProtectionClass("","");
        $protectionClass->connexionProctectionByProtNo($protNo);
        if($protectionClass->PROT_Right!=1) {
            $limitmoinsDate = date('d/m/Y', strtotime(date('Y-m-d'). " - ".$protectionClass->getDelai()." day"));
            $limitplusDate = date('d/m/Y', strtotime(date('Y-m-d'). " + ".$protectionClass->getDelai()." day"));
            $str = strtotime(date("M d Y ")) - (strtotime($date));
            $nbDay = abs(floor($str/3600/24));
            if($nbDay>$protectionClass->getDelai())
                $admin =1;
        }

        if($admin==0) {
            $url = "/addReglement&protNo=$protNo&joNum=$jo_num&rgNoLier=$rg_no_lier&ctNum=$ct_num&caNo=$ca_no&bonCaisse=$boncaisse&libelle=$libelle&caissier=$caissier&date=$date&modeReglementRec=$modeReglementRec&montant=$montant&impute=$impute&rgType=$RG_Type&afficheData=$afficheData&typeRegl=$typeRegl";
            $info = $this->getApiString($url);
            if($afficheData)
                echo json_encode($info);
        }
        else {
            if($afficheData)
                echo "la date doit être comprise entre $limitmoinsDate et $limitplusDate.";
        }
    }


    public function getReglementByFacture($cbMarq){
        $query = "  SELECT creg.RG_No
                    FROM F_DOCENTETE doc
                    INNER JOIN F_REGLECH reg
                        ON  doc.cbDO_Piece = reg.cbDO_Piece
                        AND doc.DO_Domaine = reg.DO_Domaine
                        AND doc.DO_Type = reg.DO_Type
                    INNER F_CREGLEMENT creg
                        ON  creg.RG_No = reg.RG_No
                    WHERE   doc.cbMarq = $cbMarq 
                    AND     EC_No = 0";
        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            $docEntete = new ReglementClass($resultat->RG_No);
            array_push($this->list,$docEntete);
        }
        return $this->list;
    }

    public function getListeReglementMajComptable($typeTransfert, $datedeb, $datefin,$etatPiece,$caisse){
        $rg_type =0;
        if($typeTransfert==4) $rg_type=1;

        $rg_compta = 0;
        if($etatPiece==1) $rg_compta = 1;

        $query = "
                    DECLARE @dateDebut VARCHAR(50) = ?
                            ,@dateFin VARCHAR(50) = ?
                            ,@etatPiece INT = ? 
                            ,@typeTransfert INT = ?;
                    DECLARE @rgCompta INT = (SELECT CASE WHEN @etatPiece = 1 THEN 1 ELSE 0 END)
                            ,@rgType INT = (SELECT CASE WHEN @typeTransfert = 4 THEN 1 ELSE 0 END)
                            ,@caNo INT = ?;

                    SELECT RG_No
                  FROM F_CREGLEMENT
                  WHERE (@dateDebut ='' OR RG_Date>= @dateDebut )
                  AND ( @dateFin ='' OR RG_Date<= @dateFin )
                  AND  RG_Compta = @rgCompta
                  AND RG_Type = @rgType
                  AND (@caNo =0 OR CA_No = @caNo) ";
        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            $docEntete = new ReglementClass($resultat->RG_No);
            array_push($this->list,$docEntete);
        }
        return $this->list;
    }

    public function __toString() {
        return "";
    }

    public function formatDate($val){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $val);
        return $date->format('Y-m-d');
    }



}