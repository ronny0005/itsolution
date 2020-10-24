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
class Admin {
    public $objet ;
    public $protection ;

    public function __construct()
    {
        $this->protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    }

    public function doAction($action) {
        if($this->protection->Prot_No!=null && isset($_SESSION)){
        
        switch($action) {
            case 1 : 
                if($this->protection->PROT_Right==1) $this->Liste_User(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 2 : 
                if($this->protection->PROT_Right==1) $this->Liste_Groupe(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 3 : 
                if($this->protection->PROT_Right==1) $this->Nouveau_Groupe(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 4 : 
                if($this->protection->PROT_Right==1) $this->Nouvel_User(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 5 : 
                if($this->protection->PROT_Right==1) $this->Liste_Droit(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 6 :
                if($this->protection->PROT_Right==1) $this->Code_Client(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 7 :
                if($this->protection->PROT_Right==1) $this->Envoi_Mail(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 8 :
                if($this->protection->PROT_Right==1) $this->Envoi_SMS(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 9 :
                if($this->protection->PROT_Right==1) $this->Compte_SMS(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 10 :
                if($this->protection->PROT_Right==1) $this->Config_acces(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 11 :
                if($this->protection->PROT_Right==1) $this->Config_profilUtilisateur(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 12 :
                if($this->protection->PROT_Right==1) $this->Deconnexion_totale(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 13 :
                if($this->protection->PROT_Right==1) $this->Fusion_article(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 14 :
                if($this->protection->PROT_Right==1) $this->Fusion_client(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            case 15 :
                if($this->protection->PROT_Right==1) $this->Calendrier_connexion(); else header('Location: indexMVC.php?module=1&action=1');
                break;
            default :
                if($this->protection->PROT_Right==1) $this->Liste_User(); else header('Location: indexMVC.php?module=1&action=1');
        }

        } else 
            header('Location: accueil');
    }

    public function Nouvel_User() {
        include("pages/Admin/CreationUser.php");
    }
    
    public function Nouveau_Groupe() {
        include("pages/Admin/CreationGroupe.php");
    }

    public function Deconnexion_totale(){
        $this->protection->deconnexionTotale();
        header("location:indexMVC.php?action=1&module=1");
    }

    public function Liste_User() {
        include("pages/Admin/Liste_User.php");
    }
    
    public function Liste_Groupe() {
        include("pages/Admin/Liste_Groupe.php");
    }
    
    public function Liste_Droit() {
        include("pages/Admin/Liste_Droit.php");
    }

    public function Code_Client() {
        include("pages/Admin/CodeClient.php");
    }

    public function Envoi_Mail() {
        include("pages/Admin/Envoi_Mail.php");
    }

    public function Envoi_SMS() {
        include("pages/Admin/Envoi_Mail.php");
    }

    public function Config_acces() {
        include("pages/Admin/Config_Acces.php");
    }

    public function compte_SMS() {
        include("pages/Admin/Compte_SMS.php");
    }
    public function Config_profilUtilisateur() {
        include("pages/Admin/Config_profilUtilisateur.php");
    }
    public function Fusion_client() {
        include("pages/Admin/Fusion_client.php");
    }
    public function Fusion_article() {
        include("pages/Admin/Fusion_article.php");
    }
    public function Calendrier_connexion() {
        $action = 0;
        if (isset($_POST["user"]))
        $this->protection->deleteZ_Calendar_user($_POST["PROT_NoUser"]);
        for($i=1;$i<8;$i++) {
            $jour = $this->jour($i);

            if (isset($_POST["check$jour"])) {
                $heureDebut = mb_split(":", $_POST["heureDebut$jour"])[0];
                $minDebut = mb_split(":", $_POST["heureDebut$jour"])[1];
                $heureFin = mb_split(":", $_POST["heureFin$jour"])[0];
                $minFin = mb_split(":", $_POST["heureFin$jour"])[1];
                $row = $this->protection->getZ_Calendar_user($_POST["PROT_NoUser"],$i);
                if (sizeof($row) == 0)
                    $this->protection->insertIntoZ_Calendar_user($_POST["PROT_NoUser"], $i, $i, $heureDebut, $minDebut, $heureFin, $minFin);
                else
                    $this->protection->majZ_Calendar_user($_POST["PROT_NoUser"], $i, $i, $heureDebut, $minDebut, $heureFin, $minFin);
                $action = 1;
            }
        }
        include("pages/Admin/Calendrier_connexion.php");
    }

    public function jour($value){
        switch($value){
            case 1:
                return "Lundi";
                break;
            case 2:
                return "Mardi";
                break;
            case 3:
                return "Mercredi";
                break;
            case 4:
                return "Jeudi";
                break;
            case 5:
                return "Vendredi";
                break;
            case 6:
                return "Samedi";
                break;
            case 7:
                return "Dimanche";
                break;
        }
    }



}	
?>
