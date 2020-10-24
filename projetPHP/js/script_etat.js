jQuery(function($){

    function $_GET(param) {
        var vars = {};
        window.location.href.replace( location.hash, '' ).replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function( m, key, value ) { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );

        if ( param ) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }

    if($("#montant").val()=="")
        $("#montant").val(0);
    $("#montant").inputmask({   'alias': 'integer',
        'groupSeparator': '',
        'autoGroup': true,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '',
        allowPlus: true,
        allowMinus: true
    });

    if($_GET("module")==5 && $_GET("action")==2){
        $("#DateFin").hide();
    }

    $("#datefin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#DateDebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#DateFin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#datedebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});

   if($_GET("POST_Data")==0) {
        $("#datedebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        $("#DateDebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }
    if($_GET("POST_Data")==0) {
        $("#datefin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        $("#DateFin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }


    if($_GET("action") == 36) {
        var today = new Date();
        var yyyy = today.getFullYear();
        $("#datedebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date(yyyy+'-01-01'));
        $("#DateDebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date(yyyy+'-01-01'));
        $("#datefin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date(yyyy+'-12-31'));
        $("#DateFin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date(yyyy+'-12-31'));
    }

    $("#ArticleDebut").autocomplete({
        source: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&rechEtat=1",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#ArticleDebutParam").val(ui.item.AR_Ref)
            $("#ArticleDebut").val(ui.item.AR_Design)
        }
    })

    $("#ArticleDebut").focusout(function(){
        if($("#ArticleDebut").val()!="")
            rechercheArticle($("#ArticleDebutParam"),$("#ArticleDebut"))
    })

    function rechercheArticle(articleParam,article){
        $.ajax({
            url: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&term="+articleParam.val()+"&rechEtat=1",
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if(data!="")
                    article.val(data[0].AR_Design)
                else
                    article.val("")
            }
        })
    }

    if($("#ArticleDebutParam").val()!=""){
        if($("#ArticleDebutParam").val()=="0")
            $("#ArticleDebut").val("Tout")
        else
            rechercheArticle($("#ArticleDebutParam"),$("#ArticleDebut"))
    }

    if($("#ArticleFinParam").val()!=""){
        if($("#ArticleFinParam").val()=="0")
            $("#ArticleFin").val("Tout")
        else
            rechercheArticle($("#ArticleFinParam"),$("#ArticleFin"))
    }

    $("#ClientDebut").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&type=0",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#ClientDebutParam").val(ui.item.value)
            $("#ClientDebut").val(ui.item.label)
        }
    })

    $("#ClientDebut").focusout(function(){
        findClientDebut()
    })

    $("#choix_inv").change(function(){
        choixInv()
    })

    function choixInv(){
        if($("#choix_inv").val()!=undefined)
            if($("#choix_inv").val()==2) {
                $("#datedebut").prop("disabled", false)
            }
            else {
                $("#datedebut").prop("disabled", true)
            }
    }
    choixInv()
    function findClientDebut(){
        if($("#ClientDebut").val()!="")
            $.ajax({
                url: "indexServeur.php?page=getTiersByNumIntitule&type=0&term="+$("#ClientDebutParam").val(),
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data!="")
                        $("#ClientDebut").val(data[0].CT_Intitule)
                    else
                        $("#ClientDebut").val("")
                }
            })
    }
    findClientDebut()

    $("#ClientFin").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&type=0",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#ClientFinParam").val(ui.item.value)
            $("#ClientFin").val(ui.item.label)
        }
    })

    $("#ClientFin").focusout(function(){
        findClienFin();
    })

    function findClienFin(){
        if($("#ClientFin").val()!="")
            $.ajax({
                url: "indexServeur.php?page=getTiersByNumIntitule&type=0&term="+$("#ClientFinParam").val(),
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data!="")
                        $("#ClientFin").val(data[0].CT_Intitule)
                    else
                        $("#ClientFin").val("")
                }
            })
    }
    findClienFin();
    $("#ArticleFin").autocomplete({
        source: "indexServeur.php?page=getArticleByRefDesignation&type=etat&DE_No=0&rechEtat=1",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#ArticleFinParam").val(ui.item.AR_Ref)
            $("#ArticleFin").val(ui.item.AR_Design)
        }
    })

    $("#A_Analytique").change(function(){
        listAnalytique($("#A_Analytique").val())
    })

    function listAnalytique (analytique){
        $("#CA_Num option").remove()
        $.ajax({
            url: "indexServeur.php?page=sectionByPlan&nAnalytique="+analytique,
            method: 'GET',
            dataType: 'html',
            success: function (data) {
                $("#CA_Num").append(data);
            }
        })
    }

    listAnalytique($("#A_Analytique").val())

    $("#CG_Num").autocomplete({
        source: "indexServeur.php?page=getCGNumBySearch",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#CG_Num").val(ui.item.CG_Num)
        }
    })

    $("#ArticleFin").focusout(function(){
        if($("#ArticleFin").val()!="")
            rechercheArticle($("#ArticleFinParam"),$("#ArticleFin"))
    })

    function setDateIndique(){
        if($("#ChoixInventaire").val()==0){
            $("#DateDebut").prop('enabled', true);
            $("#DateDebut").val("");
            $("#dateIndique").val(1);
        }
        if($("#ChoixInventaire").val()==1){
            $("#DateDebut").prop('enabled', false);
            $("#DateDebut").val($.datepicker.formatDate('ddmmy', new Date()));
            $("#dateIndique").val(0)
        }
    }

    $("#CT_NumDebut").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&TypeFac=Vente",
        autoFocus: true,
        select: function(event, ui) {
            event.preventDefault();
            $("#CT_NumDebut").val(ui.item.label)
            $("#clientdebut").val(ui.item.value)
        },
        focus: function(event, ui) {
        }
    })

    setDateIndique();
    $("#ChoixInventaire").change(function(){
        setDateIndique()
    });

});