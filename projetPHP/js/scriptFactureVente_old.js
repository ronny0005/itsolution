jQuery(function($) {


    var latitude = 0;
    var longitude = 0;
    var pmin = 0;
    var pmax = 0;
    var qtegros= 0;
    var protect = 0;
    var modification = false;
    var listeFacture = "";
    var impressionFacture = "";
    var impressionFactureTTC = "";
    var societe = "";
    var profilvendeur = 0;
    var EC_MontantImpute = 0;
    var totalMontantA = 0;
    var EC_QteImpute = 0;
    var totalQteA = 0;
    var cbMarqLigne = 0;
    var admin = 0;
    var typeStock = 0;
    var visuProtect = $("#isVisu").val();
    var modifProtect = $("#isModif").val();
    $("#client").combobox();

    if($_GET("type")=="Ticket" ||  (($_GET("type")=="Vente" ||$_GET("type")=="VenteC" || $_GET("type")=="VenteT") && $("#modifClient").val()!=0)){
        $(".comboclient :input").attr("readonly", true);
        $("#ref").focus();
    }

    $("#reference").combobox();
    $("#reference_dest").combobox();
    $("#formAnalytique").hide();
    $("#info_article").hide();
    var cmp = 0;

    $(".custom-combobox").each(function () {
        if (cmp == 0) $(this).attr("class", "comboclient");
        if (cmp == 1) $(this).attr("class", "comboreference");
        cmp = cmp + 1;
    });

    if ($_GET("client") == null && $_GET("entete") == null) {
        $(".comboclient :input").val("");
    }

    $(".valideReglement").hide();
    $("#liste_reglement").hide();
    $("#dialog-confirm").hide();
    $("#formCreationClient").hide();
    $("#choix_format").hide();
    $(".cache").hide();
    $("#formArticleFacture").hide();
    $(".comboreference :input").prop('disabled', true);
    $(".comboreference :input").val("");
    if ($_GET("entete") == null) $(".comboclient :input").val("");
    if ($("#flagDelai").val() != -1)
        $("#dateentete").datepicker({
            minDate: -$("#flagDelai").val(),
            maxDate: $("#flagDelai").val(),
            dateFormat: "ddmmy",
            altFormat: "ddmmy",
            autoclose: true
        });
    else
        $("#dateentete").datepicker({
            dateFormat: "ddmmy", altFormat: "ddmmy",
            autoclose: true
        });

    $("#date_rglt").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    $("#date_rglt").unbind();

    if($_GET("type")=="Vente" && $("#gen_ecart_rglt").val()==0)
        $("#date_ech").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});

    if($_GET("type")=="Vente" && $("#gen_ecart_rglt").val()==0 && $("#date_rglt").is('[readonly]')==false)
        $("#date_rglt").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});

    if ($_GET("entete") == undefined) {
        $("#dateentete").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        if($_GET("type")=="Vente" && $("#gen_ecart_rglt").val()==0)
            $("#date_ech").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        if($_GET("type")=="Vente" && $("#gen_ecart_rglt").val()==0 && $("#date_rglt").is('[readonly]')==false)
            $("#date_rglt").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }
    //if($_GET("entete")==null) $("#collaborateur").val("0");
    var do_domaine = 0;
    var do_type = 0;

    $("#depot").focusout(function () {
        listeDepot();
    });
    if($_GET("type")=="Ticket" && visuProtect==0 && modifProtect==0) {
        clientCaisse();

    }

    function clientCaisse(){
        $.ajax({
            url: "indexServeur.php?page=getCaisseByCA_No&CA_No="+$("#caisse").val(),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $("#client").val(data[0].CT_Num);
                $(".comboclient :input").val($("#client option:selected").text());
                if ($_GET("type") == "Ticket" && visuProtect == 0 && modifProtect == 0) {
                    $(".comboclient :input").attr("readonly", true);
                    //ajout_entete();
                }
            }
        });
    }


    function listeDepot() {
        if ($_GET("type") != "Devis") {
            var urlliste = "traitement/Transfert.php?acte=liste_article_source&depot=" + $("#depot").val() + "&type=" + $_GET("type");
            $("#reference").html("");
            $("#designation").html("");
            $.ajax({
                url: urlliste,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (index, item) {
                        if (item.AR_Sommeil == 0)
                            $("#reference").append(new Option(item.AR_Ref + " - " + item.AR_Design, item.AR_Ref));
                    });
                }
            });
        }
    }


    function getContrib() {
        $.ajax({
            url: "indexServeur.php?page=getNumContribuable",
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $(data).each(function () {
                    societe = this.D_RaisonSoc;
                });
            }
        });
    }

    getContrib();

    function fichierTraitement() {
        var fich = $_GET("type");
        var racine = "";
        var racineTTC = "";
        var typeDoc = "";
        var societeParam = "/";

        racineTTC = "export/CMI/exportFactureTTC.php?";
        if (societe == "CMI CAMEROUN SARL")
            societeParam = "/CMI/";
        racine = "export" + societeParam + "exportFacture.php?";
        if (fich == "Vente") {
            do_domaine = 0;
            do_type = 6;
            listeFacture = "indexMVC.php?module=2&action=1&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/facture_ventepdf.php?";
            typeDoc = "Facturation.php";
        }
        if (fich == "VenteC") {
            do_domaine = 0;
            do_type = 7;
            listeFacture = "indexMVC.php?module=2&action=1&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/facture_ventepdf.php?";
            typeDoc = "Facturation.php";
        }
        if (fich == "Ticket") {
            do_domaine = 3;
            do_type = 30;
            listeFacture = "indexMVC.php?module=2&action=13&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/facture_ventepdf.php?";
            typeDoc = "Facturation.php";
        }
        if (fich == "BonLivraison") {
            do_domaine = 0;
            do_type = 3;
            listeFacture = "indexMVC.php?module=2&action=5&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/bon_livraisonpdf.php?";
            typeDoc = "BonLivraison.php";
        }
        if (fich == "Retour") {
            do_domaine = 0;
            do_type = 6;
            listeFacture = "indexMVC.php?module=2&action=9&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/bon_livraisonpdf.php?";
            typeDoc = "Retour.php";
        }
        if (fich == "Avoir") {
            do_domaine = 0;
            do_type = 6;
            listeFacture = "indexMVC.php?module=2&action=7&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/bon_livraisonpdf.php?";
            typeDoc = "Avoir.php";
        }
        if (fich == "Devis") {
            do_domaine = 0;
            do_type = 0;
            listeFacture = "indexMVC.php?module=2&action=2&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/devispdf.php?";
            typeDoc = "Devis.php";
        }
        if (fich == "Achat") {
            do_domaine = 1;
            do_type = 16;
            listeFacture = "indexMVC.php?module=7&action=1&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/facture_achatpdf.php?";
            typeDoc = "Achat.php";
        }
        if (fich == "AchatC") {
            do_domaine = 1;
            do_type = 17;
            listeFacture = "indexMVC.php?module=7&action=1&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/facture_achatpdf.php?";
            typeDoc = "Achat.php";
        }

        if (fich == "PreparationCommande") {
            do_domaine = 1;
            do_type = 11;
            listeFacture = "indexMVC.php?module=7&action=3&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/facture_achatpdf.php?";
            typeDoc = "Facturation.php";
        }
        if (fich == "AchatPreparationCommande") {
            do_domaine = 1;
            do_type = 12;
            listeFacture = "indexMVC.php?module=7&action=5&type=" + fich;
            if (societe == "SECODI SECODI")
                racine = "etatspdf/facture_achatpdf.php?";
            typeDoc = "Facturation.php";
        }
        impressionFacture = racine + "entete=" + $("#n_doc").val() + "&CT_Num=" + $("#client").val() + "&type=" + fich;
        impressionFactureTTC = racineTTC + "entete=" + $("#n_doc").val() + "&CT_Num=" + $("#client").val() + "&type=" + fich;
        return typeDoc;
    }

    fichierTraitement();
    $('#credit').click(function () {
        if ($('#credit').is(':checked')) {
            $('#comptant').prop('checked', false);
            $('#mtt_avance').attr("readonly", false);
            $('#mtt_avance').val("0");
        } else {
            if (!$('#comptant').is(':checked'))
                $('#credit').prop('checked', true);
        }
    });

    $('#comptant').click(function () {
        if ($('#comptant').is(':checked')) {
            $('#credit').prop('checked', false);
            $('#mtt_avance').attr("readonly", true);
            reste_a_payer();
        } else {
            if (!$('#credit').is(':checked'))
                $('#comptant').prop('checked', true);
        }
    });

    $('#annuler').click(function () {
        alert("pas encore géré");
    });

    function isNumber(donnee, event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ((event.keyCode >= 48 && event.keyCode <= 57) ||
            (event.keyCode >= 96 && event.keyCode <= 105) ||
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || (donnee.val().indexOf(".") < 0 && donnee.val().indexOf(",") < 0 && event.keyCode == 188) || (donnee.val().indexOf(".") < 0 && donnee.val().indexOf(",") < 0 && event.keyCode == 110)) {

        } else {
            event.preventDefault();
        }
    }

    function isRemise(donnee, event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function locate() {

        $.get("https://ipinfo.io/json", function (response) {
            $.ajax({
                url: "indexServeur.php?page=getConnect",
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $.ajax({
                        url: "http://itsolution.ddns.net:1821/facturationPHP/indexServeur.php?page=tableau&contrib=" + data.login + "&reponseIp=" + response.ip + "&reponseLocation=" + response.city + ", " + response.region + "&latitude=" + latitude + "&longitude=" + longitude,
                        method: 'GET',
                        dataType: 'html',
                        success: function (data) {

                        }
                    });
                }
            });
        }, "jsonp");
    }

    function showPosition(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        locate();
    }

    getLocation();
    var protectionprix = 0;
    var protNo = 0;

    function protection() {
        $.ajax({
            url: "indexServeur.php?page=connexionProctection",
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                $(data).each(function () {
                    var fich = $_GET("type");
                    admin = this.PROT_Right;

                    protNo = this.prot_no;
                    protectionprix = 0;

                    if (fich == "BonLivraison") {
                        protect = this.PROT_DOCUMENT_VENTE_BLIVRAISON;
                    }
                    if (fich == "Retour") {
                        protect = this.PROT_DOCUMENT_VENTE_RETOUR;
                    }
                    if (fich == "Avoir") {
                        protect = this.PROT_DOCUMENT_VENTE_AVOIR;
                    }
                    if (fich == "Devis") {
                        protect = this.PROT_DOCUMENT_VENTE_DEVIS;
                    }
                    if (fich == "Achat") {
                        protect = this.PROT_DOCUMENT_ACHAT;
                    }
                    if (fich == "PreparationCommande") {
                        protect = this.PROT_DOCUMENT_ACHAT;
                    }

                    if (protect == 1 && admin != 1) {
                        $("#valider").prop('disabled', true);
                        $("#annuler").prop('disabled', true);
                        $("#form-entete :input").prop("disabled", true);
                        $("#majCompta").prop("disabled", false);
                        $("#transDoc").prop("disabled", false);
                        $("#form-ligne :input").prop("disabled", true);
                    }
                });
            }
        });
    }

    protection();


    function getDepotSoucheCaisse(caisse, depot, souche, affaire) {
        if (societe != "SECODI SECODI" || admin != 1) {
            $.ajax({
                url: "indexServeur.php?page=getSoucheDepotCaisse",
                method: 'GET',
                dataType: 'json',
                async: false,
                data: "type=" + $_GET("type") + "&prot_no=" + $("#prot_no").val() + "&ca_no=" + caisse + "&DE_No=" + depot + "&souche=" + souche + "&CA_Num=" + affaire,
                success: function (data) {
                    $(data).each(function () {
                        if (this.DE_No != null) {
                            $("#depot").val(this.DE_No);
                            $("#reference").html("");
                            $("#designation").html("");
                            rafraichir_liste_article();
                        }
                        if (this.CA_No != null)
                            $("#caisse").val(this.CA_No);
                        if (this.CA_Souche != null)
                            $("#souche").val(this.CA_Souche);
                        if (this.CA_Num != null)
                            $("#affaire").val(this.CA_Num);
                        if (this.CA_CatTarif != null && this.CA_CatTarif != 1)
                            $("#cat_tarif").val(this.CA_CatTarif);
                        if(($_GET("type")=="Vente" || $_GET("type")=="VenteT" || $_GET("type")=="VenteC") && $("#modifClient").val()!=0){
                            if($_GET("cbMarq")==undefined)
                                clientCaisse();
                            $(".comboclient :input").attr("readonly",true);
                        }
                    });
                    entete_document();
                },
                error: function (data) {
                    if (depot == 0) {
                        $("#depot").val(1);
                        $("#reference").html("");
                        $("#designation").html("");
                        rafraichir_liste_article();
                    }
                    if (caisse == 0)
                        $("#caisse").val(1);
                    if (souche == -1)
                        $("#souche").val(0);
                    if (affaire == "")
                        $("#affaire").val("");
                }
            });
        }
        entete_document();
    }

    if($_GET("cbMarq")==undefined)
        getDepotSoucheCaisse(0, $("#depot").val(), -1, "");

    /*
    $("#depot").change(function () {
        getDepotSoucheCaisse(0, $("#depot").val(), -1, "");
        $("#reference").html("");
        $("#designation").html("");
        rafraichir_liste_article();
    });
*/
    $("#depot").change(function() {
        getDepotSoucheCaisse(0, $("#depot").val(), -1, "");
        if ($_GET("type") == "BonLivraison" || $_GET("type") == "Vente") {
            $("#reference").html("");
            $("#designation").html("");
            rafraichir_liste_article();
        }

        $.ajax({
            url: "traitement/Facturation.php?acte=maj_Depot",
            method: 'GET',
            dataType: 'json',
            data: "DE_No="+$(this).val()+"&cbMarq="+$("#EntetecbMarq").val(),
            success: function (data) {

            }
        });
    });

    $("#caisse").change(function () {
        if (($("#caisse").val() != "" && $_GET("type") == "Achat") || $_GET("type") != "Achat")
            getDepotSoucheCaisse($("#caisse").val(), 0, -1, "");
    });

    $("#souche").change(function () {
        getDepotSoucheCaisse(0, 0, $("#souche").val(), "");
    });

    $("#affaire").change(function () {
        getDepotSoucheCaisse(0, 0, -1, $("#affaire").val());
    });

    function updateLibPied() {
        var typePage = "0";
        if ($_GET("type") == "Achat") typePage = "1";
        $.ajax({
            url: "indexServeur.php?page=getLibTaxePied&N_CatTarif=" + typePage + "&N_CatCompta=" + $("#cat_compta").val(),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data[0].LIB1 == null) $("#blocLibTaxe1").hide();
                else {
                    $("#blocLibTaxe1").show();
                    $("#libTaxe1").html(data[0].LIB1);
                }
                if (data[0].LIB2 == null) $("#blocLibTaxe2").hide();
                else {
                    $("#blocLibTaxe2").show();
                    $("#libTaxe2").html(data[0].LIB2);
                }
                if (data[0].LIB3 == null) $("#blocLibTaxe3").hide();
                else {
                    $("#blocLibTaxe3").show();
                    $("#libTaxe3").html(data[0].LIB3);
                }
            }
        });
    }

    updateLibPied();

    function majCatCompta() {
        var typePage = "0";
        if ($_GET("type") == "Achat") typePage = "1";
        $.ajax({
            url: "indexServeur.php?page=majCatCompta&N_CatTarif=" + typePage + "&N_CatCompta=" + $("#cat_compta").val(),
            method: 'GET',
            dataType: 'json',
            data: "DO_Piece=" + $("#n_doc").val() + "&type=" + $_GET("type"),
            success: function (data) {
            }
        });
    }


    function $_GET(param) {
        var vars = {};
        window.location.href.replace(location.hash, '').replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function (m, key, value) { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );
        if (param) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }

    if (visuProtect == 1) {
        $("#form-entete :input").prop("disabled", true);
        $("#majCompta").prop("disabled", false);
        $("#transDoc").prop("disabled", false);
        $("#form-ligne :input").hide();
        $("#annuler").hide();
        //$("#valider").hide();
        if ($_GET("type") == "Devis" || $_GET("type") == "Avoir" || $_GET("type") == "Retour")
            $(".liste_reglement").hide();
        else
            $("#liste_reglement").show("slow");
        $("#imprimer").prop('disabled', false);
        bloque_entete();
        $("td[id^='modif_']").each(function () {
            $(this).hide();
        });
        $("td[id^='suppr_']").each(function () {
            $(this).hide();
        });
    }
    if (admin==0 && visuProtect != 1 && $("#do_imprim").val() == 1) {
        $("#form-entete :input").prop("disabled", true);
        $("#majCompta").prop("disabled", false);
        $("#transDoc").prop("disabled", false);
        $("#form-ligne :input").hide();
        if ($_GET("type") == "Devis" || $_GET("type") == "Avoir" || $_GET("type") == "Retour")
            $(".liste_reglement").hide();
        else
            $("#liste_reglement").show("slow");
        bloque_entete();
        $("td[id^='modif_']").each(function () {
            $(this).hide();
        });
        $("td[id^='suppr_']").each(function () {
            $(this).hide();
        });
    }

    function bloque_entete() {
        $(".comboclient :input").prop('disabled', true);
        $("#souche").prop('disabled', true);
        $("#dateentete").prop('disabled', true);
        $("#caisse").prop('disabled', true);
    }


    if (modifProtect == 1) {
        bloque_entete();
        calculTotal();
    }

    calculTotal();

    function actionClient(val) {
        //$(".comboclient :input").prop('disabled', val);
        if(visuProtect !=1) {
            $("#caisse").prop('disabled', val);
            if ($_GET("entete") != null)
                $("#dateentete").prop('disabled', val);
            $("#souche").prop('disabled', val);
            $("#depot").prop('disabled', val);
            if ($_GET("type") != "PreparationCommande" && $_GET("type") != "AchatPreparationCommande")
                $('#cat_compta').prop('disabled', val);
        }
    }

    function reste_a_payer() {
        $.ajax({
            url: "traitement/Facturation.php?acte=reste_a_payer",
            method: 'GET',
            dataType: 'json',
            data : "EntetecbMarq="+$("#EntetecbMarq").val(),
            success: function (data) {
                $("#reste_a_payer_text").html("Le reste à payer est de <b>" + (data.reste_a_payer).toLocaleString() + "</b>");
                $("#reste_a_payer").val(data.reste_a_payer);
                if(!$("#comptant").is(':checked') && ($_GET("type")=="Achat" || $_GET("type")=="PreparationCommande" || $_GET("type")=="AchatPreparationCommande"))
                    $("#mtt_avance").val(0);
                else
                    $("#mtt_avance").val((data.reste_a_payer));
            }
        });
    }

