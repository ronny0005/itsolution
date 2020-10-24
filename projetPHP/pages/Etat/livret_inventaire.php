
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
<form action="indexMVC.php?module=5&action=12" method="GET">
<div class="form-group col-lg-2" >
    <label>Date indiqué</label>
    <input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" disabled/>
</div>
<div class="form-group col-lg-2">
    <label>Choix d'inventaire</label>
    <select style="margin-left: 10px;" class="form-control" id="choix_inv" name="choix_inv">
        <option value="1" <?php if($choix_inv==1) echo "selected"; ?>>Cumul de stock</option>
        <option value="2" <?php if($choix_inv==2) echo "selected"; ?>>date indiqué</option></select>
</div>
<div class="form-group col-lg-2" >
<label>Dépot</label>
    <select class="form-control" name="depot" id="depot">
        <?php
        $depotClass = new DepotClass(0);
        echo"<option value='0'";
        if(0==$depot_no) echo " selected";
        echo ">Tous</option>";
        $depotClass = new DepotClass(0);
        $rows = $depotClass->all();
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
        <label>Article de</label>
        <select  class="form-control" id="articledebut" name="articledebut"><option value="0">Tous</option>
            <?php
            $result=$objet->db->requete($objet->getAllArticle());
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $depot="";
            if($rows==null){
            }else{
                foreach($rows as $row){
                    echo "<option value=".$row->AR_Ref."";
                    if(isset($_GET["articledebut"]) && $row->AR_Ref==$articledebut) echo " selected";
                    echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
                }
            }
            ?>
        </select>
        <label>à</label>
        <select  class="form-control" id="articlefin" name="articlefin"><option value="0">Tous</option>
            <?php
            $result=$objet->db->requete($objet->getAllArticle());
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $depot="";
            if($rows==null){
            }else{
                foreach($rows as $row){
                    echo "<option value=".$row->AR_Ref."";
                    if(isset($_GET["articlefin"]) && $row->AR_Ref==$articlefin) echo " selected";
                    echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Rupture par agence</label>
        <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1 || $depot_no!=0) echo "checked";?> />
    </div>
    <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
    <input type="hidden" value="5" name="module"/>
    <input type="hidden" value="12" name="action"/>
    <div class="form-group col-lg-2" >
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
    </div>
    <div class="form-group col-lg-2" >
        <input type="submit"  class="btn btn-primary" value="Imprimer" onClick="window.open( '<?php echo "./export/exportLivretInventaire.php?datedebut=".$datedeb."&datefin=".$datefin."&depot=".$depot_no."&rupture=".$rupture."&articledebut=".$articledebut."&articlefin=".$articlefin."&choix_niv=".$choix_inv; ?> ')";/>
    </div>
</form>
</div>
<div style="clear: both">

    <?php

    $result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
        if($depot_no==0 || $depot_no==$row->DE_No){
            $val=0;
            if($rupture==1){
                 echo "<div style='clear:both'><h3 style='text-align:center'>".$row->DE_Intitule."</h3></div>";
                $val=$row->DE_No;
            }
            if($choix_inv!=2)
                $result=$objet->db->requete($objet->livretInventaireCumulStock(" ReqGlobal.DE_No,fDep.DE_Intitule,ReqGlobal.IntituleTri,ReqGlobal.IntituleTri2,fArt.AR_Ref,fArt.AR_Design,fArt.AR_SuiviStock,ReqGlobal.AG_No1,ReqGlobal.AG_No2,ReqGlobal.Enumere1,ReqGlobal.Enumere2,ReqGlobal.AE_Ref,ReqGlobal.LS_NoSerie,ReqGlobal.LS_Peremption,ReqGlobal.LS_Fabrication,CASE WHEN 0 = 0 THEN 1 ELSE ISNULL(fCondi.EC_Quantite,1)END",$val,$articledebut,$articlefin));
            else
                $result=$objet->db->requete($objet->livretInventaireDate($objet->getDate($datedeb),$articledebut,$articlefin,$val));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $CA_NET_HT=0;
        $MARGE=0;
        $classe="";
        $ref="";
        $rem=0;
        $pourcent =0;
        ?>
        
<table id="table" class="table table-bordered" cellspacing="0" >
    <thead>
        <tr>
            <?php if($rupture==0 && $depot_no==0) echo "<th>Dépot</th>"; ?>
            <th>Référence</th>
            <th>Désignation</th>
            <th>Qté en stock</th>
            <?php if($flagPxRevient==0) echo  "<th>P.R. unitaire</th>
            <th>P.R. global</th>";?>
        </tr>
    </thead>
    <tbody>
        <?php
        if($rows==null){
            echo "<tr><td colspan='5'>Aucun élément trouvé ! </td></tr>";
        }else{
            $qtestk=0;
            $pr=0;
            $prglobal=0;
            foreach ($rows as $row){
                $i++;
                $qtestk=$qtestk+ROUND($row->Qte,2);
                $prglobal =$prglobal +ROUND($row->PR,2);
                $pr= $pr+ROUND($row->Qte *$row->PR,2); 
                echo "<tr class='eqstock'>";
                if($rupture==0 && $depot_no==0) echo "<td>".$row->DE_Intitule."</td>";
                echo "<td>".$row->AR_Ref."</td>"
                ."<td>".$row->AR_Design."</td>"
                ."<td>".ROUND($row->Qte,2)."</td>";
                if($flagPxRevient==0) echo  "<td>".$objet->formatChiffre(ROUND($row->PR/$row->Qte ,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->PR,2))."</td>";
                echo "</tr>";
            }
            
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td>";
        if($rupture==0 && $depot_no==0) echo "<td></td>";
            echo "<td></td><td>$qtestk</td>";
        if($flagPxRevient==0) echo "<td>".$objet->formatChiffre(ROUND($prglobal/$qtestk,2))."</td><td>".$objet->formatChiffre($prglobal)."</td>";
        echo "</tr>";
        }
        
    ?>
        </tbody>
    </table>
<?php 
        }
        $cmp++;
        }
    }
?>

</div>
</div>


