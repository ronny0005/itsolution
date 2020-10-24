jQuery(function($) {

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
    $("#clientSource").combobox();
    $("#articleSource").combobox();
    $("#articleDest").combobox();
    $("#depotSource").combobox();
    $("#formAnalytique").hide();
    $("#info_article").hide();

    var cmp = 0;
    $("#devise").change(function(){
        if($("#devise").val()==0)
            $("#prixVenteDest").val("601");
        if($("#devise").val()==1)
            $("#prixVenteDest").val("655");
        calculQteAch();
        calculPrixTotalAchat();
    });

    $(".custom-combobox").each(function () {
        if (cmp == 0) $(this).attr("class", "clientSource");
        if (cmp == 1) $(this).attr("class", "depotSource");
        if (cmp == 2) $(this).attr("class", "articleSource");
        cmp = cmp + 1;
    });

    $("#dateDevise").datepicker({dateFormat: "yy-mm-dd", altFormat: "yy-mm-dd"});

    if($_GET("entete")==undefined) {
        $("#dateDevise").datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
    }

    $(".articleSource").focusout(function(){
        alimente_qteStock($("#articleSource").val());
    });

    function alimente_qteStock(reference){
        $.ajax({
            url: 'indexServeur.php?page=isStock&AR_Ref='+reference+'&DE_No='+$("#depotSource").val(),
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) {
                qteRestante = Math.round(data[0].AS_QteSto*100)/100;
                $("#qteSource").val(qteRestante);
                $("#qteSourceMax").val(qteRestante);
                if(!modification && Math.round(data[0].AS_QteSto)>=1 && $_GET("entete")!=null)
                    if($("#quantite").val()=="") {

                    }
            }
        });
    }

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



    $(".depotSource").focusout(function(){
            rafraichir_liste_article();
    });

    function rafraichir_liste_article(){
        $("#articleSource").empty();
        $(".articleSource :input").val("");
        $.ajax({
            url: "traitement/Transfert.php?acte=liste_article_sourceDevise&depot="+$("#depotSource").val()+"&type="+$_GET("type"),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function(data) {
                $.each(data, function(index, item) {
                    if(item.AR_Sommeil==0)
                        $("#articleSource").append(new Option(item.AR_Ref+" - "+item.AR_Design,item.AR_Ref));
                });
            }
        });
    }
    //if($_GET("entete")==null) $("#collaborateur").val("0");
    var do_domaine = 0;
    var do_type = 0;

    $("#depot").focusout(function(){
        listeDepot ();
    });

    function calculPrixTotal(){
        var prixVenteSource =0;
        var qteSource =0;
        var totalSource =0;
        if($("#prixVenteSource").val()!="")
            prixVenteSource = $("#prixVenteSource").val();
        if($("#qteSource").val()!="")
            qteSource = $("#qteSource").val();
        totalSource = Math.round((prixVenteSource * qteSource)*100,2)/100;
        $("#totalSource").val(totalSource);
    }

    function calculPrixTotalAchat(){
        var prixVenteDest =0;
        var qteDest =0;
        var totalDest =0;
        if($("#prixVenteDest").val()!="")
            prixVenteDest = $("#prixVenteDest").val();
        if($("#qteDest").val()!="")
            qteDest = $("#qteDest").val();
        totalDest = Math.round((prixVenteDest * qteDest)*100,2)/100;
        $("#totalDest").val(totalDest);
    }


    function calculQteAch(){
        var totalSource =0;
        var prixVenteDest =0;
        var qteDest =0;
        if($("#prixVenteDest").val()!="")
            prixVenteDest = $("#prixVenteDest").val();
        if($("#totalSource").val()!="")
            totalSource = $("#totalSource").val();
        qteDest = Math.round((totalSource / prixVenteDest)*100,2)/100;
        $("#qteDest").val(qteDest);
    }


    $("#prixVenteSource").keyup(function (event) {
        calculPrixTotal();
    });

    $("#qteSource").keyup(function (event) {
        calculPrixTotal();
    });

    $("#prixVenteDest").keyup(function (event) {
        calculQteAch();
        calculPrixTotalAchat();
    });

    function ajoutDevise() {
        if($("#qteSourceMax").val()>=$("#qteSource").val()) {
            var insert=1;
            var cbMarq = 0;
            if($_GET("cbMarq")!=null) {
                insert = 0;
                cbMarq = $_GET("cbMarq");
            }
            $.ajax({
                url: "traitement/facturation.php?acte=saisieDevise&insert="+insert+"&cbMarq="+cbMarq,
                method: 'GET',
                dataType: 'json',
                data: $("#form-entete").serialize(),
                success: function (data) {
              //      window.location.replace("indexMVC.php?module=2&action=11&type=VenteDevise");
                }
            });
        }
    }
    alimente_qteStock($("#articleSource").val());

    $('#valider').click(function(){
        ajoutDevise();
    });

    $('#devise').change(function(){
        paramDevise();
    });

    function paramDevise(){
        if($_GET("cbMarq")==null) {
            $("#prixVenteDest").val("0");
            $("#qteDest").val("0");
            $("#totalDest").val("0");
        }
        if($(this).val()==0) {
            $("#prixVenteDest").prop("disabled", true);
        }else{
            $("#prixVenteDest").prop("disabled", false);
        }
    }


});
