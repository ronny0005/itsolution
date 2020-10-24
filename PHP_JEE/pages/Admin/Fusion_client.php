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
    $comptet = new ComptetClass(0);
    $comptet->remplacementTiers($_POST["CT_NumAncien"],$_POST["CT_NumNouveau"]);

    ?>
    <div class="alert alert-success" role="alert">
        Le client <?= $_POST["CT_NumAncien"] ?> est maintenant identifié par le code <?= $_POST["CT_NumNouveau"] ?>
    </div>
    <?php
}
?>
<?php
include("module/Menu/BarreMenu.php");
?>
<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Fiche Client
    </h3>
</section>
            <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
            <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>

<form id="formulaire" action="#" method="POST">
    <input type="hidden" name="module" value="8" />
    <input type="hidden" name="action" value="14" />

    <div class="card p-3">
        <div class="row">
            <div class="col-6">
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
            <div class="col-6">
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
            <div class="col-12 mt-3">
                <input type="button" id="valider" name="valider" class="btn btn-primary w-100" value="Valider" />
            </div>
    </div>
            </form>
