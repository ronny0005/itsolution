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
<form action="indexMVC.php?module=5&action=4" method="GET">
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="23" name="action"/>
    <div class="form-group col-lg-3" >
        <label>Centre</label>
        <select class="form-control" name="depot" id="depot">
            <?php
            echo"<option value='0'";
            if(0==$depot_no) echo " selected";
            echo ">Tous</option>";
            $depotClass = new DepotClass(0);
            if($admin==0){
                $rows = $depotClass->getDepotUser($_SESSION["id"]);
            }
            else {
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
        <label>Rupture par agence</label>
        <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
    </div>
    <div class="form-group col-lg-2" >
        <label>Famille</label>
        <select class="form-control" id="famille" name="famille"><option value="0">Tous</option>
            <?php
                $familleClass = new FamilleClass(0);
                $rows = $familleClass->getShortList();
            if($rows==null){
            }else{
                foreach($rows as $row){
                    echo "<option value='{$row->FA_CodeFamille}'";
                    if(isset($_GET["famille"]) && $row->FA_CodeFamille==$famille) echo " selected";
                    echo ">{$row->FA_Intitule}</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Article</label>
        <select  class="form-control" id="articledebut" name="articledebut"><option value="0">Tous</option>
            <?php
            $articleClass = new ArticleClass(0);
            $rows = $articleClass->getShortList();
            foreach($rows as $row){
                echo "<option value=".$row->AR_Ref."";
                if(isset($_GET["articledebut"]) && $row->AR_Ref==$articledebut) echo " selected";
                echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
            }
            ?>
        </select>
        <label>à</label>
        <select  class="form-control" id="articlefin" name="articlefin"><option value="0">Tous</option>
            <?php
            $articleClass = new ArticleClass(0);
            $rows = $articleClass->getShortList();
            foreach($rows as $row){
                echo "<option value=".$row->AR_Ref."";
                if(isset($_GET["articlefin"]) && $row->AR_Ref==$articlefin) echo " selected";
                echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-3">
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportEtatReaprovisionnement.php?depot=$depot_no&rupture=$rupture&articledebut=$articledebut&articlefin=$articlefin')\""; ?> />
    </div>
</form>
        
<?php
        
    $totalQteReel=0;
    $totalQteMini=0;
    $totalQteMax=0;
    $totalQteCommande=0;
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
                $etatClass = new EtatClass();
        $rows = $etatClass->etatCommande($val,$articledebut,$articlefin,$famille);
        $i=0;
        $classe="";

        $QteReel=0;
        $QteMini=0;
        $QteMax=0;
        $QteCommande=0;
                
?>
<table id="tabletri" class="table table-striped table-bordered" cellspacing="0">
    <thead>
        <tr>
            <th>Référence</th>
            <th>Désignation</th>
            <th>Qté réel</th>
            <th>Qté stock minimum</th>
            <th>Qté stock maximum</th>
            <th>En rupture de</th>
        </tr>
    </thead>
    <?php
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $i++;
                if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".$row->AR_Ref."</td>"
                ."<td>".$row->AR_Design."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->AS_QteSto,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->AS_QteMini,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->AS_QteMaxi,2))."</td>"
                ."<td>".ROUND($row->QteCommande,2)."</td>";
                echo "</tr>";

                $QteReel=$QteReel+ROUND($row->AS_QteSto,2);
                $QteMini=$QteMini+ROUND($row->AS_QteMini,2);
                $QteMax=$QteMax+ROUND($row->AS_QteMaxi,2);
                $QteCommande=$QteCommande+ROUND($row->QteCommande,2);

                $totalQteReel=$totalQteReel+ROUND($row->AS_QteSto,2);
                $totalQteMini=$totalQteMini+ROUND($row->AS_QteMini,2);
                $totalQteMax=$totalQteMax+ROUND($row->AS_QteMaxi,2);
                $totalQteCommande=$totalQteCommande+ROUND($row->QteCommande,2);
            }
            echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>";
            echo "<td>Total</td><td></td><td>".$objet->formatChiffre($QteReel)."</td><td>".$objet->formatChiffre($QteMini)."</td><td>".$objet->formatChiffre($QteMax)."</td>";
            echo "<td>".$objet->formatChiffre($QteCommande)."</td>";
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
        <td style="padding:10px">Qté réel : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteReel); ?></td>
        <td style="padding:10px">Qté minimum : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteMini); ?></td>
        <td style="padding:10px">Qté maximum : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteMax); ?></td>
        <td style="padding:10px">Qté à commandée : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteCommande); ?></td>
    </tr>
</table>
<?php
}
?>

        
