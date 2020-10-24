<?php
    $id = 0;
    $username = "";
    $description = "";
    $password = "";
    $email="";
    $depot_no="";
    $caisse_no="";
    $objet = new ObjetCollector();
    $protectioncial = new ProtectionClass("","");
    $securiteAdmin=0;

    if(isset($_GET["PROT_No"])){
        $objet = new ObjetCollector();
        $id=$_GET["PROT_No"];
        $protectioncial->connexionProctectionByProtNo($_GET["PROT_No"]);
    }

?>
<script src="js/script_creationUser.js?d=<?php echo time(); ?>"></script>
    <section class="bgcolorApplication p-1">
        <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">Fiche utilisateur</h3>
    </section>
    <section class="mt-2">
    <div class="err" id="add_err"></div>
    <form id="formUser" class="formUser card" action="traitement/CreationUser.php" method="POST">
        <input name="action" value="4" type="hidden"/>
        <input name="module" value="8" type="hidden"/>
        <input name="acte" value="actionUser" type="hidden"/>
		<input name="id" id="id" value="<?= $protectioncial->Prot_No ?>" type="hidden"/>

        <div class=" row p-3">
            <div class="col-3" >
                <label> Nom : </label>
                <input value="<?= $protectioncial->PROT_User ?>" name="username" type="text" class="form-control" id="username" placeholder="Nom et prenom"/>
            </div>
        <div class="col-3" >
            <label> Description : </label>
            <input value="<?= $protectioncial->PROT_Description; ?>" name="description" type="text" class="form-control" id="description" placeholder="Description"/>
        </div>
        <div class="col-3" >
            <label> Mot de passe : </label>
            <input value="<?= $objet->decrypteMdp($protectioncial->PROT_Pwd); ?>" type="text" class="form-control" name="password" id="password" placeholder="Mot de passe" />
        </div>
        <div class="col-3" >
            <label> Email : </label>
            <input value="<?= $protectioncial->PROT_Email ?>" type="text" class="form-control" name="email" id="email" placeholder="email" />
        </div>
        <div class="col-3" >
            <label> Groupe : </label>
            <select name="groupeid" class="form-control"  id="groupeid">
               <option value="1" <?= ($protectioncial->PROT_Right==1) ? "selected" :"" ?>>Administrateurs</option>
               <option value="2" <?= ($protectioncial->PROT_Right==2) ? "selected" :"" ?>>Utilisateurs</option>
            </select>
        </div>
        <div class="col-3" >
            <label> Profil Utilisateur : </label>
            <select name="profiluser" class="form-control"  id="profiluser">
                    <option value='0'>PAS DE PROFIL</option>
                <?php
                    foreach($protectioncial->allProfil() as $row){
                        echo "<option value='{$row->PROT_No}'";
                        if($protectioncial->PROT_UserProfil == $row->PROT_No)
                            echo " selected ";
                        echo ">{$row->PROT_User}</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-3" >
            <label> Forcer Changement Mot de passe : </label>
            <select name="changepass" class="form-control" id="changepass">
               <option value="0">NON</option>
               <option value="1">OUI</option>
            </select>
        </div>

        <div class="col-3" >
            <label> Sécurité admin : </label>
            <select name="securiteAdmin" class="form-control"  id="securiteAdmin">
                <option value="0" <?= ($protectioncial->ProtectAdmin==0) ? "selected" : "" ?>>NON</option>
                <option value="1" <?= ($protectioncial->ProtectAdmin==1) ? "selected" : "" ?>>OUI</option>
            </select>
        </div>
        <div class="col-6" >
            <label>Liste des dépôts</label>
            <select class="form-control" id="depot" name="depot[]" multiple>
                <?php
                foreach($protectioncial->getDepotUser($id) as $row){
                    echo "<option value='{$row->DE_No}'";
                    if($row->Valide_Depot==1) echo " selected ";
                    echo ">{$row->DE_No} - {$row->DE_Intitule}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-6" >
            <label>Liste des dépôts principaux</label>
            <select class="form-control" id="depotprincipal" name="depotprincipal[]" multiple>
                <?php
                foreach($protectioncial->getDepotUser($id) as $row){
                    if($row->Valide_Depot==1) {
                        echo "<option value='{$row->DE_No}'";
                        if ($row->IsPrincipal== 1) echo " selected ";
                        echo ">{$row->DE_No} - {$row->DE_Intitule}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-12 mt-3" >
            <input style="width: 100%" type="submit" id="ajouterUser" name="ajouterUser" class="btn btn-primary" <?= (isset($_GET["PROT_No"])) ? 'value="Modifier"' : 'value="Ajouter"'; ?> />
        </div>
        </div>
    </form>
    </section>