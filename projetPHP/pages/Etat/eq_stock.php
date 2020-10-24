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
<form action="indexMVC.php?module=5&action=3" method="GET">
    <table style="margin-bottom: 20px">
    <thead>
        <tr>
            <td style="width:100px;vertical-align: middle">D&eacute;but :</td>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="3" name="action"/>
            <td><input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:95px;vertical-align: middle">Fin :</td>
            <td><input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:60px;vertical-align: middle"> D&eacute;pot :</td>
            <td style="padding-left: 10px;width:200px;">
                <select class="form-control" name="depot" id="depot">
                    <?php
                    $depotClass = new DepotClass(0);
                    if($admin==0){
                        $rows = $depotClass->getDepotUserPrincipal($_SESSION["id"]);
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
            </td>
            <td>Rupture par agence <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> /></td>
            <td style="padding-left:30px"><input type="submit" id="valider" class="btn btn-primary" value="Valider"/></td>
            <td style="padding-left:30px"><input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportEquationStock.php?type=mvtStock&datedeb=".$datedeb."&datefin=".$datefin."&depot=".$depot_no."&rupture=".$rupture."')\""; ?>/></td>
        </tr>
</table>
</form>
<?php
    $totalStockG=0;
    $totalEntreeG=0;
    $totalSortieG=0;
    $totalStockFinalG=0;
    $totalQteVendueG=0;
    $totalStockRestantG=0;
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
                $result=$objet->db->requete($objet->equationStkVendeur($val,$objet->getDate($datedeb),$objet->getDate($datefin)));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        $stock=0;
        $entree=0;
        $retours=0;
        $sorties=0;
        $stock_final=0;
        $qte_vendues=0;
        $stk_restant=0;
?>
<table id="table" class="table table-striped table-bordered" cellspacing="0">
    <tr>
            <th>Désignation</th>
            <th>Stocks</th>
            <th>Entrées</th>
            <th>Sorties</th>
            <th>Stock final</th>
            <th>Quantités vendues</th>
            <th>Stocks restants</th>
        </tr>
    <?php
    
        if($rows==null){
            echo "<tr><td  colspan='7'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".$row->AR_Design."</td>"
                ."<td>".$objet->formatChiffre($row->STOCKS)."</td>"
                ."<td>".$objet->formatChiffre($row->ENTREES)."</td>"
                ."<td>".$objet->formatChiffre($row->SORTIES)."</td>"
                ."<td>".$objet->formatChiffre($row->STOCK_FINAL)."</td>"
                ."<td>".$objet->formatChiffre($row->QTE_VENDUES)."</td>"
                ."<td>".$objet->formatChiffre($row->STOCK_RESTANTS)."</td>"
                . "</tr>";
                $stock=$stock+$row->STOCKS;
                $entree=$entree+$row->ENTREES;
                $sorties=$sorties+$row->SORTIES;
                $stock_final=$stock_final+$row->STOCK_FINAL;
                $qte_vendues=$qte_vendues+$row->QTE_VENDUES;
                $stk_restant=$stk_restant+$row->STOCK_RESTANTS;
                $totalStockG=$totalStockG + $row->STOCKS;
                $totalEntreeG=$totalEntreeG + $row->ENTREES;
                $totalSortieG=$totalSortieG + $row->SORTIES;
                $totalStockFinalG=$totalStockFinalG + $row->STOCK_FINAL;
                $totalQteVendueG=$totalQteVendueG + $row->QTE_VENDUES;
                $totalStockRestantG=$totalStockRestantG + $row->STOCK_RESTANTS;
            }
        }
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td>";
                
        echo "<td>".$objet->formatChiffre($stock)."</td><td>".$objet->formatChiffre($entree)."</td><td>".$objet->formatChiffre($sorties)."</td><td>".$objet->formatChiffre($stock_final)."</td>"
                . "<td>".$objet->formatChiffre($qte_vendues)."</td><td>".$objet->formatChiffre($stk_restant)."</td></tr>";
        
    ?>
    </table>
<?php
}
        }$cmp++;
    }
if($rupture==1){
?>
<table>
    <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
        <td style="padding:10px">Stocks : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalStockG); ?></td>
        <td style="padding:10px">Entrées : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalEntreeG); ?></td>
        <td style="padding:10px">Sorties : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalSortieG); ?></td>
        <td style="padding:10px">Quantités vendues : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteVendueG); ?></td>
        <td style="padding:10px">Stocks restants : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalStockRestantG); ?></td>
    </tr>
</table>
<?php
}
?>
            