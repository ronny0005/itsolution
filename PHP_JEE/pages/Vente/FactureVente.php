<script src="js/scriptFactureVente.js?d=<?= time(); ?>"></script>
    <section style="margin: 0px;padding: 5px;background-color: rgb(19,72,34);color: rgb(255,255,255);">
        <h3 class="text-center text-uppercase bgcolorApplication" style="color:white"><?= $protection->listeFactureNom($type) ?></h3>
    </section>
    <!-- List alert -->
        <div id="alertDate" class="alert alert-danger" style="display:none " role="alert">Saisissez une date !</div>
        <div id="alertTiers" class="alert alert-danger" style="display:none " role="alert">Saisissez un tiers !</div>
        <div id="alertStatut" class="alert alert-danger" style="display:none " role="alert">Choississez un statut valide !</div>
        <div id="alertEntete" class="alert alert-danger" style="display:none " role="alert"></div>
    <!-- List alert -->
    <fieldset class="card p-3">
        <legend>Entête</legend>
        <form id="form-entete" action="Document-Facture<?=$type ?>" method="get">
            <input type="hidden" id="flagMinMax" value="<?= ($type=="Vente" || $type=="BonLivraison") ? $flag_minMax : "0" ?>"/>
            <input type="hidden" id="flagDelai" value="<?= $protection->getDelai(); ?>"/>
            <input type="hidden" id="flagPxRevient" value="<?= $flagPxRevient; ?>"/>
            <input type="hidden" id="flagPxAchat" value="<?= $flagPxAchat; ?>"/>
            <input type="hidden" id="flagModifClient" value="<?= $flagModifClient; ?>"/>
            <input type="hidden" id="protectDate" value="<?= $protectDate; ?>"/>
            <input type="hidden" id="isModif" value="<?= $isModif; ?>"/>
            <input type="hidden" id="isVisu" value="<?= $isVisu; ?>"/>

            <?php
            if($_GET["type"]=="PreparationCommande" || $_GET["type"]=="AchatPreparationCommande"){
                ?>
                <div class="row">
                    <div class="col-6 col-lg-2">
                        <input class="btn btn-primary" type="button" name="majCompta" id="majCompta" value="Mise à jour comptable <?php if($docEntete->DO_Coord03==1) echo "(effectué)"; ?>" <?php if($docEntete->DO_Coord03==1) echo "disabled"; ?>/>
                    </div>
                    <div class="col-6 col-lg-2">
                        <input class="btn btn-primary" type="button" name="rattacher" id="rattacher" value="Rattacher" />
                    </div>
                    <div class="col-12 col-lg-3 text-center">
                        <label>Transfert des documents de caisse</label>
                        <input class="form-control" type="checkbox" name="transDoc" id="transDoc" value="" <?php if($docEntete->DO_Coord03==1 || $entete=="") echo "checked"; ?>/>
                    </div>
                </div>
                <?php
            }
            ?>

            <div>
                <div></div>

                <div class="form-row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label>&nbsp;<?= $libclient ?></label>
                        <div class="input-group-append">
                            <input type="hidden" class="form-control" name="CT_Num" id="CT_Num" value="<?= $client->CT_Num ?>"/>
                            <input class="form-control" type="text" id="client" name="client" value="<?= $client->CT_Intitule ?>" <?= $clientDisabled ?>>
                            <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="fa fa-user"></i></span></span>
                        </div>

                    <span class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <div class="col-6 col-sm-3 col-md-4"><label>Cat tarif</label>
                        <div class="field">
                            <select class="form-control" id="cat_tarif" name="cat_tarif" <?= $accesCatTarif ?>>
                                <?= $listeCatTarif ?>
                            </select></div>
                    </div>
                    <div class="col-6 col-sm-3 col-md-4"><label>Cat compta</label>
                        <div class="field">
                            <select class="form-control form-control" id="cat_compta" inputmode="numeric" maxlength="6" name="cat_compta"  <?= $accessCatCompta ?>>
                                <?= $listeCatCompta ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6 col-xs-6 col-sm-4 col-md-4"><label>Souche</label>
                        <div class="field">
                            <select class="form-control" id="souche" name="souche" <?= $accessSouche ?>>
                                <?= $listeSouche ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-xs-6 col-sm-4 col-md-4"><label>Affaire</label>
                        <select class="form-control" id="affaire" name="affaire" <?= $accesAffaire ?>>
                            <?= $listeAffaire ?>
                        </select>
                        <div
                                id="datetimepicker1" class="input-group date"><span class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-12 col-xs-6 col-sm-4 col-md-4"><label>Date</label>
                        <div class="input-group">
                            <input class="form-control" inputmode="numeric" type="text" id="dateentete" name="dateentete" <?= $accesDate ?> value="<?= $valueDate ?>">
                            <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-xs-12 col-sm-4 col-md-4"><label>&nbsp;Depot</label>
                        <select class="form-control" id="depot" name="depot" <?=$accesDepot ?>>
                            <?= $listeDepot ?>
                        </select>
                    </div>
                    <div
                            class="col-6 col-xs-6 col-sm-4 col-md-4"><label>Collaborateur</label>
                                <select class="form-control" id="collaborateur" name="collaborateur" <?=$accesCollaborateur ?>>
                                    <?=$listeCollaborateur ?>
                                </select>
                    </div>
                    <div class="col-6 col-xs-6 col-sm-4 col-md-4">
                        <label>Caisse</label>
                        <div class="field">
                            <select class="form-control" id="caisse" name="caisse" <?=$accesCaisse ?>>
                                <?= $listeCaisse ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6 col-xs-12 col-sm-4 col-md-4">
                        <label>&nbsp;Référence</label>
                        <div id="datetimepicker1" class="input-group date">
                            <input maxlength="17" class="form-control form-control" type="text" id="ref" value="<?= $docEntete->DO_Ref; ?>" name="reference" <?=$accessReference ?>>
                            <span class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-6 col-xs-6 col-sm-4 col-md-4"><label>N° Doc</label>
                        <div id="datetimepicker1" class="input-group date">
                            <input class="form-control form-control" type="text" id="n_doc" name="n_doc" value="<?= $docEntete->DO_Piece; ?>" disabled>
                            <input type="hidden" id="modifClient" class="modifClient" value="<?= $flagModifClient ?>"/>
                            <span class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="col-6 col-xs-6 col-sm-4 col-md-4"><label>Statut</label>
                        <div class="field">
                            <select class="form-control" id="do_statut" name="do_statut">
                                <?= $listeStatut ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </fieldset>
    <!-- List alert -->
        <div id="alertLigneMessage" class="alert alert-danger" style="display:none " role="alert"></div>
        <div id="alertLigne" class="alert alert-danger" style="display:none " role="alert"></div>
    <!-- List alert -->
    <fieldset class="card p-3">
        <legend>Ligne</legend>
        <form>
            <div>
                <div></div>
                <form id="form-ligne" name="form-ligne" method="get">
                    <input type="hidden" value="<?php echo $qte_negative; ?>" name="qte_negative" id="qte_negative"/>
                    <input type="hidden" value="<?php echo $do_imprim; ?>" name="do_imprim" id="do_imprim"/>
                    <div class="form-row">
                        <div class="col-12 col-sm-3 col-md-2 col-lg-2"><label>Référence</label>
                            <div id="datetimepicker1" class="input-group date">
                                <input type="text" id="reference" name="reference" class="form-control" placeholder="Référence" <?= $accessARRef ?>/>
                                <input type="hidden" class="form-control" id="AR_Ref" name="AR_Ref" value="" />

                                <span class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3"><label>Désignation</label>
                            <input class="form-control" type="text" id="designation" placeholder="Désignation" name="designation" <?= $accessDesignation ?>>
                            <div class="field"></div>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-lg-1 <?= $classQte; ?>"><label>Qté</label><input class="form-control" type="text" id="quantite" placeholder="<?= $libQte ?>" name="quantite" <?=$accessQte ?>></div>
                        <div class="col-6 col-sm-5 col-md-4 col-lg-2" <?= $accessPrix ?>><label>Prix unitaire</label><input class="form-control" type="text" id="prix" placeholder="P.U." name="prix" <?= $accessPrix ?>></div>
                        <div class="col-6 col-sm-3 col-md-2 col-lg-2"><label>Qté en stock</label><input class="form-control" type="text" id="quantite_stock" placeholder="Qté en stock" name="quantite_stock" disabled></div>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-2"><label>Remise</label><input class="form-control only_remise" type="text" id="remise" placeholder="Remise" name="remise" <?= $accessRemise ?>></div>
                        <input type="hidden" name="taxe1" id="taxe1" value="0" />
                        <input type="hidden" name="taxe2" id="taxe2" value="0"/>
                        <input type="hidden" name="taxe3" id="taxe3" value="0"/>
                        <input type="hidden" name="ADL_Qte" id="ADL_Qte" value="0"/>
                        <input type="hidden" name="APrix" id="APrix" value="0"/>
                        <input type="hidden" name="database" id="database" value="0"/>
                        <input type="hidden" name="cbMarq" id="cbMarq" value="0"/>
                        <input type="hidden" name="client" id="client" value="<?php echo $client; ?>"/>
                        <input type="hidden" name="acte" id="acte" value="ajout_ligne"/>
                    </div>
                </form>
                <div>
                    <div class="table-responsive" style="margin-top: 30px;">
                        <table id="ligneFacture" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Désignation</th>
                                <th <?= $accessPUTTC ?>>PU HT</th>
                                <th>Qté</th>
                                <th>Remise</th>
                                <th <?= $accessPUTTC ?>>PU TTC</th>
                                <th <?= $accessMontantHT ?>>Montant HT</th>
                                <th <?= $accessMontantTTC ?>>Montant TTC</th>
                                <?php
                                    if (!$isVisu && ($type == "PreparationCommande" || $type == "AchatPreparationCommande"))
                                        echo "<th></th>";

