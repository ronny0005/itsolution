<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CatComptaClass Extends Objet{
    //put your code here
    public $db
    ,$cbMarq;
    public $table = 'P_CATCOMPTA';
    public $lien = "pcatcompta";
    function __construct($id,$db=null)
    {
        parent::__construct($this->table, $id, 'cbMarq',$db);
        if ($this->data!=NULL && sizeof($this->data) > 0) {
            $this->CT_Intitule = $this->data[0]->CT_Intitule;
            $this->CT_PrixTTC = $this->data[0]->CT_PrixTTC;
            $this->cbIndice = $this->data[0]->cbIndice;
            $this->cbMarq = $this->data[0]->cbMarq;
        }
    }

    public function maj_cattarif(){
        parent::maj(CT_Intitule , $this->CT_Intitule);
        parent::maj(CT_PrixTTC , $this->CT_PrixTTC);
        parent::maj(cbIndice , $this->cbIndice);
        parent::maj(cbMarq , $this->cbMarq);
    }

    public function getCatCompta() {
        return $this->getApiJson("/getCatComptaVente");
    }

    public function getCatComptaAll(){
        $query =  "select  row_number() over (order by u.subject) as idcompta,u.marks,1 AS Type
                from P_CATCOMPTA
                unpivot
                (
                  marks
                  for subject in (CA_ComptaAch01, CA_ComptaAch02,CA_ComptaAch03,CA_ComptaAch04,CA_ComptaAch05,CA_ComptaAch06,CA_ComptaAch07,CA_ComptaAch08,CA_ComptaAch09,CA_ComptaAch10,CA_ComptaAch11,CA_ComptaAch12,CA_ComptaAch13,CA_ComptaAch14,CA_ComptaAch15,CA_ComptaAch16,CA_ComptaAch17,CA_ComptaAch18,CA_ComptaAch19,CA_ComptaAch20,CA_ComptaAch21,CA_ComptaAch22)
                ) u WHERE marks<>''
                union
                select  row_number() over (order by u.subject) as idcompta,u.marks,0 AS Type
                from P_CATCOMPTA
                unpivot
                (
                  marks
                  for subject in (CA_ComptaVen01, CA_ComptaVen02,CA_ComptaVen03,CA_ComptaVen04,CA_ComptaVen05,CA_ComptaVen06,CA_ComptaVen07,CA_ComptaVen08,CA_ComptaVen09,CA_ComptaVen10,CA_ComptaVen11,CA_ComptaVen12,CA_ComptaVen13,CA_ComptaVen14,CA_ComptaVen15,CA_ComptaVen16,CA_ComptaVen17,CA_ComptaVen18,CA_ComptaVen19,CA_ComptaVen20,CA_ComptaVen21,CA_ComptaVen22)
                ) u
                WHERE marks<>''
                ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }


    public function getCatComptaAllCount(){
        $query =  "
                SELECT COUNT(*) Nb FROM(
                select  row_number() over (order by u.subject) as idcompta,u.marks,1 AS Type
                from P_CATCOMPTA
                unpivot
                (
                  marks
                  for subject in (CA_ComptaAch01, CA_ComptaAch02,CA_ComptaAch03,CA_ComptaAch04,CA_ComptaAch05,CA_ComptaAch06,CA_ComptaAch07,CA_ComptaAch08,CA_ComptaAch09,CA_ComptaAch10,CA_ComptaAch11,CA_ComptaAch12,CA_ComptaAch13,CA_ComptaAch14,CA_ComptaAch15,CA_ComptaAch16,CA_ComptaAch17,CA_ComptaAch18,CA_ComptaAch19,CA_ComptaAch20,CA_ComptaAch21,CA_ComptaAch22)
                ) u WHERE marks<>''
                union
                select  row_number() over (order by u.subject) as idcompta,u.marks,0 AS Type
                from P_CATCOMPTA
                unpivot
                (
                  marks
                  for subject in (CA_ComptaVen01, CA_ComptaVen02,CA_ComptaVen03,CA_ComptaVen04,CA_ComptaVen05,CA_ComptaVen06,CA_ComptaVen07,CA_ComptaVen08,CA_ComptaVen09,CA_ComptaVen10,CA_ComptaVen11,CA_ComptaVen12,CA_ComptaVen13,CA_ComptaVen14,CA_ComptaVen15,CA_ComptaVen16,CA_ComptaVen17,CA_ComptaVen18,CA_ComptaVen19,CA_ComptaVen20,CA_ComptaVen21,CA_ComptaVen22)
                ) u
                WHERE marks<>'')A";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getCatComptaByArRef($AR_Ref,$ACP_Champ,$ACP_Type){
        $query =  "SELECT ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.ACP_Champ ELSE B.ACP_Champ END,0) ACP_Champ,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_Num ELSE B.CG_Num END,'') CG_Num,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_Intitule ELSE B.CG_Intitule END,'') CG_Intitule,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_NumA ELSE B.CG_NumA END,'') CG_NumA,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.CG_IntituleA ELSE B.CG_IntituleA END,'') CG_IntituleA,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe1 ELSE B.Taxe1 END,'') Taxe1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule1 ELSE B.TA_Intitule1 END,'') TA_Intitule1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe2 ELSE B.Taxe2 END,'') Taxe2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule2 ELSE B.TA_Intitule2 END,'') TA_Intitule2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.Taxe3 ELSE B.Taxe3 END,'') Taxe3,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Intitule3 ELSE B.TA_Intitule3 END,'') TA_Intitule3,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux1 ELSE B.TA_Taux1 END,0) TA_Taux1,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux2 ELSE B.TA_Taux2 END,0) TA_Taux2,
                ISNULL(CASE WHEN B.AR_Ref IS NULL THEN A.TA_Taux3 ELSE B.TA_Taux3 END,0) TA_Taux3
                FROM (
                SELECT A.FA_CodeFamille,FCP_Type ACP_Type,AR_Ref,FCP_Champ ACP_Champ,FCP_ComptaCPT_CompteG CG_Num,CG.CG_Intitule,FCP_ComptaCPT_CompteA CG_NumA,CA.CG_Intitule CG_IntituleA,FCP_ComptaCPT_Taxe1 Taxe1,TU.TA_Intitule TA_Intitule1,TU.TA_Taux TA_Taux1
                ,FCP_ComptaCPT_Taxe2 Taxe2,TD.TA_Intitule TA_Intitule2,TD.TA_Taux TA_Taux2,FCP_ComptaCPT_Taxe3 Taxe3,TT.TA_Intitule TA_Intitule3,TT.TA_Taux TA_Taux3
                FROM F_FAMCOMPTA A 
                INNER JOIN F_ARTICLE AR ON AR.FA_CodeFamille = A.FA_CodeFamille
                LEFT JOIN F_TAXE TU ON A.FCP_ComptaCPT_Taxe1 = TU.TA_Code
                LEFT JOIN F_TAXE TD ON A.FCP_ComptaCPT_Taxe2 = TD.TA_Code
                LEFT JOIN F_TAXE TT ON A.FCP_ComptaCPT_Taxe3 = TT.TA_Code
                LEFT JOIN F_COMPTEG CG ON A.FCP_ComptaCPT_CompteG = CG.CG_Num
                LEFT JOIN F_COMPTEG CA ON A.FCP_ComptaCPT_CompteA = CA.CG_Num) A
                LEFT JOIN (SELECT A.AR_Ref,ACP_Type,FA_CodeFamille,ACP_Champ,ACP_ComptaCPT_CompteG CG_Num,CG.CG_Intitule,ACP_ComptaCPT_CompteA CG_NumA,CA.CG_Intitule CG_IntituleA,ACP_ComptaCPT_Taxe1 Taxe1,TU.TA_Intitule TA_Intitule1,TU.TA_Taux TA_Taux1
                ,ACP_ComptaCPT_Taxe2 Taxe2,TD.TA_Intitule TA_Intitule2,TD.TA_Taux TA_Taux2,ACP_ComptaCPT_Taxe3 Taxe3,TT.TA_Intitule TA_Intitule3,TT.TA_Taux TA_Taux3
                FROM F_ARTCOMPTA A 
                INNER JOIN F_ARTICLE AR ON AR.AR_Ref = A.AR_Ref
                LEFT JOIN F_TAXE TU ON A.ACP_ComptaCPT_Taxe1 = TU.TA_Code
                LEFT JOIN F_TAXE TD ON A.ACP_ComptaCPT_Taxe2 = TD.TA_Code
                LEFT JOIN F_TAXE TT ON A.ACP_ComptaCPT_Taxe3 = TT.TA_Code
                LEFT JOIN F_COMPTEG CG ON A.ACP_ComptaCPT_CompteG = CG.CG_Num
                LEFT JOIN F_COMPTEG CA ON A.ACP_ComptaCPT_CompteA = CA.CG_Num)B ON A.FA_CodeFamille=B.FA_CodeFamille AND A.AR_Ref=B.AR_Ref AND A.ACP_Champ=B.ACP_Champ AND A.ACP_Type=B.ACP_Type
                WHERE A.AR_Ref='$AR_Ref'
                AND A.ACP_Type=$ACP_Type
                AND A.ACP_Champ=$ACP_Champ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCatComptaByCodeFamille($CodeFamille,$ACP_Champ,$ACP_Type){
        $query =  "SELECT A.FA_CodeFamille,FCP_Type ACP_Type,FCP_Champ ACP_Champ,ISNULL(FCP_ComptaCPT_CompteG,'') CG_Num,ISNULL(CG.CG_Intitule,'') CG_Intitule,
                ISNULL(FCP_ComptaCPT_CompteA,'') CG_NumA,ISNULL(CA.CG_Intitule,'') CG_IntituleA,
                ISNULL(FCP_ComptaCPT_CompteA,'')CG_NumA,ISNULL(FCP_ComptaCPT_Taxe1,'') Taxe1,
                ISNULL(TU.TA_Intitule,'') TA_Intitule1,ISNULL(TU.TA_Taux,0) TA_Taux1
                ,ISNULL(FCP_ComptaCPT_Taxe2,'') Taxe2,ISNULL(TD.TA_Intitule,'') TA_Intitule2,ISNULL(TD.TA_Taux,0) TA_Taux2,
                ISNULL(FCP_ComptaCPT_Taxe3,'') Taxe3,ISNULL(TT.TA_Intitule,'') TA_Intitule3,ISNULL(TT.TA_Taux,0) TA_Taux3
                FROM F_FAMCOMPTA A 
                LEFT JOIN F_TAXE TU ON A.FCP_ComptaCPT_Taxe1 = TU.TA_Code
                LEFT JOIN F_TAXE TD ON A.FCP_ComptaCPT_Taxe2 = TD.TA_Code
                LEFT JOIN F_TAXE TT ON A.FCP_ComptaCPT_Taxe3 = TT.TA_Code
                LEFT JOIN F_COMPTEG CG ON A.FCP_ComptaCPT_CompteG = CG.CG_Num
                LEFT JOIN F_COMPTEG CA ON A.FCP_ComptaCPT_CompteA = CA.CG_Num
                WHERE A.FA_CodeFamille='$CodeFamille'
                AND A.FCP_Type=$ACP_Type
                AND A.FCP_Champ=$ACP_Champ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getCatComptaCount() {
        $query = "select count(*) Nb
                    from(select  row_number() over (order by u.subject) as idcompta,u.marks
                                from P_CATCOMPTA
                                unpivot
                                (
                                  marks
                                  for subject in (CA_ComptaVen01, CA_ComptaVen02,CA_ComptaVen03,CA_ComptaVen04,CA_ComptaVen05,CA_ComptaVen06,CA_ComptaVen07,CA_ComptaVen08,CA_ComptaVen09,CA_ComptaVen10,CA_ComptaVen11,CA_ComptaVen12,CA_ComptaVen13,CA_ComptaVen14,CA_ComptaVen15,CA_ComptaVen16,CA_ComptaVen17,CA_ComptaVen18,CA_ComptaVen19,CA_ComptaVen20,CA_ComptaVen21,CA_ComptaVen22)
                                ) u
                                WHERE marks<>'')a";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
        }

        public function getCatComptaAchat() {
            return $this->getApiJson("/getCatComptaAchat");
        }

    public function __toString() {
        return "";
    }

}