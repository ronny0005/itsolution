<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DepotUserClass Extends Objet{
    //put your code here
    public $db,$DE_No,$Prot_No,$Is_Principal;
    public $table = 'Z_DEPOTUSER';
    public $lien ="zdepotuser";
    function __construct() {

    }

    public function __toString() {
        return "";
    }

    public function alldepotShortDetail(){
        $query = "SELECT DE_No,DE_Intitule,DE_Ville,DE_CodePostal,cbModification,1 as IsPrincipal 
                    FROM F_DEPOT";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getDepotUser($Prot_No){
        return $this->getApiJson("/user&protNo=$Prot_No");
    }

    public function getPrincipalDepot($Prot_No){
        return $this->getApiJson("/getPrincipalDepot&protNo=$Prot_No");
    }

}