
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
<form action="indexMVC.php?module=5&action=21" method="GET">
    <input type="hidden" value="5" name="module"/>
    <input type="hidden" value="21" name="action"/>
    <div class="form-group col-lg-2" >
        <label>Début</label>
        <input type="text" class="form-control" name="datedebut"  value="<?= $datedeb; ?>" id="datedebut" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Fin</label>
        <input type="text" class="form-control" name="datefin"  value="<?= $datefin; ?>" id="datefin" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Type tiers</label>
        <select class="form-control" name="type_tiers" id="type_tiers">
            <option value="-1" <?php if(-1==$type_tiers) echo " selected";?>>Tous</option>
            <option value="0" <?php if(0==$type_tiers) echo " selected";?>>Clients</option>
            <option value="1" <?php if(1==$type_tiers) echo " selected";?>>Fournisseurs</option>
            <option value="2" <?php if(2==$type_tiers) echo " selected";?>>Salariés</option>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Client de</label>
        <select class="form-control" name="clientdebut" id="clientdebut">
            <option value="0">Tous</option>
            <?php
            $comptet = new ComptetClass(0);
            $rows = $comptet->allClients();
            foreach($rows as $row){
                echo "<option value='{$row->CT_Num}'";
                if($row->CT_Num==$clientdebut) echo " selected";
                echo ">{$row->CT_Num} - {$row->CT_Intitule}</option>";
            }
            ?>
        </select>
        <label>à </label>
        <select class="form-control" name="clientfin" id="clientfin">
            <option value="0">Tous</option>
            <?php
            $comptet = new ComptetClass(0);
            $rows = $comptet->allClients();
            foreach($rows as $row){
                echo "<option value='{$row->CT_Num}'";
                if($row->CT_Num==$clientfin) echo " selected";
                echo ">{$row->CT_Num} - {$row->CT_Intitule}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
            <label>Rupture par agence</label>
        <input style="margin:auto" name="rupture" class="checkbox-inline" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
</div>
    <div class="form-group col-lg-1" >
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
    </div>
    <div class="form-group col-lg-1" >
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportbalance_tiers.php?datedeb=".$datedeb."&datefin=".$datefin."&clientdebut=".$clientdebut."&clientfin=".$clientfin."&type_tiers=".$type_tiers."&rupture=".$rupture."')\""; ?>/>
    </div>
</form>
<?php
            $totalsommeTiersAntD=0;
            $totalsommeTiersAntC=0;
            $totalsommeTiersD=0;
            $totalsommeTiersC=0;
            $totalsommeTiersAND=0;
            $totalsommeTiersANC=0;

    $result=$objet->db->requete($objet->depot());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
    if(($rupture==0 && $cmp==0)|| $rupture==1){
        if($depot_no==0 || $depot_no==$row->DE_No){
            $val=0;
            if($rupture==1 || $depot_no==$row->DE_No){
                echo "<div style='clear:both'><h3 style='text-align:center'>".$row->DE_Intitule."</h3></div>";
                $val=$row->DE_No;
            }
            $etatList = new EtatClass();
            $result=$objet->db->requete($etatList->etat_balance_tiers($objet->getDate($datedeb),$objet->getDate($datefin),$type_tiers,$clientdebut,$clientfin,$val));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $ref="";
?>

        <table id="table" class="table table-bordered" cellspacing="0" >
            <thead>
            <tr style="background-color: lightgray ">
                <th>N° de compte</th>
                <th>Intitulé des comptes</th>
                <th colspan="2">Mouvements au 31/12/<?= substr($datedeb,0,4)-1; ?></th>
                <th colspan="2">Mouvements</th>
                <th colspan="2">Soldes cumulés</th>
            </tr>
            <tr style="background-color: lightgray ">
                <td colspan="2"></td>
                <td style="text-align: center;font-weight: bold">Débit</td>
                <td style="text-align: center;font-weight: bold">Crédit</td>
                <td style="text-align: center;font-weight: bold">Débit</td>
                <td style="text-align: center;font-weight: bold">Crédit</td>
                <td style="text-align: center;font-weight: bold">Débit</td>
                <td style="text-align: center;font-weight: bold">Crédit</td>
            </tr>
            </thead>
            <tbody>
            <?php
            if($rows==null){
            }else{
                $sommeTiersAntD=0;
                $sommeTiersAntC=0;
                $sommeTiersD=0;
                $sommeTiersC=0;
                $sommeTiersAND=0;
                $sommeTiersANC=0;
                foreach ($rows as $row){
                    echo "<tr class='eqstock'>"
                        ."<td>".$row->CT_Num."</td>"
                        ."<td>".$row->CT_Intitule."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->tiersAntD,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->tiersAntC,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->tiersD,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->tiersC,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->CumulD,2))."</td>"
                        ."<td>".$objet->formatChiffre(ROUND($row->CumulC,2))."</td>";
                    echo "</tr>";
                    $sommeTiersAntD=$sommeTiersAntD+ROUND($row->tiersAntD,2);
                    $sommeTiersAntC=$sommeTiersAntC+ROUND($row->tiersAntC,2);
                    $sommeTiersD=$sommeTiersD+ROUND($row->tiersD,2);
                    $sommeTiersC=$sommeTiersC+ROUND($row->tiersC,2);
                    $sommeTiersAND=$sommeTiersAND+ROUND($row->CumulD,2);
                    $sommeTiersANC=$sommeTiersANC+ROUND($row->CumulC,2);

                    $totalsommeTiersAntD=$totalsommeTiersAntD+ROUND($row->tiersAntD,2);
                    $totalsommeTiersAntC=$totalsommeTiersAntC+ROUND($row->tiersAntC,2);
                    $totalsommeTiersD=$totalsommeTiersD+ROUND($row->tiersD,2);
                    $totalsommeTiersC=$totalsommeTiersC+ROUND($row->tiersC,2);
                    $totalsommeTiersAND=$totalsommeTiersAND+ROUND($row->CumulD,2);
                    $totalsommeTiersANC=$totalsommeTiersANC+ROUND($row->CumulC,2);

                }
                echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='2'>A reporter</td>
                        <td>".$objet->formatChiffre($sommeTiersAntD)."</td>
                        <td>".$objet->formatChiffre($sommeTiersAntC)."</td>
                        <td>".$objet->formatChiffre($sommeTiersD)."</td>
                        <td>".$objet->formatChiffre($sommeTiersC)."</td>
                        <td>".$objet->formatChiffre($sommeTiersAND)."</td>
                        <td>".$objet->formatChiffre($sommeTiersANC)."</td>
                        </tr>";}
            }


            ?>
            </tbody>
        </table>
<?php
}$cmp++;
}


if($rupture==1){

    ?>
    <table>
        <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
            <td style="padding:10px">Mvt au 31/12/<?= substr($datedeb,0,4)-1; ?> (Débit): </td>
            <td style="padding:10px"><?= $objet->formatChiffre($totalsommeTiersAntD); ?></td>
            <td style="padding:10px">Mvt au 31/12/<?= substr($datedeb,0,4)-1; ?> (Crédit): </td>
            <td style="padding:10px"><?= $objet->formatChiffre($totalsommeTiersAntC); ?></td>
        </tr>
        <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
            <td style="padding:10px">Mvt (Débit): </td>
            <td style="padding:10px"><?= $objet->formatChiffre($totalsommeTiersD); ?></td>
            <td style="padding:10px">Mvt (Crédit): </td>
            <td style="padding:10px"><?= $objet->formatChiffre($totalsommeTiersC); ?></td>
        </tr>
        <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
            <td style="padding:10px">Cumul (Débit): </td>
            <td style="padding:10px"><?= $objet->formatChiffre($totalsommeTiersAND); ?></td>
            <td style="padding:10px">Cumul (Crédit): </td>
            <td style="padding:10px"><?= $objet->formatChiffre($totalsommeTiersANC); ?></td>
        </tr>
    </table>
    <?php
}
?>