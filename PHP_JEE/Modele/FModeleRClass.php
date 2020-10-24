<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class FModeleRClass Extends Objet{
    //put your code here
    public $db,$MR_No
    ,$MR_Intitule
    ,$cbProt
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification
    ,$cbReplication
    ,$cbFlag;
    public $table = 'F_MODELER';
    public $lien ="fmodeler";

    function __construct($id)
    {
        $this->data = $this->getApiJson("/mrNo=$id");
        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->MR_No =  $this->data[0]->MR_No;
            $this->MR_Intitule =  $this->data[0]->MR_Intitule;
            $this->cbMR_Intitule =  $this->data[0]->cbMR_Intitule;
            $this->cbProt =  $this->data[0]->cbProt;
            $this->cbMarq =  $this->data[0]->cbMarq;
            $this->cbCreateur =  $this->data[0]->cbCreateur;
            $this->cbModification =  $this->data[0]->cbModification;
            $this->cbReplication =  $this->data[0]->cbReplication;
            $this->cbFlag =  $this->data[0]->cbFlag;

        }
    }

    public function __toString() {
        return "";
    }

}