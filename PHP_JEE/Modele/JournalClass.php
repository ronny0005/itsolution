<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class JournalClass Extends Objet{
    //put your code here
    public $db,$JO_Num,$JO_Intitule,$CG_Num,$JO_Type,$JO_NumPiece
    ,$JO_Contrepartie,$JO_SaisAnal,$JO_NotCalcTot,$JO_Rappro
    ,$JO_Sommeil,$JO_IFRS,$JO_Reglement
    ,$JO_SuiviTreso,$cbCreateur,$cbModification;
    public $table = 'F_JOURNAUX';
    public $lien = "fjournaux";

    function __construct($id,$db=null) {

        $this->class="fjournaux";
        $this->data = $this->getApiJson("/$id");
        if(sizeof($this->data)>0) {
            $this->JO_Num = $this->data[0]->JO_Num;
            $this->JO_Intitule = stripslashes($this->data[0]->JO_Intitule);
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->JO_Type = $this->data[0]->JO_Type;
            $this->JO_NumPiece = $this->data[0]->JO_NumPiece;
            $this->JO_Contrepartie = stripslashes($this->data[0]->JO_Contrepartie);
            $this->JO_SaisAnal = stripslashes($this->data[0]->JO_SaisAnal);
            $this->JO_NotCalcTot = $this->data[0]->JO_NotCalcTot;
            $this->JO_Rappro = $this->data[0]->JO_Rappro;
            $this->JO_Sommeil = $this->data[0]->JO_Sommeil;
            $this->JO_IFRS = $this->data[0]->JO_IFRS;
            $this->JO_Reglement = $this->data[0]->JO_Reglement;
            $this->JO_SuiviTreso = $this->data[0]->JO_SuiviTreso;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
        }
    }

    public function maj_journal(){
        parent::maj(JO_Intitule, $this->JO_Intitule);
        parent::maj(CG_Num, $this->CG_Num);
        parent::maj(JO_Type, $this->JO_Type);
        parent::maj(JO_NumPiece, $this->JO_NumPiece);
        parent::maj(JO_Contrepartie, $this->JO_Contrepartie);
        parent::maj(JO_SaisAnal, $this->JO_SaisAnal);
        parent::maj(JO_NotCalcTot, $this->JO_NotCalcTot);
        parent::maj(JO_Rappro, $this->JO_Rappro);
        parent::maj(JO_Sommeil, $this->JO_Sommeil);
        parent::maj(JO_IFRS, $this->JO_IFRS);
        parent::maj(JO_Reglement, $this->JO_Reglement);
        parent::maj(JO_SuiviTreso, $this->JO_SuiviTreso);
        parent::maj(cbCreateur, $this->userName);
        parent::maj(cbModification, $this->cbModification);
    }

    public function getJournaux($val){
        return $this->getApiJson("/getJournaux&joSommeil=$val");
    }

    public function getJournauxSaufTotaux(){
        return $this->getApiJson("/getJournauxSaufTotaux");
    }

    public function getJournauxType($type,$sommeil=-1){
        //&joSommeil=$sommeil
        return $this->getApiJson("/getJournauxType&joType=$type");
    }

    function getJournauxSaisieSelect($ouvert,$mois,$journal){
        return $this->getApiJson("/getJournauxSaisieSelect/ouvert=$ouvert&mois=$mois&joNum={$this->formatString($journal)}");
    }

    function getJournauxSaisie($ouvert,$NomMois,$JO_Num,$annee){
            return $this->getApiJson("/getJournauxSaisie/ouvert=$ouvert&NomMois=$NomMois&joNum={$this->formatString($JO_Num)}&annee=$annee");
    }

    public function calculSoldeLettrage($listCbMarq){
        return $this->getApiJson("/calculSoldeLettrage/listCbMarq=$listCbMarq");
    }
    public function getSaisieJournalExercice($JO_Num,$Mois,$Annee,$CT_Num,$dateDebut,$dateFin,$lettrage,$CG_Num){
        return $this->getApiJson("/getSaisieJournalExercice/joNum={$this->formatString($JO_Num)}&mois=$Mois&annee=$Annee&ctNum={$this->formatString($CT_Num)}&dateDebut=$dateDebut&dateFin=$dateFin&lettrage=$lettrage&cgNum={$this->formatString($CG_Num)}");
    }

    public function getTotalJournal($JO_Num,$Mois,$Annee,$sens,$CT_Num,$dateDebut,$dateFin,$lettrage,$CG_Num){
        return $this->getApiJson("/getTotalJournal/joNum={$this->formatString($JO_Num)}&mois=$Mois&annee=$Annee&sens=$sens&ctNum={$this->formatString($CT_Num)}&dateDebut=$dateDebut&dateFin=$dateFin&lettrage=$lettrage&cgNum={$this->formatString($CG_Num)}");
    }

    public function getJournalLastDate($JO_Num,$Mois,$Annee){
        return $this->getApiJson("/getJournalLastDate/joNum={$this->formatString($JO_Num)}&mois=$Mois&annee=$Annee");
    }

    public function getJournalPiece($JO_Num,$Mois,$Annee){
        return $this->getApiJson("/getJournalPiece/joNum={$this->formatString($JO_Num)}&mois=$Mois&annee=$Annee");
    }

    public function getLettrage($CT_Num,$dateDebut,$dateFin,$CG_Num){
        return $this->getApiJson("/getLettrage/ctNum={$this->formatString($CT_Num)}&dateDebut=$dateDebut&dateFin=$dateFin&cgNum={$this->formatString($CG_Num)}");
    }

    public function pointerEcriture($annuler,$listCbMarq,$ecLettrage){
        return $this->getApiJson("/pointerEcriture/annuler=$annuler&listCbMarq=$listCbMarq&ecLettrage=$ecLettrage");
    }

    public function __toString() {
        return "";
    }

}