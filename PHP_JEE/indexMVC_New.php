<?php
session_start();
if(!isset($_SESSION["login"]))
    header('Location: connexion'); //rechercher un étudiant par domaine d'activité

?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4-.css">
    <link rel="stylesheet" href="assets/css/dataTables.jqueryui.min.css">
    <link rel="stylesheet" href="assets/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/select2-bootstrap.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <link rel="stylesheet" href="css/bootstrap-clockpicker.css"/>

</head>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="assets/js/dataTables.jqueryui.min.js"></script> -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.easing.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery.inputmask.bundle.js"></script>
    <script src="assets/js/menu.js"></script>
    <script src="js/jquery.fileupload.js"></script>
    <script src="assets/js/Bootstrap-DateTime-Picker-2.js"></script>
    <script src="assets/js/theme.js?d=<?= time(); ?>"></script>
    <script src="assets/js/chart.min.js?d=<?= time(); ?>"></script>
    <script src="assets/js/bs-charts.js?d=<?= time(); ?>"></script>
    <script src="js/scriptFonctionUtile.js?d=<?= time(); ?>"></script>
    <script src="//cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/bootstrap-clockpicker.js"></script>

<?php
    include("module/includeHeader.php");
$objet = new ObjetCollector();
$protection = new ProtectionClass("","");
if(isset($_SESSION["login"]))
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);


?>
<body id="page-top">
    <div class="se-pre-con"></div>
    <div id="wrapper">
        <?php include ("module/Menu/barreMenuGauche.php"); ?>

        <div class="d-flex flex-column" id="content-wrapper" style="background-color : white">
            <div id="content">
                <?php include ("module/Menu/barreMenuHaut.php"); ?>
                <div class="container-fluid p-1 p-md-4 p-lg-4">
                    <div class=" justify-content-between align-items-center">

                    <?php


            $module = new Menu(); // Par defaut on fait l'action 1 du module 1
            $action = 1;
            if(isset($_GET['module'])){
                switch($_GET['module']){
                    case 1 : //Rien a faire, dÃ©jÃ  fait plus haut//$module = new Module1();
                        break;
                    case 2 :
                        $module = new Facturation();
                        break;
                    case 3 :
                        $module = new Creation();
                        break;
                    case 4 :
                        $module = new Mouvement();
                        break;
                    case 5 :
                        $module = new Etat();
                        break;
                    case 6 :
                        $module = new Caisse();
                        break;
                    case 7 :
                        $module = new MenuAchat();
                        break;
                    case 8 :
                        $module = new Admin();
                        break;
                    case 9 :
                        $module = new PlanComptable();
                        break;
                }
            }
            // On rÃ©cupï¿½&#168;re l'action faite..
            if(isset($_GET['action']))
                $action = (int)$_GET['action'];
            // On demande au module concernÃ© de gÃ©rer l'action associÃ©e.
            $module->doAction($action);

            //redirection à la page d'accueil a la deconnexion
            if(isset($_GET['action']) && ($_GET['action'] == 'logout'))
            {
                $_SESSION = array();
                unset($_SESSION['login']);
                unset($_SESSION['mdp']);
                unset($_SESSION["DE_No"]);
                unset($_SESSION["CT_Num"]);
                unset($_SESSION["DO_Souche"]);
                unset($_SESSION["Affaire"]);
                unset($_SESSION["Vehicule"]);
                unset($_SESSION["CO_No"]);
                unset($_SESSION["id"]);
                session_destroy();
                ob_get_clean();
                header("location:index.php");
            }
            ?>
                </div>
            </div>
        </div>
        <footer class="bg-white sticky-footer navbar-fixed-bottom">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © IT-Solution 2020</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
</body>

</html>