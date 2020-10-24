<?php
include("../Modele/DB.php");
include("../Modele/Objet.php");
include("../Modele/ObjetCollector.php");
include("../Modele/ProtectionClass.php");
$nom=$_POST["user"];
$mdp=$_POST["password"];
$protection = new ProtectionClass($nom, $mdp);

if($protection->cbMarq!=null) {
    $isCalendar = $protection->isCalendarUser($protection->Prot_No);
    if($isCalendar ==1)
        $isconnect = $protection->canConnect($protection->Prot_No, $_POST["jour"], $_POST["heure"]);
    else
        $isconnect=1;
    if($protection->cbMarq==null || $isconnect==0){
        if(isset($isCalendar))
            header('Location: ../connexion-2');
        else
            header('Location: ../connexion-1');
    }else{
        session_start();
        $_SESSION["DE_No"] =  0;//$protection->DE_No;
        $_SESSION["DO_Souche"] =  "0";//$protection->CA_Souche;
        $_SESSION["CO_No"] =  0;//$protection->CO_No;
        $_SESSION["CA_No"] =  0;//$protection->CA_No;
        $_SESSION["login"]=$nom;
        $_SESSION["mdp"]=$mdp;
        $_SESSION["id"]=$protection->Prot_No;
        $protection->updateLastLogin();
        header('Location: ../accueil');
    }
}
else
    header('Location: ../connexion-1');
?>

