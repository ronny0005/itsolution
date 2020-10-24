<?php
$objet = new ObjetCollector();
$result=$objet->db->requete($objet->UsersByid($_SESSION["id"]));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
$i=0;
$classe="";
$texte="";
$style="";
$color = "";
if($rows==null){
}else{
    $id = $rows[0]->PROT_No;
    $username = $rows[0]->PROT_User;
    $password = $objet->decrypteMdp($rows[0]->PROT_Pwd);
}
if(isset($_POST["valide"])){
    $pwd = $_POST["mdp"];
    if ($_SESSION["mdp"] == $pwd) {
        $txtNewPassword = $_POST["txtNewPassword"];
        $txtConfirmPassword = $_POST["txtConfirmPassword"];
        if($txtNewPassword==$txtConfirmPassword) {
            $result = $objet->db->requete($objet->modifierMdp($objet->crypteMdp($txtNewPassword), $_SESSION["id"]));
            $_SESSION["mdp"] = $txtNewPassword;
            $texte = "Le mot de passe a bien été changé !";
            $color="color: green;";
        }
    }else{
        $style="border-color: red";
        $color="color: red;";
        $texte = "Le mot de passe est incorrect !";
    }
}
?>
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/scriptCombobox.js"></script>
<script src="js/script_motDePasse.js"></script>
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
<form id="form-entete" class="form-horizontal" action="indexMVC.php?module=1&action=6" method="POST" >
    <div class="form-group">
        <input class="btn btn-primary" type="hidden" name="module" id="module" value="1" />
        <input class="btn btn-primary" type="hidden" name="action" id="action" value="6" />
        <div style="<?php echo $color; ?>margin: 10px"><?php echo $texte; ?></div>
        <div class="form-group col-lg-3">
            <label>Mot de passe actuel</label>
            <input class="form-control" type="password" style="<?php echo $style; ?>" name="mdp" id="mdp" value="" />
            <label>Nouveau mot de passe</label>
            <input class="form-control" type="password" name="txtNewPassword" id="txtNewPassword" value="" />
            <label>Retaper nouveau mot de passe</label>
            <input class="form-control" type="password" name="txtConfirmPassword" id="txtConfirmPassword" value="" />
            <div class="registrationFormAlert" id="divCheckPasswordMatch" style="color: red;margin: 10px"></div>
            <input class="btn btn-primary" type="submit" name="valide" id="valide" value="Valider" />
        </div>
        <div class="form-group col-lg-3">
        </div>
    </div>
</form>