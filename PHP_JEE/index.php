<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
if(isset($_GET["action"])){
    
session_start(); //to ensure you are using same session
session_destroy(); 
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
        <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4-.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.jqueryui.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
        <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
        <link rel="stylesheet" href="assets/css/styles.css">

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/Bootstrap-DateTime-Picker-2.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.jqueryui.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
        <script src="assets/js/menu.js"></script>

        <script type="text/javascript" language="javascript">
        $(function(){
            var dateJour = new Date;
            $("#jour").val(dateJour.getDay());
            $("#heure").val(("00"+dateJour.getHours()).substr(-2)+":"+("00"+dateJour.getMinutes()).substr(-2));

            var textfield = $("input[name=user]");
            if($("#code").val()==1){
                $("#output").removeClass(' alert alert-success');
                $("#output").addClass("alert alert-danger animated fadeInUp").html("Login ou mot de passe incorrect");
            }
            if($("#code").val()==2){
                $("#output").removeClass(' alert alert-success');
                $("#output").addClass("alert alert-danger animated fadeInUp").html("Horaire de connexion non autorisé");
            }
        });
        </script>
 <title>Connexion</title>
    </head>
    <body>
    <div class="login-dark" style="background-image: url(&quot;assets/img/service-fiscalite.jpg&quot;);activité commerciale de son entreprise-cover.jpg&quot;);activité commerciale de son entreprise-cover.jpg&quot;);background-color: rgb(83,89,91);">
        <form method="post" style="background-color: rgb(255,255,255);" action="module/connexion.php">
            <h2 class="sr-only">Login Form</h2>
            <div id="output"></div>
            <div class="illustration"><img src="assets/img/it_solution.png"></div>
            <div class="form-group"><input class="form-control" type="hidden" name="code" id="code" value="<?= $_GET["code"] ?>"></div>
            <div class="form-group"><input class="form-control" type="text" name="user" placeholder="Login" required="" style="color:black"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Mot de passe" style="color:black"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: rgb(19,72,34);">Valider</button></div>
            <input name="jour" id="jour" type="hidden" value="">
            <input name="heure" id="heure" type="hidden" value="">
        </form>
    </div>
    </body>
</html>
