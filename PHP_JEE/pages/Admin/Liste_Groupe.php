<?php
$objet = new ObjetCollector();
$depot=$_SESSION["DE_No"];
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeGroup.js?d=<?php echo time(); ?>"></script>
<section class="bgcolorApplication" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">Liste profil</h3>
</section>
<section class="mt-2">
    <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
    <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>

    <?php
    $statut = (isset($_GET["statut"])) ? $_GET["statut"] : 0;
    if(isset($_GET["PROT_No"]) && $statut!=0) {
        $type = "La création ";
        $alert = "alert-success";
        if($statut == 3) {
            $type = "La suppression ";
        }
        if($statut == 4) {
            $alert = "alert-danger";
            $type = "Echec de la suppression ";
        }

        if($statut == 2)
            $type = "La modification ";
        ?>
        <div class="mt-3 alert <?= $alert ?>">
            <?= $type ?> du profil <?= $_GET["PROT_No"] ?> a été effectuée !
        </div>
        <?php
    }
    ?>
<div class="card p-3 mt-3">
    <div>
        <a href="nouveauProfil" class="btn btn-primary text-right">Nouveau</a>
    </div>
    <div class="table-responsive" style="margin-top: 30px;clear:both">
        <table id="tableListeFacture" class="table table-striped">
            <thead>
                <th>Intitule</th>
                <th>Date creation</th>
                <th>Date Modification</th>
            </thead>
            <tbody id="liste_groupe">
            <?php
            $protectioncial = new ProtectionClass("","");
            $rows = $protectioncial->getAllProfils();
            if($rows==null){
                echo "<tr><td colspan='3' class='text-center'>Aucun élément trouvé ! </td></tr>";
            }else{
                foreach ($rows as $row){
                    echo "<tr class='groupe' id='groupe'>
     <td><input type='hidden' class='data-id' value='{$row->PROT_No}' ><a href='nouveauProfil-{$row->PROT_No}'>{$row->PROT_User}</a></td>
        <td><input type='hidden' class='data2-id' >{$protectioncial->formatDateAffichage($row->PROT_DateCreate)}</td>
        <td><input type='hidden' class='data3-id' >{$protectioncial->formatDateAffichage($row->cbModification)}</td>
                        </tr>";
                }
            }
            //      ?>
            </tbody>
        </table>
    </div>
</div>
</section>