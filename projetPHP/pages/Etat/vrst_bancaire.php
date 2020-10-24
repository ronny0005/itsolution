
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
<form action="indexMVC.php?module=5&action=9" method="GET">
    <table style="margin-bottom: 20px">
    <thead>
        <tr>
            <td style="width:100px;vertical-align: middle">D&eacute;but :</td>
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="15" name="action"/>
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
                    if(sizeof($rows)>1){
                        echo"<option value='0'";
                        if(0==$caisse_no) echo " selected";
                        echo ">Tous</option>";
                    }
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
                Type règlement
                <select class="form-control" style="width:180px" name="type" id="type">
                    <option value="0" <?php if ($type==0) echo "selected"; ?> >Tous</option>
                    <option value="4"  <?php if ($type==4) echo "selected"; ?> >Lettré</option>
                    <option value="2"  <?php if ($type==2) echo "selected"; ?> >Non lettré</option>
                </select>
            </td>
            <td>
        Rupture par agence
        <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
    </td>
    <td style="padding-left:30px"><input type="submit" id="valider" class="btn btn-primary" value="Valider"/></td>
            <td style="padding-left:30px"><input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportVrstBancaire.php?datedeb=".$datedeb."&datefin=".$datefin."&caisse=".$caisse_no."&type=".$type."&rupture=".$rupture."')\""; ?>/></td>
        </tr>
</table>
</form>
<?php 
    $totalMontant=0;
    $totalMontantImpute=0;
    $totalResteAImpute=0;
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
    $result=$objet->db->requete($etatList->etatVrstBancaire($val, $objet->getDate($datedeb),$objet->getDate($datefin),$type));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $somMontant=0;
        $somMontantImputer=0;
        $somResteAImputer=0;
        $classe="";
        $ref="";
        
       
?><table id="table" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr style="text-transform: uppercase">
            <th>Numéro</th>
            <th>Libellé</th>
            <th>Montant sortie</th>
            <th>Type</th>
            <th>Solde non imputé</th>
            <th>Caisse</th>
            <th>Date de sortie</th>
            <th>P.J.</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if($rows==null){
            echo "<tr><td colspan='9'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $somMontant=$somMontant+ROUND($row->RG_Montant,2);
                $somMontantImputer=$somMontantImputer+ROUND($row->RC_Montant,2);
                $somResteAImputer=$somResteAImputer+ROUND($row->ResteAPayer,2);
                $totalMontant=$totalMontant+$somMontant;
                $totalMontantImpute=$totalMontantImpute+$somMontantImputer;
                $totalResteAImpute=$totalResteAImpute+$somResteAImputer;
                $fichier="";
                if($row->Lien_Fichier!=null)
                    $fichier="<a target='_blank' class='fa fa-download' href='upload/files/".$row->Lien_Fichier."'></a>";
                
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td>".$row->RG_Piece."</td>"
                ."<td>".$row->RG_Libelle."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->RG_Montant,2))."</td>"
                ."<td>".$row->Type_lettre   ."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->ResteAPayer,2))."</td>"
                ."<td>".$row->CA_Intitule."</td>"
                ."<td>".$objet->getDateDDMMYYYY($row->RG_Date)."</td>"
                ."<td>$fichier</td></tr>";
            }
            
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='2' >Total</td><td>".$objet->formatChiffre($somMontant)."</td><td></td><td>".$objet->formatChiffre($somResteAImputer)."</td>"
                . "<td></td><td></td><td></td></tr>";
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
        <td style="padding:10px">Montant : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMontant); ?></td>
        <td style="padding:10px">Reste à imputer : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalResteAImpute); ?></td>
        <?php } ?>
    </tr>
</table>
