<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class FCompteaClass Extends Objet{
    //put your code here
    public $db,$N_Analytique
    ,$CA_Num
    ,$cbCA_Num
    ,$CA_Intitule
    ,$CA_Type
    ,$CA_Classement
    ,$CA_Raccourci
    ,$CA_Report
    ,$N_Analyse
    ,$CA_Saut
    ,$CA_Sommeil
    ,$CA_DateCreate
    ,$CA_Domaine
    ,$CA_Achat
    ,$CA_Vente
    ,$cbProt
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification
    ,$cbReplication
    ,$cbFlag
    ;
    public $table = 'F_COMPTEA';
    public $lien = 'fcomptea';

    function __construct($id)
    {
        $this->data = $this->getApiJson("/caNum=$id");
        if($id!=0)
            if (sizeof($this->data) > 0) {
                $this->N_Analytique =  $this->data[0]->N_Analytique;
                $this->CA_Num =  $this->data[0]->CA_Num;
                $this->cbCA_Num =  $this->data[0]->cbCA_Num;
                $this->CA_Intitule =  $this->data[0]->CA_Intitule;
                $this->CA_Type =  $this->data[0]->CA_Type;
                $this->CA_Classement =  $this->data[0]->CA_Classement;
                $this->CA_Raccourci =  $this->data[0]->CA_Raccourci;
                $this->CA_Report =  $this->data[0]->CA_Report;
                $this->N_Analyse =  $this->data[0]->N_Analyse;
                $this->CA_Saut =  $this->data[0]->CA_Saut;
                $this->CA_Sommeil =  $this->data[0]->CA_Sommeil;
                $this->CA_DateCreate =  $this->data[0]->CA_DateCreate;
                $this->CA_Domaine =  $this->data[0]->CA_Domaine;
                $this->CA_Achat =  $this->data[0]->CA_Achat;
                $this->CA_Vente =  $this->data[0]->CA_Vente;
                $this->cbProt =  $this->data[0]->cbProt;
                $this->cbMarq =  $this->data[0]->cbMarq;
                $this->cbCreateur =  $this->data[0]->cbCreateur;
                $this->cbModification =  $this->data[0]->cbModification;
                $this->cbReplication =  $this->data[0]->cbReplication;
                $this->cbFlag =  $this->data[0]->cbFlag;
            }
    }


    public function getAffaire($sommeil=-1){
        return $this->getApiJson("/affaire&sommeil=$sommeil");
    }

    public function __toString() {
        return "";
    }

}