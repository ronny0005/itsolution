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
<form action="indexMVC.php?module=5&action=18" method="GET">
    <div class="form-group col-lg-2" >
            <label>Début</label>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="18" name="action"/>
            <input type="text" class="form-control" name="datedebut" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Fin</label>
        <input type="text" class="form-control" name="datefin"  value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Analytique</label>
        <select class="form-control" name="N_Analytique" id="N_Analytique">
            <option value="0">Tous</option>
            <?php
            $result=$objet->db->requete($objet->getListeTypePlan());
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows==null){
            }else{
                foreach($rows as $row){
                    echo "<option value=".$row->cbIndice."";
                    if($row->cbIndice == $N_Analytique) echo " selected";
                    echo ">".$row->A_Intitule."</option>";
                }
            }
            ?>
    </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Famille</label>
        <select class="form-control" id="famille_statachat" name="famille_statachat"><option value="0">Tous</option>
        <?php
        $familleClass = new FamilleClass(0);
        $rows =$familleClass->getShortList();
        if($rows==null){
        }else{
            foreach($rows as $row){
                echo "<option value='{$row->FA_CodeFamille}'";
                if(isset($_GET["famille_statachat"]) && $row->FA_CodeFamille==$famille) echo " selected";
                echo ">{$row->FA_Intitule}</option>";
            }
        }
        ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Article de</label>
        <select  class="form-control" id="articledebut" name="articledebut"><option value="0">Tous</option>
            <?php
            $article = new ArticleClass(0,$objet->db);
            foreach($article->all() as $row){
                echo "<option value={$row->AR_Ref}";
                if(isset($_GET["articledebut"]) && $row->AR_Ref==$articledebut) echo " selected";
                echo ">{$row->AR_Design}</option>";
            }
            ?>
        </select>
        <label>à</label>
        <select  class="form-control" id="articlefin" name="articlefin"><option value="0">Tous</option>
            <?php
            foreach($article->all() as $row){
                echo "<option value='{$row->AR_Ref}'";
                if(isset($_GET["articlefin"]) && $row->AR_Ref==$articlefin) echo " selected";
                echo ">{$row->AR_Design}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Rupture par plan</label>
        <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1 || $N_Analytique!=0) echo "checked";?> />
    </div>
    <div class="form-group col-lg-3">
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportStatArticleAffaire.php?datedebut=".$datedeb."&datefin=".$datefin."&N_Analytique=".$N_Analytique."&famille_statachat=".$famille."&articledebut=".$articledebut."&articlefin=".$articlefin."&rupture=".$rupture."')\""; ?> />
    </div>
</form>
        
<?php

    $totalCANetHTG=0;
    $totalPrecompteG=0;
    $totalCANetTTCG=0;
    $totalQteVendueG=0;
    $totalMargeG=0;
    $result=$objet->db->requete($objet->getListeTypePlanByVal($N_Analytique));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($N_Analytique==0 || $N_Analytique==$row->cbIndice){
                $val=0;
                if($rupture==1 || $N_Analytique==$row->cbIndice){
                    echo "<div style='clear:both'><h3 style='text-align:center'>".$row->A_Intitule."</h3></div>";
                    $val=$row->cbIndice;
                }
        $result=$objet->db->requete($objet->stat_articleAchatByCANum("D.N_Analytique,D.CA_Num,CA_Intitule,DO_Tiers,CT_Intitule,AR.AR_Ref,AR_Design,E.CO_No,CO_Nom",$objet->getDate($datedeb),$objet->getDate($datefin), $famille,$articledebut,$articlefin,$val));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $canetht=0;
        $canetttc=0;
        $precompte=0;
        $qte=0;
        $marge=0;
        $margeca=0;
        $classe="";
                
?>
<table id="table" class="table table-striped table-bordered" cellspacing="0">
    <tr>
        <th>Code <br/>Analytique</th>
        <th>Désignation <br/>Analytique</th>
        <th>Désignation <br/>Fournisseur</th>
        <th>Collaborateur</th>
        <th>Ref. <br/>Article</th>
        <th>Désignation</th>
        <th>PU HT</th>
        <th>PU TTC</th>
        <th>Quantités</th>
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
                echo "<td>".$row->CA_Num."</td>"
                    ."<td>".$row->CA_Intitule."</td>"
                    ."<td>".$row->CT_Intitule."</td>"
                    ."<td>".$row->CO_Nom."</td>"
                    ."<td>".$row->AR_Ref."</td>"
                    ."<td>".$row->AR_Design."</td>"
                    ."<td>".$objet->formatChiffre(ROUND($row->TotCAHTNet,2))."</td>"
                    ."<td>".$objet->formatChiffre(ROUND($row->TotCATTCNet,2))."</td>"
                    ."<td>".$objet->formatChiffre(ROUND($row->TotQteVendues,2))."</td>"
                    ."</tr>";
                $canetht=$canetht+ROUND($row->TotCAHTNet,2);
                $canetttc=$canetttc+ROUND($row->TotCATTCNet,2);
                $qte=$qte+ROUND($row->TotQteVendues,2);
                $totalCANetHTG=$totalCANetHTG+ROUND($row->TotCAHTNet,2);
                $totalCANetTTCG=$totalCANetTTCG+ROUND($row->TotCATTCNet,2);
                $totalQteVendueG=$totalQteVendueG+ROUND($row->TotQteVendues,2);
            }
            $totmargepourc=0;
            if($canetht>0)$totmargepourc=ROUND($marge/$canetht*100,2);
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>";
        echo "<td colspan='6'>Total</td><td>".$objet->formatChiffre($canetht)."</td><td>".$objet->formatChiffre($canetttc)."</td>";
        echo "<td>".$objet->formatChiffre($qte)."</td></tr>";
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
        <td style="padding:10px">PU HT : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetHTG); ?></td>
        <td style="padding:10px">PU TTC : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetTTCG); ?></td>
        <td style="padding:10px">Quantités : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteVendueG); ?></td>
    </tr>
</table>
<?php
}
?>

        
