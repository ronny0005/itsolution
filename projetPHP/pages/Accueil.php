<script src="js/jqModal.js"></script>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
require_once './Modele/DB.php';
require_once './Modele/ObjetCollector.php';

$objet = new ObjetCollector();

 $uid= $_SESSION["id"];
//variable pour reinitialisation du mot de passe

?>
<div id="milieu">
    <div class="container">

<div class="jumbotron">
<h2>Bienvenue</h2>
<p style="font-size: 1.50rem">Cette application est un outil de gestion de contenu. <br/>
    Elle vous permettra de gérer des factures de ventes et d'achats, ainsi que les règlements associés</p>
</div>



