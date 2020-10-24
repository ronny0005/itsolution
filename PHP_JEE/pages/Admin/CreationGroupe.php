<?php
if(isset($_GET["PROT_No"])){
    $profil = new ProtectionClass("","");
    $profil->connexionProctectionByProtNo($_GET["PROT_No"]);
}

$value=0;
?>
<script src="js/script_creationGroupe.js?d=<?php echo time(); ?>"></script>
<?php
include("module/Menu/BarreMenu.php");
?>
<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Fiche Profil
    </h3>
</section>

<?php if($value==-1) echo "<div class='alert alert-danger'> Le profil {$_POST["profilName"]} existe déjà !</div>"; ?>
<?php if($value>0) echo "<div class='alert alert-success'> Le profil {$_POST["profilName"]} a été crée !</div>"; ?>
<form action="Traitement/Creation.php" method="POST">
    <div class="row card p-3">
        <div class="col-lg-6">
            <label>Nom du profil </label>
            <input type="hidden" name="update" value="<?= (isset($_GET['PROT_No'])) ? 1 : 0 ?>" />
            <input type="hidden" name="acte" value="gestionProfil" />
            <input type="hidden" name="PROT_No" value="<?= (isset($_GET['PROT_No'])) ? $_GET['PROT_No'] : 0 ?>" />
            <input type="text" class="form-control" id="profilName" name="profilName" value="<?= (isset($_GET["PROT_No"])) ? $profil->PROT_User : "" ?>" />
        </div>
        <div class="col-lg-12" style="margin-top: 10px">
            <input type="submit" class="btn btn-primary" value="Valider" id="valider" name="valider">
        </div>
    </div>
</form>

       