<?php
    $depot = 0;
    $intitule = "";
    $adresse = "";
    $complement = "";
    $codePostal = "";
    $ville= "";
    $contact= "";
    $principal= "";
    $caisse= "";
    $region= "";
    $pays= "";
    $email= "";
    $tel= "";
    $telecopie= "";
    $protected = 0;
    $flagNouveau = 0;
    $flagProtected = 0;
    $flagSuppr = 0;
    $soucheachat=-1;
    $souchevente=-1;
    $soucheinterne=-1;
    $codedepot = "";
    $affaire = "";
    $objet = new ObjetCollector();
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("depot");
    $flagSuppr = $protection->SupprType("depot");
    $flagNouveau = $protection->NouveauType("depot");

if(isset($_GET["DE_No"])){
    $depotItem = new DepotClass($_GET["DE_No"]);
    $depot = $depotItem->DE_No;
    $intitule = $depotItem->DE_Intitule;
    $adresse = $depotItem->DE_Adresse;
    $complement = $depotItem->DE_Complement;
    $codePostal = $depotItem->DE_CodePostal;
    $ville= $depotItem->DE_Ville;
    $contact= $depotItem->DE_Contact;
    $principal= $depotItem->DE_Principal;
    $caisse= $depotItem->CA_No;
    $region= $depotItem->DE_Region;
    $pays= $depotItem->DE_Pays;
    $email= $depotItem->DE_EMail;
    $tel= $depotItem->DE_Telephone;
    $telecopie= $depotItem->DE_Telecopie;
    $affaire= $depotItem->CA_Num;
    $soucheachat= $depotItem->CA_SoucheAchat;
    $souchevente= $depotItem->CA_SoucheVente;
    $soucheinterne= $depotItem->CA_SoucheStock;
    $codedepot = $depotItem->DE_Code;
    $affaire = $depotItem->CA_Num;
}
?>
<script src="js/script_creationDepot.js?d=<?php echo time(); ?>"></script>

<?php
include("module/Menu/BarreMenu.php");
?>
<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Fiche depot
    </h3>
</section>

<form id="formDepot" class="card p-3 formDepot" action="ficheDepot" method="GET">
    <input type="hidden" name="DE_No" id="DE_No" value="<?= (isset($_GET["DE_No"])) ? $_GET["DE_No"] : "0" ?>" />
