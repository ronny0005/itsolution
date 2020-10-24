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
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
        if($protection->Prot_No!=""){
            switch($action) {
                case 1 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->liste_Mouvement_Transfert();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 3 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ENTREE!=2)) $this->Mouvement_entree();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 4 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_SORTIE!=2)) $this->Mouvement_sortie();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 5 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->saisie_mvtTrsft();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 7 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ENTREE!=2)) $this->saisie_mvtEntree();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 8 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_SORTIE!=2)) $this->saisie_mvtSortie(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 9 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DEPRECIATION_STOCK!=2)) $this->liste_Mouvement_Transfert_details();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 10 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_INTERNE_2!=2)) $this->saisie_mvtTrsft_detail();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 11 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->liste_Mouvement_Transfert_confirmation();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 12 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->saisie_Transfert_confirmation();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 13 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->confirmation_transfert();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 14 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_STOCK!=2)) $this->fiche_confirmation_transfert();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                default :
                    $this->Mouvement_Transfert(); // On décide ce que l'on veut faire		
            }
        } else 
            header('Location: index.php');

    }

    public function liste_Mouvement_Transfert() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function liste_Mouvement_Transfert_confirmation() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function liste_Mouvement_Transfert_details() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function Mouvement_entree() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function Mouvement_sortie() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function saisie_mvtTrsft() {
        include("pages/Stock/Mouvement.php");
    }
    public function saisie_Transfert_confirmation() {
        include("pages/Stock/Mouvement.php");
    }
    public function saisie_mvtEntree() {
        include("pages/Stock/Mouvement.php");
    }
    public function saisie_mvtSortie() {
        include("pages/Stock/Mouvement.php");
    }
    public function fiche_confirmation_transfert() {
        include("pages/Stock/Mouvement.php");
    }

    public function saisie_mvtTrsft_detail() {
        include("pages/Stock/Mouvement_detail.php");
    }
    public function confirmation_transfert(){
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
//        include("pages/Stock/Confirmation_transfert.php");
    }

}
?>
