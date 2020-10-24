<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("famille");
    $flagSuppr = $protection->SupprType("famille");
    $flagNouveau = $protection->NouveauType("famille");

?>
<script src="js/script_listeFamille.js?d=<?php echo time(); ?>"></script>


<section class="bgcolorApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">Liste Famille</h3>
</section>

        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>

<div class="card p-3">
    <form action="listeFamille-0" method="GET">
        <table style="margin-bottom: 20px;width:100%">
        <thead>
            <tr>
                <?php if($flagNouveau){ ?>
                    <td style="float:right"><a href="ficheFamille"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td><?php } ?>
            </tr>
            </form>
    </table>
    <?php

    $statut = $_GET["statut"];

    if (isset($_GET["FA_CodeFamille"]) && $statut != 0) {
        $type = "La création ";
        $alert = "alert-success";

        if ($statut == 3) {
            $type = "La suppression ";
        }

        if ($statut == 4) {
            $alert = "alert-danger";
            $type = "Echec de la suppression ";
        }

        if ($statut == 2)
            $type = "La modification ";

        ?>
        <div class="mt-3 alert <?= $alert ?>">
            <?= $type ?>de la famille <?= $_GET["FA_CodeFamille"] ?> a été effectuée !
        </div>
        <?php
    }
    ?>
    <table id="table" class="table table-striped">
        <thead>
                <th>Code</th>
                <th>Intitulé</th>
                <?php if($flagSuppr) echo "<th></th>"; ?>
        </thead>
        <tbody id="liste_article">
            <?php
            $objet = new ObjetCollector();
            $familleClass = new FamilleClass(0);
            $rows = $familleClass->getShortList();
            $i=0;
            $classe="";
            if($rows==null){
                echo "<tr><td>Aucun élément trouvé ! </td></tr>";
            }else{
                foreach ($rows as $row){
                $i++;
                if($i%2==0) $classe = "info";
                        else $classe="";
                echo "<tr class='article $classe' id='article_{$row->FA_CodeFamille}'>
                        <td><a href='ficheFamille-{$row->FA_CodeFamille}'>{$row->FA_CodeFamille}</a></td>
                        <td>{$row->FA_Intitule}</td>";
                        if($flagSuppr) echo "<td><a href='supprFamille-{$row->FA_CodeFamille}' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer {$row->FA_CodeFamille} ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                        echo "</tr>";
                }
            }
          ?>
    </tbody>
    </table>
</div>
