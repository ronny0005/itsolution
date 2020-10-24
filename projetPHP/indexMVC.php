<!DOCTYPE html>
<?php
    session_start();
    include("Modele/Mail.php");
    include("Modele/LogFile.php");
    include("Modele/DB.php");
    include("Modele/Objet.php");
    include("Modele/ObjetCollector.php");
    include("Modele/CaisseClass.php");
    include("Modele/CollaborateurClass.php");
    include("Modele/JournalClass.php");
    include("Modele/ArtClientClass.php");
    include("Modele/DepotClass.php");
    include("Modele/DepotCaisseClass.php");
    include("Modele/DepotUserClass.php");
    include("Modele/DocEnteteClass.php");
    include("Modele/CatComptaClass.php");
    include("Modele/EtatClass.php");
    include("Modele/ReglementClass.php");
    include("Modele/CompteaClass.php");
    include("Modele/P_CommunicationClass.php");
    include("Modele/LiaisonEnvoiMailUser.php");
    include("Modele/LiaisonEnvoiSMSUser.php");
    include("Modele/ContatDClass.php");
    include("Modele/DocLigneClass.php");
    include("Modele/ComptetClass.php");
    include("Modele/CatTarifClass.php");
    include("Modele/ProtectionClass.php");
    include("Modele/TaxeClass.php");
    include("Modele/FamilleClass.php");
    include("Modele/ArticleClass.php");
include("Modele/F_TarifClass.php");
include("Modele/CompteGClass.php");
    include("module/Menu.php");
    include("module/Facturation.php");
    include("module/MenuAchat.php");
    include("module/Creation.php");
    include("module/Mouvement.php");
    include("module/Caisse.php");
    include("module/Etat.php");
    include("module/Admin.php");
include("module/PlanComptable.php");

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link href="projetPHP/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="projetPHP/css/style.css" media="screen" />
    <link href="projetPHP/css/bootstrap.css" rel="stylesheet">
    <link href="projetPHP/css/jquery-ui.css" rel="stylesheet">
    <link href="projetPHP/css/jquery-ui.theme.css" rel="stylesheet">
    <link href="projetPHP/css/fieldset.css" rel="stylesheet">
    <link href="projetPHP/css/font-awesome.min.css" rel="stylesheet">
    <link href="projetPHP/css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="projetPHP/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="projetPHP/css/bootstrap-clockpicker.css"/>
    <link rel="stylesheet" href="projetPHP/css/bootstrap-datepicker.css" />

    <script src="projetPHP/js/jquery.js"></script>
    <script src="projetPHP/js/notify.js"></script>
    <script src="projetPHP/js/jquery_ui.js"></script>
    <script src="projetPHP/js/bootstrap-3.1.1.min.js"></script>
    <script src="projetPHP/js/bootstrap-clockpicker.js"></script>
    <script src="projetPHP/js/scriptCombobox.js"></script>
    <script src="projetPHP/js/jqModal.js"></script>
    <script src="projetPHP/js/jquery.dataTables.min.js"></script>
    <script src="projetPHP/js/jquery.fileupload.js"></script>
    <script src="projetPHP/js/scriptFonctionUtile.js?d=<?php echo time(); ?>"></script>
    <script src="projetPHP/js/jquery.inputmask.bundle.js"></script>
    <link rel="stylesheet" href="projetPHP/css/select2.min.css">
    <link rel="stylesheet" href="projetPHP/css/select2-bootstrap.css">
    <script src="projetPHP/js/select2.min.js"></script>
    <script>
        jQuery(function ($) {

            (function ($) {
                $(document).ready(function () {
                    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();
                        $(this).parent().siblings().removeClass('open');
                        $(this).parent().toggleClass('open');
                    });
                });
            })(jQuery);

            $.datepicker.regional['fr'] = {
                closeText: 'Fermer',
                prevText: '&#x3c;Préc',
                nextText: 'Suiv&#x3e;',
                currentText: 'Aujourd\'hui',
                monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
                    'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
                monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
                    'Jul','Aou','Sep','Oct','Nov','Dec'],
                dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
                dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
                dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
                weekHeader: 'Sm',
                dateFormat: 'ddmmyy',
                firstDay: 1
            };
            $.datepicker.setDefaults($.datepicker.regional['fr']);
        }); // End of use strict
    </script>
    <?php
        $objet = new ObjetCollector();
        $protection = new ProtectionClass("","",$objet->db);
        if(isset($_SESSION["login"]))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"], $objet->db);

        $module = new Menu(); // Par defaut on fait l'action 1 du module 1
        $action = 1;
        if (isset($_GET['module'])) {
            switch ($_GET['module']) {
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
</div></div>
</body>
</html>