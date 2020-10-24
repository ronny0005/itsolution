<script src="js/script_creationClient.js?d=<?php echo time(); ?>"></script>
<?php
include("controller/structure/TiersController.php");
?>
    <form id="form-creationClient" action="FicheClient" method="GET">
        <section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
            <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);"><?php if($type=="client") echo "Fiche client"; if($type=="fournisseur") echo "Fiche fournisseur"; if($type=="salarie") echo "Fiche salarié"; ?></h3>
        </section>

        <div class="card p-3">
        <div class="row mt-3" >
            <div class="col-6 col-sm-6 col-md-6" >
                    <input type="hidden" id="type" name="type" type="hidden" value="<?php if($type=="fournisseur") echo "1"; if($type=="client") echo "0";if($type=="salarie") echo "2"; ?>"/>
                <input type="hidden" id="DE_No" name="DE_No" type="hidden" value="1"/>
                <label for="inputfirstname" class="control-label"> Num&eacute;ro compte : </label>
                <input value="<?= $cbMarqTiers ?>" type="hidden" name="cbMarqTiers" id="cbMarqTiers" />

                <input maxlength="17" value="<?= $ncompte; ?>" style=";text-transform:uppercase" type="text" onkeyup="this.value=this.value.replace(' ','')" name="CT_Num" id="CT_Num" class="form-control only_alpha_num" placeholder="Numéro compte" <?php if(isset($_GET["CT_Num"])) echo "disabled"; ?> />
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Intitul&eacute; : </label>
                <input maxlength="35" value="<?= $intitule; ?>" style="text-transform:uppercase" type="text" name="CT_Intitule" class="form-control" id="intitule" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Adresse : </label>
                <input value="<?php echo $adresse; ?>" style="" name="CT_Adresse" type="text" class="form-control" id="adresse" placeholder="Adresse" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> R&eacute;gion : </label>
                <input value="<?php echo $region; ?>" style="" type="text" class="form-control" name="CT_CodeRegion" id="CT_CodeRegion" placeholder="Région" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Ville : </label>
                <input value="<?php echo $ville; ?>" style=""  type="text" class="form-control" name="CT_Ville" id="CT_Ville" placeholder="ville" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> T&eacute;l&eacute;phone : </label>
                <input value="<?php echo $tel; ?>" style="" name="CT_Telephone" type="text" class="form-control only_phone_number" id="tel" placeholder="Téléphone" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> N Siret/NContrib : </label>
                <input value="<?php echo $nsiret; ?>" style="" name="CT_Siret" type="text" class="form-control" id="CT_Siret" placeholder="N° Siret" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Identifiant/RC Num :  </label>
                <input value="<?php echo $identifiant; ?>" style="" name="CT_Identifiant" type="text" class="form-control" id="CT_Identifiant" placeholder="Identifiant" <?php if(!$flagProtected) echo "disabled"; ?>/>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Compteg : </label>
                <select style="" name="CG_NumPrinc" class="form-control" id="CG_NumPrinc<?php if(!$flagProtected) echo "protected"?>" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <?php
                    $ctype=0;
                    $cdefaut="Cl.";
                    if($type=="fournisseur"){
                        $ctype=1;
                        $cdefaut="Fr.";
                    }
                    if($type=="salarie"){
                        $ctype=2;
                        $cdefaut="Sal.";
                    }
                    $ptiers = new PTiersClass($cdefaut);
                    $cdefaut=$ptiers->T_Val01T_Compte;
                    $pcompteg = new CompteGClass(0);
                    $listCompteg = $pcompteg->getComptegByType(0);
                    $cg_val =$cdefaut;
                    foreach($listCompteg as $row){
                        echo "<option value='{$row->CG_Num}'";
                        if((!isset($_GET["CT_Num"]) && $row->CG_Num == $cg_val)|| $compteg==$row->CG_Num) echo " selected";
                        echo ">{$row->CG_Num} - {$row->CG_Intitule}</option>";
                    }

                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Cat Tarif : </label>
                <select style="" name="N_CatTarif"  class="form-control" name="N_CatTarif" id="cattarif" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <?php
                    $pcatTarif = new P_CatTarifClass(0);
                    foreach($pcatTarif->all() as $row){
                        echo "<option value={$row->cbIndice}";
                        if($row->cbIndice==$cattarif) echo " selected";
                        echo ">{$row->CT_Intitule}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Cat compta : </label>
                <select style="" name="N_CatCompta" class="form-control" name="N_CatCompta" id="catcompta" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <?php
                    $pcatcompta = new P_CatComptaClass(0);
                    if($type=="client")
                        $rows = $pcatcompta->getCatComptaVente();
                    else
                        $rows = $pcatcompta->getCatComptaAchat();

                    foreach($rows as $row){
                        echo "<option value={$row->idcompta}";
                        if($row->idcompta==$catcompta) echo " selected";
                        echo ">{$row->marks}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Mode de règlement : </label>
                <select style="" name="mode_reglement" class="form-control" name="mode_reglement" id="mode_reglement" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <option value="0"></option>
                    <?php
                    $modeleReglement = new FModeleRClass(0);
                    $rows = $modeleReglement->all();
                    foreach ($rows as $row){
                        echo "<option value={$row->MR_No}";
                        if($row->MR_No==$MR_No) echo " selected";
                        echo ">{$row->MR_Intitule}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Dépôt : </label>
                <select style="width:100%"  name="depot" class="form-control" name="depot" id="depot" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <?php
                    $depotClass = new DepotClass(0);
                    foreach($depotClass->all() as $row){
                        echo "<option value={$row->DE_No}";
                        if($row->DE_No==$depot) echo " selected";
                        echo ">{$row->DE_Intitule}</option>";
                    }

                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Collaborateur : </label>
                <select style="" class="form-control" name="CO_No" id="CO_No" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <option value="0" <?php if($co_no==0) echo " selected"; ?>>-</option>
                    <?php
                    $collab = new CollaborateurClass(0);
                    $rows = $collab->allVendeur();
                    if(sizeof($rows)==0){
                    }else{
                        foreach($rows as $row){
                            echo "<option value='{$row->CO_No}'";
                            if($row->CO_No==$co_no) echo " selected";
                            echo ">{$row->CO_Nom}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Affaire : </label>
                <select style="" name="CA_Num" class="form-control" name="CA_Num" id="CA_Num" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <option value="">-</option>
                    <?php
                    $comptea = new FCompteaClass(0);
                    foreach($comptea->getAffaire() as $row){
                        if($row->CA_Num!=""){
                            echo "<option value='{$row->CA_Num}'";
                            if($row->CA_Num!="" && $row->CA_Num==$affaire) echo " selected ";
                            echo ">{$row->CA_Intitule}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Sommeil: </label>
                <select style="" class="form-control" name="CT_Sommeil" id="CT_Sommeil" <?= (!$flagProtected) ? "disabled":""; ?>>
                    <option value="0" <?= ($ctSommeil==0) ? " selected" : "" ?>>Non</option>
                    <option value="1" <?= ($ctSommeil==1) ? " selected" : "" ?>>Oui</option>
                </select>
            </div>

            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Encours max autorisé : </label>
                <input value="<?= $ctEncours ?>" style="" name="CT_Encours" type="text" class="form-control" id="CT_Encours" placeholder="" <?= (!$flagProtected) ? "disabled" : "" ?>/>
            </div>

            <div class="col-6 col-sm-6 col-md-6" >
                <label for="inputfirstname" class="control-label"> Ctrle de l'encours client : </label>
                <select style="" class="form-control" name="CT_ControlEnc" id="CT_ControlEnc" <?= (!$flagProtected) ? "disabled":""; ?>>
                    <option value="0" <?= ($CT_ControlEnc==0) ? " selected" : "" ?>>Contrôle automatique</option>
                    <option value="1" <?= ($CT_ControlEnc==1) ? " selected" : "" ?>>Selon code risque</option>
                    <option value="2" <?= ($CT_ControlEnc==2) ? " selected" : "" ?>>Compte bloqué</option>
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12">
                <button id="ajouterClient" name="ajouterClient" class="btn btn-primary float-right mt-3" style="width:100%" <?php if(!$flagProtected) echo "disabled"; ?>>Valider</button>
            </div>
        </div>

        </div>
</form>