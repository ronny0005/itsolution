<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author Test
 */
class Mouvement {

    public function doAction($action) {
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($protection->Prot_No!=null && isset($_SESSION)){
            switch($action) {
                case 1 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->Liste_Mouvement();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 3 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ENTREE!=2)) $this->Liste_Mouvement();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 4 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_SORTIE!=2)) $this->Liste_Mouvement();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 5 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->Mouvement_Stock();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 7 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ENTREE!=2)) $this->Mouvement_Stock();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 8 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_SORTIE!=2)) $this->Mouvement_Stock(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 9 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DEPRECIATION_STOCK!=2)) $this->Liste_Mouvement();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 10 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_INTERNE_2!=2)) $this->saisie_mvtTrsft_detail();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 11 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->Liste_Mouvement();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 12 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->Mouvement_Stock();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 13 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->Liste_Mouvement();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 14 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->Mouvement_Stock();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                default :
                    $this->Mouvement_Transfert(); // On décide ce que l'on veut faire		
            }
        } else 
            header('Location: accueil');

    }


    public function Liste_Mouvement() {
        include("module/Menu/SetParamGlobal.php");
        include("controller/listeFactureController.php");
        include("pages/ListeFacture.php");
    }

    public function Mouvement_Stock() {
        include("module/Menu/SetParamGlobal.php");
        include("controller/FactureController.php");
        include("pages/Stock/Mouvement.php");
    }

    public function saisie_mvtTrsft_detail() {
        include("pages/Stock/Mouvement_detail.php");
    }

}
?>
