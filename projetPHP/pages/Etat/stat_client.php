
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_etat.js?d=<?php echo time(); ?>"></script>
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
<form action="indexMVC.php?module=5&action=5" method="GET">
    <div class="form-group col-lg-2" >
            <label>Début</label>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="5" name="action"/>
            <input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Fin</label>
        <input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
    </div>
    <div class="form-group col-lg-3" >
        <label>Centre</label>
        <select class="form-control" name="depot" id="depot">
            <?php
            $depotClass = new DepotClass(0);
            if($admin==0){
                $rows = $depotClass->getDepotUserPrincipal($_SESSION["id"]);
                if(sizeof($rows)>1){
                    echo"<option value='0'";
                    if(0==$depot_no) echo " selected";
                    echo ">Tous</option>";
                }
            }
            else {
                echo"<option value='0'";
                if(0==$depot_no) echo " selected";
                echo ">Tous</option>";
                $depotClass = new DepotClass(0);
                $rows = $depotClass->all();
            }
            if($rows==null){
            }else{
                foreach($rows as $row){
                    echo "<option value=".$row->DE_No."";
                    if($row->DE_No==$depot_no) echo " selected";
                    echo ">".$row->DE_Intitule."</option>";
                }
            }
            ?>
    </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Type</label>
        <select name="do_type" id="do_type" class="form-control">
            <option value="2" <?php if($do_type==2) echo "selected"; ?>>TI</option>
            <option value="7" <?php if($do_type==7) echo "selected"; ?>>TI + FC </option>
            <option value="6" <?php if($do_type==6) echo "selected"; ?>>TI + FC + FA</option>
            <option value="3" <?php if($do_type==3) echo "selected"; ?>>TI + FC + FA + BL</option>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Rupture par agence</label>
        <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
    </div>
    <div class="form-group col-lg-3">
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportStatClientParAgence.php?type=mvtStock&datedeb=".$datedeb."&datefin=".$datefin."&depot=".$depot_no."&rupture=".$rupture."&do_type=".$do_type."')\""; ?> />
    </div>
</form>
                
<?php

$totalCANetHTG=0;
$totalPrecompteG=0;
$totalCANetTTCG=0;
$totalMargeG=0;
if($admin==0){
    $rows = $depotClass->getDepotUserPrincipal($_SESSION["id"]);
}
else {
    $depotClass = new DepotClass(0);
    $rows = $depotClass->all();
}
foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                if($rupture==1 || $depot_no==$row->DE_No){
                  echo "<div style='clear:both'><h3 style='text-align:center'>".$row->DE_Intitule."</h3></div>";
                $val=$row->DE_No;
                }
                $etatList = new EtatClass();
                $result=$objet->db->requete($etatList->stat_clientParAgence($val, $objet->getDate($datedeb), $objet->getDate($datefin),$do_type,$_SESSION["id"] ));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
    
        $i=0;
        $canetht=0;
        $canetttc=0;
        $precompte=0;
        $marge=0;
        $tva=0;
        $classe="";
?>
<table id="table" class="table table-striped table-bordered" cellspacing="0">
    <tr>
            <th>Client</th>
            <th>CA HT</th>
            <th>Precompte</th>
            <?php if($flagPxRevient==0) { echo"<th>Marge</th>";} ?>
            <th>CA TTC</th>
        </tr>
    <?php
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".$row->CT_Intitule."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->TotCAHTNet,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->PRECOMPTE,2))."</td>";
                if($flagPxRevient==0) { echo "<td>".$objet->formatChiffre(ROUND($row->TotMarge,2))."</td>";}
                echo "<td>".$objet->formatChiffre(ROUND($row->TotCATTCNet,2))."</td>"
                . "</tr>";
                $canetht=$canetht+ROUND($row->TotCAHTNet,2);
                $canetttc=$canetttc+ROUND($row->TotCATTCNet,2);
                $precompte=$precompte+ROUND($row->PRECOMPTE,2);
                $marge=$marge+ROUND($row->TotMarge,2);
                
                $totalCANetHTG=$totalCANetHTG+ROUND($row->TotCAHTNet,2);
                $totalPrecompteG=$totalPrecompteG+ROUND($row->PRECOMPTE,2);
                $totalCANetTTCG=$totalCANetTTCG+ROUND($row->TotCATTCNet,2);
                $totalMargeG=$totalMargeG+ROUND($row->TotMarge,2);
            }
            
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td>";
        echo "<td>".$objet->formatChiffre($canetht)."</td><td>".$objet->formatChiffre($precompte)."</td>";
        if($flagPxRevient==0) { echo "<td>".$objet->formatChiffre($marge)."</td>";}
        echo "<td>".$objet->formatChiffre($canetttc)."</td></tr>";
        }
        
    ?>
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
        <td style="padding:10px">CA Net HT : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetHTG); ?></td>
        <td style="padding:10px">Precompte : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalPrecompteG); ?></td>
        <td style="padding:10px">CA Net TTC : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetTTCG); ?></td>
        <?php if($flagPxRevient==0){ ?>
        <td style="padding:10px">Marge : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMargeG); ?></td>
        <?php } ?>
    </tr>
</table>
<?php
}
?>
        <div style="width:500px;float:left;height:300px;margin-right: 20px" id="chartContainer"></div>
        <div style="width:500px;float:right;height:300px" id="chartContainer2"></div>
        <script type="text/javascript">
</script>
