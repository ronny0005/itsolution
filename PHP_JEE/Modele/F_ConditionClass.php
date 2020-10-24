<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class F_ConditionClass Extends Objet{
    //put your code here
    public $db,$AR_Ref,$CO_No,$EC_Enumere
    ,$EC_Quantite,$CO_Ref,$CO_CodeBarre,$CO_Principal
    ,$cbProt,$cbMarq,$cbCreateur,$cbModification,$cbReplication,$cbFlag;
    public $lien = 'fcondition';
    public $table = 'F_Condition';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'cbMarq',$db);
        $this->data = $this->getApiJson("/cbMarq=$id");
        if(sizeof($this->data)>0) {
            $this->AR_Ref = $this->data[0]->AR_Ref;
            $this->      CO_No = $this->data[0]->      CO_No;
            $this->      EC_Enumere = $this->data[0]->      EC_Enumere;
            $this->      EC_Quantite = $this->data[0]->      EC_Quantite;
            $this->      CO_Ref = $this->data[0]->      CO_Ref;
            $this->      CO_CodeBarre = $this->data[0]->      CO_CodeBarre;
            $this->      CO_Principal = $this->data[0]->      CO_Principal;
            $this->      cbProt = $this->data[0]->      cbProt;
            $this->      cbMarq = $this->data[0]->      cbMarq;
            $this->      cbCreateur = $this->data[0]->      cbCreateur;
            $this->      cbModification = $this->data[0]->      cbModification;
            $this->      cbReplication = $this->data[0]->      cbReplication;
            $this->      cbFlag = $this->data[0]->      cbFlag;
        }
    }
    public function detailConditionnement($arRef){
        return $this->getApiJson("/detailConditionnement&arRef=$arRef&TC_RefCF");

    }
    public function __toString() {
        return "";
    }

}