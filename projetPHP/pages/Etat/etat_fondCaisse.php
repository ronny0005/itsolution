
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
    <table style="margin-bottom: 20px">
    <thead>
        <tr>
            <td style="width:100px;vertical-align: middle">D&eacute;but :</td>
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="16" name="action"/>
            <td><input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:95px;vertical-align: middle">Fin :</td>
            <td><input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:60px;vertical-align: middle"> Caisse :</td>
            <td style="padding-left: 10px;width:200px;">
                <select class="form-control" name="caisse" id="caisse">
                    <?php
                    if($admin==0){
                        $isPrincipal = 1;
                        $result=$objet->db->requete($objet->getCaisseDepot($_SESSION["id"]));
                    }else{
                        $result=$objet->db->requete($objet->caisse());
                    }
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->CA_No."";
                            if($row->CA_No==$caisse_no) echo " selected";
                            echo ">".$row->CA_Intitule."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
            <td>
        Rupture par agence
        <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
    </td>
    <td style="padding-left:30px"><input type="submit" id="valider" class="btn btn-primary" value="Valider"/></td>
            <td style="padding-left:30px"><input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportCtrlReportSolde.php?datedeb=".$datedeb."&datefin=".$datefin."&caisse=".$caisse_no."&rupture=".$rupture."')\""; ?>/></td>
        </tr>
</table>
</form>
<?php 

    $totalFondCaisse=0;
    $totalSoldeJournee=0;
    $totalEcart=0;
    $result=$objet->db->requete($objet->caisse());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
            if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($caisse_no==0 || $caisse_no==$row->CA_No){
                $val=0;
                if($rupture==1 || $caisse_no==$row->CA_No){
                 echo "<div style='clear:both'><h3 style='text-align:center'>".$row->CA_Intitule."</h3></div>";
                 $val=$row->CA_No;
                }
                $etatList = new EtatClass();
        $result=$objet->db->requete($etatList->etatFondCaisse($val, $objet->getDate($datedeb), $objet->getDate($datefin)));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $somFondCaisse=0;
        $somSoldeJournee=0;
        $somEcart=0;
        $classe="";
        $ref="";
       
?><table id="table" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr style="text-transform: uppercase">
            <th>Numéro</th>
            <th>Date</th>
            <th>Libellé</th>
            <th>Fond de caisse</th>
            <th>Solde fin de journée</th>
            <th>Ecart</th>
            <th>Caisse</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if($rows==null){
            echo "<tr><td colspan='9'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                
                $somFondCaisse=$somFondCaisse+ROUND($row->FOND_CAISSE,2);
                $somSoldeJournee = $somSoldeJournee+ROUND($row->SOLDE_JOURNEE,2);
                $totalSoldeJournee=$somSoldeJournee+ROUND($row->SOLDE_JOURNEE,2);
                $somEcart=$somEcart+ROUND($row->ECART,2);
                $totalFondCaisse=$totalFondCaisse+$somFondCaisse;
                $totalSoldeJournee=$totalSoldeJournee+$somSoldeJournee;
                $totalEcart=$totalEcart+$somEcart;

                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td>".$row->RG_Piece."</td>"
                ."<td>".$objet->getDateDDMMYYYY($row->RG_Date)."</td>"
                ."<td>".$row->RG_Libelle."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->FOND_CAISSE,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->SOLDE_JOURNEE,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->ECART,2))."</td>"
                ."<td>".$row->CA_Intitule."</td>"
                . "</tr>";
            }
            
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='3' >Total</td><td>".$objet->formatChiffre($somFondCaisse)."</td><td>".$objet->formatChiffre($somSoldeJournee)."</td>"
                . "<td>".$objet->formatChiffre($somEcart)."</td><td></td></tr>";
        }
        
    ?>
        </tbody>
    </table>
        <?php 
               }
        }
        $cmp++;
    }
    }
    
    if($rupture==1){      
?>
<table>
    <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
        <td style="padding:10px">Total fond de caisse : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalFondCaisse); ?></td>
        <td style="padding:10px">Total solde : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalSoldeJournee); ?></td>
        <td style="padding:10px">Total ecart : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalEcart); ?></td>
        <?php } ?>
    </tr>
</table>