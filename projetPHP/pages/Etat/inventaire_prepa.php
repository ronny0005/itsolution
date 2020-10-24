
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
<form action="indexMVC.php?module=5&action=2" method="GET">
    <table style="margin-bottom: 20px">
    <thead>
        <tr>
            <td style="width:50px;vertical-align: middle">Date :</td>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="2" name="action"/>
            <td><input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" disabled/></td>
            <td><select style="margin-left: 10px;" class="form-control" id="choix_inv" name="choix_inv">
                    <option value="1" <?php if($choix_inv==1) echo "selected"; ?>>Cumul de stock</option>
                    <option value="2" <?php if($choix_inv==2) echo "selected"; ?>>date indiqué</option></select></td>
            <td style="padding-left: 10px;width:60px;vertical-align: middle"> Depot :</td>
            <td style="padding-left: 10px;width:200px;">
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
            </td>
            <td>Rupture par agence <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> /></td>
            <td><input type="submit" id="valider" class="btn btn-primary" value="Valider"/></td>
            <td style="padding-left:30px"><input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportInventairePrep.php?type=mvtStock&choix_inv=$choix_inv&datedeb=".$datedeb."&datefin=0&depot=".$depot_no."&rupture=".$rupture."')\""; ?>/></td>
        </tr>
</table>
</form>
<?php
    $tottalQteG=0;
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
                $etat = new EtatClass(0);
                if($choix_inv==1)
                    $result = $objet->db->requete($etat->getPreparatoireCumul($val));
                else
                    $result=$objet->db->requete($etat->getetatpreparatoire($val,$objet->getDate($datedeb)));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                $i=0;
                $classe="";
                $total=0;
        ?>
<table id="table" class="table table-striped table-bordered" cellspacing="0">
    <tr>
        <th>Reference</th>
        <th>Désignation</th>
        <th>Quantité</th>
        <?php if($flagPxRevient==0) echo"<th>Prix Revient</th>";?>
        <?php if($flagPxRevient==0 && $choix_inv!=1) echo "<th>Prix Unitaire</th><th>Suivi</th>"; ?>
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
                echo "<td>".$row->AR_Ref."</td>"
                ."<td>".$row->AR_Design."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->Qte,2))."</td>";
                if($flagPxRevient==0) echo "<td>".$objet->formatChiffre(ROUND($row->PR,2))."</td>";
                if($flagPxRevient==0 && $choix_inv!=1) echo "<td>".$objet->formatChiffre(ROUND($row->PU,2))."</td>"
                ."<td>".$row->SUIVI."</td>";
                echo "</tr>";
                $total=$total+$row->Qte;
                $tottalQteG=$tottalQteG+$row->Qte;
            }
        }
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td>Total</td>";
        echo "<td></td><td>".$objet->formatChiffre($total)."</td>";
    if($flagPxRevient==0) echo "<td></td>";
    if($flagPxRevient==0 && $choix_inv!=1) echo "<td></td><td></td>";
                echo "</tr>";
        ?>
        </tbody>
    </table>
<?php 
                
            }
        }$cmp++;
    }
    
    if($rupture==1){
?>
    
<table>
    <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
        <td style="padding:10px">Quantité : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($tottalQteG); ?></td>
    </tr>
</table>
<?php 
    }
    ?>