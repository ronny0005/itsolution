<?php
    $co_no = 0;
    $nom = "";
    $prenom = "";
    $fonction = "";
    $service = "";
    $adresse = "";
    $complement = "";
    $codePostal = "";
    $ville= "";
    $region= "";
    $pays= "";
    $email= "";
    $tel= "";
    $telecopie= "";
    $btnVendeur= "";
    $btnCaissier= "";
    $btnAcheteur = "";
    $btnControleur = "";
    $btnRecouv = "";
    $protected = 0;
    $flagNouveau = 0;
    $flagProtected = 0;
    $flagSuppr = 0;
    $objet = new ObjetCollector();
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("collaborateur");
    $flagSuppr = $protection->SupprType("collaborateur");
    $flagNouveau = $protection->NouveauType("collaborateur");

    if(isset($_GET["CO_No"])){
        $collaborateurClass = new CollaborateurClass($_GET["CO_No"]);
            $co_no = $collaborateurClass->CO_No;
            $nom = $collaborateurClass->CO_Nom;
            $prenom = $collaborateurClass->CO_Prenom;
            $fonction = $collaborateurClass->CO_Fonction;
            $service = $collaborateurClass->CO_Service;
            $adresse = $collaborateurClass->CO_Adresse;
            $complement = $collaborateurClass->CO_Complement;
            $codePostal = $collaborateurClass->CO_CodePostal;
            $ville= $collaborateurClass->CO_Ville;
            $region= $collaborateurClass->CO_CodeRegion;
            $pays= $collaborateurClass->CO_Pays;
            $email= $collaborateurClass->CO_EMail;
            $tel= $collaborateurClass->CO_Telephone;
            $telecopie= $collaborateurClass->CO_Telecopie;
            $btnVendeur= $collaborateurClass->CO_Vendeur;
            $btnCaissier= $collaborateurClass->CO_Caissier;
            $btnAcheteur = $collaborateurClass->CO_Acheteur;
            $btnControleur = $collaborateurClass->CO_Receptionnaire;
            $btnRecouv = $collaborateurClass->CO_ChargeRecouvr;
    }
?>
<script src="js/script_creationCollaborateur.js?d=<?= time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>

<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Fiche collaborateur
    </h3>
</section>
        <form action="ficheCollaborateur" class="card p-3" method="GET" name="formCollab" id="formCollab">
            <div class="row">
        <div class="col-lg-3" >
            <label>Nom</label>
            <input type="hidden" name="CO_No" id="CO_No" value="<?= $co_no; ?>" />
                <input type="text" class="form-control" value="<?php echo $nom; ?>" name="nom" id="nom" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-lg-3">
            <label>Prénom</label>
                <input type="text" class="form-control" value="<?php echo $prenom; ?>" name="prenom" id="prenom" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-lg-6">
            <label>Fonction</label>
            <input type="text"  class="form-control" value="<?php echo $fonction; ?>" name="fonction" id="fonction" <?php if(!$flagProtected) echo "disabled"; ?>/>
            
        </div>
        <div class="col-lg-4">
            <label>Service</label>
                <input type="text" class="form-control" value="<?php echo $service; ?>" name="service" id="service" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        
        <div class="col-lg-4">
            <label>Adresse</label>
            <input type="text"  class="form-control" value="<?php echo $adresse; ?>" name="adresse" id="adresse" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-lg-4">    <label>Compl.</label>
            <input type="text" class="form-control" value="<?php echo $complement; ?>" name="complement" id="complement" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-lg-2">
            <label>C.P.</label>
                <input type="text"  class="form-control" value="<?php echo $codePostal; ?>" name="codePostal" id="codePostal" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-lg-2">
            <label>Ville</label>
            <input type="text" class="form-control" value="<?php echo $ville; ?>" name="ville" id="ville" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
            
        <div class="col-lg-2">
            <label>Région</label>
            <input type="text"  class="form-control" value="<?php echo $region; ?>" name="region" id="region" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
            
        <div class="col-lg-2">
            <label>Pays</label>
            <input type="text" class="form-control" value="<?php echo $pays; ?>" name="pays" id="pays" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-lg-4">
            <label>Email</label>
            <input type="text"  class="form-control" value="<?php echo $email; ?>" name="email" id="email" <?php if(!$flagProtected) echo "disabled"; ?>/>
            
        </div>
        <div class="col-lg-3">
            <label>Teléphone</label>
            <input type="text" class="form-control" value="<?php echo $tel; ?>" name="telephone" id="telephone" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-lg-2">
            <label>Télécopie</label>
            <input type="text"  class="form-control" value="<?php echo $telecopie; ?>" name="telecopie" id="telecopie" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-1 mt-4">
            <label>Vendeur</label>
            <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnVendeur==1) echo " checked "; ?> name="vendeur" id="vendeur" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-1 mt-4">
            <label>Caissier</label>
            <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnCaissier==1) echo " checked "; ?> name="caissier" id="caissier" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-1 mt-4">
            <label>Acheteur</label>
            <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnAcheteur==1) echo " checked "; ?> name="acheteur" id="acheteur" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-2  mt-4">
            <label>Controleur</label>
            <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnControleur==1) echo " checked "; ?> name="controleur" id="controleur" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-lg-2 mt-4">
            <label>Chrg. Recouvr.</label>
            <input type="checkbox" style="margin: auto" class="checkbox" <?php if($btnRecouv==1) echo " checked "; ?> name="recouvrement" id="recouvrement" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-12 mt-2">
            <input type="button" style="width:100%" class="btn btn-primary" value="Valider" name="valider" id="valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        </form>