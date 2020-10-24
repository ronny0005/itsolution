<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $flagNouveau = 1;
    $flagProtected = 0;
    $flagSuppr = 1;
    $sommeil = -1;
    if(isset($_GET["sommeil"]))
        $sommeil = $_GET["sommeil"];
    $type = "client";
    if($_GET["action"]==8) $type="fournisseur";
    if($_GET["action"]==16) $type="salarie";
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    if($type=="client"){
        $flagProtected = $protection->protectedType($type);
        $flagSuppr = $protection->SupprType($type);
        $flagNouveau = $protection->NouveauType($type);
    }
    if($type=="fournisseur" || $type=="salarie"){
        $flagProtected = $protection->protectedType($type);
        $flagSuppr = $protection->SupprType($type);
        $flagNouveau = $protection->NouveauType($type);
    }

?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeClient.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
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
    <input type="hidden" id="protected" value="<?php echo $protected; ?>"/>
    <input type="hidden" id="supprProtected" value="<?php echo $flagSuppr; ?>"/>
    <input type="hidden" id="flagCreateur" value="<?php echo $protection->PROT_Right; ?>"/>

    <div class="col-md-12">

<fieldset class="entete">
    <legend class="entete">
<?php 
if($type=="client")
echo "Liste client";
if($type=="fournisseur")
    echo "Liste fournisseur";
if($type=="salarie")
    echo "Liste salarié";
?>
    </legend>
<div class="form-group">
<form action="indexMVC.php?module=2&action=2" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
            <td>
                <select id="sommeil" style="width:100px" class="form-control">
                    <option value="-1" <?php if($sommeil==-1) echo " selected "; ?> >Tout</option>
                    <option value="1" <?php if($sommeil==1) echo " selected "; ?> >Sommeil</option>
                    <option value="0" <?php if($sommeil==-0) echo " selected "; ?> >Non Sommeil</option>
                </select>
            </td>
        <?php if($flagNouveau){ ?><td style="float:right"><a href="<?php if($type=="fournisseur") echo "indexMVC.php?module=3&action=9"; if($type=="client") echo "indexMVC.php?module=3&action=2"; if($type=="salarie") echo "indexMVC.php?module=3&action=17"; ?>"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>

<table cellpadding="1" cellspacing="1" id="users" class="display" width="100%">
        <thead style="background-color: #dbdbed;">
            <th>Num</th>
            <th>Intitulé</th>
            <th>CG Num</th>
            <th>Cat. Tarif</th>
            <th>Cat. Compta</th>
            <?php if($flagSuppr) echo "<th></th>"; ?>
            <?php if($protection->PROT_Right==1) echo "<th>Créateur</th>"; ?>
        </thead>
</table>
 </div>   
</div>
 
</div>
