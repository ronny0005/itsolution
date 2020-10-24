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
        $protection = new ProtectionClass("","");
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($protection->Prot_No!=""){
            switch($action) {
                    case 1 :
                        if($protection->protectionListeFacture($_GET["type"]))
                            $this->Facture_Vente();
                        else
                            header('Location: indexMVC_.Newphp?accueil'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 3 :
                        if($protection->protectionListeFacture($_GET["type"]))
                            $this->Facturation_Vente();
                        else
                            header('Location: indexMVC_.Newphp?accueil'); //rechercher un étudiant par domaine d'activité
                        break;
                    default : 
                            $this->Facture_Vente(); // On décide ce que l'on veut faire		
            }
        } else 
            header('Location: accueil');
    }


    public function Facture_Vente() {
        include("module/Menu/SetParamGlobal.php");
        include("controller/listeFactureController.php");
        include("pages/ListeFacture.php");
    }
    public function Facturation_Vente() {
        include("module/Menu/SetParamGlobal.php");
        include("controller/FactureController.php");
        include("pages/Vente/FactureVente.php");
    }
}
?>