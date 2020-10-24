<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("depot");
    $flagSuppr = $protection->SupprType("depot");
    $flagNouveau = $protection->NouveauType("depot");

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeDepot.js?d=<?php echo time(); ?>"></script>
</head>
<body>
    <?php
include("module/Menu/BarreMenu.php");
?>

<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Liste depot
    </h3>
</section>

<div class="corps">
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete card p-3">
<div class="form-group">
<form action="indexMVC.php?module=2&action=2" method="GET">
        <?php if($flagNouveau){ ?>
            <div class="mb-3" style="float:right">
                <a href="ficheDepot">
                    <button type="button" id="nouveau" class="btn btn-primary">Nouveau</button>
                </a>
            </div> <?php } ?>
</form>

    <?php
    $statut = (isset($_GET["statut"])) ? $_GET["statut"] : 0;
    if(isset($_GET["DE_No"]) && $statut!=0) {
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
        $depotClass= new DepotClass($_GET["DE_No"] );
        ?>
        <div class="mt-3 alert <?= $alert ?>">
            <?= $type ?>du dépot <?= $depotClass->DE_Intitule ?> a été effectuée !
        </div>
        <?php
    }
    ?>
<div class="err" id="add_err"></div>
<table id="table" class="table table-striped">
        <thead>
            <th>Intitulé</th>
            <th>Code postal</th>
            <th>Ville</th>
            <?php if($flagSuppr) echo "<th></th>"; ?>
        </thead>
    <tbody id="liste_depot">
        <?php
        
        $objet = new ObjetCollector();
        $depot = new DepotClass(0);
        $rows = $depot->all();
        if($rows==null){
            echo "<tr><td colspan='3'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            ?>
                <tr class="article <?= $classe ?>" id="article_<?=$row->DE_No ?>">
                    <td><a href="ficheDepot-<?= $row->DE_No ?>"><?= $row->DE_Intitule ?></a></td>
                    <td><?= $row->DE_CodePostal ?></td>
                    <td><?= $row->DE_Ville ?></td>
                    <?php
                        if($flagSuppr) {
                            ?>
                            <td><a href="supprDepot-<?= $row->DE_No ?>" onclick="if(window.confirm("Voulez-vous vraiment supprimer <?=$row->DE_Intitule ?>")){return true;}else{return false;}"><i class='fa fa-trash-o'></i></a></td>
                        <?php }
                        ?>
                    </tr>
        <?php
            }
        }
      ?>
</tbody>
</table>
 </div>   
</div>
 
</div>
