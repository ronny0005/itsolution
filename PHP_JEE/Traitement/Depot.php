<?php
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/ObjetCollector.php");
    $objet = new ObjetCollector(); 
}
?>