if (!$isVisu)
    echo "<th></th>
            <th></th>";
        if($protection->PROT_CBCREATEUR!=2)
                echo "<th>Createur</th>";
?>
        </tr>
    </thead>
    <tbody id="article_body">
      <?php
      if(isset($_GET["cbMarq"])) {
          $rows = $docEntete->listeLigneFacture();
          $i = 0;
          $classe = "";
          $fournisseur = 0;
          if ($docEntete->DO_Domaine != 0)
              $fournisseur = 1;
          if ($rows == null) {
          } else {
              foreach ($rows as $row) {
                  $docligne = new DocLigneClass($row->cbMarq);
                  $typefac = 0;
                  if($cat_tarif == null)
                      $cat_tarif =0;
                  $rows = $docligne->getPrixClientHT($docligne->AR_Ref, $docEntete->N_CatCompta, $cat_tarif, 0, 0, $docligne->DL_Qte, $fournisseur);
                  if(sizeof($rows)>0)
                  $rows = $rows[0];
                  if ($rows != null) {
                      $typefac = $rows->AC_PrixTTC;
                  }
                  $i++;
                  if ($i % 2 == 0) $classe = "info";
                  else $classe = "";
                  $qteLigne = (round($docligne->DL_Qte * 100) / 100);
                  $remiseLigne = $docligne->DL_Remise;
                  $puttcLigne = ROUND($docligne->DL_PUTTC, 2);
                  $montantHTLigne = ROUND($docligne->DL_MontantHT, 2);
                  $montantTTCLigne = ROUND($docligne->DL_MontantTTC, 2);

                  if ($_GET["type"] == "Retour") {
                      $qteLigne = -$qteLigne;
                      $montantTTCLigne = -$montantTTCLigne;
                      $montantHTLigne = -$montantHTLigne;
                  }
?>
                  <tr class='facture <?= $classe; ?>' id='article_<?= $docligne->cbMarq; ?>'>
                      <td id='AR_Ref' style='color:blue;text-decoration: underline'><?= $docligne->AR_Ref; ?></td>
                      <td id='DL_Design' style='align:left'><?= $docligne->DL_Design; ?></td>
                      <td id='DL_PrixUnitaire' class="text-right" style="<?php
                    if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                        echo "display:none";?>">
                        <?= $objet->formatChiffre(round($docligne->DL_PrixUnitaire, 2)); ?></td>
                    <td id='DL_Qte'class="text-right" ><?= $objet->formatChiffre($qteLigne); ?></td>
                      <td id='DL_Remise' class="text-right" ><?= $remiseLigne ?></td>
                      <td id='PUTTC' style="<?php
                          if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                              echo "display:none";?>" class="text-right"><?= $objet->formatChiffre($puttcLigne); ?></td>

                      <td id='DL_MontantHT' class="text-right" style="<?php
                      if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                          echo "display:none";?>"><?= $objet->formatChiffre($montantHTLigne); ?></td>
                      <td id='DL_MontantTTC' class="text-right" style="<?php
                          if((($type=="Achat" || $type=="AchatC" || $type=="AchatT" || $type=="AchatPreparationCommande"|| $type=="PreparationCommande")&& $flagPxAchat!=0))
                              echo "display:none";?>">

                          <span class="d-none" id='DL_NoColis'><?= $docligne->DL_NoColis; ?></span>
                          <span class="d-none" id='cbMarq'><?= $docligne->cbMarq; ?></span>
                          <span class="d-none" id='DL_CMUP'><?= $docligne->DL_CMUP; ?></span>
                          <span class="d-none" id='DL_TYPEFAC'><?= $typefac; ?></span>
                      <?= $objet->formatChiffre($montantTTCLigne); ?></td>
                  <?php
                  if (!$isVisu && ($type == "PreparationCommande" || $type == "AchatPreparationCommande"))
                      echo "<td id='lignea_{$docligne->cbMarq}'><i class='fa fa-sticky-note fa-fw'></i></td>";
                  if (!$isVisu)
                      echo "<td id='modif_{$docligne->cbMarq}'>
                                <i class='fa fa-pencil fa-fw'></i>
                            </td>
                            <td id='suppr_{$docligne->cbMarq}'><i class='fa fa-trash-o'></i></a></td>";
                  if($protection->PROT_CBCREATEUR!=2)
                      echo "<td>{$docligne->getcbCreateurName()}</td>";
                  echo "</tr>";
                  $totalht = $totalht + ROUND($docligne->DL_MontantHT, 2);
                  $tva = $tva + ROUND($docligne->MT_Taxe1, 2);
                  $precompte = $precompte + ROUND($docligne->MT_Taxe2, 2);
                  $marge = $marge + ROUND($docligne->MT_Taxe3, 2);
                  $totalttc = $totalttc + ROUND($docligne->DL_MontantTTC, 2);
              }
          }
      }
