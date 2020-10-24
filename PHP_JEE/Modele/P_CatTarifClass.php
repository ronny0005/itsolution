<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class P_CatTarifClass Extends Objet{
    //put your code here
    public $db
        ,$CT_Intitule
		,$CT_PrixTTC
		,$cbIndice
		,$cbMarq;
    public $lien = 'pcattarif';
    public $table = 'P_CatTarif';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'cbMarq',$db);
        $this->data = $this->getApiJson("/cbMarq=$id");
        if(sizeof($this->data)>0) {
            $this->CT_Intitule = $this->data[0]->CT_Intitule;
            $this->CT_PrixTTC = $this->data[0]->CT_PrixTTC;
            $this->cbIndice = $this->data[0]->cbIndice;
            $this->cbMarq = $this->data[0]->cbMarq ;
        }
    }

    public function __toString() {
        return "";
    }

}