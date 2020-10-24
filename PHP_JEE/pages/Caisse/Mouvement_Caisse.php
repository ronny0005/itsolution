<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/script_caisse.js?d=<?php echo time(); ?>"></script>
<script type="text/javascript" src="js/jquery.js?d=<?php echo time(); ?>"></script>
<section class="" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">Mouvement de caisse</h3>
</section>

    <input type="hidden" class="form-control" id="flagAffichageValCaisse" value="<?= $flagAffichageValCaisse;/*$flagModifSupprComptoir;*/ ?>" />
    <input type="hidden" class="form-control" id="flagCtrlTtCaisse" value="<?= $flagCtrlTtCaisse/*$flagModifSupprComptoir;*/ ?>" />
        <fieldset class="entete card p-3">
            <legend class="entete">Entete</legend>
            <form class="form-horizontal" action="mvtCaisse" method="POST">
                <div class="row">
                        <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                            <label>Caisse</label>
                            <input type="hidden" id="action" name="action" value="1"/>
                            <input type="hidden" id="module" name="module" value="6"/>
                            <input type="hidden" id="postData" name="postData" value="<?= $datapost; ?>"/>
                            <select class="form-control" name="caisseComplete" id="caisseComplete">
                                <?php
                                $isPrincipal = 0;

                                $caisse = new CaisseClass(0);
                                if($admin==0){
                                    $isPrincipal = 1;
                                    $rows = $caisse->getCaisseDepot($_SESSION["id"]);
                                }else{
                                    $rows = $caisse->listeCaisseShort();
                                }
                                if($rows==null){
                                }else{
                                    if(sizeof($rows)>1)
                                        echo "<option value='-1'>Sélectionner une caisse</option>";

                                    foreach($rows as $row) {
                                        if ($isPrincipal == 0) {
                                            echo "<option value='{$row->CA_No}'";
                                            if ($row->CA_No == $ca_no) echo " selected";
                                            echo ">{$row->CA_Intitule}</option>";
                                        } else {
                                            if ($row->IsPrincipal != 0) {
                                                echo "<option value='{$row->CA_No}'";
                                                if ($row->CA_No == $ca_no) echo " selected";
                                                echo ">{$row->CA_Intitule}</option>";
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                            <label>Type</label>
                            <select class="form-control" name="type_mvt_ent" id="type_mvt_ent">
                                <option value="-1">Sélectionner un type</option>
                                <?php
                                if($profil_caisse==1 || $admin==1){
                                    ?>
                                    <option value="4" <?php if($type=="4") echo " selected"; ?>>Mouvement de sortie</option>
                                    <option value="5" <?php if($type=="5") echo " selected"; ?>>Mouvement d'entrée</option>
                                    <option value="2" <?php if($type=="2") echo " selected"; ?>>Fond de caisse</option>
                                    <option value="16" <?php if($type=="16") echo " selected"; ?>>Transfert de caisse</option>
                                    <?php
                                }
                                ?>
                                <option value='6'<?php if($type=="6") echo " selected"; ?>>Verst bancaire</option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                            <label>Début</label>
                            <div class="input-group">
                                <input  type="text"  class="form-control" id="dateReglementEntete_deb" name="dateReglementEntete_deb" placeholder="Date" value="<?= $datedeb; ?>"/>
                                <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                            <label>Fin</label>
                            <div class="input-group">
                                <input  type="text"  class="form-control" id="dateReglementEntete_fin" name="dateReglementEntete_fin" placeholder="Date" value="<?= $datefin; ?>"/>
                                <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 mt-3">
                            <button type="submit" class="btn btn-primary" id="recherche" name="recherche">Rechercher</button>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4  mt-3">
                            <button type="button" class="btn btn-primary" id="imprimer">Imprimer</button>
                        </div>
                </div>
            </form>
        </fieldset>

        <fieldset class="entete card p-3">
            <legend class="entete">Ligne</legend>
            <?php
            if(1==1){
            ?>
            <form class="form-horizontal" action="mvtCaisse" method="POST" name="form_ligne" id="form_ligne">
                <div class="row">
                        <input type="hidden" id="action" name="action" value="1"/>
                        <input type="hidden" id="module" name="module" value="6"/>
                        <input type="hidden" id="caisseComplete_ligne" name="caisseComplete" value=""/>
                        <input type="hidden" id="type_mvt_ent_ligne" name="type_mvt_ent" value=""/>
                        <input type="hidden" id="dateReglementEntete_deb_ligne" name="dateReglementEntete_deb" value=""/>
                        <input type='hidden' id='RG_Modif' name='RG_Modif' value='0'/>
                        <input type='hidden' id='rg_typeregModif' name='rg_typeregModif' value='0'/>

                        <input type='hidden' id='RG_NoLigne' name='RG_NoLigne' value='0'/>
                        <input type='hidden' id='RG_NoDestLigne' name='RG_NoDestLigne' value='0'/>

                        <input type="hidden" id="dateReglementEntete_fin_ligne" name="dateReglementEntete_fin" value=""/>
                        <input type="hidden" id="cg_num_ligne" name="cg_num" value=""/>
                        <?php //if($flagDateMvtCaisse!=2){ ?>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                            <label>Date saisie</label>
                            <div class="input-group">
                            <input type="text"  class="form-control" id="dateReglement" name="date" placeholder="Date" <?php if($flagDateMvtCaisse==2) echo "readonly"; ?>/>
                            <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
                            </div>
                        </div>
                        <?php //} ?>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                            <label>Caisse</label>
                            <select class="form-control" name="CA_No" id="caisseLigne" placeholder="caisse">
                                <?php
                                $caisseClass = new CaisseClass(0);
                                if($admin==0){
                                    $isPrincipal = 1;
                                    $rows = $caisseClass->getCaisseDepot($_SESSION["id"]);
                                }else{
                                    $rows = $caisseClass->listeCaisseShort();

                                }
                                if(sizeof($rows)>1)
                                    echo "<option value='-1'>Sélectionner une caisse</option>";
                                if($rows==null){
                                }else{
                                    foreach($rows as $row) {
                                        if ($isPrincipal == 0) {
                                            echo "<option value='{$row->CA_No}'";
                                            if ($row->CA_No == $ca_no) echo " selected";
                                            echo ">{$row->CA_Intitule}</option>";
                                        } else {
                                            if ($row->IsPrincipal != 0) {
                                                echo "<option value='{$row->CA_No}'";
                                                if ($row->CA_No == $ca_no) echo " selected";
                                                echo ">{$row->CA_Intitule}</option>";
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                            <label>Libellé</label>
                            <input type="text" maxlength="27" class="form-control" id="libelleRec" name="libelle" placeholder="Libellé" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-2">
                            <label>Compte générale.</label>
                            <input type="hidden" class="form-control" name="CG_NumBanque" id="CG_NumBanque" value=""/>
                            <input type="hidden" class="form-control" name="CG_Analytique" id="CG_Analytique" value="0"/>
                            <input type="text" class="form-control" name="banque" id="banque" value="" placeholder="Compte générale"/>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                            <label>Mouvement</label>
                            <select class="form-control" name="rg_typereg" id="type_mvt_lig">
                                <?php
                                if(1==1){
                                    ?>
                                    <option value='4'>Mouvement de sortie</option>
                                    <option value="5">Mouvement d'entrée</option>
                                    <option value="2">Fond de caisse</option>
                                <?php }
                                if($protection->PROT_OUVERTURE_TOUTE_LES_CAISSES==0) echo "<option value='16'>Transfert caisse</option>";
                                ?>
                                <option value='6'>Verst bancaire</option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                            <label>Montant</label>
                            <input type="text" class="form-control" id="montantRec" name="montant" placeholder="Montant" />
                        </div>

                        <div class="col-6 col-sm-6 col-md-6 col-lg-2" id="divCA_Num" style="display:none">
                            <label>Compte analytique</label>
                            <input type="hidden" class="form-control" name="CA_Num" id="CA_Num" value=""/>
                            <input type="text" class="form-control" name="CA_Intitule" id="CA_Intitule" value="" placeholder="Compte analytique"/>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-2" id="divJournalDest">
                            <label>Journal</label>
                            <select class="form-control" id="journalRec" name="journalRec">
                                <option value=""></option>
                                <?php
                                $journalRec = new JournalClass(0);
                                $rows = $journalRec->getJournauxType(2,0);
                                foreach ($rows as $row){
                                    ?>
                                    <option value="<?= $row->JO_Num ?>"><?= "{$row->JO_Num} - {$row->JO_Intitule}" ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class='col-12 col-sm-6 col-md-6 col-lg-2' id="divCaisseDest">
                            <label>Caisse dest. :</label>
                            <select style="float:left" class="form-control" name="CA_No_Dest" id="CA_No_Dest" placeholder="caisse">

                                <option value="-1">Sélectionner une caisse</option>
                                <?php
                                $caisse = new CaisseClass(0);
                                if($admin==0){
                                    $isPrincipal = 1;
                                    $rows = $caisse->getCaisseDepot($_SESSION["id"]);
                                }else{
                                    $rows = $caisse->listeCaisseShort();
                                }
                                if($rows==null){
                                }else{
                                    foreach($rows as $row) {
                                        if ($isPrincipal == 0) {
                                            echo "<option value='{$row->CA_No}'";
                                            if ($row->CA_No == $ca_no) echo " selected";
                                            echo ">{$row->CA_Intitule}</option>";
                                        } else {
                                            if ($row->IsPrincipal != 0) {
                                                echo "<option value='{$row->CA_No}'";
                                                if ($row->CA_No == $ca_no) echo " selected";
                                                echo ">{$row->CA_Intitule}</option>";
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-2  mt-4">
                            <button type="button" class="btn btn-primary" id = "validerRec" name= "validerRec">Valider</button>
                        </div>
                </div>
                <?php
                echo "</form>";
                }
                ?>
                <table class="table mt-3" id="tableRecouvrement">
                    <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>N° Piece</th>
                        <th>Date</th>
                        <th>Libelle</th>
                        <th>Montant</th>
                        <th>Caisse</th>
                        <th>Caissier</th>
                        <th>Type</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    function typeCaisse($val){
                        if($val==16) return "Transfert caisse";
                        if($val==5) return "Entrée";
                        if($val==4) return "Sortie";
                        if($val==2) return "Fond de caisse";
                        if($val==6) return "Vrst bancaire";
                    }
                    $reglement = new ReglementClass(0);
                    $rows = $reglement->listeReglementCaisse($objet->getDate($datedeb),$objet->getDate($datefin),$ca_no,$type);
                    $reglement->afficheMvtCaisse($rows,$flagAffichageValCaisse,$flagCtrlTtCaisse);
                    ?>
                    </tbody>
                </table>
    </div>


    <div id="blocModal">
        <div class='col-md-6'>
            Libellé :<input type='text' class='form-control' id='libelleRecModif' placeholder='Libellé' />
        </div>
        <div class='col-md-6'>
            Montant :<input type='text' class='form-control' id='montantRecModif' placeholder='Montant' />
        </div>
    </div>
</div>
</fieldset>
<div id="valide_vrst" title="VALIDATION VRST BANCAIRE DAF">
    <div class="form-group">
        <div class="col-lg-3">
            <label>Bordereau</label>
            <input class="form-control" name="bordereau" id="bordereau"/>
        </div>
        <div class="col-lg-3">
            <label>Banque</label>
            <input class="form-control" maxlength="8" name="libelle_banque" id="libelle_banque"/>
        </div>
        <div class="col-lg-3">
            <label>Date</label>
            <input class="form-control" maxlength="8" name="libelle_date" id="libelle_date"/>
        </div>
        <div id="fichier" class="col-md-3">
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" type="file" name="files[]" multiple>
            <!-- The global progress bar -->
            <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
            </div>
            <!-- The container for the uploaded files -->
            <div id="files" class="files"></div>
        </div>
    </div>
</div>
