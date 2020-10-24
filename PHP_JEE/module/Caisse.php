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
class Caisse {

    public function doAction($action) {
        if(isset($_SESSION["DE_No"])){
            switch($action) {
                    case 1 : 
                        $this->Mouvement_caisse(); //rechercher un étudiant par domaine d'activité 
                        break;
                    default : 
                        $this->Mouvement_caisse(); // On décide ce que l'on veut faire		
            }
        }else header('Location: accueil');
    }

    public function Mouvement_caisse() {
        include("controller/MouvementCaisseController.php");
        include("pages/Caisse/Mouvement_Caisse.php");
    }
   
}
?>
