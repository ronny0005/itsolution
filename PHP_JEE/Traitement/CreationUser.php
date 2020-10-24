<?php
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
session_start();
$objet = new ObjetCollector();
include("../Modele/Objet.php");
include("../Modele/ArticleClass.php");
include("../Modele/FamilleClass.php");
include("../Modele/ComptetClass.php");
include("../Modele/DepotClass.php");
include("../Modele/CaisseClass.php");
include("../Modele/CatTarifClass.php");
include("../Modele/F_TarifClass.php");
include("../Modele/F_ArtClientClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/F_CatalogueClass.php");

    if(strcmp($_POST["acte"],"actionUser") == 0){

        $protectionUser = new ProtectionClass("","");
        $protectionUser->connexionProctectionByProtNo($_POST["id"]);
        $protectionUser->PROT_User = $_POST["username"];
        $protectionUser->PROT_Description = $_POST["description"];
        $protectionUser->PROT_Pwd = $_POST["password"];
        $protectionUser->PROT_Email = $_POST["email"];
        $protectionUser->PROT_Right = $_POST["groupeid"];
        $protectionUser->PROT_PwdStatus = $_POST["changepass"];

        $protectionUser->PROT_UserProfil = (isset($_POST["profiluser"])) ? $_POST["profiluser"] : 0;
        $depot = (isset($_POST["depot"])) ? $_POST["depot"] : 0;
        $depotprincipal = (isset($_POST["depotprincipal"])) ? $_POST["depotprincipal"] : 0;
        if($_POST["id"]!="")
            $protectionUser->majProtectioncial($depot,$depotprincipal);
        else {
            $protectionUser->ajoutUser($_POST["securiteAdmin"], $depot, $depotprincipal);
            die();
        }
        header("Location: ../utilisateur");
    }