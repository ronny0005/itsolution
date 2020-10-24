<?php
    $objet = new ObjetCollector();
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("collaborateur");
    $flagSuppr = $protection->SupprType("collaborateur");
    $flagNouveau = $protection->NouveauType("collaborateur");
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeCollaborateur.js?d=<?php echo time(); ?>"></script>
</head>
<body>
    <?php
include("module/Menu/BarreMenu.php");
?>
<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Liste collaborateur
    </h3>
</section>

<div class="corps">
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>

<fieldset class="entete card p-3">
<div class="form-group">
<form action="listeCollaborateur-0" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
        <?php if($flagNouveau){ ?><td style="float:right"><a href="ficheCollaborateur"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>

    <?php
    $statut = $_GET["statut"];
    if(isset($_GET["CO_No"]) && $statut!=0) {
        $collaborateurClass = new CollaborateurClass($_GET["CO_No"]);
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
            <?= $type ?>du collaborateur <?= $collaborateurClass->CO_Nom ?> a été effectuée !
        </div>
        <?php
    }
    ?>
<table id="table" class="table table-striped">
        <thead>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Fonction</th>
            <?php if($flagSuppr)  echo"<th></th>";?>
        </thead>
    <tbody id="liste_collaborateur" >
        <?php
        $collaborateurClass = new CollaborateurClass(0);
        $rows = $collaborateurClass->all();
        if($rows==null){
            echo "<tr><td colspan='3'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            ?>
            <tr class="article" id="article_<?= $row->CO_No ?>">
                <td><a href="ficheCollaborateur-<?= $row->CO_No ?>"><?= $row->CO_Nom ?></a></td>
                <td><?= $row->CO_Prenom ?></td>
                <td><?= $row->CO_Fonction ?></td>
            <?php
            if($flagSuppr) {
                ?>
                <td>
                    <a href="Traitement\Collaborateur.php?acte=suppr&CO_No=<?= $row->CO_No ?>" onclick="if(window.confirm('Voulez-vous vraiment supprimer <?= "{$row->CO_Nom} {$row->CO_Prenom}" ?> ?')){return true;}else{return false;}"><i class="fa fa-trash-o"></i></a></td>
            <?php
            }
                    echo "</tr>";
            }
        }
        ?>
</tbody>
</table>
 </div>   
</div>
