<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class P_CatComptaClass Extends Objet{
    //put your code here
    public $db
        ,$idcompta
		,$marks;
    public $lien = 'pcatcompta';
    public $table = 'P_CatCompta';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'cbMarq',$db);
        $this->data = $this->getApiJson("/cbMarq=$id");
        if(sizeof($this->data)>0) {
            $this->idcompta = $this->data[0]->idcompta;
            $this->marks = $this->data[0]->marks;
        }
    }
    public function getCatComptaVente(){
        return $this->getApiJson("/getCatComptaVente");
    }

    public function getCatComptaAchat(){
        return $this->getApiJson("/getCatComptaAchat");
    }

    public function __toString() {
        return "";
    }

}