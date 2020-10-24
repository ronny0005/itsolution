
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
<form action="indexMVC.php?module=5&action=9" method="GET">
    <input type="hidden" value="5" name="module"/>
    <input type="hidden" value="9" name="action"/>
    <div class="form-group col-lg-2" >
        <label>Début</label>
        <input type="text" class="form-control" name="datedebut"  value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Fin</label>
        <input type="text" class="form-control" name="datefin"  value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Caisse</label>
        <select class="form-control" name="caisse" id="caisse">

            <?php

            if($admin==0){
                $isPrincipal = 1;
                $result=$objet->db->requete($objet->getCaisseDepot($_SESSION["id"]));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
            }else{
                $caisseClass = new CaisseClass(0,$objet->db);
                $rows = $caisseClass->listeCaisseShort();
            }

            if(sizeof($rows)>1){
                echo "<option value='0'";
                    if($caisse_no==0) echo " selected ";
                    echo ">TOUT</option>";
                }
            if($rows==null){
            }else{
                foreach($rows as $row){
                    echo "<option value='{$row->CA_No}'";
                    if($row->CA_No==$caisse_no) echo " selected";
                    echo ">{$row->CA_Intitule}</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Type règlement :</label>
                <select class="form-control" name="type_reglement" id="type_reglement">
                    <option value="-1"<?php if($type_reglement==-1) echo " selected"; ?>>TOUT LES MOUVEMENTS</option>
                    <option value="0"<?php if($type_reglement==0) echo " selected"; ?>>Règlement</option>
                    <option value="5"<?php if($type_reglement==5) echo " selected"; ?>>Entrée</option>
                    <option value="4"<?php if($type_reglement==4) echo " selected"; ?>>Sortie</option>
                    <option value="6"<?php if($type_reglement==6) echo " selected"; ?>>Versement bancaire</option>
                    <option value="2"<?php if($type_reglement==2) echo " selected"; ?>>Fond de caisse</option>
                </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Mode règlement :</label>
                <select style="width:165px" type="checkbox" id="mode_reglement" name="mode_reglement" class="form-control">
                <option value="0" <?php if($mode_reglement==0) echo "selected"; ?>>TOUS LES MODES</option>
                <?php 
                $result = $objet->db->requete( $objet->listeTypeReglement());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows !=null){
                    foreach ($rows as $row){
                        echo "<option value='".$row->R_Code."' ";
                                if($row->R_Code==$mode_reglement) echo "selected";
                                echo ">".$row->R_Intitule."</option>";
                    }
                }

                ?>
                </select>
    </div>
    <div class="form-group col-lg-2" >
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
    </div>
    <div class="form-group col-lg-2" >
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportEtatCaisse.php?datedeb=".$datedeb."&datefin=".$datefin."&caisse=".$caisse_no."&mode_reglement=".$mode_reglement."&type_reglement=".$type_reglement."')\""; ?>/>
    </div>
</form>
<?php
$totalFondCaisse=0;
$totalEntree=0;
$totalSortie=0;

if($admin==0){
    $isPrincipal = 1;
    $result=$objet->db->requete($objet->getCaisseDepot($_SESSION["id"]));
}else{
    $result=$objet->db->requete($objet->caisse());
}
 $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
            $val_caisse=$row->CA_No;
            if($caisse_no==0 || $caisse_no==$row->CA_No){
            
            echo "<h4 style='text-align: center'>".$row->CA_Intitule."</h4>";
       
?><table id="table" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr style="text-transform: uppercase">
            <th style="vertical-align: middle">Date</th>
            <th>Mode <br/>de règlement</th>
            <th>N° <br/>Tiers</th>
            <th style="vertical-align: middle">Libellé</th>
            <th>Fond <br/>de caisse</th>
            <th>Entrée<br/> caisse</th>
            <th>Sortie<br/> caisse</th>
            <th>Solde<br/> progressif</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $etatList = new EtatClass();
    $query = $etatList->etatCaisse($val_caisse, $objet->getDate($datedeb), $objet->getDate($datefin),$mode_reglement,$type_reglement);
    $result=$objet->db->requete($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $dlprix=0;
        $cumulPrix=0;
        $somCredit=0;
        $somDebitt=0;
        $somFondCaisse=0;
        $classe="";
        $ref="";
        if($rows==null){
            echo "<tr><td colspan='7'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $somCredit=$somCredit+ROUND($row->CREDIT,2);
                if($row->N_Reglement!=5)
                $somDebitt=$somDebitt+ROUND($row->DEBIT,2);
                $somFondCaisse=$somFondCaisse+ROUND($row->FOND_CAISSE,2);
                if($row->N_Reglement==1 || $row->N_Reglement==10)
                    $cumulPrix=ROUND($row->CUMUL,2);
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td>".$objet->getDateDDMMYYYY($row->RG_Date)."</td>"
                ."<td>".$row->R_Intitule."</td>"
                ."<td>".$row->CT_Intitule."</td>"
                ."<td>".$row->RG_Libelle."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->FOND_CAISSE,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->CREDIT,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->DEBIT,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->CUMUL,2))."</td>"
                . "</tr>";
            }

            $totalFondCaisse=$totalFondCaisse+$somFondCaisse;
            $totalEntree=$totalEntree+$somCredit;
            $totalSortie=$totalSortie+$somDebitt;
            $total = $somCredit + $somDebitt + $somFondCaisse;
        echo "<tr style='background-color: grey;color: white;font-weight: bold;'><td colspan='4' >Total</td><td>".$objet->formatChiffre($somFondCaisse)."</td><td>".$objet->formatChiffre($somCredit)."</td><td>".$objet->formatChiffre($somDebitt)."</td>"
                . "<td>".$objet->formatChiffre($cumulPrix)."</td></tr>";
        }
        
    ?>
        </tbody>
    </table>
        <?php 
        }
        
        }
    }
        ?>
