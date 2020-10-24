<?php
    $objet = new ObjetCollector();
?>
<script src="js/Admin/Calendrier_connexion.js?d=<?php echo time(); ?>"></script>
<?php
include("module/Menu/BarreMenu.php");

?>
<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Calendrier de connexion
    </h3>
</section>
<?php
    if($action==1){
        echo "<div class='alert alert-success'>La modification a bien été effectuée !</div>";
    }
?>
        <form class="" action="#" name="calendar" method="POST">
            <div class="card p-3">
            <div class="row">
                <div class="col-2">
                    <label>Utilisateur</label>
                    <input type="hidden" class="btn btn-primary" id="PROT_NoUser" name="PROT_NoUser" value=""/>
                    <select class="form-control" name="user" id="user">
                        <?php
                        $prot_no=0;
                            $protectionClass = new ProtectionClass("","");
                            $rows = $protectionClass->getUtilisateurAdminMain();
                            if ($rows != null) {
                                foreach ($rows as $row) {
                                    echo "<option value='{$row->PROT_No_User}'";
                                    if($prot_no==$row->PROT_No_User) echo "selected";
                                    echo ">".$row->Prot_User;
                                        echo "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <?php
                $day = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");
                foreach ($day as $value) {
                    ?>
                    <div class="row">
                        <div class="col-lg-2">
                            <label><?= $value ?></label>
                            <input type="checkbox" class="form-control" name="check<?= $value ?>" id="check<?= $value ?>"/>
                        </div>
                        <div class="col-lg-2">
                            <label>Heure début</label>
                            <div class="input-group clockpicker">
                                <input name="heureDebut<?= $value ?>" id="heureDebut<?= $value ?>" type="text" class="form-control" value="00:00">
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label>Heure Fin</label>
                            <div class="input-group clockpicker">
                                <input name="heureFin<?= $value ?>" id="heureFin<?= $value ?>" type="text" class="form-control" value="00:00">
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            <div class="col-12 mt-3">
                <input type="button" class="w-100 btn btn-primary" id="valider" name="valider" value="Valider"/>
            </div>
            </div>
        </form>