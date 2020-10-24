<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class PTiersClass Extends Objet{
    //put your code here
    public $db,$T_Principal
    ,$T_Val01T_Intitule
    ,$T_Val01T_TCompte
    ,$T_Val01T_Compte
    ,$T_Val02T_Intitule
    ,$T_Val02T_TCompte
    ,$T_Val02T_Compte
    ,$T_Val03T_Intitule
    ,$T_Val03T_TCompte
    ,$T_Val03T_Compte
    ,$T_Val04T_Intitule
    ,$T_Val04T_TCompte
    ,$T_Val04T_Compte
    ,$T_Val05T_Intitule
    ,$T_Val05T_TCompte
    ,$T_Val05T_Compte
    ,$T_Val06T_Intitule
    ,$T_Val06T_TCompte
    ,$T_Val06T_Compte
    ,$T_Val07T_Intitule
    ,$T_Val07T_TCompte
    ,$T_Val07T_Compte
    ,$T_Val08T_Intitule
    ,$T_Val08T_TCompte
    ,$T_Val08T_Compte
    ,$T_Val09T_Intitule
    ,$T_Val09T_TCompte
    ,$T_Val09T_Compte
    ,$T_Val10T_Intitule
    ,$T_Val10T_TCompte
    ,$T_Val10T_Compte
    ,$T_Numerotation
    ,$T_Lg
    ,$T_Racine
    ,$cbIndice
    ,$cbMarq;

    public $table = 'P_Tiers';
    public $lien = 'ptiers';

    function __construct($id,$db=null)
    {
        parent::__construct($this->table, $id, 'cbMarq',$db);
        $this->data = $this->getApiJson("/tVal01TIntitule=$id");
        if (sizeof($this->data) > 0) {
            $this->T_Principal =  $this->data[0]->T_Principal;
            $this->T_Val01T_Intitule =  $this->data[0]->T_Val01T_Intitule;
            $this->T_Val01T_TCompte =  $this->data[0]->T_Val01T_TCompte;
            $this->T_Val01T_Compte =  $this->data[0]->T_Val01T_Compte;
            $this->T_Val02T_Intitule =  $this->data[0]->T_Val02T_Intitule;
            $this->T_Val02T_TCompte =  $this->data[0]->T_Val02T_TCompte;
            $this->T_Val02T_Compte =  $this->data[0]->T_Val02T_Compte;
            $this->T_Val03T_Intitule =  $this->data[0]->T_Val03T_Intitule;
            $this->T_Val03T_TCompte =  $this->data[0]->T_Val03T_TCompte;
            $this->T_Val03T_Compte =  $this->data[0]->T_Val03T_Compte;
            $this->T_Val04T_Intitule =  $this->data[0]->T_Val04T_Intitule;
            $this->T_Val04T_TCompte =  $this->data[0]->T_Val04T_TCompte;
            $this->T_Val04T_Compte =  $this->data[0]->T_Val04T_Compte;
            $this->T_Val05T_Intitule =  $this->data[0]->T_Val05T_Intitule;
            $this->T_Val05T_TCompte =  $this->data[0]->T_Val05T_TCompte;
            $this->T_Val05T_Compte =  $this->data[0]->T_Val05T_Compte;
            $this->T_Val06T_Intitule =  $this->data[0]->T_Val06T_Intitule;
            $this->T_Val06T_TCompte =  $this->data[0]->T_Val06T_TCompte;
            $this->T_Val06T_Compte =  $this->data[0]->T_Val06T_Compte;
            $this->T_Val07T_Intitule =  $this->data[0]->T_Val07T_Intitule;
            $this->T_Val07T_TCompte =  $this->data[0]->T_Val07T_TCompte;
            $this->T_Val07T_Compte =  $this->data[0]->T_Val07T_Compte;
            $this->T_Val08T_Intitule =  $this->data[0]->T_Val08T_Intitule;
            $this->T_Val08T_TCompte =  $this->data[0]->T_Val08T_TCompte;
            $this->T_Val08T_Compte =  $this->data[0]->T_Val08T_Compte;
            $this->T_Val09T_Intitule =  $this->data[0]->T_Val09T_Intitule;
            $this->T_Val09T_TCompte =  $this->data[0]->T_Val09T_TCompte;
            $this->T_Val09T_Compte =  $this->data[0]->T_Val09T_Compte;
            $this->T_Val10T_Intitule =  $this->data[0]->T_Val10T_Intitule;
            $this->T_Val10T_TCompte =  $this->data[0]->T_Val10T_TCompte;
            $this->T_Val10T_Compte =  $this->data[0]->T_Val10T_Compte;
            $this->T_Numerotation =  $this->data[0]->T_Numerotation;
            $this->T_Lg =  $this->data[0]->T_Lg;
            $this->T_Racine =  $this->data[0]->T_Racine;
            $this->cbIndice =  $this->data[0]->cbIndice;
            $this->cbMarq =  $this->data[0]->cbMarq;
        }
    }

}