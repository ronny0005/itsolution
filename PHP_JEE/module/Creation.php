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
class Creation {

    public function doAction($action) {
        $objet = new ObjetCollector();
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($protection->Prot_No!=null && isset($_SESSION)){
            switch($action) {
                case 1 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_ARTICLE!=2)) $this->Nouvel_Article();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 2 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Nouvel_Client();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 3 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_ARTICLE!=2)) $this->Liste_Article(); else header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 4 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Liste_Client();  else header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 5 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_FAMILLE!=2)) $this->Liste_Catalogue();  else header('Location: accueil'); //rechercher un étudiant par domaine d'activité
                    break;
                case 6 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_FAMILLE!=2)) $this->Liste_Famille();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 7 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_FAMILLE!=2)) $this->Nouvel_Famille();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 8 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Liste_Fournisseur();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 9 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Nouveau_Fournisseur();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 10 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DEPOT!=2)) $this->Liste_Depot();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 11 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_DEPOT!=2)) $this->Nouveau_Depot();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 12 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)) $this->Liste_Collaborateur();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 13 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)) $this->Nouveau_Collaborateur();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 14 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)) $this->Liste_Caisse();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 15 : 
                    if($protection->PROT_Right==1 || ($protection->PROT_COLLABORATEUR!=2)) $this->Nouvelle_Caisse();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 16 :
                    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Liste_Salarie();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 17 :
                    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Nouveau_Salarie();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 18 :
                    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Liste_Remise();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                case 19 :
                    if($protection->PROT_Right==1 || ($protection->PROT_CLIENT!=2)) $this->Nouveau_Remise();  else header('Location: accueil');//rechercher un étudiant par domaine d'activité
                    break;
                default :
                    $this->Liste_Article(); // On décide ce que l'on veut faire		
            }

        } else 
            header('Location: accueil');
    }

    public function Nouvel_Article() {
        include("module/Menu/SetParamGlobal.php");
        include("controller/structure/ArticleController.php");
        include("pages/Structure/CreationArticle.php");
    }
    
    public function Nouveau_Fournisseur() {
        include("pages/Structure/CreationClient.php");
    }
    
    public function Nouvel_Client() {
        include("pages/Structure/CreationClient.php");
    }
    
    public function Liste_Article() {
        include("module/Menu/SetParamGlobal.php");
        include("controller/structure/ListeArticleController.php");
        include("pages/Structure/Liste_Article.php");
    }
    
    public function Liste_Client() {
        include("pages/Structure/Liste_Client.php");
    }
    
    public function Liste_Fournisseur() {
        include("pages/Structure/Liste_Client.php");
    }
    
    public function Liste_Catalogue() {
        include("pages/Structure/Gestion_Catalogue.php");
    }
    
    public function Liste_Famille() {
        include("pages/Structure/Gestion_Famille.php");
    }
    
    public function Liste_Collaborateur() {
        include("pages/Structure/Liste_Collaborateur.php");
    }
    
    public function Nouvel_Famille() {
        include("pages/Structure/CreationFamille.php");
    }
    
    public function Liste_Depot() {
        include("pages/Structure/Liste_depot.php");
    }
    
    public function Nouveau_Depot() {
        include("pages/Structure/CreationDepot.php");
    }
    
    
    public function Liste_Caisse() {
        include("pages/Structure/Liste_Caisse.php");
    }
    
    public function Nouvelle_Caisse() {
        include("pages/Structure/CreationCaisse.php");
    }
    
    public function Nouveau_Collaborateur() {
        include("pages/Structure/CreationCollaborateur.php");
    }

    public function Nouveau_Salarie() {
        include("pages/Structure/CreationClient.php");
    }

    public function Liste_Salarie() {
        include("pages/Structure/Liste_Client.php");
    }

    public function Nouveau_Remise() {
        include("pages/Structure/CreationRemise.php");
    }

    public function Liste_Remise() {
        include("pages/Structure/Liste_Remise.php");
    }

}	
?>
