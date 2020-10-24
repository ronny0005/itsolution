<fieldset class="card p-3 entete">
<legend class="entete">Entete</legend>
                <div class="err" id="add_err"></div>
		<form id="form-entete" class="form-horizontal" action="indexMVC.php?module=4&action=5" method="GET" >
                    <input type="hidden" value="4" name="module"/>
                    <input type="hidden" value="5" name="action"/>
                    <input type="hidden" value="ajout_entete" name="acte"/>
                    <input type="hidden" id="flagDelai" value="<?php echo $protection->getDelai(); ?>"/>
                    <input type="hidden" value="<?php echo $_SESSION["id"];?>" name="id"/>
                    <input type="hidden" id="flagPxRevient" value="<?php echo $flagPxRevient; ?>"/>
                    <input type="hidden" id="isModif" value="<?= $isModif; ?>"/>
                    <input type="hidden" id="isVisu" value="<?= $isVisu; ?>"/>
                    <input type="hidden" value="<?= $type ?>" id="typeFacture" name="typeFacture" />
    <div class="row">
        <div class="col-6 col-sm-6 col-md-6">
            <label>Référence : </label>
            <input type="text" class="form-control" name="reference" id="ref" placeholder="Référence" value="<?= $docEntete->DO_Ref; ?>" <?php if($isVisu||$type=="Transfert_valid_confirmation" ) echo "disabled"?> />
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <label>N Doc : </label>
            <input type="text" class="form-control" id="n_doc" placeholder="N Document" value="<?= $docEntete->DO_Piece ?>" disabled/>
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <label>Dépot : </label>
            <input class="form-control" type="hidden" name="DE_No" id="DE_No" value="<?php if(!isset($_GET["cbMarq"])) echo ""; else if($type=="Transfert" || $type=="Transfert_confirmation" || $type=="Transfert_detail") echo $docEntete->DE_No; else echo $docEntete->DO_Tiers;  ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?> />
            <input class="form-control" type="text" name="depot" id="depot" value="<?php if(!isset($_GET["cbMarq"]))  echo ""; else if($type=="Transfert" || $type=="Transfert_confirmation" || $type=="Transfert_detail") echo (new DepotClass($docEntete->DE_No))->DE_Intitule; else echo (new DepotClass($docEntete->DO_Tiers))->DE_Intitule; ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?> />
        </div>
        <?php
        if($type=="Transfert" || $type=="Transfert_confirmation" || $type=="Transfert_detail"){
            $depotDestNo = "";
            $depotDest = "";
            if($docEntete->DE_No!=NULL){
                $depotDestNo = $docEntete->DE_No;
                if($type=="Transfert" || $type=="Transfert_confirmation")
                    $depotDestNo = $docEntete->DO_Tiers;
                if($type=="Transfert_detail")
                    $depotDestNo =  $docEnteteTransfertDetail->DE_No;
                $depotDest = (new DepotClass($depotDestNo))->DE_Intitule;
            }

            ?>
            <div class="col-6 col-sm-6 col-md-6">
            <label>Destination : </label>
            <input class="form-control" type="hidden" name="CO_No" id="CO_No" value="<?= $depotDestNo ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?> />
            <input class="form-control" type="text" name="collaborateur" id="collaborateur" value="<?= $depotDest ?>" <?php if(isset($_GET["cbMarq"]) || $isVisu) echo "disabled"; ?> />
            </div>
        <?php
        }

        ?>
        <div class="col-6 col-sm-6 col-md-6">
            <label>Affaire : </label>
            <select class="form-control" id="affaire" name="affaire">
                <?php
                    if($admin==0){
                        $rows = $protection->getSoucheDepotGrpAffaire($_SESSION["id"],$type,0);
                    }else{
                        $rows = $protection->getAffaire(0);
                    }
                        if($rows==null){
                        }else{
                            foreach($rows as $row){
                                echo "<option value='{$row->CA_Num}'";
                                if($row->CA_Num==$affaire) echo " selected";
                                echo ">{$row->CA_Intitule}</option>";
                            }
                        }

                    ?>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6">
            <label>Date : </label>
            <?php
                $protectDate = 0;
                if($flagDateStock!=0)
                    $protectDate=1;

            ?>
            <div class="input-group">
                <input type="text" class="form-control" id="dateentete" name="dateentete" placeholder="Date" value="<?= $dateEntete;?>" <?php if(isset($_GET["cbMarq"]) || (!isset($_GET["cbMarq"]) && $flagDateStock==1)) echo "disabled" ?>/>
                <span class="input-group-append"><span class="input-group-text bg-transparent"><i class="far fa-calendar"></i></span></span>
            </div>
        </div>
        <input type="hidden" name="cbMarqEntete" id="cbMarqEntete" value="<?= ($docEntete->cbMarq =="") ? 0 : $docEntete->cbMarq; ?>" />
   </div>
</form>
</fieldset>
