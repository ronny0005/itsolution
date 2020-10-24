<?php
    $depot = 0;
    $protected= 0;
    $saisiejourn = 0;
    $JO_SaisAnal = 0;
    $JO_Num = $_GET["JO_Num"];
$JO_Intitule = "";
    $Mois = substr($_GET["exercice"],-2);
    $Annee = substr($_GET["exercice"],0,4);
    $objet = new ObjetCollector();   
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_DEPOT==1) $protected = $rows[0]->PROT_DEPOT;
    }
    
        if(isset($_GET["JO_Num"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getJournauxByJONum($_GET["JO_Num"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $JO_Num = $rows[0]->JO_Num;
            $JO_Intitule = $rows[0]->JO_Intitule;
            $JO_SaisAnal = $rows[0]->JO_SaisAnal;
        }
       
    }

    
?>
<script src="js/Structure/Comptabilite/script_saisieJournalExercice.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    </div>
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color:#eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu." - ".$JO_Num ." - ".$JO_Intitule." - ".date('M', mktime(0, 0, 0, substr($_GET["exercice"],-2), 10)); ?>
    </h4>
</div>
    </head>  
        <div><h1></h1></div>
        <div>
            <div class="form-group" >
                <div class="col-lg-2">
                    Ancien solde
                </div>
                <div class="col-lg-1">
                </div>
                <div class="col-lg-1">
                </div>
            </div>
            <div style="clear: both"></div>
            <div class="form-group" >
                <div class="col-lg-2">
                    Total journal 
                </div>
                <div class="col-lg-1" id="DivtotalJournalDebit">
                    <input type="text" id="totalJournalDebit" name="totalDebit" style="background-color:white;border:white" disabled/>
                </div>
                <div class="col-lg-1" id="DivtotalJournalCredit">
                    <input type="text" id="totalJournalCredit" name="totalCredit" style="background-color:white;border:white" disabled/>
                </div>
            </div>
            <div style="clear: both"></div>
            <div class="form-group" >
                <div class="col-lg-2">
                    Nouveau solde
                </div>
                <div class="col-lg-1" id="DivnouveauSoldeDebit">
                    <input type="text" id="nouveauSoldeDebit" name="totalDebit" style="background-color:white;border:white" disabled/>
                </div>
                <div class="col-lg-1" id="DivnouveauSoldeCredit">
                    <input type="text" id="nouveauSoldeCredit" name="totalDebit" style="background-color:white;border:white" disabled/>
                </div>
            </div>
            <br/>
        </div>
        <div style="clear: both"></div>
            <div class="form-group" >
                <div class="col-lg-2">
                    <input type="button" class="btn btn-primary" id="saisieAnal" value="Saisie analytique" name="saisieAnal" <?php if($JO_SaisAnal==0)echo " disabled "; ?>/>
                </div>
            </div>
<form id="formModeleReglement" class="formModeleReglement" action="indexMVC.php?module=9&action=14" method="GET">
        
        <div class="form-group" >
            <table class="table" id="tableEcritureC" >
                <thead>
                    <tr style="text-align: center;font-weight: bold">
                        <td style="width:100px">Jour</td>
                        <td style="width:100px">N Piece</td>
                        <td style="width:100px">N Facture</td>
                        <td style="width:100px">Référence</td>
                        <td style="width:150px">N Compte général</td>
                        <td style="width:150px">N Compte tiers</td>
                        <td style="width:300px">Libellé écriture</td>
                        <td style="width:100px">Date échéance</td>
                        <td style="width:250px">Débit</td>
                        <td style="width:250px">Crédit</td>
                        <td style="width:50px"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr id="param">
                        <td>
                            <input maxlength="2" value="" type="text" name="EC_Jour" class="form-control only_integer" id="EC_Jour"/>
                        </td>
                        <td>
                        <input value="" type="text" name="EC_Piece" class="form-control" id="EC_Piece" disabled/>
                        </td>
                        <td>
                            <input value="" type="text" name="EC_Facture" class="form-control" id="EC_Facture"/>
                        </td>
                        <td>
                            <input value="" type="text" name="EC_RefPiece" class="form-control" id="EC_RefPiece"/>
                        </td>
                        <td>
                            <select name="CG_Num" class="form-control" id="CG_Num">
                                <option value=""></option>
                                <?php 
                                $result =  $objet->db->requete( $objet->getCompteg());
                                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                if($rows !=null){
                                    foreach ($rows as $row){
                                        echo "<option value=".$row->CG_Num."";
                                        //if($row->CG_Num == $CG_Num) echo " selected";
                                        echo ">".$row->CG_Num." - ".$row->CG_Intitule."</option>";
                                    }
                                }

                                ?>
                            </select>
                        </td>
                        <td>
                            <select name="CT_Num" class="form-control" id="CT_Num">
                                <option value=""></option>
                                <?php 
                                $result =  $objet->db->requete( $objet->allClients());
                                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                if($rows !=null){
                                    foreach ($rows as $row){
                                        echo "<option value=".$row->CT_Num."";
                                        //if($row->CG_Num == $CG_Num) echo " selected";
                                        echo ">".$row->CT_Num." - ".$row->CT_Intitule."</option>";
                                    }
                                }
                                $result =  $objet->db->requete($objet->allFournisseur());
                                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                if($rows !=null){
                                    foreach ($rows as $row){
                                        echo "<option value=".$row->CT_Num."";
                                        //if($row->CG_Num == $CG_Num) echo " selected";
                                        echo ">".$row->CT_Num." - ".$row->CT_Intitule."</option>";
                                    }
                                }

                                ?>
                            </select>
                        </td>
                        <td>
                            <input value="" type="text" name="EC_Intitule" class="form-control" id="EC_Intitule"/>
                        </td>
                        <td>
                            <input value="" type="text" name="EC_Echeance" class="form-control" id="EC_Echeance"/>
                        </td>
                        <td>
                            <input value="" type="text" name="EC_MontantDebit" class="form-control" id="EC_MontantDebit"/>
                        </td>
                        <td>
                            <input value="" type="text" name="EC_MontantCredit" class="form-control" id="EC_MontantCredit"/>
                        </td>
                        <td colspan="4">
                            <!-- The file input field used as target for the file upload widget -->
                            <input id='fileupload' type='file' name='files[]' multiple>
                            <!-- The global progress bar -->
                            <div id='progress' class='progress'>
                                <div class='progress-bar progress-bar-success'></div>
                            </div>
                            <!-- The container for the uploaded files -->
                            <div id='files' class='files'></div>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $result =  $objet->db->requete( $objet->getSaisieJournalExercice($JO_Num,$Mois,$Annee));
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if($rows !=null){
                            foreach ($rows as $row){
                                echo "<tr id='emodeler_$saisiejourn'>
                                        <td id='tabEC_Jour'>".$row->EC_Jour."</td>
                                        <td id='tabEC_Piece'>".$row->EC_Piece."</td>
                                        <td id='tabEC_Facture'>".$row->EC_RefPiece."</td>
                                        <td id='tabEC_RefPiece'>".$row->EC_Reference."</td>
                                        <td id='tabCG_Num'>".$row->CG_Num."</td>
                                        <td id='tabCT_Num'>".$row->CT_Num."</td>
                                        <td id='tabEC_Intitule'>".$row->EC_Intitule."</td>
                                        <td id='tabEC_Echeance'>"; if($row->EC_Echeance_C=="1900-01-01") echo ""; else echo $row->EC_Echeance_C; echo "</td>
                                        <td id='tabEC_MontantDebit'>".$objet->formatChiffre(ROUND($row->EC_MontantDebit,2))."</td>
                                        <td id='tabEC_MontantCredit'>".$objet->formatChiffre(ROUND($row->EC_MontantCredit,2))."</td>
                                        <td id='modif_$saisiejourn'><i class='fa fa-pencil fa-fw'></i></td><td id='suppr_$saisiejourn'><i class='fa fa-trash-o'></i></td>";
                                        if($row->Lien_Fichier!="")
                                            echo "<td><a target='_blank' href='upload/files/".$row->Lien_Fichier."' class='fa fa-download'></a></td>";
                                        echo "<td id='data' style='visibility:hidden' ><span style='visibility:hidden' id='tabCG_Analytique'>".$row->CG_Analytique."</span><span style='visibility:hidden' id='tabEC_No'>".$row->EC_No."</span></td></tr>";                    
                                $saisiejourn = $saisiejourn + 1;
                            }
                        }

                    ?>
                    </tbody>
                <tfoot>
                </tfoot>
                
            </table>
        </div>        
    <div style="clear:both"></div>
        <div class="form-group col-lg-2" >
            <input type="hidden" id="saisiejourn" name="saisiejourn" value="<?php echo $saisiejourn; ?>" />
            <input type="button" id="Ajouter" name="Ajouter" class="btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>        

</form>

<div id="formAnalytique">
<div class="form-group" >
    <div class="col-lg-2">
        <label>Plan</label>
        <select class="form-control" id="N_Analytique" name="N_Analytique" <?php if($protected==1) echo "disabled"; ?>>
                <?php
                    $result=$objet->db->requete($objet->getListeTypePlan());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->cbIndice."";
                            //if($row->cbIndice == $N_Analytique) echo " selected";
                            echo ">".$row->A_Intitule."</option>";
                        }
                    }
                    ?>
            </select>
    </div>
</div>

<div>
    <table id="table">
        <th style="text-align: center"><td style="padding: 10px">Qté/Devise</td><td style="padding: 10px">Montant</td></th>
        <tr style="text-align: center"><td>A imputer</td><td id="qte_imputer"></td><td id="montant_imputer"></td></tr>
        <tr style="text-align: center"><td>Total imputé</td><td id="qte_timputer"></td><td id="montant_timputer"></td></tr>
        <tr style="text-align: center"><td>Solde</td><td id="qte_solde"></td><td id="montant_solde"></td></tr>
    </table>
</div>
        
<div class="form-group" >
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
                                    echo "<option value='".$row->CA_Num."'>".$row->CA_Intitule."</option>";
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
                   $result =  $objet->db->requete($objet->getSaisieAnal(5,1));
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

               ?>
               </tbody>
           <tfoot>
               </tfoot>

       </table>
   </div>        
</div>   