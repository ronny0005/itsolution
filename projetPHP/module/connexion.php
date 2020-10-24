<?php
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/ProtectionClass.php");

if(!isset($_POST["user"]))
    header('Location: ../index.php?code=1');

$nom=$_POST["user"];
$mdp=$_POST["password"];
$objet = new ObjetCollector();
$protection = new ProtectionClass($nom, $mdp,$objet->db);
$rows = $protection->connectSage2();

$isconnect=0;
if($rows!=null) {
    $isCalendar = $protection->isCalendarUser($protection->Prot_No);
    if($isCalendar ==1)
        $isconnect = $protection->canConnect($protection->Prot_No, $_POST["jour"], $_POST["heure"]);
    else
        $isconnect=1;
}
if($rows==null || $isconnect==0){
    if(isset($isCalendar))
        header('Location: ../index.php?code=2');
    else
        header('Location: ../index.php?code=1');
}else{
    session_start();
    $_SESSION["DE_No"] =  $rows[0]->DE_No;
    $_SESSION["DO_Souche"] =  $rows[0]->CA_Souche;
    $_SESSION["CO_No"] =  $rows[0]->CO_No;
    $_SESSION["CA_No"] =  $rows[0]->CA_No;
    $_SESSION["login"]=$nom;
    $_SESSION["mdp"]=$mdp;
    $_SESSION["id"]=$rows[0]->PROT_No;
    $uid= $rows[0]->PROT_No;
    //mise a jour date de connexion
    $result1=$objet->db->requete($objet->UpdateLastLogin($uid));
    header('Location: ../indexMVC.php?action=1&module=1');
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

