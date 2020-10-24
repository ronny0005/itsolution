<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class JournalClass Extends Objet{
    //put your code here
    public $db,$JO_Num,$JO_Intitule,$CG_Num,$JO_Type,$JO_NumPiece
    ,$JO_Contrepartie,$JO_SaisAnal,$JO_NotCalcTot,$JO_Rappro
    ,$JO_Sommeil,$JO_IFRS,$JO_Reglement
    ,$JO_SuiviTreso,$cbCreateur,$cbModification;
    public $table = 'F_JOURNAUX';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'JO_Num',$db);
        if(sizeof($this->data)>0) {
            $this->JO_Num = $this->data[0]->JO_Num;
            $this->JO_Intitule = stripslashes($this->data[0]->JO_Intitule);
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->JO_Type = $this->data[0]->JO_Type;
            $this->JO_NumPiece = $this->data[0]->JO_NumPiece;
            $this->JO_Contrepartie = stripslashes($this->data[0]->JO_Contrepartie);
            $this->JO_SaisAnal = stripslashes($this->data[0]->JO_SaisAnal);
            $this->JO_NotCalcTot = $this->data[0]->JO_NotCalcTot;
            $this->JO_Rappro = $this->data[0]->JO_Rappro;
            $this->JO_Sommeil = $this->data[0]->JO_Sommeil;
            $this->JO_IFRS = $this->data[0]->JO_IFRS;
            $this->JO_Reglement = $this->data[0]->JO_Reglement;
            $this->JO_SuiviTreso = $this->data[0]->JO_SuiviTreso;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
        }
    }

    public function maj_journal(){
        parent::maj(JO_Intitule, $this->JO_Intitule);
        parent::maj(CG_Num, $this->CG_Num);
        parent::maj(JO_Type, $this->JO_Type);
        parent::maj(JO_NumPiece, $this->JO_NumPiece);
        parent::maj(JO_Contrepartie, $this->JO_Contrepartie);
        parent::maj(JO_SaisAnal, $this->JO_SaisAnal);
        parent::maj(JO_NotCalcTot, $this->JO_NotCalcTot);
        parent::maj(JO_Rappro, $this->JO_Rappro);
        parent::maj(JO_Sommeil, $this->JO_Sommeil);
        parent::maj(JO_IFRS, $this->JO_IFRS);
        parent::maj(JO_Reglement, $this->JO_Reglement);
        parent::maj(JO_SuiviTreso, $this->JO_SuiviTreso);
        parent::maj(cbCreateur, $this->userName);
        parent::maj(cbModification, $this->cbModification);
    }

    public function getJournaux($val){
        $query = "SELECT JO_Num,JO_Intitule,CG_Num,cbModification
                FROM ".$this->db->baseCompta.".dbo.F_JOURNAUX
                WHERE ($val=0 AND 1=1) OR ($val=1 AND JO_Sommeil=0) OR ($val=2 AND JO_Sommeil=1)";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getJournauxSaufTotaux(){
        $query = "SELECT JO_Num,JO_Intitule,CG_Num,cbModification
                FROM F_JOURNAUX
                WHERE JO_Type<>0";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getJournauxType($type,$sommeil=-1){
        $query = "SELECT JO_Num,JO_Intitule,CG_Num,cbModification
                FROM F_JOURNAUX
                WHERE JO_Type=$type
                AND ($sommeil = -1 OR JO_Sommeil=$sommeil)";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }


    function getJournauxSaisieSelect($ouvert,$mois,$journal){
        $query = "  SET language french;
                    DECLARE @mois AS INT = $mois;
                    DECLARE @ouvert AS INT = $ouvert;
                    DECLARE @journal AS VARCHAR(50) = '$journal';
                
                WITH months(NomMois,MonthNumber) AS
                (
                    SELECT  NomMois = DateName( month , DateAdd( month , 1, 0 ) - 1 )
                            ,MonthNumber = 1 
                    UNION ALL
                    SELECT  NomMois = DateName( month , DateAdd( month , MonthNumber+1, 0 ) - 1 )
                            ,MonthNumber = MonthNumber+1  
                    FROM    months
                    WHERE   MonthNumber < 12
                )

                SELECT  MonthNumber
                        ,NomMois = CASE WHEN @mois=1 THEN NomMois ELSE '' END 
                        ,JO_Num = CASE WHEN @journal=1 THEN A.JO_Num ELSE '' END 
                FROM(
                SELECT  NomMois
                        ,MonthNumber
                        ,JO_Num
                        ,JO_Intitule
                FROM    F_JOURNAUX,months
                )A
                LEFT JOIN F_JMOUV B 
                    ON  A.JO_Num =B.JO_Num 
                    AND A.MonthNumber=MONTH(JM_Date)
                WHERE   (@ouvert!=1 OR (@ouvert=1 AND B.JO_Num IS NOT NULL))
                AND     (@ouvert!=2 OR (@ouvert=2 AND B.JO_Num IS NULL))
                GROUP BY MonthNumber
                         ,CASE WHEN @mois=1 THEN NomMois ELSE '' END 
                         ,CASE WHEN @journal=1 THEN A.JO_Num ELSE '' END
                ORDER BY MonthNumber";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    function getJournauxSaisie($ouvert,$NomMois,$JO_Num,$annee){
        $query = "SET language french;
                    DECLARE @NomMois AS VARCHAR(50) = '$NomMois';
                    DECLARE @ouvert AS INT = $ouvert;
                    DECLARE @annee AS INT = $annee;
                    DECLARE @joNum AS VARCHAR(50) = '$JO_Num';
                    WITH months AS
                (
                    SELECT  NomMois = DateName( month , DateAdd( month , 1, 0 ) - 1 )
                            ,MonthNumber = 1 
                    UNION ALL
                    SELECT  NomMois = DateName( month , DateAdd( month , MonthNumber+1, 0 ) - 1 )
                            ,MonthNumber = MonthNumber+1  
                    FROM    months
                    WHERE   MonthNumber < 12
                )

                SELECT A.*
                FROM(
                    SELECT  NomMois
                            ,MonthNumber
                            ,JO_Num
                            ,JO_Intitule
                    FROM    F_JOURNAUX,months)A
                LEFT JOIN F_JMOUV B 
                    ON  A.JO_Num =B.JO_Num 
                    AND MonthNumber=MONTH(JM_Date)
                WHERE 
                (@ouvert!=1 OR (@ouvert=1 AND B.JO_Num IS NOT NULL))
                AND (@ouvert!=2 OR (@ouvert=2 AND B.JO_Num IS NULL))
                AND (@NomMois='0' OR NomMois=@NomMois)
                AND (@joNum='0' OR A.JO_Num=@joNum)
                AND YEAR(JM_Date) = @annee
                ORDER BY MonthNumber
                ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function calculSoldeLettrage($listCbMarq){
        if($listCbMarq=="")
            $listCbMarq = 0;
        $query = " 
                SELECT EC_MontantCredit = CASE WHEN EC_MontantCredit <= EC_MontantDebit THEN 0 ELSE EC_MontantCredit-EC_MontantDebit END
                        , EC_MontantDebit = CASE WHEN EC_MontantDebit <= EC_MontantCredit THEN 0 ELSE EC_MontantDebit-EC_MontantCredit END
                FROM (SELECT  EC_MontantCredit = SUM(CASE WHEN EC_Sens=1 THEN EC_Montant ELSE 0 END) 
                        ,EC_MontantDebit = SUM(CASE WHEN EC_Sens=0 THEN EC_Montant ELSE 0 END)
                FROM    F_ECRITUREC A
                WHERE cbMarq IN ($listCbMarq))A";

        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getSaisieJournalExercice($JO_Num,$Mois,$Annee,$CT_Num,$dateDebut,$dateFin,$lettrage,$CG_Num){
        $query= "
                DECLARE @joNum VARCHAR(50) = '$JO_Num';
                DECLARE @Mois INT = $Mois;
                DECLARE @Annee INT = $Annee;
                DECLARE @ctNum NVARCHAR(50) = '$CT_Num';
                DECLARE @dateDebut NVARCHAR(50) = '$dateDebut';
                DECLARE @dateFin NVARCHAR(50) = '$dateFin';
                DECLARE @lettrage INT = '$lettrage';
                DECLARE @cgNum NVARCHAR(50) = '$CG_Num';
                
                SELECT  A.JO_Num
                        ,A.cbMarq
                        ,A.EC_No
                        ,JM_Date
                        ,EC_Jour
                        ,EC_Reference
                        ,EC_Piece
                        ,EC_Date
                        ,A.EC_Lettrage
                        ,EC_RefPiece,EC_TresoPiece
                        ,Lien_Fichier = ISNULL(Lien_Fichier,'')
                        ,A.CG_Num,A.CT_Num,EC_Intitule,N_Reglement
                        ,EC_Echeance,EC_Sens,EC_Montant
                        ,EC_MontantCredit = CASE WHEN EC_Sens=1 THEN EC_Montant ELSE 0 END 
                        ,EC_MontantDebit = CASE WHEN EC_Sens=0 THEN EC_Montant ELSE 0 END 
                        ,EC_Echeance_C = CAST(EC_Echeance AS DATE) 
                        ,B.CG_Analytique
                FROM    F_ECRITUREC A
                LEFT JOIN  F_COMPTEG B 
                    ON  A.CG_Num = B.CG_Num
                LEFT JOIN Z_ECRITURECPIECE C 
                    ON  A.EC_No = C.EC_No
                WHERE   (@joNum ='' OR JO_Num=@joNum) 
                AND     (@ctNum ='' OR A.CT_Num=@ctNum) 
                AND     (@cgNum ='' OR A.CG_Num=@cgNum) 
                AND     (   (@dateDebut <>'' OR @dateFin<>'') 
                            OR (@dateDebut ='' AND @dateFin='' AND MONTH(JM_Date) = @Mois))
                AND     YEAR(JM_Date) = @Annee
                AND     (@lettrage = -1 OR A.EC_Lettre = @lettrage)
                AND     (@dateDebut = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) >= @dateDebut)
                AND     (@dateFin = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) <= @dateFin)
                ORDER BY A.cbMarq";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalJournal($JO_Num,$Mois,$Annee,$sens,$CT_Num,$dateDebut,$dateFin,$lettrage,$CG_Num){
        $query= "
                DECLARE @joNum VARCHAR(50) ='$JO_Num';
                DECLARE @Mois INT =$Mois;
                DECLARE @Annee INT =$Annee;
                DECLARE @sens INT =$sens;
                DECLARE @ctNum NVARCHAR(50) ='$CT_Num';
                DECLARE @cgNum NVARCHAR(50) ='$CG_Num';
                DECLARE @dateDebut NVARCHAR(50) ='$dateDebut';
                DECLARE @dateFin NVARCHAR(50) ='$dateFin';
                DECLARE @lettrage INT ='$lettrage';
                
                SELECT EC_Montant = CASE WHEN @sens = 0 THEN ABS(EC_Montant) ELSE EC_Montant END
                FROM(
                SELECT  EC_Montant = SUM(CASE WHEN EC_Sens = 1 THEN EC_Montant ELSE - EC_Montant END) 
                FROM    F_ECRITUREC A
                LEFT JOIN   F_COMPTEG B 
                    ON  A.CG_Num = B.CG_Num
                LEFT JOIN   Z_ECRITURECPIECE C 
                    ON  A.EC_No = C.EC_No
                WHERE   (@joNum ='' OR JO_Num=@joNum) 
                AND     (@ctNum ='' OR A.CT_Num=@ctNum) 
                AND     (@cgNum ='' OR A.CG_Num=@cgNum) 
                AND     (   (@dateDebut <>'' OR @dateFin<>'') 
                            OR (@dateDebut ='' AND @dateFin='' AND MONTH(JM_Date) = @Mois))
                AND     YEAR(JM_Date) = @Annee
                AND     (@sens=2 OR EC_Sens = @sens)
                AND     (@lettrage = -1 OR A.EC_Lettre = @lettrage)
                AND     (@dateDebut = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) >= @dateDebut)
                AND     (@dateFin = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) <= @dateFin)
                )A
                ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 0;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Montant;

        $list = ["EC_Montant" => $result];
        return (object)$list;
    }

    public function getJournalLastDate($JO_Num,$Mois,$Annee){
        $query= "
                DECLARE @joNum VARCHAR(50) ='$JO_Num';
                DECLARE @Mois INT =$Mois;
                DECLARE @Annee INT =$Annee;
                
                SELECT  EC_Jour = MAX(EC_Jour) 
                FROM    F_ECRITUREC A
                LEFT JOIN  F_COMPTEG B 
                    ON  A.CG_Num = B.CG_Num
                LEFT JOIN Z_ECRITURECPIECE C 
                    ON  A.EC_No = C.EC_No
                WHERE   JO_Num=@joNum 
                AND     MONTH(JM_Date) = @Mois
                AND     YEAR(JM_Date) = @Annee
                ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 1;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Jour;
        $list = ["EC_Jour" => $result];
        return (object)$list;
    }

    public function getJournalPiece($JO_Num,$Mois,$Annee){
        $query= "
                DECLARE @joNum VARCHAR(50) ='$JO_Num';
                DECLARE @Mois INT =$Mois;
                DECLARE @Annee INT =$Annee;
                
                SELECT  EC_Piece = MAX(TRY_CAST(EC_Piece AS INT)) 
                FROM    F_ECRITUREC A
                LEFT JOIN  F_COMPTEG B 
                    ON  A.CG_Num = B.CG_Num
                LEFT JOIN Z_ECRITURECPIECE C 
                    ON  A.EC_No = C.EC_No
                WHERE   JO_Num=@joNum 
                AND     MONTH(JM_Date) = @Mois
                AND     YEAR(JM_Date) = @Annee
                ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 1;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Piece;
        $list = ["EC_Piece" => $result];
        return (object)$list;
    }

    public function getLettrage($CT_Num,$dateDebut,$dateFin,$CG_Num){
        $query= "
                BEGIN 
				DECLARE @result VARCHAR(10);
				DECLARE @ctNum VARCHAR(50) ='$CT_Num';
				DECLARE @cgNum VARCHAR(50) ='$CG_Num';
                DECLARE @dateDebut NVARCHAR(50) ='$dateDebut';
                DECLARE @dateFin NVARCHAR(50) ='$dateFin';
                
				SELECT  @result = CHAR(ASCII(EC_Lettrage)+1)
                FROM    F_ECRITUREC A
                WHERE   EC_Lettre=1
				AND		(@ctNum='' OR CT_Num=@ctNum)
                AND		(@cgNum='' OR CG_Num=@cgNum)
                AND     (@dateDebut = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) >= @dateDebut)
                AND     (@dateFin = '' OR CAST(DATEADD(DAY,A.EC_Jour-1,A.JM_Date) AS DATE) <= @dateFin)
                
				select EC_Lettrage = ISNULL(@result,'A')
				END
                ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 1;
        if(sizeof($row)>0)
            $result = $row[0]->EC_Lettrage;
        $list = ["EC_Lettrage" => $result];
        return (object)$list;
    }

    public function pointerEcriture($annuler,$listCbMarq,$ecLettrage){
        $query = "  BEGIN
                        SET NOCOUNT ON;
                        DECLARE @amount FLOAT;
                        DECLARE @result INT;
                        DECLARE @annuler INT = $annuler;
                        DECLARE @ecLettrage VARCHAR(50) = '$ecLettrage';
                        SELECT  @amount = SUM(CASE WHEN EC_Sens = 1 THEN EC_Montant ELSE - EC_Montant END) 
                        FROM    F_ECRITUREC
                        WHERE   cbMarq IN ($listCbMarq)
                        
                        IF  @amount=0 
                            BEGIN 
                                UPDATE F_ECRITUREC SET EC_Lettre = @annuler
                                                    ,EC_Lettrage = @ecLettrage 
                                WHERE cbMarq IN ($listCbMarq)
                                SELECT @result = 1
                            END 
                        ELSE 
                            BEGIN 
                                SELECT @result = 0
                            END
                            SELECT Result = @result 
                    END ";
        $result= $this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $result = 1;
        if(sizeof($row)>0)
            $result = $row[0]->Result;
        $list = ["Result" => $result];
        return (object)$list;
    }

    public function __toString() {
        return "";
    }

}