<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CaisseClass Extends Objet{
    //put your code here
    public $db,$CA_No,$CA_Intitule,$DE_No,$CO_No,$CO_NoCaissier,$CT_Num,$JO_Num,$CA_Souche,$cbCreateur,$cbMarq;
    public $table = 'F_CAISSE';
    public $lien ="fcaisse";
    function __construct($id)
    {
        $this->data = $this->getApiJson("/$id");
        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->CA_No = $this->data[0]->CA_No;
            $this->CA_Intitule = stripslashes($this->data[0]->CA_Intitule);
            $this->DE_No = $this->data[0]->DE_No;
            $this->CO_No = $this->data[0]->CO_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->CT_Num = stripslashes($this->data[0]->CT_Num);
            $this->JO_Num = stripslashes($this->data[0]->JO_Num);
            $this->CA_Souche = $this->data[0]->CA_Souche;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbMarq = $this->data[0]->cbMarq;

        }
    }

    public function clotureCaisse($dateCloture,$caisseDebut,$caisseFin,$ProtNo,$typeCloture)
    {
        $this->getApiExecute("/clotureCaisse/dateCloture=$dateCloture&caisseDebut=$caisseDebut&caisseFin=$caisseFin&protNo=$ProtNo&typeCloture=$typeCloture");
    }

    public function getCaNum(){
        return $this->getApiJson("/getCaNum&caNo={$this->CA_No}");
    }

    public function insertDepotCaisse($DE_No){
		$this->getApiJson("/insertDepotCaisse/caNo={$this->CA_No}&deNo={$DE_No}");
    }

    public function allCaisse(){
        return $this->getApiJson("/all");
    }


    public function getCaisseDepot($prot_no){
        return $this->getApiJson("/getCaisseDepot/$prot_no");
   }

    public function maj_caisse(){
        parent::maj('CA_Intitule', $this->CA_Intitule);
        parent::maj('DE_No', $this->DE_No);
        parent::maj('CO_No', $this->CO_No);
        parent::maj('CO_NoCaissier', $this->CO_NoCaissier);
        parent::maj('CT_Num', $this->CT_Num);
        parent::maj('JO_Num', $this->JO_Num);
        parent::maj('CA_Souche', $this->CA_Souche);
    }

    public function insertCaisse($codeDepot){
		 $this->getApiJson("/insertCaisse/caIntitule={$this->formatString($this->CA_Intitule)}&coNoCaissier={$this->CO_NoCaissier}&joNum={$this->formatString($this->JO_Num)}&cbCreateur=".$this->formatString($_SESSION["id"])."&codeDepot=$codeDepot");
    }

    public function deleteCaisse()
    {
        $this->getApiJson("/deleteCaisse/caNo={$this->CA_No}");
    }

    public function supprDepotCaisse()
    {
        $this->getApiJson("/supprDepotCaisse&caNo={$this->CA_No}");
    }

    public function listeCaisseShort(){
		return $this->getApiJson("/listeCaisseShort");
    }

public function getCaissierByCaisse($ca_no)
{
	return $this->getApiJson("/getCaissierByCaisse&caNo={$ca_no}");
}
    public function __toString() {
        return "";
    }

}