?>

    </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </fieldset>
    <fieldset class="card p-3">
        <legend>Pied</legend>
        <div id="piedPage"></div>
    </fieldset>

<div class="table-responsive">
    <fieldset id="liste_reglement" class="card p-3 " style="<?php if($isVisu == 0) echo "display:none"; ?>">
        <legend>R&egrave;glement</legend>
        <table class="table table-striped" id="tableRecouvrement">
            <thead>
            <tr>
                <th>Date du règlement</th>
                <th>Date de l'échéance</th>
                <th>Libelle</th>
                <th>Montant</th>
                <th>Solde progressif</th>
            </tr>
            </thead>
            <tbody>
            <?= $listeReglement ?>
            </tbody>
        </table>
    </fieldset>
</div>
<div class="container" <?= $accessListeSaisie ?>>
    <fieldset id="liste_saisieEC" class="entete">
        <legend class="entete">Création écriture compta</legend>
        <table class="table" id="tableEC">
            <thead>
            <tr>
                <th>Code journal</th>
                <th>Exercice</th>
                <th>Jour</th>
                <th>N° Facture</th>
                <th>Référence</th>
                <th>N° Compte général</th>
                <th>N° Compte tiers</th>
                <th>Libellé écriture</th>
                <th>Date échéance</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </fieldset>
