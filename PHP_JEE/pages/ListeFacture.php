<script src="js/script_listeFacture.js?d=<?php echo time(); ?>"></script>
<section class="bgcolorApplication" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);"><?= $protection->listeFactureNom($type) ?></h3>
</section>
<section class="mt-3">
<form id="valideLigne" action="listeFacture-<?= $type ?>" method="POST">
    <div class="card p-3">
    <div class="row p-2">
        <div class="col-6 col-sm-6 col-md-6 col-lg-2"><label>Début</label>
            <div class="input-group">
                <input class="form-control" type="text" id="datedebut" name="datedebut" inputmode="numeric" maxlength="6" value="<?= $datedeb ?>">
                <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
            <label>Fin</label>
            <div class="input-group">
                <input class="form-control" type="text" id="datefin" name="datefin" inputmode="numeric" maxlength="6" value="<?= $datefin ?>">
                <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <label>Dépot</label>
            <div class="input-group">
                <input type="hidden" value="<?= sizeof($_POST) ?>" name="post" id="post"/>
                <input type="hidden" value="<?= $protection->lienMenuNouveau($type) ?>" name="lienMenuNouveau" id="lienMenuNouveau"/>
                <input type="hidden" value="<?= $type ?>" name="typeDoc" id="typeDoc"/>
                <select class="form-control" id="depot" name="depot">
                    <?= $listeDepot ?>
                </select>
                <span class="input-group-append">
                    <span class="input-group-text bg-transparent"><i class="fas fa-industry"></i></span>
                </span>
            </div>
        </div>

        <div <?= $afficheListeTiers ?> class="col-12 col-sm-6 col-md-6 col-lg-3">
            <label><?= $libTiers ?></label>
            <div class="input-group">
                <input type="hidden" id="CT_Num" value ="<?= $client ?>" name="client">
                <input type="text"  id="client" value ="<?= $libClient ?>" name="libClient" class="form-control">
                <span class="input-group-append">
                    <span class="input-group-text bg-transparent"><i class="fas fa-users"></i></span>
                </span>
            </div>
        </div>

        <div <?= $afficheTypeFacture ?> class="col-12 col-sm-6 col-md-6 col-lg-2">
            <label>Type</label>
            <select class="form-control" id="type" name="type">
                <?= $listeTypeFacture ?>
            </select>
        </div>
        <div class="col-12 col-lg-0 text-right mt-3">
            <button class="w-100 btn btn-primary" id="valider" type="button">Valider</button>
        </div>
    </div>
    </div>
