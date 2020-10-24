
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/script_etat.js?d=<?= time(); ?>"></script>
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
<form action="indexMVC.php?module=5&action=1" method="GET">
    <div class="form-group">
        <div style="float:left;width:120px">
            <label>Début</label>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="1" name="action"/>
            <input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
        </div>
        <div style="float:left;width:120px">
            <label>Fin</label>
            <input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
        </div>
        <div style="float:left;width:270px">
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
        <div style="float:left;width:130px">
            <label>Rupture par agence</label> 
            <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
        </div>
        <div style="float:left;width:120px">
            <label>Article de </label>
            <select  class="form-control" id="ArticleDebut" name="articledebut">
                <option value="0">Tous</option>
                <?php
                    $articleClass = new ArticleClass(0);
                    $rows = $articleClass->getShortList();
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->AR_Ref."";
                                if(isset($_GET["articledebut"]) && $row->AR_Ref==$articledebut) echo " selected ";
                            echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
                        }
                    }
                ?>
            </select>
        </div>
        
        <div style="float:left;width:120px">
            <label>A </label>
            <select class="form-control" id="ArticleFin" name="articlefin">
                <option value="0">Tous</option>
                    <?php
                        $articleClass = new ArticleClass(0);
                        $rows = $articleClass->getShortList();
                        if($rows==null){
                        }else{
                            foreach($rows as $row){
                                echo "<option value=".$row->AR_Ref."";
                                if(isset($_GET["articlefin"]) && $row->AR_Ref==$articlefin) echo " selected ";
                                echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
                            }
                        }
                    ?>
                </option>
            </select>
        </div>
        <div style="float:left;width:400px">
            <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
            <input type="button"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportMvtStock.php?type=mvtStock&datedeb=".$datedeb."&datefin=".$datefin."&depot=".$depot_no."&rupture=".$rupture."&articledebut=".$articledebut."&articlefin=".$articlefin."')\""; ?>/>
        </div>
    </div>
</form>
<?php
include("corpsEtatStock.php");
?>