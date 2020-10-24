<?php


?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_interrogationTiers.js?d=<?php echo time(); ?>"></script>
</head>

<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">
    <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?= $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?= $_SESSION["login"]; ?>"/>
    <input type="hidden" id="AnneeExercice" value="<?= $annee; ?>"/>
    <input type="hidden" id="typeInterrogation" value="<?= $typeInterrogation; ?>"/>

    <div class="row">
        <div class="col-lg-6"  style="padding: 10px">
            <div class="row">
                <div>
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
                <div class="col-lg-6">
                    <label>Compte</label>
                    <select class="form-control" id="ctNum" name="ctNum">

                    </select>
                </div>
                <div class="col-lg-6">
                    <label>Lettre</label>
                    <input type="text" id="lettre" name="lettre" class="form-control" />
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-lg-4">
                    <label>Date debut</label>
                    <input type="input" class="form-control" id="dateDebut" name ="dateDebut" />
                </div>
                <div class="col-lg-4">
                    <label>Date Fin</label>
                    <input type="input" class="form-control" id="dateFin" name ="dateFin" />
                </div>
                <div class="col-lg-4">
                    <label>Ecriture</label>
                    <select class="form-control" id="typeEcriture" name ="typeEcriture">
                        <option value="-1">Toutes les écritures</option>
                        <option value="1">Ecritures lettrées</option>
                        <option value="0">Ecritures non lettrées</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="col-lg-6" style="padding: 30px">
            <div class="row" style="margin-top: 10px">
                <div class="col-lg-4">
                    Solde lettrage
                </div>
                <div class="col-lg-4">
                    <input type="text" id="soldeLettrageDebit" name="soldeLettrageDebit" style="background-color:white;border:white;text-align: right" disabled/>
                </div>
                <div class="col-lg-4">
                    <input type="text" id="soldeLettrageCredit" name="soldeLettrageCredit" style="background-color:white;border:white;text-align: right" disabled/>
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-lg-4">
                    Totaux
                </div>
                <div class="col-lg-4">
                    <input type="text" id="totauxDebit" name="totauxDebit" style="background-color:white;border:white;text-align: right" disabled/>
                </div>
                <div class="col-lg-4">
                    <input type="text" id="totauxCredit" name="totauxCredit" style="background-color:white;border:white;text-align: right" disabled/>
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-lg-4">
                    Solde compte
                </div>
                <div class="col-lg-4">
                    <input type="text" id="soldeCompteDebit" name="soldeCompteDebit" style="background-color:white;border:white;text-align: right" disabled/>
                </div>
                <div class="col-lg-4">
                    <input type="text" id="soldeCompteCredit" name="soldeCompteCredit" style="background-color:white;border:white;text-align: right" disabled/>
                </div>
            </div>
        </div>
        </div>


    <div class="table-responsive" style="margin-top: 10px">
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
                    <th style="display: none"></th>
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
                            <td style='display:none' id='cbMarq'>{$row->cbMarq}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    </div>
</div>
