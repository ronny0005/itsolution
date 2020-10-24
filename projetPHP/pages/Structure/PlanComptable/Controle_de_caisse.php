<?php
    $depot = 0;
    $protected= 0;
    $objet = new ObjetCollector();
    $protection = new ProtectionClass("","",$objet->db);
    if(isset($_SESSION["login"]))
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"],$objet->db);
    if($protection->Prot_No!=""){
        if($rows[0]->PROT_DEPOT==1)
            $protected = $rows[0]->PROT_DEPOT;
    }
    
?>
<script src="js/Structure/Comptabilite/script_controleDeCaisse.js"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color:#eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
    </head>  
        <div><h1></h1></div>
<form id="formCtrleCaisse" class="formCtrleCaisse" action="indexMVC.php?module=9&action=15" method="GET">
        
        <div class="form-group" >
            <div class="form-group col-lg-2" >
                <label>Date</label>
                <input type="text" id="dateControle" class="form-control" name="dateControle"/>
            </div>  
            <div class="form-group col-lg-2" >
                <label>Caisse</label>
                <select  class="form-control" id="caisseControle" name="caisseControle">
                    <option value="0"></option>
                    <?php
                        if($admin==0){
                            $result=$objet->db->requete($objet->getCaisseDepot($_SESSION["id"]));     
                        }else{
                            $result=$objet->db->requete($objet->caisse());   
                        }
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        $depot="";
                        if($rows==null){
                        }else{
                            foreach($rows as $row){
                                echo "<option value=".$row->CA_No."";
                                echo ">".$row->CA_Intitule."</option>";
                            }
                        }
                    ?>
                </select>
                <input type="hidden" id="dateControle" name="dateControle"/>
            </div>  
        </div>
        <div>
            <div class="col-lg-2" style="text-align: center"> 
                <label>Total caisse</label>
            </div>
            <div class="col-lg-2" id="totalConstate" style="text-align: center">
                <label>Total constaté</label>
            </div>
            <div class="col-lg-2" id="totalEcart" style="text-align: center">
                <label>Total écart</label>
            </div>
        </div>
            <br/>
        </div>
    <div style="clear:both"></div>
        <div class="form-group col-lg-2" >
            <input type="hidden" id="saisiejourn" name="saisiejourn" value="<?php echo $saisiejourn; ?>" />
            <input type="button" id="Ajouter" name="Ajouter" class="btn btn-primary" value="Valider" <?php if($protected==1) echo "disabled"; ?>/>
        </div>        

</form>
