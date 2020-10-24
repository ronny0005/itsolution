<?php
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/Objet.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/CollaborateurClass.php");
    $objet = new ObjetCollector(); 
}
if($_GET["acte"] =="suppr"){
    $CO_No = $_GET["CO_No"];
    $collaborateurClass = new CollaborateurClass($CO_No);
    $collaborateurClass ->delete();
    header('Location: ../listeCollaborateur-3-'.$CO_No);
}

if($_GET["acte"]=="ajout"){
    $nom = str_replace("'", "''", $_GET["nom"]);
    $prenom = str_replace("'", "''", $_GET["prenom"]);
    $fonction = str_replace("'", "''", $_GET["fonction"]);
    $service = str_replace("'", "''", $_GET["service"]);
    $adresse = str_replace("'", "''", $_GET["adresse"]);
    $complement = str_replace("'", "''", $_GET["complement"]);
    $codePostal = str_replace("'", "''", $_GET["codePostal"]);
    $ville= str_replace("'", "''", $_GET["ville"]);
    $region= str_replace("'", "''", $_GET["region"]);
    $pays= str_replace("'", "''", $_GET["pays"]);
    $email= str_replace("'", "''", $_GET["email"]);
    $telephone= $_GET["telephone"];
    $telecopie= $_GET["telecopie"];
    if(isset($_GET["vendeur"]))$btnVendeur=1;
    else $btnVendeur=0;
    if(isset($_GET["caissier"]))$btnCaissier=1;
    else $btnCaissier=0;
    if(isset($_GET["acheteur"]))$btnAcheteur=1;
    else $btnAcheteur=0;
    if(isset($_GET["controleur"]))$btnControleur=1;
    else $btnControleur=0;
    if(isset($_GET["recouvrement"]))$btnRecouv=1;
    else $btnRecouv=0;
    $collaborateurClass = new CollaborateurClass(0,$objet->db);
    $value = $collaborateurClass->insertCollaborateur($nom,$prenom,$adresse,$complement,$codePostal,$fonction,$ville,$region,$pays,$service,$btnVendeur,$btnCaissier,$btnAcheteur,$telephone,$telecopie,$email,$btnControleur,$btnRecouv,$_SESSION["id"]);
    if($value[0]->CO_No==0){
        echo $value[0]->Message;
    }else{
        echo json_encode($value);
    }
}

if($_GET["acte"]=="modif"){
    $co_no=$_GET["CO_No"];
    $nom = str_replace("'", "''", $_GET["nom"]);
    $prenom = str_replace("'", "''", $_GET["prenom"]);
    $fonction = str_replace("'", "''", $_GET["fonction"]);
    $service = str_replace("'", "''", $_GET["service"]);
    $adresse = str_replace("'", "''", $_GET["adresse"]);
    $complement = str_replace("'", "''", $_GET["complement"]);
    $codePostal = str_replace("'", "''", $_GET["codePostal"]);
    $ville= str_replace("'", "''", $_GET["ville"]);
    $region= str_replace("'", "''", $_GET["region"]);
    $pays= str_replace("'", "''", $_GET["pays"]);
    $email= str_replace("'", "''", $_GET["email"]);
    $telephone= $_GET["telephone"];
    $telecopie= $_GET["telecopie"];
    if(isset($_GET["vendeur"]))$btnVendeur=1;
    else $btnVendeur=0;
    if(isset($_GET["caissier"]))$btnCaissier=1;
    else $btnCaissier=0;
    if(isset($_GET["acheteur"]))$btnAcheteur=1;
    else $btnAcheteur=0;
    if(isset($_GET["controleur"]))$btnControleur=1;
    else $btnControleur=0;
    if(isset($_GET["recouvrement"]))$btnRecouv=1;
    else $btnRecouv=0;
    $collaborateurClass = new CollaborateurClass($co_no);
    $collaborateurClass->majIfUpdate("CO_Nom",$nom,$collaborateurClass->CO_Nom);
    $collaborateurClass->majIfUpdate("CO_Prenom",$prenom,$collaborateurClass->CO_Prenom);
    $collaborateurClass->majIfUpdate("CO_Adresse",$adresse,$collaborateurClass->CO_Adresse);
    $collaborateurClass->majIfUpdate("CO_Complement",$complement,$collaborateurClass->CO_Complement);
    $collaborateurClass->majIfUpdate("CO_CodePostal",$codePostal,$collaborateurClass->CO_CodePostal);
    $collaborateurClass->majIfUpdate("CO_Fonction",$fonction,$collaborateurClass->CO_Fonction);
    $collaborateurClass->majIfUpdate("CO_Ville",$ville,$collaborateurClass->CO_Ville);
    $collaborateurClass->majIfUpdate("CO_CodeRegion",$region,$collaborateurClass->CO_CodeRegion);
    $collaborateurClass->majIfUpdate("CO_Pays",$pays,$collaborateurClass->CO_Pays);
    $collaborateurClass->majIfUpdate("CO_Service",$service,$collaborateurClass->CO_Service);
    $collaborateurClass->majIfUpdate("CO_Vendeur",$btnVendeur,$collaborateurClass->CO_Vendeur);
    $collaborateurClass->majIfUpdate("CO_Caissier",$btnCaissier,$collaborateurClass->CO_Caissier);
    $collaborateurClass->majIfUpdate("CO_Acheteur",$btnAcheteur,$collaborateurClass->CO_Acheteur);
    $collaborateurClass->majIfUpdate("CO_Telephone",$telephone,$collaborateurClass->CO_Telephone);
    $collaborateurClass->majIfUpdate("CO_Telecopie",$telecopie,$collaborateurClass->CO_Telecopie);
    $collaborateurClass->majIfUpdate("CO_Email",$email,$collaborateurClass->CO_EMail);
    $collaborateurClass->majIfUpdate("CO_ChargeRecouvr",$btnControleur,$collaborateurClass->CO_ChargeRecouvr);
    $collaborateurClass->majIfUpdate("CO_Receptionnaire",$btnRecouv,$collaborateurClass->CO_Receptionnaire);
/*    $collaborateurClass->modifCollaborateur($nom,$prenom,$adresse,$complement,$codePostal,$fonction,$ville,$region,$pays
        ,$service,$btnVendeur,$btnCaissier,$btnAcheteur,$telephone,$telecopie,$email,$btnControleur,$btnRecouv
        ,$co_no,$_SESSION["id"]);
*/
    $data = array('CO_No' => $co_no);
    echo json_encode($data);
}
?>
