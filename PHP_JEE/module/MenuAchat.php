<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuAchat
 *
 * @author Test
 */
class MenuAchat {
    
     public function doAction($action) {
         $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($protection->Prot_No!=null && isset($_SESSION)){
            switch($action) {
                case 1 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_FACTURE!=2)) $this->Facture_Achat();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 2 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_FACTURE!=2)) $this->Facturation_Achat();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 3 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)) $this->Facture_PreparationCommande();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 4 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)) $this->PreparationCommande();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 5 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)) $this->Facture_AchatPreparationCommande();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 6 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_PREPARATION_COMMANDE!=2)) $this->AchatPreparationCommande();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 7 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_RETOUR!=2)) $this->Facture_AchatRetour();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 8 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_ACHAT_RETOUR!=2)) $this->AchatRetour();  else header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                    default :
                            $this->Facturation_Achat(); // On décide ce que l'on veut faire		
            }
        } else 
            header('Location: accueil');
    }

    public function Facturation_Achat() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facture_Achat() {
        include("pages/Vente/FactureVente.php");
    }
    public function PreparationCommande() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facture_PreparationCommande() {
        include("pages/Vente/FactureVente.php");
    }
    public function AchatPreparationCommande() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facture_AchatPreparationCommande() {
        include("pages/Vente/FactureVente.php");
    }
    public function AchatRetour() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facture_AchatRetour() {
        include("pages/Vente/FactureVente.php");
    }
}
