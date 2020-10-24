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
class Menu {
    public function doAction($action) {
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($protection->Prot_No!=null){
            switch($action) {
                case 1 :
                    $this->Accueil();
                    break;
                case 2 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_REGLEMENT!=2)) $this->Recouvrement(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 3 :
                    if($protection->PROT_Right==1 || ($protection->PROT_SAISIE_INVENTAIRE!=2)) $this->Saisi_inventaire(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 4 :
                    if($protection->PROT_Right==1 || ($protection->PROT_SAISIE_REGLEMENT_FOURNISSEUR!=2)) $this->Recouvrement(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 5 :
                    if($protection->PROT_Right==1 || ($protection->PROT_GENERATION_RGLT_CLIENT!=2)) $this->Recouvrement(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 6 :
                    $this->Mot_de_passe();
                    break;
                case 7 :
                    if($protection->PROT_Right==1)
                        $this->createReport(); else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                default :
                    $this->Accueil(); // On décide ce que l'on veut faire
            }
        } else
            header('Location: connexion');
    }

    public function Accueil() {
        include("pages/Accueil.php");
    }

    public function createReport() {
        include("pages/createReport.php");
    }
    
    public function Recouvrement() {
        include("pages/Recouvrement.php");
    }

    public function Saisi_inventaire() {
        include("pages/saisie_inventaire.php");
    }

    public function Mot_de_passe() {
        include("pages/mot_de_passe.php");
    }
}	
?>