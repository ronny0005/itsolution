<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DepotCaisseClass Extends Objet{
    //put your code here
    public $db,$DE_No,$CA_No;
    public $table = 'Z_DEPOTCAISSE';
    public $lien ="zdepotcaisse";

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'DE_No',$db);
        if(sizeof($this->data)>0) {
            $this->list = $this->data;
        }
    }

    public function maj_depotcaisse(){
//        parent::maj(DE_Intitule, $this->DE_Intitule,'DE_No',$this->DE_No);
//        parent::maj(DE_Complement, $this->DE_Complement,'DE_No',$this->DE_No);
    }

    public function getDepotCaisseSelect($caisseVal){
        return $this->getApiJson("/getDepotCaisseSelect&caNo=$caisseVal");
    }

    public function __toString() {
        return "";
    }

}