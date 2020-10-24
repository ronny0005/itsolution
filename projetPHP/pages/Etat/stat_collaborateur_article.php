
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
<form action="indexMVC.php?module=5&action=13" method="GET">
    <div class="form-group col-lg-2" >
            <label>Début</label>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="13" name="action"/>
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
/*            if($admin==0){
                $rows = $depotClass->getDepotUserPrincipal($_SESSION["id"]);
            }
            else {
  */              echo"<option value='0'";
                if(0==$depot_no) echo " selected";
                echo ">Tous</option>";
                $depotClass = new DepotClass(0);
                $rows = $depotClass->all();
    //        }
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
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportStatCollabParArticle.php?datedeb=".$datedeb."&datefin=".$datefin."&do_type=".$do_type."&depot=".$depot_no."&rupture=".$rupture."')\""; ?> />
    </div>
</form>
                         
<?php
$totalCANetHTG=0;
    $totalPrecompteG=0;
    $totalCANetTTCG=0;
    $totalQteVendueG=0;
    $totalMargeG=0;
        $CA_NET_HT_GR=0;
        $CA_NET_TTC_GR=0;
        $MARGE_GR=0;
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
        $result=$objet->db->requete($etatList->stat_collaborateurparArticleClient($val,$objet->getDate($datedeb), $objet->getDate($datefin),$do_type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $CA_NET_HT=0;
        $CA_NET_TTC=0;
        $MARGE=0;
        $classe="";
        $ref="-";
        $rem=0;
        $pourcent =0;
        ?>
        
<table id="table" class="table table-bordered" cellspacing="0" >
    <thead>
        <tr>
            <th>Réference</th>
            <th>Désignation</th>
            <th>CA HT net</th>
            <th>CA TTC net</th>
            <th>% Remise</th>
            <?php if($flagPxRevient==0) { echo "<th>Marge</th>"; } ?>
            <?php if($flagPxRevient==0) { echo "<th>% Marge su CA net</th>";} ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if($rows==null){
        }else{
            $cmpligne=0;
            foreach ($rows as $row){
                if($ref!=$row->CO_Nom){
                    if($cmpligne>0){
                        $soutmarge=0;
                        if($soustotalCAHT>0)$soutmarge=ROUND($soustotalMarge/$soustotalCAHT*100,2);
                        echo "<tr style='background-color:#a4a4a4;font-weight: bold'><td>Sous total $ref</td><td></td><td>".$objet->formatChiffre($soustotalCAHT)."</td><td>".$objet->formatChiffre($soustotalCATTC)."</td><td></td>";
                        if($flagPxRevient==0)echo"<td>".$objet->formatChiffre($soustotalMarge)."</td><td>".$objet->formatChiffre($soutmarge)."</td>";
                        echo "</tr>";
                     }
                    $soustotalCAHT=0;
                    $soustotalCATTC=0;
                    $soustotalMarge=0;
                    $ref=$row->CO_Nom;
                    echo "<tr style='background-color:#f9f9f9'><td colspan='5'><b>$ref</b></td>";
                    if($flagPxRevient==0)echo"<td></td><td></td>";
                    echo "</tr>";
                    $i=0;
                }
                $ref=$row->CO_Nom;
                $rem=$row->Rem-$row->CA_NET_HT;
                $pourcent = 0;
                if($row->CA_NET_HT!=0)
                $pourcent = $row->MARGE*100/$row->CA_NET_HT;

                $i++;
                echo "<tr class='eqstock'>"
                ."<td>".$row->AR_Ref."</td>"
                ."<td>".$row->AR_Design."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->CA_NET_HT,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->CA_NET_TTC,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($rem,2))."</td>";
                if($flagPxRevient==0) { echo "<td>".$objet->formatChiffre(ROUND($row->MARGE,2))."</td>"
                ."<td>".ROUND($pourcent,2)."</td>"; }
                echo "</tr>";
                $CA_NET_HT=$CA_NET_HT+ROUND($row->CA_NET_HT,2);
                $CA_NET_TTC=$CA_NET_TTC+ROUND($row->CA_NET_TTC,2);
                $MARGE=$MARGE+ROUND($row->MARGE,2);
                $soustotalCAHT=$soustotalCAHT+ROUND($row->CA_NET_HT,2);
                $soustotalCATTC=$soustotalCATTC+ROUND($row->CA_NET_TTC,2);
                $soustotalMarge=$soustotalMarge+ROUND($row->MARGE,2);
                $CA_NET_HT_GR=$CA_NET_HT_GR+ROUND($row->CA_NET_HT,2);
                $CA_NET_TTC_GR=$CA_NET_TTC_GR+ROUND($row->CA_NET_TTC,2);
                $MARGE_GR=$MARGE_GR+ROUND($row->MARGE,2);
                $totalCANetHTG=$totalCANetHTG+ROUND($row->CA_NET_HT,2);
                $totalCANetTTCG=$totalCANetTTCG+ROUND($row->CA_NET_TTC,2);
                $totalMargeG=$totalMargeG+ROUND($row->MARGE,2);
                $cmpligne++;
            }
            if($cmpligne>0){
                $val1=0;
                if($soustotalCAHT!=0)
                $val1 = $objet->formatChiffre(ROUND($soustotalMarge/$soustotalCAHT*100,2));
                echo "<tr style='background-color:#a4a4a4;font-weight: bold'><td>Sous total $ref</td><td></td><td>".$objet->formatChiffre($soustotalCAHT)."</td><td>".$objet->formatChiffre($soustotalCATTC)."</td><td></td>";
                if($flagPxRevient==0)echo"<td>".$objet->formatChiffre($soustotalMarge)."</td><td>".$val1."</td>";
                 echo "</tr>";
             }
             $val1=0;
            if($CA_NET_HT!=0)
                $val1=$objet->formatChiffre(ROUND($MARGE/$CA_NET_HT*100,2));
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td><td></td><td>".$objet->formatChiffre($CA_NET_HT)."</td><td>".$objet->formatChiffre($CA_NET_TTC)."</td><td></td>";
        if($flagPxRevient==0) { echo "<td>".$objet->formatChiffre($MARGE)."</td>".
        "<td>".$val1."</td></tr>";}
        }
            
        
    ?>
        </tbody>
    </table>
        <br/>
        <br/>
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
        <td style="padding:10px">CA Net TTC : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetTTCG); ?></td>
        <?php if($flagPxRevient==0){ ?>
        <td style="padding:10px">Marge : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMargeG); ?></td>
        <td style="padding:10px">% de Marge : </td>
        <td style="padding:10px"><?php $val1=0; if($totalCANetHTG!=0) $val1=$objet->formatChiffre(ROUND($totalMargeG/$totalCANetHTG*100,2)); echo $val1; ?></td>
        <?php } ?>
    </tr>
</table>
<?php
}
?>