<fieldset class=" entete">
<legend class="entete ">Informations</legend>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6" >
            <label> Intitul&eacute; : </label>
                <input maxlength="35" value="<?= $intitule; ?>" type="text" name="intitule" class="form-control" id="intitule" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6" >
            <label> Adresse : </label>
                <input maxlength="17" value="<?= $adresse; ?>" type="text" onkeyup="this.value=this.value.replace(' ','')" name="adresse" class="form-control" id="adresse" placeholder="Adresse" <?php if(!$flagProtected) echo "disabled"; ?> />
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6" >
            <label> Complément : </label>
            <input name="complement" type="text" class="form-control" id="complement" placeholder="Complément" value="<?= $complement; ?>" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-6 col-md-3 col-lg-2" >
            <label> C.P. : </label>
            <input type="text" name="cp" class="form-control" name="cp" placeholder="C.P." id="cp" value="<?= $codePostal; ?>" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-6 col-md-3 col-lg-2" >
            <label> Région : </label>
            <input name="region"  type="text" class="form-control" id="region" placeholder="Région" value="<?= $region; ?>"  <?php if(!$flagProtected) echo "disabled"; ?> />
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-2" >
            <label> Pays : </label>
            <input value="<?php echo $pays; ?>" name="pays" type="text" class="form-control" id="tel" placeholder="Pays" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-2" >
            <label> Ville : </label>
            <input type="text" class="form-control" name="ville" id="cat_compta" placeholder="Ville" value="<?php echo $ville; ?>" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class=" col-sm-6 col-md-6 col-lg-2" >
            <label> Caisse : </label>
        <select class="form-control" id="caisse" name="caisse" <?php if(!$flagProtected) echo "disabled"; ?>>
        <option value="0" <?php if(0==$caisse) echo " selected"; ?>></option>
                <?php
                    $caisseClass = new CaisseClass(0);
                    $rows = $caisseClass->all();
                    foreach($rows as $row){
                        echo "<option value='{$row->CA_No}'";
                        if($row->CA_No == $caisse) echo " selected";
                        echo ">{$row->CA_Intitule}</option>";
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-2" >
            <label> Code depot : </label>
            <input value="<?php echo $codedepot; ?>" name="code_depot" type="text" class="form-control" id="code_depot" placeholder="Code dépôt" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-2" >
            <label> Téléphone : </label>
            <input name="tel" type="text" value="<?php echo $tel; ?>" class="form-control" id="tel" placeholder="Tel." <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>        
        <div class="col-6 col-sm-6 col-md-4 col-lg-2" >
            <label> Affaire : </label>
            <select class="form-control" id="affaire" name="affaire" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="0" <?php if($affaire=="") echo "selected"; ?>></option>
                <?php
                    $affaire = new FCompteaClass(0);
                    $rows = $affaire->all();
                    foreach($rows as $row){
                        echo "<option value='{$row->CA_Num}'";
                        if($row->CA_Num==$affaire) echo " selected";
                        echo ">{$row->CA_Intitule}</option>";
                    }
                    ?>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-2" >
            <label>Cat tarif :</label>
            <select class="form-control" id="CA_CatTarif" name="CA_CatTarif" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="0"></option>
                <?php
                $cattarif = new CatTarifClass(0);
                $rows = $cattarif->allCatTarif();
                foreach($rows as $row){
                    ?>
                    <option value="<?= $row->cbIndice ?>"
                        <?php if(isset($_GET["DE_No"]) && $row->cbIndice == $depotItem->CA_CatTarif) echo " selected "; ?>>
                        <?= $row->CT_Intitule ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
</fieldset>
<fieldset class="entete">
<legend class="entete">Souche</legend>
<div class="row">
<div class="col-12 col-sm-6 col-md-4 col-lg-4" >
    <label> Souche vente : </label>
    <select class="form-control" id="souche_vente" name="souche_vente" <?php if(!$flagProtected) echo "disabled"; ?>>
        <option value="0" <?php if(-1==$souchevente) echo " selected"; ?>></option>
                        <?php
                        $rows = $protection->getSoucheVente();
                        foreach($rows as $row){
                            echo "<option value='{$row->cbIndice}'";
                            if($row->cbIndice==$souchevente) echo " selected";
                            echo ">{$row->S_Intitule}</option>";
                        }
                    ?>
            </select>
</div>        

<div class="col-12 col-sm-6 col-md-4 col-lg-4" >
    <label> Souche achat: </label>
    <select class="form-control" id="souche_achat" name="souche_achat" <?php if(!$flagProtected) echo "disabled"; ?>>
        <option value="0" <?php if(-1==$soucheachat) echo " selected"; ?>></option>
        <?php
            $rows = $protection->getSoucheAchat();
                foreach($rows as $row){
                    echo "<option value='{$row->cbIndice}'";
                    if($row->cbIndice==$soucheachat) echo " selected";
                    echo ">{$row->S_Intitule}</option>";
                }
            ?>
    </select>
</div>        

<div class="col-12 col-sm-6 col-md-4 col-lg-4" >
    <label> Souche interne : </label>
<select class="form-control" id="souche_interne" name="souche_interne" <?php if(!$flagProtected) echo "disabled"; ?>>
    <option value="0" <?php if(-1==$soucheinterne) echo " selected"; ?>></option>
        <?php
        $rows = $protection->getSoucheInterne();
        foreach($rows as $row){
            echo "<option value='{$row->cbIndice}'";
            if($row->cbIndice==$soucheinterne) echo " selected";
            echo ">{$row->S_Intitule}</option>";
        }
        ?>
</select>
</div>
</div>
</fieldset>
<fieldset class="entete">
<legend class="entete">Code client</legend>
<select class="form-control" id="code_client" name="code_client[]" <?php if(!$flagProtected) echo "disabled"; ?> multiple>
        <?php
        $comptetClass = new ComptetClass(0);
        $rows = $comptetClass->getDepotClient($depot,0); ;
        foreach($rows as $row){
            echo "<option value='{$row->CodeClient}'";
            if($row->Valide_Depot==1) echo " selected";
            echo ">{$row->CodeClient} - {$row->Libelle_ville}</option>";
        }
        ?>
</select>

</fieldset>
<div class="col-lg-12 mt-3" >
    <input style="width:100%" type="button" id="ajouterDepot" name="ajouterDepot" class="btn btn-primary bgcolorApplication" value="Valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
</div>        
</form>
