<?php
    session_start();
    include("../Modele/DB.php");
    include("../Modele/Objet.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/DocEnteteClass.php");

if($_GET["acte"] =="transBLFacture"){
    $docEntete = new DocEnteteClass(0);
    $docEntete->transBLFacture($_GET["cbMarq"],$_GET["conserv_copie"], $_GET["type_trans"],$_GET["reference"],$_GET["date"],$_SESSION["id"]);
}


?>