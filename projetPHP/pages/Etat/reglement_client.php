
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/script_etat.js"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
include("enteteParam.php");
?>
<div id="milieu">    
    <div class="container">
            
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<form action="indexMVC.php?module=5&action=7" method="GET">
    <div class="form-group col-lg-2" >
            <label>Début</label>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="7" name="action"/>
            <input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Fin</label>
        <input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Mode règlement</label>
        <select style="width:165px" type="checkbox" id="mode_reglement" name="mode_reglement" class="form-control"> 
                <option value="0" <?php if($treglement==0) echo "selected"; ?>>TOUS LES MODES</option>
                <?php 
                $result = $objet->db->requete( $objet->listeTypeReglement());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows !=null){
                    foreach ($rows as $row){
                        echo "<option value='".$row->R_Code."' ";
                                if($row->R_Code==$treglement) echo "selected";
                                echo ">".$row->R_Intitule."</option>";
                    }
                }

                ?>
                </select>
    </div>
        <div class="form-group col-lg-2" >
        <label>Type Facture</label>
        <select class="form-control" name="facComptabilise" id="facComptabilise">
            <option value="0" <?php if($facComptabilise==0) echo " selected "; ?>>Tous</option>
            <option value="1" <?php if($facComptabilise==1) echo " selected "; ?>>Facture</option>
            <option value="2" <?php if($facComptabilise==2) echo " selected "; ?>>Facture Comptabilisée</option>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Type règlement</label>
        <select class="form-control" style="width:180px" name="type" id="type">
            <option value="-1" <?php if ($type==-1) echo "selected"; ?> >Tous</option>
            <option value="1"  <?php if ($type==1) echo "selected"; ?> >Règlements imputés</option>
            <option value="0"  <?php if ($type==0) echo "selected"; ?> >Règlements non imputés</option>
        </select>
    </div>
    <div class="form-group col-lg-3" >
        <label>Client</label>
        <select class="form-control" name="client" id="client">
            <option value="0"<?php if($client=="0") echo "selected"; ?>>Tous</option>   
            <?php
            $comptet = new ComptetClass(0);
            $rows = $comptet->allClients();
            foreach($rows as $row){
                echo "<option value='{$row->CT_Num}'";
                if($row->CT_Num==$client) echo " selected ";
                echo ">{$row->CT_Intitule}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Caisse</label>
        <select class="form-control" name="caisse" id="caisse">
            <?php
            $caisseClass = new CaisseClass(0);

            if($admin==0){
                $isPrincipal = 1;
                $rows = $caisse->getCaisseDepot($_SESSION["id"]);
            }else{
                echo "<option value=''";
                if($caisse=="") echo " selected ";
                echo ">Tout</option>";
                $rows = $caisse->all();
            }
            foreach($rows as $row){
                echo "<option value={$row->CA_No}";
                if($row->CA_No==$caisse) echo " selected";
                echo ">{$row->CA_Intitule}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Rupture par caisse</label>
        <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
    </div>
    <div class="form-group col-lg-3" >
        <label></label>
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportReglementClient.php?type=".$type."&mode_reglement=".$treglement."&client=".$client."&caisse=$caisse&datedeb=".$datedeb."&datefin=".$datefin."&rupture=".$rupture."&facComptabilise=".$facComptabilise."')\""; ?>/>
    </div>
        
</form>
<?php
$totalMontantG=0;
$totalMontantAvanceG=0;
$totalResteAPayerG=0;
$caisseClass = new CaisseClass(0);
    $rows = $caisseClass->all();
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($caisse==0 || $caisse==$row->CA_No){
                $val=0;
                if($rupture==1 || $caisse==$row->CA_No){
                 echo "<div style='clear:both'><h3 style='text-align:center'>".$row->CA_Intitule."</h3></div>";
                 $val=$row->CA_No;
                }
                $result=$objet->db->requete($objet->getReglement($client,$type,$treglement,$objet->getDate($datedeb),$objet->getDate($datefin),$val,$facComptabilise));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                $i=0;
                $somRG=0;
                $somRC=0;
                $somRAP=0;
                $classe="";
?>
<table id="table" class="table table-striped table-bordered" cellspacing="0">
    <thead>
    <tr>
            <th>Date</th>
            <th>N° Tiers</th>
            <th>Libelle</th>
            <th>Montant</th>
            <th>Montant imputé</th>
            <th>Reste à imputer</th>
            <th>Caisse</th>
            <th>Caissier</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($rows==null){
        echo "<tr><td>Aucun élément trouvé ! </td></tr>";
    }else{
        foreach ($rows as $row){
        $i++;
        if($i%2==0) $classe = "info";
                else $classe="";
        echo "<tr class='reglement $classe' id='reglementetat".$row->RG_No."'>"
                . "<td>".$row->RG_Date."</td>"
                . "<td>".$row->CT_NumPayeur."</td>"
                . "<td>".$row->RG_Libelle."</td>"
                . "<td id='RG_Montant'>".$objet->formatChiffre(ROUND($row->RG_Montant))."</td>"
                . "<td id='RC_Montant'>".$objet->formatChiffre(ROUND($row->RC_Montant))."</td>"
                . "<td id='RC_Montant'>".$objet->formatChiffre(ROUND($row->RG_Montant - $row->RC_Montant))."</td>"
                . "<td>".$row->CA_Intitule."</td>"
                . "<td>".$row->CO_Nom."</td>"
                . "<td style='display:none' id='RG_No'>".$row->RG_No."</td>"
                . "</tr>";
    $result=$objet->db->requete($objet->getFactureRGNo($row->RG_No));
    $rowsFacture = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rowsFacture as $rowfacture){
        echo "<tr class='reglement' id='reglementetat'>"
                . "<td id='RC_Montant'></td>"
                . "<td>".$rowfacture->DO_Date."</td>"
                . "<td>".$rowfacture->CT_Num."</td>"
                . "<td>".$rowfacture->DO_Piece."</td>"
                . "<td id='RG_Montant'>".$objet->formatChiffre(ROUND($rowfacture->ttc))."</td>"
                . "<td id='RC_Montant'></td>"
                . "<td></td>"
                . "<td></td>"
                . "<td style='display:none' id='RG_No'></td>"
                . "</tr>";
    }


        $somRG=$somRG+ROUND($row->RG_Montant,2);
        $somRC=$somRC+ROUND($row->RC_Montant,2);
        $somRAP=$somRAP+ROUND($row->RG_Montant - $row->RC_Montant,2);
        $totalMontantG=$totalMontantG+ROUND($row->RG_Montant,2);
        $totalMontantAvanceG=$totalMontantAvanceG+ROUND($row->RC_Montant,2);
        $totalResteAPayerG=$totalResteAPayerG+ROUND($row->RG_Montant - $row->RC_Montant,2);

        }
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='2'>Total</td><td></td>"
        . "<td>".$objet->formatChiffre($somRG)."</td><td>".$objet->formatChiffre($somRC)."</td><td>".$objet->formatChiffre($somRAP)."</td><td></td><td></td></tr>";
    }

    ?>
        </tbody>
    </table>

<?php 
            }
        }
        $cmp++;
    }
    
 if($rupture==1){
?>
<table>
    <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
        <td style="padding:10px">Montant : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontantG); ?></td>
        <td style="padding:10px">Montant imputé : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontantAvanceG); ?></td>
        <td style="padding:10px">Reste à imputer : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalResteAPayerG); ?></td>
    </tr>
</table>
<?php 
    }
?>