</form>
</section>


    <div class="card p-3 mt-3">
        <div>
        <button <?= $afficheBoutonNouveau ?> class="btn btn-primary" id="nouveau" type="button">Nouveau</button>
        </div>
        <div class="table-responsive" style="margin-top: 30px;clear:both">
            <table id="tableListeFacture" class="table table-striped">
                <thead class="">
                    <tr>
                        <th>Numéro Pièce</th>
                        <th>Reference</th>
                        <th style="display: none">Reference</th>
                        <th>Date</th>
                        <th <?= ($protection->afficheClientListe($type)) ?>>Client</th>
                        <th <?= ($protection->afficheDepotListe($type)) ?>>Dépot</th>
                        <th <?= ($protection->afficheFournisseurListe($type)) ?>>Fournisseur</th>
                        <th <?= ($protection->afficheFournisseurListe($type)) ?>>Dépot</th>
                        <th <?= ($protection->afficheDepotDestListe($type)) ?>>Dépot source</th>
                        <th <?= ($protection->afficheDepotDestListe($type))?>>Dépot dest.</th>
                        <th>Total TTC</th>
                        <th <?= ($protection->afficheStatutListe ($type)) ?>>Montant r&eacute;gl&eacute;</th>
                        <th <?= ($protection->afficheStatutListe ($type)) ?>>Statut</th>
                        <th <?= ($protectedSuppression) ? "" : "style='display:none'" ?> ></th>
                        <th <?= ($protection->afficheTransformListe($type))  ?>></th>
                        <th></th>
                        <th <?= ($protection->PROT_CBCREATEUR!=2) ? "" : "style='display:none'" ?>>Créateur</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $docEntete = new DocEnteteClass(0);
                $listFacture = $docEntete->listeFactureSelect($depot,$objet->getDate($datedeb),$objet->getDate($datefin),$client,$type);

                if(sizeof($listFacture)>0){
                    foreach ($listFacture as $row){
                    $message="";
                    $avance="";
                    if($protection->afficheStatutListe ($type)==""){
                        $avance = round($row->avance);
                        if($avance==null) $avance = 0;
                        $message =$row->statut;
                    }
                    $date = new DateTime($row->DO_Date);
                    ?>
                    <tr data-toggle="tooltip" data-placement="top" title="<?= $row->PROT_User ?>"
                        class='facture' id='article_<?= $row->DO_Piece ?>'>
                        <td id='entete'><a href='<?= lienfinal($row->DO_Piece,$type,$row->cbMarq,$row->DO_Domaine,$row->DO_Type,$protected) ?>'><?= $row->DO_Piece ?></a></td>
                        <td><?= $row->DO_Ref ?></td>
                        <td style='display:none' id='cbMarq'><?= $row->cbMarq ?></td>
                        <span style='display:none' id='cbCreateur'><?= $row->PROT_User ?></span>
                        <td><?= $date->format('d-m-Y') ?></td>
                        <td <?= ($protection->afficheClientListe($type)) ?>><?= $row->CT_Intitule ?></td>
                        <td <?= ($protection->afficheDepotListe($type)) ?>><?= $row->DE_Intitule ?></td>
                        <td <?= ($protection->afficheFournisseurListe($type)) ?>><?= $row->CT_Intitule ?></td>
                        <td <?= ($protection->afficheFournisseurListe($type)) ?>><?= $row->DE_Intitule ?></td>
                        <td <?= ($protection->afficheDepotDestListe($type)) ?>><?= $row->DE_Intitule ?></td>
                        <td <?= ($protection->afficheDepotDestListe($type)) ?>><?= (isset($row->DE_Intitule_dest)) ? $row->DE_Intitule_dest : " " ?></td>
                        <td><?= $objet->formatChiffre(round($row->ttc)) ?></td>
                        <td <?= ($protection->afficheStatutListe ($type)) ?>><?= $objet->formatChiffre($avance) ?></td>
                        <td <?= ($protection->afficheStatutListe ($type)) ?>><?= $message ?></td>
                        <td <?= ($protectedSuppression) ? "" : "style='display:none'" ?> >
                            <a href="Traitement\Facturation.php?type=<?= $type ?>&acte=suppr_facture&cbMarq=<?= $row->cbMarq ?>" onclick="if(window.confirm('Voulez-vous vraiment supprimer la facture <?= $row->DO_Piece ?> ?')){return true;}else{return false;}">
                                <i class='fa fa-trash-o'></i></a></td>
                        </td>
                        <td <?= $protection->afficheTransformListe($type) ?>><input type="button" class="btn btn-primary" value="Convertir en facture" id="transform"/></td>
                        <td><i class='fa fa-print' <?= ($row->DO_Imprim) ? "" : "style='display:none'" ?>></i></td>
                        <td <?= ($protection->PROT_CBCREATEUR!=2) ? "" : "style='display:none'" ?>><?= $row->PROT_User ?></td>
                    </tr>
                        <?php
                    }
                }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <div id="menu_transform">
        <div class="row">
            <div class="col-12">
                <label>Type<br/></label>
                <select id="type_trans" name="type_trans" class="form-control">
                    <option value="6">Facture</option>
                    <?php
                    if($type=="Devis")
                        echo "<option value='3'>Bon de livraison</option>";
                    ?>
                </select>
            </div>
            <div class="col-12">
                <label>Nouvelle date</label>
                <input class="form-control" type="text" id="date_transform"/>
            </div>
            <div class="col-12">
                <label>Nouvelle référence</label>
                <input class="form-control" type="text" id="reference"/>
            </div>
        </div>
    </div>