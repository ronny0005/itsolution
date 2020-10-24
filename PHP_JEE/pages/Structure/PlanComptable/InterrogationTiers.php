
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_interrogationTiers.js?d=<?php echo time(); ?>"></script>
<section class="m-0 p-1" style="background-color: rgb(19,72,34);">
    <h3 class="text-center text-uppercase bgcolorApplication text-white"><?= $texteMenu ?></h3>
</section>
    <input type="hidden" id="AnneeExercice" value="<?= $annee; ?>"/>
    <input type="hidden" id="typeInterrogation" value="<?= $typeInterrogation; ?>"/>
<div id="alertInfo" class="alert mt-2"></div>
    <div class="row mt-3">
        <div class="col-lg-6 p-3">
            <div class="row">
                <div class="col-12">
                    <label>Fonctions</label>
                    <select class="form-control" name="fonctions" id="fonctions">
                        <option value="1"></option>
                        <option value="2">Automatique</option>
                        <option value="3">Pointer</option>
                        <option value="4">Annuler</option>
                        <option value="5">Traitement</option>
                        <option value="6">Calculer</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label>Compte</label>
                    <select class="form-control" id="ctNum" name="ctNum">

                    </select>
                </div>
                <div class="col-6">
                    <label>Lettre</label>
                    <input type="text" id="lettre" name="lettre" class="form-control" />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    <label>Date debut</label>
                    <input type="input" class="form-control" id="dateDebut" name ="dateDebut" />
                </div>
                <div class="col-4">
                    <label>Date Fin</label>
                    <input type="input" class="form-control" id="dateFin" name ="dateFin" />
                </div>
                <div class="col-4">
                    <label>Ecriture</label>
                    <select class="form-control" id="typeEcriture" name ="typeEcriture">
                        <option value="-1">Toutes les écritures</option>
                        <option value="1">Ecritures lettrées</option>
                        <option value="0">Ecritures non lettrées</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="col-lg-6 p-3 card">
            <div class="row mt-3">
                <div class="col-4">
                    Solde lettrage
                </div>
                <div class="col-4">
                    <input type="text" id="soldeLettrageDebit" class="text-right bg-white border-0" name="soldeLettrageDebit" disabled/>
                </div>
                <div class="col-4">
                    <input type="text" id="soldeLettrageCredit" class="text-right bg-white border-0" name="soldeLettrageCredit" disabled/>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    Totaux
                </div>
                <div class="col-4">
                    <input type="text" id="totauxDebit" name="totauxDebit" class="text-right bg-white border-0" disabled/>
                </div>
                <div class="col-4">
                    <input type="text" id="totauxCredit" name="totauxCredit" class="text-right bg-white border-0" disabled/>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    Solde compte
                </div>
                <div class="col-4">
                    <input type="text" id="soldeCompteDebit" name="soldeCompteDebit" class="text-right bg-white border-0" disabled/>
                </div>
                <div class="col-4">
                    <input type="text" id="soldeCompteCredit" name="soldeCompteCredit" class="text-right bg-white border-0" disabled/>
                </div>
            </div>
        </div>
        </div>


    <div class="table-responsive mt-2">
        <table id="interrogationTiers" class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Code</th>
                    <th>Date</th>
                    <th>N°Piece</th>
                    <th>N° Fac</th>
                    <th>Référence</th>
                    <th>N° Compte</th>
                    <th>Libellé écriture</th>
                    <th>Date échéance</th>
                    <th>Lettrage montant</th>
                    <th>Pointage</th>
                    <th>Débit</th>
                    <th>Crédit</th>
                    <th class="d-none"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listItem as $row){
                    echo "<tr>
                            <td><input type='checkbox' name='selectLigne' id='selectLigne' /></td>
                            <td>{$row->JO_Num}</td>
                            <td>{$row->EC_Jour}</td>
                            <td>{$row->EC_Piece}</td>
                            <td>{$row->EC_RefPiece}</td>
                            <td>{$row->EC_Reference}</td>
                            <td>{$row->CT_Num}</td>
                            <td>{$row->EC_Intitule}</td>
                            <td>";
                            if($row->EC_Echeance_C=="1900-01-01")
                                echo "";
                            else
                                echo $objet->getDateDDMMYYYY($row->EC_Echeance_C);
                            echo"</td>
                            <td>{$row->EC_Lettrage}</td>
                            <td></td>
                            <td id='amountDebit'>{$objet->formatChiffre($row->EC_MontantDebit)}</td>
                            <td id='amountCredit'>{$objet->formatChiffre($row->EC_MontantCredit)}</td>
                            <td class='d-none' id='cbMarq'>{$row->cbMarq}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    </div>
</div>
