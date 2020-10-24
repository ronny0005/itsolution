<?php
$objet = new ObjetCollector();
$depot=$_SESSION["DE_No"];
?>
<script src="js/Admin/script_fusionClient.js?d=<?php echo time(); ?>"></script>
</head>
<body>

<?php

include("module/Menu/BarreMenu.php");

if(isset($_POST["CT_NumAncien"])){
    $comptet = new ComptetClass(0,$objet->db);
    $comptet->remplacementTiers($_POST["CT_NumAncien"],$_POST["CT_NumNouveau"]);

    ?>
    <div class="alert alert-success" role="alert">
        Le client <?= $_POST["CT_NumAncien"] ?> est maintenant identifié par le code <?= $_POST["CT_NumNouveau"] ?>
    </div>
    <?php
}
?>

<div id="milieu">
    <div class="container">

        <div class="container clearfix">
            <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
                <?php echo $texteMenu; ?>
            </h4>
        </div>
        <div class="corps">
            <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
            <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>

            <div class="row">
<form id="formulaire" action="#" method="POST">
    <input type="hidden" name="module" value="8" />
    <input type="hidden" name="action" value="14" />
    <div class="row">
        <div class="col-lg-4">
            <label>Ancien code client :</label>
            <select class="form-control" id="CT_NumAncien" name="CT_NumAncien">
                <?php
                $client = new ComptetClass(0,$objet->db);
                $rows = $client->allClients(0);
                foreach($rows as $row){
                    ?>
                    <option value="<?= $row->CT_Num ?>"><?= $row->CT_Num." - ".$row->CT_Intitule ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <label>Nouveau code client :</label>
            <select class="form-control" id="CT_NumNouveau" name="CT_NumNouveau">
                <?php
                foreach($rows as $row){
                    ?>
                    <option value="<?= $row->CT_Num ?>"><?= $row->CT_Num." - ".$row->CT_Intitule ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <input type="button" id="valider" name="valider" class="btn btn-primary" value="Valider" />
    </div>
            </form>
            </div>

        </div>
