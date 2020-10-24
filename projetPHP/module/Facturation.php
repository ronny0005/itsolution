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
class Facturation {

    public function doAction($action) {
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
        if($protection->Prot_No !=""){
            switch($action) {
                    case 1 : 
                        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_FACTURE!=2))
                            $this->Facture_Vente();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 2 : 
                        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_DEVIS!=2))
                            $this->Devis();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 3 : 
                        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_FACTURE!=2))
                            $this->Facturation_Vente();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 4 : 
                        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_DEVIS!=2))
                            $this->Facturation_Devis();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 5 : 
                        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_BLIVRAISON!=2))
                            $this->Facturation_BonLivraison();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 6 : 
                        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_BLIVRAISON!=2))
                            $this->BonLivraison();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 7 : 
                        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_AVOIR!=2))
                            $this->Facturation_Avoir();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 8 : 
                        if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_AVOIR!=2))
                            $this->Avoir();
                        else
                            header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                        break;
                case 9 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_RETOUR!=2))
                        $this->Facturation_Retour();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 10 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_RETOUR!=2))
                        $this->Retour();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 11 :
                    if($objet->db->flagDataOr==1 && ($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_FACTURE!=2)))
                        $this->Facturation_VenteDevise();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 12 :
                    if($objet->db->flagDataOr==1 && ($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_FACTURE!=2)))
                        $this->VenteDevise();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 13 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_FACTURE!=2))
                        $this->Facturation_Ticket();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 14 :
                    if($protection->PROT_Right==1 || ($protection->PROT_VENTE_COMPTOIR!=2))
                        $this->Ticket();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                    default : 
                            $this->Facture_Vente(); // On décide ce que l'on veut faire		
            }
        } else 
            header('Location: index.php');
    }

    public function Facture_Vente() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function Devis() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function Facturation_Vente() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facturation_Devis() {
        include("pages/Vente/FactureVente.php");
    }
    public function BonLivraison() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facturation_BonLivraison() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    
    public function Avoir() {
        include("pages/Vente/FactureVente.php");
    }
    
    public function Facturation_Avoir() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }

    public function Retour() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facturation_Retour() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function VenteDevise() {
        include("pages/Vente/FactureVenteDevise.php");
    }
    public function Facturation_VenteDevise() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
    public function Ticket() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facturation_Ticket() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture.php");
    }
}
?>