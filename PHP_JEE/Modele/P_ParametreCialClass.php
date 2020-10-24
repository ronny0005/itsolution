<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class P_ParametreCialClass Extends Objet{
    //put your code here
    public $db
      ,$P_CreditCaisse
      ,$P_DebitCaisse
      ,$P_ChpAnal
      ,$P_ChpAnalDoc
      ,$P_Conversion
      ,$P_Indispo
      ,$P_Echeances
      ,$P_StockSaisie
      ,$P_PeriodEncours
      ,$P_GestionPlanning
      ,$P_ReportPrixRev
      ,$cbMarq;
    public $table = 'P_ParametreCial';
    public $lien = 'pparametrecial';

    function __construct($db=null) {
        parent::__construct($this->table,'cbMarq',$db);
        $this->data = $this->getApiJson("/getPParametrecial");
            $this->P_CreditCaisse = $this->data->p_CreditCaisse;
            $this->P_DebitCaisse = $this->data->p_DebitCaisse;
            $this->P_ChpAnal = $this->data->p_ChpAnal;
            $this->P_ChpAnalDoc = $this->data->p_ChpAnalDoc;
            $this->P_Conversion = $this->data->p_Conversion;
            $this->P_Indispo = $this->data->p_Indispo;
            $this->P_Echeances = $this->data->p_Echeances;
            $this->P_StockSaisie = $this->data->p_StockSaisie;
            $this->P_PeriodEncours = $this->data->p_PeriodEncours;
            $this->P_GestionPlanning = $this->data->p_GestionPlanning;
            $this->P_ReportPrixRev = $this->data->p_ReportPrixRev;
            $this->cbMarq = $this->data->cbMarq;
    }

    public function __toString() {
        return "";
    }

}