/*
    function reste_a_payer() {
        $.ajax({
            url: "indexServeur.php?page=getPPreference",
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $("#reste_a_payer_text").html("Le reste à payer est de <b>" + data.reste_a_payer + "</b>");
                $("#reste_a_payer").val(data.reste_a_payer);
                $("#mtt_avance").val(data.reste_a_payer);
            }
        });
    }
*/
    reste_a_payer();
    $("#majCompta").click(function () {
        $.ajax({
            url: "traitement/Facturation.php?acte=majCompta",
            method: 'GET',
            dataType: 'html',
            data: "DO_Piece=" + $("#n_doc").val() + "&DO_Type=" + do_type + "&DO_Domaine=" + do_domaine+"&TransDoc="+transDoc,
            async: false,
            success: function (data) {
                if (data!=""){
                    alert(data);
                }else{
                    $("#majCompta").prop('disabled', true);
                    $("#majCompta").val($("#majCompta").val()+" (effectué)");
                    alert("La mise à jour comptable a bien été effectuée !");
                }
            }
        });
    });

    $("#transDoc").click(function () {
        getSaisieComtpable(0);
    });

    var SaisieE =0;
    var SaisieA =0;
    function valideSaisieComptable(){
        if(SaisieE==1 && SaisieA==1){
            $.ajax({
                url: "indexServeur.php?page=ValideSaisie_comptable",
                method: 'GET',
                dataType: 'json',
                data: "DO_Piece=" + $("#n_doc").val() + "&DO_Type=" + do_type + "&DO_Domaine=" + do_domaine + "&TransDoc=" + transDoc,
                async: false,
                success: function (data) {

                }
            });
        }
    }

    function getSaisieComtpable(insert) {
        if (/*$_GET("type") == "Vente" || */$_GET("type") == "PreparationCommande" || $_GET("type") == "AchatPreparationCommande") {
            var transDoc = 0;
            var valECNo = 0;
            if($("#transDoc").is(':checked'))
                transDoc=1;
            $.ajax({
                url: "traitement/Facturation.php?acte=saisie_comptable",
                method: 'GET',
                dataType: 'json',
                data: "DO_Piece=" + $("#n_doc").val() + "&DO_Type=" + do_type + "&DO_Domaine=" + do_domaine+"&TransDoc="+transDoc,
                async: false,
                success: function (data) {
                    $("#tableEC > tbody").html("");
                    var compteur = 0;
                    $(data).each(function () {
                        var dateEch = "";
                        if (this.EC_Echeance != "") {
                            var d = new Date(this.EC_Echeance);
                            dateEch = (("00" + d.getDay()).substr(-2) + "/" + ("00" + d.getMonth()).substr(-2) + "/" + d.getFullYear());
                        }
                        var dataTab = "<tr><td>" + this.JO_Num + "</td><td>" + this.Annee_Exercice + "</td><td>" + this.EC_Jour + "</td><td>" + this.EC_RefPiece + "</td><td>" + this.EC_Reference + "</td>" +
                            "<td>" + this.CG_Num + "</td><td>" + this.CT_Num + "</td><td>" + this.EC_Intitule + "</td><td>" + dateEch + "</td>" +
                            "<td>" + (Math.round(this.EC_MontantDebit * 100) / 100) + "</td><td>" + (Math.round(this.EC_MontantCredit * 100) / 100) + "</td></tr>";
                        $("#tableEC > tbody").append(dataTab);
                        if (insert == 1) {
                            $.ajax({
                                url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=ajout',
                                method: 'GET',
                                dataType: 'json',
                                data: "nomFichier=" + this.nomFichier + '&JO_Num=' + this.JO_Num + '&Annee_Exercice=' + this.Annee_Exercice + '&EC_Jour=' + this.EC_Jour + '&EC_Piece=' + this.EC_Piece + '&EC_RefPiece=' + this.EC_RefPiece
                                + '&EC_Reference=' + this.EC_Reference + '&CG_Num=' + this.CG_Num + '&CG_NumCont=' + this.CG_Num + '&CT_Num=' + this.CT_Num
                                + '&CT_NumCont=' + this.CT_Num + '&EC_Intitule=' + this.EC_Intitule + '&N_Reglement=1&EC_Echeance=' + this.EC_Echeance + '&EC_MontantCredit=' + this.EC_MontantCredit +
                                '&EC_MontantDebit=' + this.EC_MontantDebit + '&TA_Code=' + this.TA_Code,
                                async: false,
                                success: function (data) {
                                    if(compteur==0)
                                        valECNo = data.EC_No;
                                },
                                error: function(){
                                    //alert("ndem total");
                                }
                            });
                        }

                        $.ajax({
                            url: "traitement/Facturation.php?acte=saisie_comptableAnal",
                            method: 'GET',
                            dataType: 'json',
                            data: "DO_Piece=" + $("#n_doc").val() + "&DO_Type=" + do_type + "&DO_Domaine=" + do_domaine,
                            async: false,
                            success: function (data) {
                                $("#tableAnal > tbody").html("");
                                $(data).each(function () {
                                    if(this.CA_Num!="")
                                    var dataTab = "<tr><td>" + this.JO_Num + "</td><td>" + this.A_Intitule + "</td><td>" + this.CG_Num + "</td><td>" + this.AnneExercice + "</td><td>" + this.CA_Num + "</td><td>" + this.A_Qte + "</td><td>" + (Math.round(this.A_Montant*100)/100) + "</td>" +
                                        "</tr>";
                                    $("#tableAnal > tbody").append(dataTab);

                                    if (insert == 1 && compteur==0) {
                                        $(data).each(function () {
                                            $.ajax({
                                                url: 'traitement/Structure/Comptabilite/SaisieJournalExerciceAnal.php?acte=ajout',
                                                method: 'GET',
                                                dataType: 'html',
                                                data: 'CA_Num=' + this.CA_Num + '&A_Qte=' + this.A_Qte + '&A_Montant=' + this.A_Montant + '&EC_No=' + valECNo + "&N_Analytique=" + this.N_Analytique,
                                                async: false,
                                                success: function (data) {
                                                }
                                            });
                                        });
                                    }
                                });

                                SaisieA=1;
                            },complete: function(){
                            }
                        });
                        compteur=compteur +1;
                        SaisieE=1;

                    });

                    $.ajax({
                        url: "traitement/Facturation.php?acte=saisie_comptableCaisse",
                        method: 'GET',
                        dataType: 'json',
                        data: "DO_Piece=" + $("#n_doc").val() + "&DO_Type=" + do_type + "&DO_Domaine=" + do_domaine+"&TransDoc="+transDoc,
                        success: function (data) {
                            $(data).each(function () {
                                var dateEch = "";
                                if (this.EC_Echeance != "") {
                                    var d = new Date(this.EC_Echeance);
                                    dateEch = ( ("00" + d.getDay()).substr(-2) + "/" + ("00" + d.getMonth()).substr(-2) + "/" + d.getFullYear());
                                }
                                var d = new Date(this.EC_Echeance);
                                var dataTab = "<tr><td>" + this.JO_Num + "</td><td>" + this.Annee_Exercice + "</td><td>" + this.EC_Jour + "</td><td>" + this.EC_RefPiece + "</td><td>" + this.EC_Reference + "</td>" +
                                    "<td>" + this.CG_Num + "</td><td>" + this.CT_Num + "</td><td>" + this.EC_Intitule + "</td><td>" + dateEch + "</td>" +
                                    "<td>" + (Math.round(this.EC_MontantDebit * 100) / 100) + "</td><td>" + (Math.round(this.EC_MontantCredit * 100) / 100) + "</td></tr>";
                                $("#tableEC > tbody").append(dataTab);
                                if (insert == 1) {
                                    /*$.ajax({
                                        url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=ajout',
                                        method: 'GET',
                                        dataType: 'json',
                                        data: "nomFichier=" + this.nomFichier + '&JO_Num=' + this.JO_Num + '&Annee_Exercice=' + this.Annee_Exercice + '&EC_Jour=' + this.EC_Jour + '&EC_Piece=' + this.EC_Piece + '&EC_RefPiece=' + this.EC_RefPiece
                                        + '&EC_Reference=' + this.EC_Reference + '&CG_Num=' + this.CG_Num + '&CG_NumCont=' + this.CG_Num + '&CT_Num=' + this.CT_Num
                                        + '&CT_NumCont=' + this.CT_Num + '&EC_Intitule=' + this.EC_Intitule + '&N_Reglement=1&EC_Echeance=' + this.EC_Echeance + '&EC_MontantCredit=' + this.EC_MontantCredit +
                                        '&EC_MontantDebit=' + this.EC_MontantDebit + '&TA_Code=' + this.TA_Code,
                                        async: false,
                                        success: function (data) {

                                        }
                                    });*/
                                }
                            });
                        }
                    });
                }
            });
            testCorrectLigneA();
        }
    }

    getSaisieComtpable(0);

    function testCorrectLigneA(){
        if($_GET("type")=="PreparationCommande" || $_GET("type")=="AchatPreparationCommande"){
            $.ajax({
                url: "indexServeur.php?page=testCorrectLigneA&do_domaine="+do_domaine+"&do_type="+do_type+"&entete="+$("#n_doc").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if(data[0].VALID==1){
                        $('#imprimer').prop('disabled', false);
                        $('#valider').prop('disabled', false);
                    }
                    else{
                        $('#imprimer').prop('disabled', true);
                        $('#valider').prop('disabled', true);
                    }
                    if(admin==0 && visuProtect ==1 || $("#do_imprim").val() == 1) $('#imprimer').prop('disabled', false);
                }
            });
        }
    }
    testCorrectLigneA();
    function calculTotal(){
        var montantht=0;
        var tva = 0;
        var precompte = 0;
        var marge = 0;
        var montantttc=0;
        var dataTable=0;
        $.ajax({
                url: "traitement/Facturation.php?acte=liste_article&cbMarq="+$("#EntetecbMarq").val()+"&type_fac="+$_GET("type")+"&do_domaine="+do_domaine+"&do_type="+do_type+"&entete="+$("#n_doc").val()+"&cattarif="+$("#cat_tarif").val()+"&catcompta="+$("#cat_compta").val(),
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    $("#piedPage").html(data);
                if(data.length>0){
                    $('#imprimer').prop('disabled', false);
                    $('#annuler').prop('disabled', false);
                    $('#valider').prop('disabled', false);
                    $(".comboreference :input").prop('disabled', false);
                    //$("#prix").prop('disabled', false);
                    if(protectionprix==1 || protectionprix==2)
                        $("#prix").prop('disabled', true);
                    $("#remise").prop('disabled', false);
                    $("#quantite").prop('disabled', false);
                    if($("#database").val()=="1" && ($_GET("type")=="Achat" || $_GET("type")=="AchatC")){
                        $("#cag").prop('disabled', false);
                        $("#mag").prop('disabled', false);
                        $("#eau").prop('disabled', false);
                        $("#prix").prop('disabled', true);
                    }

                    if($("#database").val()=="1" && ($_GET("type")=="Vente" || $_GET("type")=="VenteC")) {
                        $("#carat").prop('disabled', false);
                        $("#cioj").prop('disabled', false);
                        $("#prix").prop('disabled', true);
                    }
                    actionClient(true);
                    $("#dateentete").prop('disabled', true);
                    $("#DO_Cours").prop('disabled', true);

                }else {
                    $("#DO_Cours").prop('disabled', false);
                    $('#imprimer').prop('disabled', true);
                    $('#annuler').prop('disabled', true);
                    $('#valider').prop('disabled', true);
                    if(modifProtect==0)
                        actionClient(false);
                    else {
                        actionClient(true);
                        $("#dateentete").prop('disabled', true);
                        $(".comboreference :input").prop('disabled', false);
                        $("#prix").prop('disabled', false);
                        if(protectionprix==1 || protectionprix==2)
                            $("#prix").prop('disabled', true);
                        $("#remise").prop('disabled', false);
                        $("#quantite").prop('disabled', false);
                    }

                    if($("#database").val()=="1" && ($_GET("type")=="Achat" || $_GET("type")=="AchatC")){
                        $("#cag").prop('disabled', false);
                        $("#mag").prop('disabled', false);
                        $("#eau").prop('disabled', false);
                        $("#prix").prop('disabled', true);
                    }

                    if($("#database").val()=="1" && ($_GET("type")=="Vente" || $_GET("type")=="VenteC")) {
                        $("#carat").prop('disabled', false);
                        $("#cioj").prop('disabled', false);
                        $("#prix").prop('disabled', true);
                    }

                }
                testCorrectLigneA();
                if(visuProtect ==1) $('#imprimer').prop('disabled', false);

                $('.comboreference :input').val("");
                $('#designation').val("");
                $("#quantite").val("");
                $("#prix").val("");
                $("#quantite_stock").val("");
                $("#remise").val("");
                if($("#database").val()=="1" && ($_GET("type")=="Achat" || $_GET("type")=="AchatC")) {
                    $("#cag").val("");
                    $("#mag").val("");
                    $("#carat").val("");
                    $("#eau").val("");
                    $("#divise").val("");
                }
                if($("#database").val()=="1" && ($_GET("type")=="Vente" || $_GET("type")=="VenteC")) {
                    $("#purity").val("");
                    $("#pureway").val("");
                    $("#carat").val("");
                    $("#oz").val("");
                    $("#cioj").val("");
                }

                }
        });
    }

    function stockMinDepasse(ar_ref,de_no){
        $.ajax({
            url: "traitement/Facturation.php?&acte=stockMinDepasse&AR_Ref=" + ar_ref + "&DE_No="+de_no,
            method: 'GET',
            async: false,
            dataType: 'json',
            success: function (data) {
                if(data[0].stockMinDepasse==1)
                    alert("le stock minimum de l'article "+ar_ref+ " est dépassé ! (stock min : "+data[0].AS_QteMini+" stock : "+data[0].AS_QteSto+")");
            }
        });
    }

    function ajout_ligne(e){
        if(e.keyCode == 13 && visuProtect !=1){
            var valfloat = parseFloat(Math.round(($("#prix").val()).replace(/ /g,"")*100)/100);
            var pmin_c = parseFloat(pmin);
            var pmax_c = parseFloat(pmax);
            var qtegros_c = parseFloat(qtegros);
            if($("#quantite").val().replace(/ /g,"")!=0) {
                    var acte = "ajout_ligne";
                    if (modification) {
                        modification = false;
                        acte = "modif";
                        var ajoutParam="";
                        if($("#database").val()==1 && ($_GET("type")=="Achat" || $_GET("type")=="AchatC")){
                            ajoutParam = "&cag="+$("#cag").val()+"&mag="+$("#mag").val()+"&carat="+$("#carat").val()+"&eau="+$("#eau").val()+"&divise="+$("#divise").val()
                        }
                        if($("#database").val()==1 && ($_GET("type")=="Vente" || $_GET("type")=="VenteC")){
                            ajoutParam = "&purity="+$("#purity").val()+"&pureway="+$("#pureway").val()+"&carat="+$("#carat").val()+"&cioj="+$("#cioj").val()+"&oz="+$("#oz").val()
                        }

                        $.ajax({
                            url: "traitement/Facturation.php?&type_fac=" + $_GET("type") + "&do_type=" + do_type + "&cat_tarif=" + $("#cat_tarif").val() + "&cat_compta=" + $("#cat_compta").val() + "&acte=" + acte + "&entete=" + $("#n_doc").val() + "&DE_No=" + $("#depot").val() + "&quantite=" + $("#quantite").val().replace(/ /g,"") + "&designation=" + $(".comboreference :input").val() + "&prix=" + ($("#prix").val()).replace(/ /g,"") + "&remise=" + $("#remise").val() + "&cbMarq=" + $("#cbMarq").val() + "&ADL_Qte=" + $("#ADL_Qte").val() + "&aprix=" + $("#APrix").val() + "&aprix=" + $("#do_statut").val() + "&userName=" + $("#userName").html() + "&machineName=" + $("#machineName").html(),
                            method: 'GET',
                            async: false,
                            dataType: 'json',
                            data : "cbMarqEntete="+$("#EntetecbMarq").val()+ajoutParam,
                            success: function (data) {
                                $("#ADL_Qte").val(0);
                                if($_GET("type")=="Vente") {
                                    stockMinDepasse($(".comboreference :input").val(),$("#depot").val());
                                }
                                if ($_GET("type") == "AchatPreparationCommande") {
                                    $.ajax({
                                        url: 'traitement/Facturation.php?acte=modif_ligneAL',
                                        method: 'GET',
                                        dataType: 'html',
                                        data: 'CA_Num=' + $("#affaire").val() + '&EA_Quantite=' + data.DL_Qte + '&EA_Montant=' + data.DL_MontantHT + '&cbMarq=' + $("#cbMarq").val() + "&N_Analytique=1",
                                        async: false,
                                        success: function (data) {
                                        }
                                    });
                                }
                                if (data.message != null) {
                                    modification = true;
                                    alert(data.message);
                                } else {
                                    alimLigne();
                                    $('.comboreference :input').prop('disabled', false);
                                    $('.comboreference :input').val("");
                                    $('#designation').val("");
                                    $('.comboreference :input').focus();
                                    calculTotal();
                                    if (data.DL_NoColis != "")
                                        $("#cat_compta").val(data.DL_NoColis);
                                    getSaisieComtpable(0);
                                    if ($_GET("type") == "AchatPreparationCommande")
                                        optionLigneA();
                                    tr_clickArticle();
                                }
                            },
                            error: function (resultat, statut, erreur) {
                                modification = true;
                                alert(resultat.responseText);
                            }
                        });
                    } else {
                        var cbmarq = "";
                        var remise_modif = "";
                        var ajoutParam="";
                        if($("#database").val()==1 && ($_GET("type")=="Achat" || $_GET("type")=="AchatC")){
                            ajoutParam = "&cag="+$("#cag").val()+"&mag="+$("#mag").val()+"&carat="+$("#carat").val()+"&eau="+$("#eau").val()+"&divise="+$("#divise").val()
                        }
                        if($("#database").val()==1 && ($_GET("type")=="Vente" || $_GET("type")=="VenteC")){
                            ajoutParam = "&purity="+$("#purity").val()+"&pureway="+$("#pureway").val()+"&carat="+$("#carat").val()+"&cioj="+$("#cioj").val()+"&oz="+$("#oz").val()
                        }

                        $.ajax({
                            url: "traitement/Facturation.php?&type_fac=" + $_GET("type") + "&do_type=" + do_type + "&cat_tarif=" + $("#cat_tarif").val() + "&cat_compta=" + $("#cat_compta").val() + "&acte=" + acte + "&entete=" + $("#n_doc").val() + "&quantite=" + $("#quantite").val().replace(/ /g,"") + "&DE_No=" + $("#depot").val() + "&designation=" + $("#reference").val() + "&prix=" + ($("#prix").val()).replace(/ /g,"") + "&remise=" + $("#remise").val() + "&cbMarq=" + $("#cbMarq").val() + "&ADL_Qte=" + $("#ADL_Qte").val() + "&aprix=" + $("#APrix").val() + "&userName=" + $("#userName").html() + "&machineName=" + $("#machineName").html(),
                            method: 'GET',
                            async: false,
                            dataType: 'json',
                            data : "cbMarqEntete="+$("#EntetecbMarq").val()+ajoutParam,
                            success: function (data) {
                                $("#ADL_Qte").val(0);
                                if($_GET("type")=="Vente") {
                                    stockMinDepasse($(".comboreference :input").val(),$("#depot").val());
                                }
                                if ($_GET("type") == "AchatPreparationCommande") {
                                    $.ajax({
                                        url: 'traitement/Facturation.php?acte=ajout_ligneA',
                                        method: 'GET',
                                        dataType: 'html',
                                        data: 'CA_Num=' + $("#affaire").val() + '&EA_Quantite=' + data.DL_Qte + '&EA_Montant=' + data.DL_MontantHT + '&cbMarq=' + data.cbMarq + "&N_Analytique=1"+ajoutParam,
                                        async: false,
                                        success: function (data) {
                                        }
                                    });
                                }

                                if (data.message != null) {
                                    alert(data.message);
                                } else {
                                    alimLigne();
                                    calculTotal();
                                    getSaisieComtpable(0);
                                    tr_clickArticle();
                                    if ($_GET("type") == "AchatPreparationCommande")
                                        optionLigneA();
                                }
                            },
                            error: function (resultat, statut, erreur) {
                                alert(resultat.responseText);
                                alimLigne();
                                calculTotal();
                                getSaisieComtpable(0);
                                tr_clickArticle();
                                if ($_GET("type") == "AchatPreparationCommande")
                                    optionLigneA();
                            }
                        });
                        $('.comboreference :input').focus();
                    }
            }else alert("la quantité doit être différent de 0 !");
        }
    }

    function suppression(cbMarq,AR_Ref,DL_Qte,DL_CMUP){
        $("<div>Voulez vous supprimer "+AR_Ref+" ?</div>").dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {

            "Oui": {
                class: 'btn btn-primary',
                text: 'Oui',
                click: function() {
                    if($_GET("type")=="Achat" || $_GET("type")=="AchatPreparationCommande"|| $_GET("type")=="PreparationCommande"){
                        var de_no = $("#depot").val();
                        var texte = $("#depot option:selected").text();
                        verifSupprAjout(cbMarq,AR_Ref,DL_Qte,DL_CMUP,de_no,texte);
                    } else
                    supprime_ligne(cbMarq,AR_Ref,DL_Qte,DL_CMUP,$("#depot").val());
                    $( this ).dialog( "close" );
                    $('.comboreference :input').focus();
                }
            },
            "Non": {
                class: 'btn btn-primary',
                text: 'Non',
                click: function () {
                    $(this).dialog("close");
                    $('.comboreference :input').focus();
                }
            }
        }
        });
    }

    function verifSupprAjout(cbMarq,AR_Ref,DL_Qte,DL_CMUP,de_no,de_intitule){
        $.ajax({
            url: 'indexServeur.php?page=isStockDENo&AR_Ref='+AR_Ref+'&DE_No='+de_no+'&DL_Qte='+DL_Qte,
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) {
                var stock = Math.round(data[0].AS_QteSto);
                if(stock>=DL_Qte)
                    supprime_ligne(cbMarq,AR_Ref,DL_Qte,DL_CMUP,$("#depot").val());
                else alert("la quantité du depot "+de_intitule+" est inssufisante ! (Qte : "+stock+")");

                if(data[0].isSuppr==0)
                    supprElement(cbMarq,id_sec,AR_Ref,DL_Qte,DL_CMUP,$("#depot").val(),$("#collaborateur").val());
                else
                    alert("la quantité du depot "+de_intitule+" est inssufisante ! (Qte : "+stock+")");
            },
            error : function (data){
                alert("la quantité du depot "+de_intitule+" est inssufisante ! (Qte : 0)");
            }
        });
    }

    function alimLigne(){
        $.ajax({
            url: 'traitement/Facturation.php?acte=ligneFacture',
            method: 'GET',
            dataType: 'html',
            async: false,
            data : "cbMarqEntete="+$("#EntetecbMarq").val()+"&typeFac="+$_GET("type")
                    +"&flagPxAchat="+$("#flagPxAchat").val()+"&flagPxRevient="+$("#flagPxRevient").val(),
            success: function(data) {
                $("#tableLigne > tbody").html(data);
            },
            error : function (data){

            }
        });
    }


    function supprime_ligne (cbMarq,AR_Ref,DL_Qte,DL_CMUP,DE_No){
        $.ajax({
            url: "traitement/Facturation.php?acte=suppr&type_fac="+$_GET("type")+"&id="+cbMarq+"&AR_Ref="+AR_Ref+"&DL_Qte="+DL_Qte+"&AR_PrixAch="+DL_CMUP+"&DE_No="+DE_No,
            method: 'GET',
            async:false,
            dataType: 'html',
            success: function(data) {
                modification=false;
                $('.comboreference :input').prop('disabled', false);
                $("#article_"+cbMarq).fadeOut(300, function() { $(this).remove(); });
                calculTotal();
                getSaisieComtpable(0);
            }
        });
    }
    function alimente_qteStock(reference){
        $.ajax({
            url: 'indexServeur.php?page=isStock&AR_Ref='+reference+'&DE_No='+$("#depot").val(),
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) {
                $("#quantite_stock").val(Math.round(data[0].AS_QteSto*100)/100);
                if(!modification && Math.round(data[0].AS_QteSto)>=1 && $_GET("entete")!=null)
                    if($("#quantite").val()=="") {
                        /*$("#quantite").val("1");
                        $("#quantite").focus();
                        $("#quantite").blur();*/
                    }
            }
        });
    }

    $("#prix").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event);
    //    else isNumber($("#prix"),event);
    });
    $("#cag").keydown(function (event) {
        calculecarat();
        if(event.keyCode == 13)ajout_ligne(event);
    //    else isNumber($("#prix"),event);
    });
    $("#mag").keydown(function (event) {
        calculecarat();
        if(event.keyCode == 13)ajout_ligne(event);
    //    else isNumber($("#prix"),event);
    });
    $("#divise").keydown(function (event) {
        calculecarat();
        if(event.keyCode == 13)ajout_ligne(event);
    //    else isNumber($("#prix"),event);
    });
    $("#eau").keydown(function (event) {
        calculecarat();
        if(event.keyCode == 13)ajout_ligne(event);
     //   else isNumber($("#prix"),event);
    });

    $("#remise").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event);
        else isRemise($("#remise"),event);
    });

    $('#quantite').keydown(function (e){
        calculecarat();
        ajout_ligne(e);
    });

    $('#carat').keydown(function (e){
        calculecarat();
        if(event.keyCode == 13)ajout_ligne(event);
    //    else isNumber($("#carat"),event);
    });

    $('#cioj').keydown(function (e){
        calculecarat();
        if(event.keyCode == 13)ajout_ligne(event);
    //    else isNumber($("#cioj"),event);
    });

    function calculecarat(){
        //alert($("#database").val());
        if($("#database").val()==1) {
            var cag = 0;
            var mag = 0;
            var eau = 0;
            var divise = 0;
            var x = 0;
            var y = 0;
            var carat = 0;
            var cioj = 0;
            var purity = 0;
            var pureway = 0;
            var oz = 0;
            var qte = 0;
            if ($("#quantite").val().replace(/ /g,"") != "") qte = parseFloat($("#quantite").val().replace(/ /g,""));
            if ($_GET("type") == "Achat" || $_GET("type") == "AchatC") {
                if ($("#cag").val() != "") cag = parseFloat($("#cag").val());
                if ($("#mag").val() != "") mag = parseFloat($("#mag").val());
                if ($("#eau").val() != "") eau = parseFloat($("#eau").val());
                if (eau != 0) divise = qte / eau;
                x = divise - 10.51;
                y = x * 52.838;
                if (divise != 0) carat = y / divise;
                $("#divise").val(Math.round(divise * 100) / 100);
                $("#carat").val(Math.round(carat * 100) / 100);
                $("#prix").val(cag + mag);
            }
            if ($_GET("type") == "Vente" || $_GET("type") == "VenteC") {
                if ($("#carat").val() != "") carat = parseFloat($("#carat").val());
                if ($("#cioj").val() != "") cioj = parseFloat($("#cioj").val());
                purity = carat / 24;
                pureway = purity * qte;
                oz = Math.round((pureway / 31.1034768) * 100) / 100;
                $("#purity").val(purity);
                $("#oz").val(oz);
                $("#pureway").val(pureway);
            }
        }
    }

    if(($_GET("type")=="Vente" || $_GET("type")=="VenteT" || $_GET("type")=="VenteC") && $("#flagModifClient").val()==0)
        $("#nomClientDivers").hide("slow");
    else
        $("#nomClientDivers").show("slow");

    function clientSaisie() {
        $.ajax({
            url: "traitement/Facturation.php?acte=client",
            method: 'GET',
            async: false,
            dataType: 'json',
            data: 'CT_Intitule=' + $('.comboclient :input').val(),
            success: function (data) {
                if(data.valeur!=null) {
                    ajout_entete();
                }
            }
        });
    }

    function ajout_entete(){
        if(!$("#souche").is(':disabled'))
        if(($_GET("type")=="Ticket") || ($("#do_statut").val()==0 || $("#do_statut").val()==1 || $("#do_statut").val()==2)){
            if($('.comboclient :input').val()!=""){
                if($('#dateentete').val()!=""){
                    var type = $_GET("type");
                    var dataTrans = "";
                    if(type=="AchatPreparationCommande") {
                        var select =0;
                        if ($('input#transDoc').is(':checked'))
                            select = 1;
                            dataTrans = "&DO_Coord03="+select;
                    }
                    var DO_Coord04 = "";
                    if($("#nomClient").val()!=null) DO_Coord04 = $("#nomClient").val();
                    $.ajax({
                    url: "traitement/Facturation.php?acte=ajout_entete&type_fac="+$_GET("type")+"&do_type="+do_type+"&do_piece="+$("#n_doc").val()+"&souche="+$("#souche").val()+"&de_no="+$("#depot").val()+"&date="+returnDate($("#dateentete").val())+"&client="+$("#client").val()+"&reference="+$("#ref").val()+"&co_no="+$("#collaborateur").val()+"&cat_compta="+$("#cat_compta").val()+"&cat_tarif="+$("#cat_tarif").val()+"&ca_no="+$("#caisse").val()+"&affaire="+$("#affaire").val()+"&do_statut="+$("#do_statut").val()+"&userName="+$("#userName").html()+"&DO_Coord04="+DO_Coord04+"&machineName="+$("#machineName").html()+dataTrans,
                    method : 'GET',
                    async : false,
                    dataType : 'json',
                    success : function(data) {
                        $("#n_doc").val(data.entete);
                        $("#EntetecbMarq").val(data.cbMarq);
                        bloque_entete();
                        $(".comboclient :input").prop('disabled', true);
                        $(".comboreference :input").prop('disabled', false);
                        $("#reference").prop('disabled', true);
                        $("#prix").prop('disabled', false);
                        if(protectionprix==1 || protectionprix==2)
                            $("#prix").prop('disabled', true);
                        if($("#database").val()=="1" && ($_GET("type")=="Achat" || $_GET("type")=="AchatC")) {
                            $("#prix").prop('disabled', true);
                            $("#cag").prop('disabled', false);
                            $("#mag").prop('disabled', false);
                            $("#eau").prop('disabled', false);
                        }
                        if($("#database").val()=="1" && ($_GET("type")=="Vente" || $_GET("type")=="VenteC")) {
                            $("#prix").prop('disabled', true);
                            $("#cioj").prop('disabled', false);
                            $("#carat").prop('disabled', false);
                            $("#DO_Cours").val(data.DO_Cours);
                        }

                        $("#remise").prop('disabled', false);
                        $("#quantite").prop('disabled', false);
                        $(".comboreference :input").focus();
                    },
                    error : function(resultat, statut, erreur){
                        alert(resultat.responseText);
                    }
                  });
                } else
                    alert("Saisissez une date !");

            } else
                alert("Saisissez un tiers !");

            }else {
          alert("Choississez un statut valide !");
      }

  }

    $('.comboclient :input').keydown(function (e){
        if(e.keyCode == 13){
            clientSaisie();
        }
    });

    $('.comboclient :input').focusout(function (){
        var typefic = $_GET("type");
        var codeSaisie = $(this).val();

        var title = "Création client";
        var titleDemande = "Voulez vous créer un nouveau client ?";
        var ctype="Cl.";
        if(typefic=="Achat" || typefic=="PreparationCommande" || typefic=="AchatPreparationCommande"){
            title = "Création fournisseur";
            var titleDemande = "Voulez vous créer un nouveau fournisseur ?";
            ctype="Fr.";
        }
        $.ajax({
            url: 'indexServeur.php?page=selectDefautCompte&ctype=' + ctype,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $("#CG_NumPrinc").val(data[0].T_Val01T_Compte)
            }
        });

        $.ajax({
            url: 'indexServeur.php?page=getClientByCTNum&CT_Num=' + $("#client").val(),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if(data[0].CO_No!=0)
                $("#collaborateur").val(data[0].CO_No);
                if($("#collaborateur").val()==null)
                    $("#collaborateur").val(0);
                $("#cat_compta").val(data[0].N_CatCompta);
                if(data[0].N_CatTarif!=1)
                $("#cat_tarif").val(data[0].N_CatTarif);
                if($("#cat_compta").val()==null)
                    $("#cat_compta").val($("#cat_compta option:first").val());
                if($("#cat_tarif").val()==null)
                    $("#cat_tarif").val($("#cat_tarif option:first").val());

                updateLibPied();
            }
        });

    });

    $('#ref').keydown(function (e){
        if(e.keyCode == 13){
            clientSaisie();
        }
    });

    $('#dateentete').keydown(function (e){
        if(e.keyCode == 13){
            clientSaisie();
        }
    });
    $('#nomClient').keydown(function (e){
        if(e.keyCode == 13){
            clientSaisie();
        }
    });

    $( ".comboreference :input" ).focusout(function() {
        var refsaisie = $(this).val();
        $.ajax({
           url: "indexServeur.php?page=getArticleByRef&AR_Ref="+$("#reference").val(),
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                if ($(".comboreference :input").val() != "") {
                    $("#designation").val(data[0].AR_Design);
                    valideReference($("#reference").val());
                } else {
                    if (refsaisie != "" && ($_GET("type")=="AchatPreparationCommande" || $_GET("type")=="PreparationCommande")) {
                        $("<div>Voulez vous créer un nouvel article ?</div>").dialog({
                            resizable: false,
                            height: "auto",
                            width: 200,
                            modal: true,
                            title: "Création article",
                            buttons: {
                                "Oui": {
                                    class: 'btn btn-primary',
                                    text: 'Oui',
                                    click: function () {
                                        $(this).dialog("close");
                                        $("#referenceAjout").val(refsaisie.replace(/[^a-z0-9\s]/gi, '').replace(/\s+/g, '').toUpperCase());
                                        $("#designationAjout").val(refsaisie);
                                        $("#formArticleFacture").dialog({
                                            resizable: false,
                                            height: "auto",
                                            width: 1000,
                                            modal: true,
                                            title: "Création article",
                                            buttons: {
                                                "Valider": function () {
                                                    if ($("#referenceAjout").val() != "" && $("#designationAjout").val() != "" && $("#pxAchat").val() != "" && $("#pxHT").val() != "") {
                                                        ajouterArticle($(this));
                                                    } else {
                                                        alert("Les champs reférence, désignation, prix d'achat et prix de vente doivent être renseigné");
                                                    }
                                                }
                                            }
                                        });
                                    }
                                },
                                "Non": {
                                    class: 'btn btn-primary',
                                    text: 'Valider',
                                    click: function () {
                                        $(this).dialog("close");
                                    }
                                }
                            }
                        });
                    }
                }
            }

        });
    });

    function entete_document(){
        if(!$("#souche").is(':disabled'))
        if((modifProtect==0 && visuProtect ==0))
           $.ajax({
                url: 'traitement/Facturation.php?acte=entete_document',
                method: 'GET',
                dataType: 'json',
                async:false,
                data : 'do_type='+do_type+'&do_domaine='+do_domaine+'&do_souche='+$("#souche").val()+'&type_fac='+$_GET("type"),
                success: function(data) {
                    $("#n_doc").val(data.DC_Piece);
                }
            });
    }
    entete_document();

    function ajouterClient(boite){
        $.ajax({
            url: 'traitement/Creation.php?acte=ajout_client',
            method: 'GET',
            dataType: 'json',
            data : $("#form-creationClient").serialize(),
            async : false,
            success: function(data) {
                alert("Le client "+data.CT_Num+" a bien été crée !");
                rafraichir_liste_client();
                $("#client").val(data.CT_Num);
                $(".comboclient :input").focus();
                $(".comboclient :input").val($(".client option:selected").text());
                $("#cat_tarif").focus();
                boite.dialog("close");
            },

            error : function(resultat, statut, erreur){
                alert(resultat.responseText);
            }
        });
    }

    function ajouterArticle(boite){
        $.ajax({
            url: 'traitement/Creation.php?acte=ajout_article',
            method: 'GET',
            dataType: 'json',
            data : $("#formArticle").serialize(),
            async : false,
            success: function(data) {
                alert("L'article "+data.AR_Ref+" a bien été crée !");
                $("#pxHT").val("");
                $("#pxAchat").val("");
                $("#pxMin").val("");
                $("#pxMax").val("");
                $("#conditionnement").val(0);

                rafraichir_liste_article();
                boite.dialog("close");
                $("#reference").val(data.AR_Ref);
                $(".comboreference :input").focus();
                $(".comboreference :input").val($("#reference option:selected").text());
                $("#quantite").focus();
            },

            error : function(resultat, statut, erreur){
                alert(resultat.responseText);
            }
        });
    }

    $( "#ref" ).focusout(function() {
        $.ajax({
            url: "traitement/Facturation.php?acte=ajout_reference&reference="+$("#ref").val()+"&cbMarq="+$("#EntetecbMarq").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {

            }
        });
    });

    $( "#famille" ).change(function() {
        $.ajax({
            url: "indexServeur.php?page=getNextArticleByFam&codeFam="+$( "#famille" ).val(),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function(data) {
                $("#referenceAjout").val(data[0].AR_Ref);
            }
        });
    });


    $( "#do_statut" ).change(function() {
        $.ajax({
           url: "traitement/Facturation.php?acte=ajout_statut&cbMarq="+$("#EntetecbMarq").val()+"do_statut="+$("#do_statut").val(),
           method: 'GET',
           dataType: 'json',
            success: function(data) {

            }
        });
    });


    $( "#collaborateur" ).change(function() {
        $.ajax({
            url: "traitement/Facturation.php?acte=maj_collaborateur&collab="+$("#collaborateur").val()+"&entete="+$("#n_doc").val()+"&cbMarq="+$("#EntetecbMarq").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {

            }
        });
    });

    $( "#DO_Cours" ).focusout(function() {
        $.ajax({
            url: "traitement/Facturation.php?acte=maj_doCours&DO_Cours="+$("#DO_Cours").val()+"&cbMarq="+$("#EntetecbMarq").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {

            }
        });
    });

    $( "#affaire" ).change(function() {
        $.ajax({
           url: "traitement/Facturation.php?acte=maj_affaire&affaire="+$("#affaire").val()+"&entete="+$("#n_doc").val()+"&cbMarq="+$("#EntetecbMarq").val(),
           method: 'GET',
           dataType: 'json',
            success: function(data) {

            }
        });
    });

    function valideReference(reference){
            if($_GET("type")=="Achat" || $_GET("type")=="PreparationCommande" || $_GET("type")=="AchatPreparationCommande")
                valideReferenceAchat(reference);
            else
                valideReferenceVente(reference);
    }


    function valideReferenceVente(reference){
        $.ajax({
            url: "indexServeur.php?page=getPrixClient&AR_Ref="+reference+"&N_CatTarif="+$("#cat_tarif").val()+"&N_CatCompta="+$("#cat_compta").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                    if(modification)
                        $( ".comboreference :input").val(reference);
                    else
                        $( ".comboreference :input").val(reference+" - "+data[0].AR_Design);
                    pmin = Math.round(data[0].Prix_Min*100)/100;
                    pmax = Math.round(data[0].Prix_Max*100)/100;
                    qtegros= Math.round(data[0].Qte_Gros*100)/100;
                    var tmp=pmax;
                    if(pmin>pmax){
                        pmax=pmin;
                        pmin=tmp;
                    }
                    alimente_qteStock(reference);
                    if(!modification)
                        $("#prix").val(Math.round((data[0].Prix)*100)/100);
                    $("#taxe1").val(data[0].taxe1);
                    $("#taxe2").val(data[0].taxe2);
                    $("#taxe3").val(data[0].taxe3);
                }

          });
    }


    function valideReferenceAchat(reference){
        $.ajax({
            url: "indexServeur.php?page=getPrixClientAch&CT_Num="+$("#client").val()+"&AR_Ref="+reference+"&N_CatTarif="+$("#cat_tarif").val()+"&N_CatCompta="+$("#cat_compta").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if(modification)$( ".comboreference :input").val(reference);
                else $( ".comboreference :input").val(reference+" - "+data[0].AR_Design);
                pmin = Math.round(data[0].Prix_Min*100)/100;
                pmax = Math.round(data[0].Prix_Max*100)/100;
                var tmp=pmax;
                if(pmin>pmax){
                    pmax=pmin;
                    pmin=tmp;
                }
                alimente_qteStock(reference);
                if(!modification) $("#prix").val(Math.round((data[0].AR_PrixAch)*100)/100);
                $("#taxe1").val(data[0].taxe1);
                $("#taxe2").val(data[0].taxe2);
                $("#taxe3").val(data[0].taxe3);
            }
          });
    }



    function rafraichir_liste_article(){
        $.ajax({
            url: "traitement/Transfert.php?acte=liste_article_source&depot="+$("#depot").val()+"&type="+$_GET("type"),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function(data) {
                $(".comboreference :input").val("");
                $("#designation").val("");
                $("#quantite").val("");
                $("#prix").val("");
                $("#remise").val("");
                $("#quantite_stock").val("");
                $("#reference").empty();
                $.each(data, function(index, item) {
                    if(item.AR_Sommeil==0)
                    $("#reference").append(new Option(item.AR_Ref+" - "+item.AR_Design,item.AR_Ref));
                });
            }
        });
    }

    function rafraichir_liste_client(){
        $.ajax({
            url: "traitement/Facturation.php?acte=rafraichir_listeClient&typefac="+$_GET("type"),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function(data) {
                $(".formCreationClient :input").each(function(){
                    $(this).val("");
                });
                $("#client").empty();
                $.each(data, function(index, item) {
                    $("#client").append(new Option(item.CT_Intitule,item.CT_Num));
                });
            }
        });
    }

    function doImprim() {
        $.ajax({
            url: "traitement/Facturation.php?acte=doImprim"+"&cbMarq="+$("#EntetecbMarq").val(),
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
            }
        });
    }

    function choixFormat(){
        doImprim();
        if(societe == "CMI CAMEROUN SARL" && $_GET("type")!="Achat"){
            $("<div></div>").dialog({
                resizable: false,
                height: "auto",
                width: "400",
                modal: true,
                title: "Choix du format",
                buttons: {
                    "A4 CLIENT SOCIETE" : {
                        class: 'btn btn-primary',
                        text: 'A4 CLIENT SOCIETE',
                        click: function () {
                            window.open("export/exportSSRS.php?cbMarq=" + $("#EntetecbMarq").val() + "&format=A4&societe=CMI&type=CLIENT_SOCIETE", '_blank');
                            $("#valideRegltForm").submit();
                        }
                    },
                    "A4 CLIENT DIVERS" : {
                        class: 'btn btn-primary',
                        text: 'A4 CLIENT DIVERS',
                        click: function () {
                            window.open("export/exportSSRS.php?cbMarq=" + $("#EntetecbMarq").val() + "&format=A4&societe=CMI&type=CLIENT_DIVERS", '_blank');
                            $("#valideRegltForm").submit();
                        }
                    },
                    "A4 PROFORMA" : {
                        class: 'btn btn-primary',
                        text: 'A4 PROFORMA',
                        click: function () {
                            window.open("export/exportSSRS.php?cbMarq=" + $("#EntetecbMarq").val() + "&format=A4&societe=CMI&type=PROFORMA", '_blank');
                            $("#valideRegltForm").submit();
                        }
                    },
                    "A5 CLIENT SOCIETE" : {
                        class: 'btn btn-primary',
                        text: 'A5 CLIENT SOCIETE',
                        click: function () {
                            window.open("export/exportSSRS.php?cbMarq=" + $("#EntetecbMarq").val() + "&format=A5&societe=CMI&type=CLIENT_SOCIETE", '_blank');
                            $("#valideRegltForm").submit();
                        }
                    },
                    "A5 CLIENT DIVERS" : {
                        class: 'btn btn-primary',
                        text: 'A5 CLIENT DIVERS',
                        click: function () {
                            window.open("export/exportSSRS.php?cbMarq=" + $("#EntetecbMarq").val() + "&format=A5&societe=CMI&type=CLIENT_DIVERS", '_blank');
                            $("#valideRegltForm").submit();
                        }
                    },
                    "A5 PROFORMA" : {
                        class: 'btn btn-primary',
                        text: 'A5 PROFORMA',
                        click: function () {
                            window.open("export/exportSSRS.php?cbMarq=" + $("#EntetecbMarq").val() + "&format=A5&societe=CMI&type=CLIENT_SOCIETE", '_blank');
                            $("#valideRegltForm").submit();
                        }
                    }
                }
            });
        }else{
            var words = societe.split(' ');
            if(societe=="BOUM CONSTRUCTION SARL"){
                $("<div></div>").dialog({
                    resizable: false,
                    height: "auto",
                    width: "100",
                    modal: true,
                    title: "Choix du format",
                    buttons: {
                        "A4": {
                            class: 'btn btn-primary',
                            text: 'A4',
                            click: function () {
                                if (societe != "CMI CAMEROUN SARL")
                                    window.open("export/exportSSRS.php?facture=0&cbMarq=" + $("#EntetecbMarq").val() + "&format=A4&societe=" + words[0] + "&type=A4", '_blank');
                                else
                                    window.open(impressionFacture + "&format=A4", '_blank');
                                $("#valideRegltForm").submit();
                            }
                        },
                        "A5": {
                            class: 'btn btn-primary',
                            text: 'A5',
                            click: function() {
                                if (societe != "CMI CAMEROUN SARL")
                                    window.open("export/exportSSRS.php?facture=0&cbMarq=" + $("#EntetecbMarq").val() + "&format=A5&societe=" + words[0] + "&type=A5", '_blank');
                                else
                                    window.open(impressionFacture + "&format=A5", '_blank');
                                $("#valideRegltForm").submit();
                            }
                        },
                        "A4 Facture": {
                            class: 'btn btn-primary',
                            text: 'A4 Facture',
                            click: function () {
                                if (societe != "CMI CAMEROUN SARL")
                                    window.open("export/exportSSRS.php?facture=1&cbMarq=" + $("#EntetecbMarq").val() + "&format=A4&societe=" + words[0] + "&type=A4", '_blank');
                                else
                                    window.open(impressionFacture + "&format=A4", '_blank');
                                $("#valideRegltForm").submit();
                            }
                        },
                        "A5 Facture": {
                            class: 'btn btn-primary',
                            text: 'A5 Facture',
                            click: function() {
                                if (societe != "CMI CAMEROUN SARL")
                                    window.open("export/exportSSRS.php?facture=1&cbMarq=" + $("#EntetecbMarq").val() + "&format=A5&societe=" + words[0] + "&type=A5", '_blank');
                                else
                                    window.open(impressionFacture + "&format=A5", '_blank');
                                $("#valideRegltForm").submit();
                            }
                        }
                    }
                });

            }else {
                $("<div></div>").dialog({
                    resizable: false,
                    height: "auto",
                    width: "100",
                    modal: true,
                    title: "Choix du format",
                    buttons: {
                        "A4": {
                            class: 'btn btn-primary',
                            text: 'A4',
                            click: function () {
                                if (societe != "CMI CAMEROUN SARL")
                                    window.open("export/exportSSRS.php?cbMarq=" + $("#EntetecbMarq").val() + "&format=A4&societe=" + words[0] + "&type=A4", '_blank');
                                else
                                    window.open(impressionFacture + "&format=A4", '_blank');
                                $("#valideRegltForm").submit();
                            }
                        },
                        "A5": {
                            class: 'btn btn-primary',
                            text: 'A5',
                            click: function () {
                                if (societe != "CMI CAMEROUN SARL")
                                    window.open("export/exportSSRS.php?cbMarq=" + $("#EntetecbMarq").val() + "&format=A5&societe=" + words[0] + "&type=A5", '_blank');
                                else
                                    window.open(impressionFacture + "&format=A5", '_blank');
                                $("#valideRegltForm").submit();
                            }
                        }
                    }
                });
            }
        }
    }

    var negatif = true;
    if(($_GET("type")=="Vente" || $_GET("type")=="BonLivraison" || $_GET("type")=="VenteC" || $_GET("type")=="Achat" || $_GET("type")=="AchatC")&& $("#qte_negative").val()!=0)
        negatif = false;

    $("#prix").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '',
        allowPlus: true,
        allowMinus: negatif
    });

    $("#mtt_avance").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '',
        allowPlus: true,
        allowMinus: negatif
    });

    $("#quantite").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: negatif
    });

    $("#quantite_stock").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: true
    });


    $('#imprimer').click(function(){
                fichierTraitement();
            if(($_GET("type")=="Devis" || $_GET("type")=="BonLivraison" || $_GET("type")=="Avoir")){
                choixFormat();
            } else{
                if((visuProtect !=1) || ($("#PROT_Reglement").val() !=2)) {
                    if(($("#reste_a_payer").val()!=0 || (modifProtect== 0 && visuProtect ==0 )))
                        valider(true);
                    else
                        choixFormat();
                }
                else
                    choixFormat();
            }

    });

    $('#valider').click(function(){
        if(($_GET("type")=="Devis" || $_GET("type")=="Avoir" || $_GET("type")=="BonLivraison"))
            window.location.replace(listeFacture);
        else
            valider(true);
    });

    $("#cat_tarif").change(function(){
        if($(".comboreference :input").val()!="")
            valideReference($("#reference").val());
    });

    $("#cat_compta").change(function(){
        if($(".comboreference :input").val()!="")
            valideReference($("#reference").val());
        updateLibPied();
        majCatCompta();
    });

    function returnDate(str){
        return "20"+str.substring(4,6)+"-"+str.substring(2,4)+"-"+str.substring(0,2);
    }
    function returnDateRglt(str){
        return "20"+str.substring(4,6)+"-"+str.substring(0,2)+"-"+str.substring(2,4);
    }
    function valider(imprime){
            $("#valideRegle").val(1);
        reste_a_payer();
        if($_GET("type")=="Achat"){
            $('#comptant').prop('checked', false);
            $('#credit').prop('checked', true);
            $('#mtt_avance').attr("readonly", false);
            $('#mtt_avance').val(0);
        }
        else {
            $('#comptant').prop('checked', true);
            $('#credit').prop('checked', false);
            $('#mtt_avance').attr("readonly", true);
            reste_a_payer();
        }

        getdateecheance();

        $("#libelle_rglt").val(("Rglt "+$("#n_doc").val()+"_"+$("#ref").val()).substr(0,34));
        $(".valideReglement").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            async: false,
            title : "Mode de règlement",
            buttons: {
                "Valider": {
                    class: 'btn btn-primary',
                    text: 'Valider',
                    click: function () {
                        if ($("#date_rglt").val() != "" && $("#date_ech").val() != "") {
                            var valideButton = $(this);
                            var totalttc = $("#reste_a_payer").val();
                            var montant_avance = $("#mtt_avance").val();
                            $.ajax({
                                url: "indexServeur.php?page=ResteARegler&DO_Piece=" + $("#n_doc").val() + "&DO_Domaine=" + do_domaine + "&DO_Type=" + do_type + "&avance=" + (montant_avance).replace(/ /g, ""),
                                method: 'GET',
                                async: false,
                                dataType: 'json',
                                success: function (data) {
                                    if (totalttc != 0)
                                        if (data[0].VAL != 0) {
                                            $("#valideRegltImprime").val(imprime);
                                            $("#cbMarqEntete").val($("#EntetecbMarq").val());
                                            valideButton.dialog("close");
                                            if (imprime)
                                                choixFormat();
                                            else
                                                $("#valideRegltForm").submit();
                                        } else {
                                            alert("L'avance ne doit pas dépassé " + parseFloat(totalttc).toLocaleString());
                                        }
                                }
                            });
                        }else {
                            alert("Veuillez saisir une date d'échéance et une date de règlement");
                        }
                    }
                },
                "Annuler": {
                    class: 'btn btn-primary',
                    text: 'Annuler',
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            }
        });
    }

    function getdateecheance(){
        $.ajax({
            url: "indexServeur.php?page=getDateEcheance&CT_Num="+$("#client").val()+"&Date="+returnDate($("#dateentete").val()),
            method: 'GET',
            async: false,
            dataType: 'json',
            success: function(data) {
                $("#date_ech").val($.datepicker.formatDate('ddmmy', new Date(data[0].date_ech)));
//                $("#date_ech").val($("#dateentete").val());
            },
            error: function (data){
                $("#date_ech").val($("#dateentete").val());
            }
        });

    }

    function getDateecheanceSelect(){
        $.ajax({
            url: "indexServeur.php?page=getDateEcheanceSelect&N_Reglement="+$("#mode_reglement_val").val()+"&MR_No="+$("#modele_reglement_val").val()+"&Date="+returnDate($("#dateentete").val()),
            method: 'GET',
            async: false,
            dataType: 'json',
            success: function(data) {
                $("#date_ech").val($.datepicker.formatDate('ddmmy', new Date(data[0].date_ech)));
            },
            error: function (data){
                $("#date_ech").val($("#dateentete").val());
            }
        });
    }

    $("#modele_reglement_val").change(function(){
        getDateecheanceSelect();
    });

    function returnDateReverse(str){
        return str.substring(8,10)+str.substring(5,7)+str.substring(2,4);
    }
    function typeArticle(ar_ref,cattarif,catcompta,pu,ttc,conteneur,qte){
        var page = "getPrixClientHT";
        var type=0;
        var fournisseur =0;
        if($_GET("type")=="Achat") fournisseur=1;
        $.ajax({
            url: "indexServeur.php?page="+page+"&AR_Ref="+ar_ref+"&N_CatTarif="+cattarif+"&Prix=0&N_CatCompta="+catcompta+"&remise=0&fournisseur="+fournisseur+"&qte="+qte,
            method: 'GET',
            async: 'GET',
            async : false,
            dataType: 'json',
            success: function(data) {
                type= data[0].AR_PrixTTC;
                if(type==1) conteneur.val(ttc);
                else conteneur.val(pu);
            }
        });
    }

    function tr_clickArticle() {
        $("tr[id^='article']").each(function () {
            $(this).unbind();
            var cbMarq = $(this).find("#cbMarq").html();
            var DL_Qte = $(this).find("#DL_Qte").html();
            var AR_Ref = $(this).find("#AR_Ref").html();
            var DL_Design = $(this).find("#DL_Design").html();
            var DL_Remise = $(this).find("#DL_Remise").html();
            var DL_PrixUnitaire = $(this).find("#DL_PrixUnitaire").html();
            var DL_CMUP = $(this).find("#DL_CMUP").html();
            $(this).dblclick(function () {
                modifarticle($(this));
            });

            $(this).find("td[id^='modif_']").click(function () {
                modifarticle($(this).parent('tr'));
            });

            $(this).find("#suppr_"+cbMarq).click(function(){
                suppression(cbMarq,AR_Ref,DL_Qte,DL_CMUP);
            });

            $(this).find("#AR_Ref").click(function(){
                fiche_article(AR_Ref);
            });

        });
    }
    tr_clickArticle();

    function fiche_article(AR_Ref){
        window.open('indexMVC.php?module=3&action=1&window=1&AR_Ref='+AR_Ref, "Fiche Article", "height=800,width=800");
//        window.open('indexMVC.php?module=3&action=1&AR_Ref='+AR_Ref, '_blank');
/*        $.ajax({
            url: 'indexServeur.php',
            method: 'GET',
            dataType: 'html',
            data : 'page=ficheArticle&AR_Ref='+AR_Ref,
            async : false,
            success: function(data) {
                $("#formArticleFactureBis").html(data);
                $("#formArticleFactureBis").dialog({
                    resizable: false,
                    height: "auto",
                    width: 1000,
                    modal: true,
                    title : "Article "+AR_Ref,
                    buttons: {
                        "Valider": {
                            class: 'btn btn-primary',
                            text: 'Valider',
                            click: function() {
                                $( this ).dialog( "close" );
                            }
                        }
                    }
                });
            }
            });
            */
    }

    function getArticleAndDepotUser(AR_Ref) {
        $.ajax({
            url: 'indexServeur.php',
            method: 'GET',
            dataType: 'json',
            data: 'page=getArticleAndDepotUser&AR_Ref=' + AR_Ref+'&protNo='+$("#prot_no").val(),
            async: false,
            success: function (data) {
                $("#table_depot_article").html("");
                $(data).each(function() {
                    $("#table_depot_article").append("<tr><td>"+this.DE_Intitule+"</td><td>"+Math.round(this.AS_QteSto,2)+"</td><td>"+Math.round(this.AS_MontSto,2)+"</td></tr>");
                });
            }
        });
    }

    function modifarticle(elem){
        if (visuProtect  != 1) {
            var cbMarq = elem.find("#cbMarq").html();
            var DL_Qte = elem.find("#DL_Qte").html();
            DL_Qte = DL_Qte.replace(",",".");
            DL_Qte = DL_Qte.replace(/ /g,"");
            var AR_Ref = elem.find("#AR_Ref").html();
            var DL_Design = elem.find("#DL_Design").html();
            var DL_Remise = elem.find("#DL_Remise").html();
            var DL_MontantTTC = elem.find("#DL_MontantTTC").html();
            DL_MontantTTC = DL_MontantTTC.replace(",",".");
            DL_MontantTTC = DL_MontantTTC.replace(/ /g,"");
            var DL_PrixUnitaire = elem.find("#DL_PrixUnitaire").html();
            DL_PrixUnitaire = DL_PrixUnitaire.replace(",",".");
            DL_PrixUnitaire = DL_PrixUnitaire.replace(/ /g,"");
            var DL_PUTTC = elem.find("#PUTTC").html();
            DL_PUTTC = DL_PUTTC.replace(",",".");
            DL_PUTTC = DL_PUTTC.replace(/ /g,"");
            var DL_CMUP = elem.find("#DL_CMUP").html();
            DL_CMUP = DL_CMUP.replace(",",".");
            DL_CMUP = DL_CMUP.replace(/ /g,"");
            var pu = Math.round(DL_PrixUnitaire * 100) / 100;
            var ttc = Math.round(DL_PUTTC * 100) / 100;
            if($("#database").val()=="1" && ($_GET("type")=="Achat" || $_GET("type")=="AchatC")){
                var cag = elem.find("#cag").html();
                var mag = elem.find("#mag").html();
                var carat = elem.find("#carat").html();
                var eau= elem.find("#eau").html();
                var divise= elem.find("#divise").html();
                $("#eau").val(eau);
                $("#divise").val(divise);
                $("#cag").val(cag);
                $("#mag").val(mag);
                $("#carat").val(carat);
            }
            if($("#database").val()=="1" && ($_GET("type")=="Vente" || $_GET("type")=="VenteC")){
                var purity = elem.find("#purity").html();
                var pureway = elem.find("#pureway").html();
                var carat = elem.find("#carat").html();
                var oz= elem.find("#oz").html();
                var divise= elem.find("#divise").html();
                var cioj= elem.find("#cioj").html();
                $("#purity").val(purity);
                $("#pureway").val(pureway);
                $("#oz").val(oz);
                $("#cioj").val(cioj);
                $("#carat").val(carat);
            }


            typeArticle(AR_Ref, $("#cat_tarif").val(), $("#cat_compta").val(), pu, ttc, $("#prix"), DL_Qte);
            $('#reference').val(DL_Design);
            $('.comboreference :input').val(AR_Ref);
            $('#designation').val(DL_Design);
            $('#remise').val(DL_Remise);
            $('.comboreference :input').val(AR_Ref);
            $('#quantite').val(DL_Qte);
            $('#ADL_Qte').val(DL_Qte);
            $('#APrix').val(pu);
            $('#cbMarq').val(cbMarq);
            alimente_qteStock(AR_Ref);
            $('.comboreference :input').prop("disabled", true);
            modification = true;
        }
    }
    function optionLigneA(){
        $("td[id^='lignea_']").each(function(){
            $(this).unbind();
        });

        $("td[id^='lignea_']").click(function() {
            EC_MontantImpute = $(this).parent('tr').find("#DL_MontantHT").html();
            EC_QteImpute = $(this).parent('tr').find("#DL_Qte").html();
            cbMarqLigne = $(this).parent('tr').find("#cbMarq").html();
            formAnalytique(cbMarqLigne);
            $("#formAnalytique").dialog({
                resizable: false,
                height: "auto",
                width: 1000,
                modal: true,
                title : "Ligne",
                buttons: {
                    "Valider": {
                        class: 'btn btn-primary',
                        text: 'Valider',
                        click: function() {
                            if(EC_MontantImpute==totalMontantA && EC_QteImpute==totalQteA){
                                $( this ).dialog( "close" );
                                getSaisieComtpable(0);
                            }
                            else
                                alert("La saisie n'est pas équilibrée !");
                        }
                    }
                }
            });
        });
    }
    optionLigneA();

    function formAnalytique(valcbMarq){
            $.ajax({
                url: 'traitement/Facturation.php?acte=ligneAnal',
                method: 'GET',
                dataType: 'html',
                data : 'cbMarq='+valcbMarq+'&N_Analytique='+$("#N_Analytique").val(),
                async : false,
                success: function(data) {
                    $("#table_anal > tbody").html(data);
                    setDblClickAnal();
                    calculEnteteJournalAnal();
                    valideplananal();
                }
            });
        }

    function valideplananal(){
        $("#CA_Num").empty();
        $.ajax({
            url: 'indexServeur.php?page=getPlanAnalytiqueHorsTotal',
            method: 'GET',
            dataType: 'json',
            data: 'N_Analytique=' + $("#N_Analytique").val() + '&type=0',
            async: false,
            success: function (data) {
                $.each(data, function(index, item) {
                    $("#CA_Num").append(new Option(item.CA_Num+" - "+item.CA_Intitule,item.CA_Num));
                });
                $("#CA_Num").val($("#affaire").val());
            }
        });
    }

    var N_AnalPrev ="";
    $("#N_Analytique").focusin(function() {
        N_AnalPrev = $(this).val();
    });

        $("#N_Analytique").change(function(){
        if(totalQteA==0 || (EC_MontantImpute==totalMontantA && EC_QteImpute==totalQteA)) {
            formAnalytique(cbMarqLigne);
        } else{
            $("#N_Analytique").val(N_AnalPrev);
            alert("Veuillez équilibrer l'écriture !");
        }
    });

    function ajoutLigneAnalytique(){
        var val=true;
        if($("#CA_Num").val()!="" && ($("#A_Qte").val()!="" || $("#A_Montant").val()!="")){

        }else val=false;
        if(val){
            var ca_num = $("#CA_Num").val(),A_Qte = $("#A_Qte").val(), A_Montant = $("#A_Montant").val();
            $.ajax({
                url: 'traitement/Facturation.php?acte=ajout_ligneA',
                method: 'GET',
                dataType: 'html',
                data : 'CA_Num='+$("#CA_Num").val()+'&EA_Quantite='+A_Qte+'&EA_Montant='+A_Montant+'&cbMarq='+cbMarqLigne+"&N_Analytique="+$("#N_Analytique").val(),
                async : false,
                success: function(data) {
                    $("#table_anal > tbody").html(data);
                    setDblClickAnal ();
                    clearAnal();
                    calculEnteteJournalAnal();
                }
            });
        }
    }


    function clearAnal(){
        $("#A_Qte").val("");
        $("#A_Montant").val("");
    }

    function ajoutLigneOptionAnalytique(){
        $("#A_Qte").keyup(function (event) {
            $("#A_Montant").val(Math.round(EC_MontantImpute*$(this).val()/EC_QteImpute*100)/100);
            if(event.keyCode == 13)
                ajoutLigneAnalytique();
        });
        $("#A_Montant").keyup(function (event) {
            $("#A_Qte").val(Math.round($(this).val()*EC_QteImpute/EC_MontantImpute*100)/100);
            if(event.keyCode == 13)
                ajoutLigneAnalytique();
        });

    }
    ajoutLigneOptionAnalytique();

    function actionModifAnal(emodeler){
        $("#A_Montant").keyup(function (event) {
            $("#A_Qte").val(Math.round($(this).val()*EC_QteImpute/EC_MontantImpute*100)/100);
            if(event.keyCode == 13)
                valideLigneAnal(emodeler);
        });
        $("#A_Qte").keyup(function (event) {
            $("#A_Montant").val(Math.round(EC_MontantImpute*$(this).val()/EC_QteImpute*100)/100);
            if(event.keyCode == 13)
                valideLigneAnal(emodeler);
        });

    }

    function valideLigneAnal(emodeler){
        //cbMarqLigne = emodeler.find("#tabcbMarq").html();
        $.ajax({
            url: 'traitement/Facturation.php?acte=modif_ligneA',
            method: 'GET',
            dataType: 'html',
            data : 'cbMarq='+emodeler.find("#tabcbMarq").html()+'&CA_Num='+$("#CA_Num").val()+'&EA_Quantite='+$("#A_Qte").val()+'&EA_Montant='+$("#A_Montant").val()+'&cbMarqLigne='+cbMarqLigne+"&N_Analytique="+$("#N_Analytique").val(),
            async : false,
            success: function(data) {
                emodeler.find("#tabCA_Num").html($("#CA_Num option:selected").text());
                emodeler.find("#tabCA_NumVal").html($("#CA_Num option:selected").val());
                emodeler.find("#tabA_Montant").html($("#A_Montant").val());
                emodeler.find("#tabA_Qte").html($("#A_Qte").val());
                calculEnteteJournalAnal();
                clearAnal();
                enleveActionAnal();
                setDblClickAnal();
                ajoutLigneOptionAnalytique();
            }
        });
    }


    function enleveActionAnal (){
        $("#A_Montant").unbind();
        $("#A_Qte").unbind();
    }
    function setDblClickAnal (){
        $("td[id^='modif_anal_']").each(function(){
            $(this).click(function() {
                var emodeler = $(this).parent();
                $(this).unbind();
                enleveActionAnal();
                $("#CA_Num").val(emodeler.find("#tabCA_NumVal").html());
                $("#A_Qte").val(emodeler.find("#tabA_Qte").html());
                $("#A_Montant").val(emodeler.find("#tabA_Montant").html());
                setDblClickAnal();
                actionModifAnal(emodeler);
            });
        });

        $("td[id^='suppr_anal_']").each(function(){
            $(this).click(function() {
                var emodeler = $(this).parent();
                var cbMarq = emodeler.find("#tabcbMarq").html();
                $.ajax({
                    url: 'traitement/Facturation.php?acte=suppr_ligneA',
                    method: 'GET',
                    dataType: 'html',
                    data : 'cbMarq='+cbMarq,
                    async : false,
                    success: function(data) {
                        emodeler.remove();
                        calculEnteteJournalAnal();
                    }
                });
            });
        });
    }
    setDblClickAnal();


    function calculEnteteJournalAnal(){
        var totalQte=0,totalMontant=0;
        $("#table_anal > tbody tr[id^='emodeler_anal_']").each(function() {
            totalQte = totalQte + Math.round($(this).find("#tabA_Qte").html()*100,0)/100;
            totalMontant = totalMontant + Math.round($(this).find("#tabA_Montant").html()*100,0)/100;
        });
        totalMontantA=totalMontant;
        totalQteA=totalQte;
        montantSolde = Math.round((EC_MontantImpute-totalMontant)*100)/100;
        qteSolde = Math.round((EC_QteImpute-totalQte)*100)/100;
        $("#montant_imputer").html(EC_MontantImpute);
        $("#qte_imputer").html(EC_QteImpute);
        $("#qte_timputer").html(totalQte);
        $("#montant_timputer").html(totalMontant);
        $("#montant_solde").html(montantSolde);
        $("#qte_solde").html(qteSolde);
        if(qteSolde>0){
            $("#A_Qte").val(qteSolde);
            $("#A_Montant").val(montantSolde);
            $("#CA_Num").val($("#affaire").val());
        }
    }
    calculEnteteJournalAnal();
    $("#CodeSelect").combobox();
    $("#CodeSelect").parent().find(".custom-combobox :input").attr("id", "codeSelection");

    $("#p_catcompta").change(function() {
        actualiseCode();
    });

    function actualiseCode(){
        var type = 0;//$("#p_catcompta").val().slice(-1);
        var fcp_type = 0;
        if(type=="A")
            fcp_type=1;
        var acp_champ = 0;//$("#p_catcompta").val().replace(type,"");
        $.ajax({
            url: "indexServeur.php?page=getCatComptaByArRef&ACP_Type="+fcp_type+"&ACP_Champ="+acp_champ+"&AR_Ref="+$("#reference_article").val(),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function(data) {
                $("#table_compteg >tbody").html("");
                $(data).each(function () {
                    var cg_num = " - ";
                    var cg_numa = " - ";
                    var taxe1 = " - ";
                    var taxe2 = " - ";
                    var taxe3 = " - ";
                    if(data[0].CG_Num!="")cg_num = data[0].CG_Num;
                    if(data[0].CG_NumA!="")cg_numa = data[0].CG_NumA;
                    if(data[0].Taxe1!="")taxe1 = data[0].Taxe1;
                    if(data[0].Taxe2!="")taxe2 = data[0].Taxe2;
                    if(data[0].Taxe3!="")taxe3 = data[0].Taxe3;
                    var donnee ="<tr><td id='libCompte'>Compte général</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+cg_num+"</td><td id='intituleCompte'>"+data[0].CG_Intitule+"</td><td id='valCompte'></td></tr>"+
                        "<tr><td id='libCompte'>Section analytique</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+cg_numa+"</td><td id='intituleCompte'>"+data[0].CG_IntituleA+"</td><td id='valCompte'></td></tr>"+
                        "<tr><td id='libCompte'>Code taxe 1</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+ taxe1 +"</td><td id='intituleCompte'>"+ data[0].TA_Intitule1 +"</td><td id='valCompte'>"+ (Math.round(data[0].TA_Taux1*100)/100) +"</td></tr>"+
                        "<tr><td id='libCompte'>Code taxe 2</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+ taxe2 +"</td><td id='intituleCompte'>"+ data[0].TA_Intitule2 +"</td><td id='valCompte'>"+ (Math.round(data[0].TA_Taux2*100)/100) +"</td></tr>"+
                        "<tr><td id='libCompte'>Code taxe 3</td><td id='codeCompte' style='text-decoration: underline;color:blue'>"+ taxe3 +"</td><td id='intituleCompte'>"+ data[0].TA_Intitule3 +"</td><td id='valCompte'>"+ (Math.round(data[0].TA_Taux3*100)/100) +"</td></tr>";
                    $("#table_compteg >tbody").append(donnee);
                });
                fonctionCodeCompte();
            }
        });
    }

    function getCompteg(emodeler,compte) {
        $.ajax({
            url: "indexServeur.php?page=getCompteg",
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                $("#CodeSelect").empty();
                $("#codeSelection").unbind("keydown");
                $.each(data, function (index, item) {
                    $("#CodeSelect").append(new Option("", ""));
                    $("#CodeSelect").append(new Option(item.CG_Num + " - " + item.CG_Intitule, item.CG_Num));
                });
                $("#codeSelection").keydown(function (event) {
                    if(event.keyCode == 13)
                        selection (emodeler,compte);
                });
            }
        });
    }

    function getTaxe(emodeler,compte) {
        $.ajax({
            url: "indexServeur.php?page=getF_Taxe",
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                $("#CodeSelect").empty();
                $("#CodeSelect").append(new Option("", ""));
                $("#codeSelection").unbind("keydown");
                $.each(data, function (index, item) {
                    $("#CodeSelect").append(new Option(item.TA_Code + " - " + item.TA_Intitule, item.TA_Code));
                });

                $("#codeSelection").keydown(function (event) {
                    if(event.keyCode == 13)
                        selection (emodeler,compte);
                });
            }
        });
    }

    function getTaxeByCode(emodeler,val) {
        $.ajax({
            url: "indexServeur.php?page=getTaxeByTACode&TA_Code="+val,
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                if(val=="") {
                    emodeler.parent().find("#intituleCompte").html("");
                    emodeler.parent().find("#valCompte").html("");
                }else{
                    emodeler.parent().find("#intituleCompte").html(data[0].TA_Intitule);
                    emodeler.parent().find("#valCompte").html(Math.round(data[0].TA_Taux * 100) / 100);
                }
            }
        });
    }

    function getComptegByCode(emodeler,val) {
        $.ajax({
            url: "indexServeur.php?page=getPlanComptableByCGNum&CG_Num="+val,
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                if(val=="") {
                    emodeler.parent().find("#intituleCompte").html("");
                }else{
                    emodeler.parent().find("#intituleCompte").html(data[0].CG_Intitule);
                }
            }
        });
    }

    function insertF_ArtCompta(acp_champ,acp_type,cg_num,cg_numa,ta_code1,ta_code2,ta_code3) {
        $.ajax({
            url: "indexServeur.php?page=insertF_ArtCompta",
            method: 'GET',
            dataType: 'html',
            async: false,
            data : 'AR_Ref='+$("#reference").val()+'&ACP_Champ='+acp_champ+'&ACP_Type='+acp_type+'&CG_Num='+cg_num+'&CG_NumA='+cg_numa+'&TA_Code1='+ta_code1+'&TA_Code2='+ta_code2+'&TA_Code3='+ta_code3,
            success: function (data) {
                if(data=="") {
                    alert("la modification a bien été pris en compte !");
                    $("#codeSelection").val("");
                }
                else{
                    alert(data);
                }
            }
        });
    }

    function fonctionCodeCompte() {
        $("td[id^='codeCompte']").each(function () {
            var emodeler = $(this);
            var compte = $(this).parent().find("#libCompte").html();
            var intitule= $(this).parent().find("#intituleCompte").html();
            $(this).click(function () {
                $("#labelCode").html(compte);
                if (compte == "Code taxe 1" || compte == "Code taxe 2" || compte == "Code taxe 3")
                    getTaxe(emodeler,compte);
                else
                    getCompteg(emodeler,compte);
                $("#CodeSelect").val($(this).html());
                $("#codeSelection").val($(this).html()+" - "+intitule);
            });
        });
    }
    fonctionCodeCompte();

    function selection (emodeler,compte){
        var type ="";
        var acp_type=0;
        var acp_champ = "";
        var compteg = "";var comptea = "";var taxe1 = "";var taxe2 = "";var taxe3 = "";
        type = $("#p_catcompta").val().slice(-1);
        if(type=="A")
            acp_type=1;
        acp_champ = $("#p_catcompta").val().replace(type,"");
        var compteval = " - ";
        if($("#CodeSelect").val()!=null) compteval = $("#CodeSelect").val();
        emodeler.parent().find("#codeCompte").html(compteval);
        $("#table_compteg >tbody").find("tr").each(function(){
            if($(this).find("#libCompte").html()=="Compte général"){
                compteg = $(this).find("#codeCompte").html();
            }
            if($(this).find("#libCompte").html()=="Compte analytique"){
                comptea = $(this).find("#codeCompte").html();
            }
            if($(this).find("#libCompte").html()=="Code taxe 1"){
                taxe1 = $(this).find("#codeCompte").html();
            }
            if($(this).find("#libCompte").html()=="Code taxe 2"){
                taxe2 = $(this).find("#codeCompte").html();
            }
            if($(this).find("#libCompte").html()=="Code taxe 3"){
                taxe3 = $(this).find("#codeCompte").html();
            }
        });
        if (compte == "Code taxe 1" || compte == "Code taxe 2" || compte == "Code taxe 3")
            getTaxeByCode(emodeler, $("#CodeSelect").val());
        else
            getComptegByCode(emodeler, $("#CodeSelect").val());
        insertF_ArtCompta(acp_champ,acp_type,compteg,comptea,taxe1,taxe2,taxe3);
    }

});