</div>
<div class="container" <?= $accessListeSaisie ?>>
    <fieldset id="liste_saisieAnal" class="entete">
        <legend class="entete">Création écriture analytique</legend>
        <table class="table" id="tableAnal">
            <thead>
            <tr>
                <th>Code journal</th>
                <th>Plan analytique</th>
                <th>N° Compte général</th>
                <th>Exercice</th>
                <th>Section</th>
                <th>Qte/Dévise</th>
                <th>Montant</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </fieldset>
</div>


<div class="container">
    <form action="indexMVC.php?action=3&module=2" method="GET" name="form-valider" id="form-valider">
    <div class="row" style="padding-top: 10px;padding-bottom: 10px;">
        <input type="hidden" value="2" name="module"/>
        <input type="hidden" value="3" name="action"/>
        <input type="hidden" name="entete" id="valide_entete" value="0"/>
        <input type="hidden" name="client" id="valide_client" value="0"/>
        <input type="hidden" name="montant_avance" id="montant_avance" value="0"/>
        <input type="hidden" name="reste_a_payer" id="reste_a_payer" value="<?= $reste_a_payer; ?> "/>
        <input type="hidden" name="montant_total" id="montant_total" value="<?= $totalttc; ?>"/>
        <input type="hidden" name="PROT_Reglement" id="PROT_Reglement" value="<?= $protection->PROT_DOCUMENT_REGLEMENT; ?>"/>
        <input type="hidden" id="imprime_val" name="imprime_val" value="0"/>
        <div class="col-4 col-sm-2"><button class="btn btn-primary" id="annuler" type="button">Annuler</button></div>
        <div class="col-4 col-sm-2" <?php if(!$isModif) echo"style='display:none'" ?>><button class="btn btn-primary" id="valider" type="button">Valider</button></div>
        <div class="col-4 col-sm-2"><button class="btn btn-primary" id="imprimer" type="button">Imprimer</button></div>
    </div>
    </form>
