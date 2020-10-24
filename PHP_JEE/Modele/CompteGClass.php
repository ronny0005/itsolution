<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CompteGClass Extends Objet{
    //put your code here
    public $db,$CG_Num,$CG_Type,$CG_Intitule,$CG_Classement
    ,$N_Nature,$CG_Report,$CR_Num
    ,$CG_Raccourci,$CG_Saut,$CG_Regroup
    ,$CG_Analytique,$CG_Echeance,$CG_Quantite,$CG_Lettrage
    ,$CG_Tiers,$CG_DateCreate
    ,$CG_Devise,$N_Devise,$TA_Code,$CG_Sommeil
    ,$cbProt,$cbMarq,$cbCreateur,$cbModification
    ,$cbReplication,$cbFlag;

    public $table = 'dbo.F_COMPTEG';
    public $lien = 'fcompteg';

    function __construct($id,$mode="all",$db=null)
    {
        $this->data = $this->getApiJson("/cgNum=$id");
        if (sizeof($this->data) > 0) {
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->CG_Type = $this->data[0]->CG_Type;
            $this->CG_Intitule = $this->data[0]->CG_Intitule;
            $this->CG_Classement = $this->data[0]->CG_Classement;
            $this->N_Nature = $this->data[0]->N_Nature;
            $this->CG_Report = $this->data[0]->CG_Report;
            $this->CR_Num = $this->data[0]->CR_Num;
            $this->CG_Raccourci = $this->data[0]->CG_Raccourci;
            $this->CG_Saut = $this->data[0]->CG_Saut;
            $this->CG_Regroup = $this->data[0]->CG_Regroup;
            $this->CG_Analytique = $this->data[0]->CG_Analytique;
            $this->CG_Echeance = $this->data[0]->CG_Echeance;
            $this->CG_Quantite = $this->data[0]->CG_Quantite;
            $this->CG_Lettrage = $this->data[0]->CG_Lettrage;
            $this->CG_Tiers = $this->data[0]->CG_Tiers;
            $this->CG_DateCreate = $this->data[0]->CG_DateCreate;
            $this->CG_Devise = $this->data[0]->CG_Devise;
            $this->N_Devise = $this->data[0]->N_Devise;
            $this->TA_Code = $this->data[0]->TA_Code;
            $this->CG_Sommeil = $this->data[0]->CG_Sommeil;
            $this->cbProt = $this->data[0]->cbProt;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->cbReplication = $this->data[0]->cbReplication;
            $this->cbFlag = $this->data[0]->cbFlag;
        }
    }

    public function getComptegByType($type=0){
        return $this->getApiJson("/getComptegByType&cgType=$type");
    }



    public function allSearch($intitule="",$top=0){
        return $this->getApiJson("/allSearch&intitule={$this->formatString($intitule)}&top=$top");
    }

    public function __toString() {
        return "";
    }
}