</div>

<div id="dialog-confirm" title="Suppression" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Voulez vous supprimez cette ligne ?</p>
</div>

<div class="validFacture" style="display:none">
    <form action="Traitement/Facturation.php" method="GET" id="redirectFacture">
        <input type="hidden" value="<?= $type ?>" id="typeFacture" name="typeFacture" />
        <input type="hidden" value="redirect" id="acte" name="acte" />
    </form>
</div>


<div class="valideReglement" style="display:none">
    <form action="Traitement/Facturation.php" method="GET" id="valideRegltForm">
        <input type="hidden" value="0" id="DO_Imprim" name="DO_Imprim" />
        <!-- Lists alert -->
        <div id="alertValideReglement" class="alert alert-danger" style="display:none" role="alert"></div>
        <!-- Lists alert -->
        <div class="row">
        <div style=" text-align: center<?php if($bloqueReglement) echo";display:none"; ?>" class="col-lg-6" >
            <label>Comptant</label>
            <input type="checkbox" id="comptant" name="comptant"/>
        </div>
        <div style="text-align: center<?php if($bloqueReglement) echo";display:none"; ?>" class="col-lg-6" >
            <label>Crédit</label>
            <input type="checkbox" id="credit" name="credit"/>
        </div>
        <div style="text-align: center" class="col-lg-6" >
            <label>Date reglement</label>
            <div class="input-group">
                <input type="text" id="date_rglt" name="date_rglt" class="form-control only_integer" <?php if($flagDateRglt!=0) echo"readonly"; ?>/>
                <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
            </div>
        </div>
        <div style="text-align: center" class="col-lg-6" >
            <label>Date échéance</label>
            <div class="input-group">
                <input type="text" id="date_ech" name="date_ech" class="form-control only_integer" <?php if($bloqueReglement) echo"readonly"; ?>/>
                <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
            </div>
        </div>
        <div style="text-align: center" class="col-lg-12" >
            <label>Libellé règlt</label>
            <input type="text" id="libelle_rglt" maxlength="35" name="libelle_rglt" class="form-control" <?php if($bloqueReglement) echo"readonly"; ?>/>
        </div>
        <div style="text-align: center" class="col-lg-6" >
            <label>Mode de rglt</label>
            <select id="mode_reglement_val" name="mode_reglement_val" class="form-control" <?php if($bloqueReglement) echo"readonly"; ?>>
                <?php

                $rows = $creglement->listeTypeReglement();
                if($rows !=null) {
                    foreach ($rows as $row) {
                        if ($row->R_Code == "01") {
                            echo "<option value='{$row->R_Code}'>{$row->R_Intitule}</option>";
                        } else {
                            if ($flagRisqueClient == 0) {
                                echo "<option value='{$row->R_Code}'>{$row->R_Intitule}</option>";
                            }
                        }
                    }
                }
                ?>
            </select>
        </div>
        <div style="text-align: center" class="col-lg-6" >
            <label>Modele rglt</label>
            <select id="modele_reglement_val" name="modele_reglement_val" class="form-control" <?php if($bloqueReglement) echo"readonly"; ?>>
                <option value=""></option>
                <?php
                $rows = $creglement->getModeleReglement();
                if($rows !=null) {
                    foreach($rows as $row){
                        ?>
                        <option value="<?= $row->MR_No; ?>"><?= $row->MR_Intitule ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div style="text-align: center" class="col-lg-6" >
            <label>Montant avance</label>
            <input type="hidden" id="valideRegltImprime" name="valideRegltImprime" />
            <input type="hidden" id="cbMarqEntete" name="cbMarqEntete" value="<?= ($docEntete->cbMarq!="") ? $docEntete->cbMarq : 0 ?>"/>
            <input type="hidden" id="valideRegle" name="valideRegle" value="0"/>
            <input type="hidden" id="typeFacture" name="typeFacture" value="<?= $_GET["type"]; ?>"/>
            <input type="hidden" id="PROT_No" name="PROT_No" value="<?= $_SESSION["id"]; ?>"/>
            <input type="hidden" id="acte" name="acte" value="regle"/>
            <input type="input" id="mtt_avance" name="mtt_avance" class="form-control" READONLY/>
        </div>
        <?php if(isset($_GET["entete"])){
            ?>
            <div id="reste_a_payer_text" style="margin-top:20px;float:right" class="col-lg-12">
                Le reste à payer est de <b><?php echo $reste_a_payer; ?></b>
            </div>
        <?php } ?>
        </div>
    </form>
</div>

<div id='formArticleFactureBis' style='display: none;'></div>
<div id="formArticleFacture"></div>

<div id="formAnalytique"  style="display:none">
    <div class="form-group" >
        <div class="col-lg-2">
            <label>Plan</label>
            <select class="form-control" id="N_Analytique" name="N_Analytique">
                <?php
                $result=$objet->db->requete($objet->getListeTypePlan());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value='{$row->cbIndice}'";
                        //if($row->cbIndice == $N_Analytique) echo " selected";
                        echo ">{$row->A_Intitule}</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div style="display:none">
        <table id="table">
            <th style="text-align: center"><td style="padding: 10px">Qté/Devise</td><td style="padding: 10px">Montant</td></th>
            <tr style="text-align: center"><td>A imputer</td><td id="qte_imputer"></td><td id="montant_imputer"></td></tr>
            <tr style="text-align: center"><td>Total imputé</td><td id="qte_timputer"></td><td id="montant_timputer"></td></tr>
            <tr style="text-align: center"><td>Solde</td><td id="qte_solde"></td><td id="montant_solde"></td></tr>
        </table>
    </div>

    <div class="form-group" style="display:none" >
        <table class="table" id="table_anal" style="width:100%">
            <thead>
            <tr style="text-align: center;font-weight: bold">
                <td>Section</td>
                <td>Qte/Devise</td>
                <td>Montant</td>
            </tr>
            <tr id="param">
                <td>
                    <select name="CA_Num" class="form-control" id="CA_Num">
                        <option value=""></option>
                        <?php
                        $result =  $objet->db->requete( $objet->getAnalytiqueSaisie());
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if($rows !=null){
                            foreach ($rows as $row){
                                echo "<option value='{$row->CA_Num}'>{$row->CA_Intitule}</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input value="" type="text" name="A_Qte" class="form-control" id="A_Qte"/>
                </td>
                <td>
                    <input value="" type="text" name="A_Montant" class="form-control" id="A_Montant"/>
                </td>
            </tr>
            </thead>
            <tbody>
            <?php
            /*   $result =  $objet->db->requete($objet->getSaisieAnal(5,1));
               $rows = $result->fetchAll(PDO::FETCH_OBJ);
               if($rows !=null){
                   foreach ($rows as $row){
                       echo "<tr id='emodeler_anal_$saisiejourn'>
                               <td id='tabCA_Num'>".$row->CA_Intitule."</td>
                               <td id='tabA_Qte'>".$row->EA_Quantite."</td>
                               <td id='tabA_Montant'>".$row->EA_Montant."</td>
                               <td id='data' style='visibility:hidden' ><span style='visibility:hidden' id='tabcbMarq'>".$row->cbMarq."</span></td>
                           </tr>";
                       $saisiejourn = $saisiejourn + 1;
                   }
               }
*/
            ?>
            </tbody>
            <tfoot>
            </tfoot>

        </table>
    </div>
</div>
<div style="clear:both"></div>



<div style="display: none;" id="barCode">
    <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx">
        <div class="custom-file">
            <label class="custom-file-label" for="fileToUpload">Take or select photo(s)</label><br />
            <input class="custom-file-input" type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" />
        </div>
        <div id="details"></div>
        <div>
            <input type="button"  class="btn btn-primary" onclick="uploadFile()" value="Valider" />
        </div>
        <div id="progress"></div>
    </form>
    <input type="hidden" id="barCodeValue" value="" />
