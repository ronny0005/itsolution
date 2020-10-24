jQuery(function($) {
    var modification = 0;
    var prixCond = 0;
    var protect = 0;
    var emodelerComplement;
//    $("#formSelectCompte").hide();
//    $("#CodeSelect").combobox();
//    $("#CodeSelect").parent().find(".custom-combobox :input").attr("id", "codeSelection");

    $("#famille").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {
        updateReference()
    });
    function updateReference(){
        $.ajax({
            url: "indexServeur.php?page=getNextArticleByFam&codeFam="+$( "#famille" ).val(),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function(data) {
                $("#reference").val(data[0].AR_Ref);
                createReference();
            }
        });
        if(protect!=1){
            $.ajax({
                url: 'traitement/Creation.php?acte=catalog_article&famille='+$("#famille").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $("#catalniv1").html("<option value='0'></option>");
                    $("#catalniv2").html("<option value='0'></option>");
                    $("#catalniv3").html("<option value='0'></option>");
                    $("#catalniv4").html("<option value='0'></option>");
                    if(data.CL_No1!=0){
                        $("#catalniv1").append("<option value="+data.CL_No1+">"+data.CL_Intitule1+"</option>");
                        $('#catalniv1').unbind('click');
                        $('#catalniv1').click(function(){
                            catalniv1();
                        });
                    }
                }
            });
        }
    }
    updateReference()
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

    function protection() {
        $.ajax({
            url: "indexServeur.php?page=connexionProctection",
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $(data).each(function () {
                    protect = this.PROT_ARTICLE;
                    if (protect == 1) {
                        $("#formArticle :input").prop("disabled", true);
                    }
                });
            }
        });
    }

    protection();

    $('#ajouter').click(function () {
        $.ajax({
            url: 'traitement/Creation.php?acte=articleByDesign',
            method: 'POST',
            dataType: 'html',
            data: "AR_Design=" + $("#designation").val(),
            success: function (data) {

                if(data!="" && !$('#reference').is(':disabled'))
                    alert(data);
                else
                    ajouterArticle();
            },
            error: function (resultat, statut, erreur) {
                alert(resultat.responseText);
            }
        });
    });

    $("#panel_cond").hide();

    $('#AR_PrixTTC').change(function () {
        $("[id^='detailCond_']").each(function () {
            if ($(this).find("#AC_PrixTTCExist").html() == "") {
                var val = " HT";
                if ($('#AR_PrixTTC').val() == 1) val = " TTC";
                $(this).find("#Cat_PrixTTC").html(val);
            }
        });
    });

    $('#depot_stock').change(function () {
        changeArtStock();
    });

    function changeArtStock(){
        $.ajax({
            url: 'traitement/Creation.php?acte=artStock',
            method: 'GET',
            dataType: 'json',
            data: "DE_No=" + $("#depot_stock").val() + "&AR_Ref=" + $("#reference").val(),
            success: function (data) {
                if(data==""){
                    $("#stock_min").val(0);
                    $("#stock_max").val(0);
                }else {
                    $("#stock_min").val(Math.round(data[0].AS_QteMini, 2));
                    $("#stock_max").val(Math.round(data[0].AS_QteMaxi, 2));
                }
            },
            error: function (resultat, statut, erreur) {
                alert(resultat.responseText);
            }
        });
    }
    changeArtStock();

    $('#stock_min').keyup(function (e) {
        if (e.keyCode == 13) {
            updateStockBorne();
        }
    });

    $('#stock_max').keyup(function (e) {
        if (e.keyCode == 13) {
            updateStockBorne();
        }
    });

    function updateStockBorne() {
        $.ajax({
            url: 'traitement/Creation.php?acte=updateF_ArtStockBorne',
            method: 'GET',
            dataType: 'html',
            data: "DE_No=" + $("#depot_stock").val() + "&AR_Ref=" + $("#reference").val() + "&QteMax=" + $("#stock_max").val().replace(" ", "") + "&QteMin=" + $("#stock_min").val().replace(" ", ""),
            success: function (data) {
                alert("la saisie à bien été enregistrée !");
            },
            error: function (resultat, statut, erreur) {
                alert(resultat.responseText);
            }
        });
    }

    $("#pxMin, #pxMax, #stock_min, #stock_max, #pxHT, #AF_PrixAch, #AF_Conversion, #AF_ConvDiv, #AF_QteMini, #pxCond, #pxAchat, #AC_Coef, #AF_Remise, #AF_Colisage, #qteGros").inputmask({
        'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        'rightAlign': true,
        'digitsOptional': false,
        'placeholder': '0.00'
    });

    function ajouterArticle() {
        if ($("#cbMarqArticle").val()!=0) {
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_article&reference=' + $("#reference").val(),
                method: 'GET',
                dataType: 'json',
                data: $("#formArticle").serialize(),
                success: function (data) {
                    //if($_GET("window")==undefined)
                        window.location.replace("listeArticle-2-" + data.AR_Ref);
                    //else
                    //    window.close();
                }
            });
        } else {
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_article&reference='+$("#reference").val(),
                method: 'GET',
                dataType: 'json',
                data: $("#formArticle").serialize(),
                success: function (data) {
                    if(data.code==0)
                        window.location.replace("listeArticle-1-" + $("#reference").val());
                    else
                        alert(data.message)
                },
                error: function (resultat, statut, erreur) {
                    alert(resultat.responseText);
                }
            });
        }
    }

    $("#reference").focusout(function () {
        createReference();
    });
    $("#designation").focusout(function () {
        createReference();
    });

    function createReference() {
/*        if (!$('#reference').is(':disabled') && $_GET("AR_Ref") == null && $("#reference").val() != "" && $("#designation").val() != "" && $(".comboclient").val() != "") {
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_article',
                method: 'GET',
                dataType: 'json',
                data: $("#formArticle").serialize(),
                success: function (data) {
                    $("#reference").val(data.AR_Ref);
                    $("#reference").prop("disabled", true);
                },
                error: function (resultat, statut, erreur) {
                    alert(resultat.responseText);
                }
            });
        }*/
    }

    $('#conditionnement').on('change', function () {
        if (protect != 1) {
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_article&reference=' + $("#reference").val() + '&designation=' + $("#designation").val() + '&pxAchat=' + $("#pxAchat").val() + '&famille=' + $("#famille").val() + '&pxHT=' + $("#pxHT").val() + '&conditionnement=' + $("#conditionnement").val() + '&pxMin=' + $("#pxMin").val() + '&pxMax=' + $("#pxMax").val(),
                method: 'GET',
                dataType: 'html',
                success: function (data) {

                }
            });
        }
    });


    $('#pxAchat').on('keyup', function () {
        $("#pxMin").val($('#pxAchat').val());
    });

    $('#pxHT').on('keyup', function () {
        $("#pxMax").val($('#pxHT').val());
    });

    $("tr[id^='detailCond_']").dblclick(function () {
        if (protect != 1) {

            if ($("#cbMarqArticle").val != 0) {
                $("#panel_cond").dialog({
                    resizable: false,
                    height: "auto",
                    width: 700,
                    modal: true
                });

                $("#pxCond").val($(this).find("#prix_cond").html());
                $("#TbDetail_cond").html("");
                $("#COND_PrixTTC").val($(this).find("#AC_PrixTTC").html());
                prixCond = $(this).find("#value_cond").val();
                i = 0;
                $.ajax({
                    url: 'traitement/Creation.php?acte=cond_detail&value_cond=' + $(this).find("#value_cond").val() + '&reference=' + $("#reference").val(),
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $.ajax({
                            url: 'traitement/Creation.php?acte=cond_detail_pxMinMax&value_cond=' + prixCond + '&reference=' + $("#reference").val(),
                            method: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $("#AC_Coef").val(data[0].AC_Coef);
                                $("#pxCond").val(data[0].AC_PrixVen);
                            }
                        });
                        $(data).each(function () {
                            i = i + 1;
                            var ec_enum = this.EC_Enumere;
                            var ec_qte = Math.round(this.EC_Quantite);
                            var ec_prix = Math.round(this.TC_Prix);
                            var new_item = $("<tr id='" + this.EC_Enumere + "'><td>" + this.EC_Enumere + "</td>"
                                + "<td>" + ec_qte + "</td>"
                                + "<td>" + ec_prix + "</td><td id='suppr_" + this.EC_Enumere + "'>X</td></tr>");
                            $("#TbDetail_cond").append(new_item).on('dblclick', '#' + this.EC_Enumere, function () {
                                $("#titre_cond").val(ec_enum);
                                $("#Atitre_cond").val(ec_enum);
                                $("#qte_cond").val(ec_qte);
                                $("#prixV_cond").val(ec_prix);
                                $("#val_cond").val(i);
                                modification = 1;
                            }).on('click', '#suppr_' + ec_enum, function () {
                                $.ajax({
                                    url: 'traitement/Creation.php?acte=suppr_conditionnement&enumere=' + ec_enum + '&AR_Ref=' + $("#reference").val(),
                                    method: 'GET',
                                    dataType: 'html',
                                    success: function (data) {
                                        $('#panel_cond').dialog('close');
                                    }
                                });
                            });
                        });
                    }
                });
            }
        }
    });

    $("#AF_Devise").change(function(){
        if($(this).val() != 0) {
            $("#fournisseurPADevise").attr("readonly", false);
            $("#AF_PrixAch").attr("readonly", true);
            $("#AF_PrixAch").val("");
        }
        else {
            $("#fournisseurPADevise").attr("readonly", true);
            $("#AF_PrixAch").attr("readonly", false);
            $("#AF_PrixAch").val($("#pxAchat").val());
        }
    });
    $("#AF_TypeRem").change(function(){
        if($(this).val() == 1) {
            $("#AF_Remise").attr("readonly", true);
            $("#AF_Remise").val("");
        }
        else {
            $("#AF_Remise").attr("readonly", false);
        }
    });


    $("td[id^='supprFournisseur']").each(function() {
        $(this).click(function() {
            var cbmarqFourniss = $(this).parent().find("#cbMarq").html();
            var fourniss = $(this).parent().find("#CT_Num").html();
            var elem = $(this).parent();
            $("<div>Voulez vous supprimer le fournisseur " + fourniss + " ?</div>").dialog({
                resizable: false,
                height: "auto",
                width: 500,
                modal: true,
                buttons: {
                    "Oui": {
                        class: 'btn btn-primary',
                        text: 'Oui',
                        click: function () {
                            $.ajax({
                                url: 'traitement/Creation.php?acte=supprArtFournisseur&cbMarq=' + cbmarqFourniss,
                                method: 'GET',
                                dataType: 'html',
                                async: false,
                                success: function (data) {
                                    elem.fadeOut(300, function() { $(this).remove(); });
                                }
                            });
                            $(this).dialog("close");
                        }
                    },

                    "Non": {
                        class: 'btn btn-primary',
                        text: 'Non',
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                }
            });
        });
    });


    $("td[id^='modifFournisseur']").each(function() {
        $(this).click(function() {
            var cbmarqFourniss = $(this).parent().find("#cbMarq").html();
            var fourniss = $(this).parent().find("#CT_Num").html();
            var elem = $(this).parent();
            $.ajax({
                url: 'traitement/Creation.php?acte=getArtFournisseur&cbMarq=' + cbmarqFourniss,
                method: 'GET',
                dataType: 'json',
                async: false,
                success: function (data) {
                    $("#AF_DateApplication").val(data[0].DateApplication);
                    $("#AF_RefFourniss").val(data[0].AF_RefFourniss);
                    $("#fournisseurNum").val(data[0].CT_Num);
                    $("#fournisseurNum").attr("readonly", true);
                    $("#AF_CodeBarre").val(data[0].AF_CodeBarre);
                    $("#AF_Devise").val(data[0].AF_Devise);
                    $("#AF_PrixAch").val(data[0].AF_PrixAch);
                    $("#AF_TypeRem").val(data[0].AF_TypeRem);
                    $("#AF_Remise").val(data[0].AF_Remise);
                    $("#AF_Colisage").val(data[0].AF_Colisage);
                    $("#AF_Unite").val(data[0].AF_Unite);
                    $("#AF_ConvDiv").val(data[0].AF_ConvDiv);
                    $("#AF_Conversion").val(data[0].AF_Conversion);
                    $("#AF_QteMini").val(data[0].AF_QteMini);
                    $("#AF_Garantie").val(data[0].AF_Garantie);
                    $("#AF_DelaiAppo").val(data[0].AF_DelaiAppro);
                    if(data[0].AF_Principal==1)
                    $("#AF_Principal").prop('checked', true);
                    Prixfournisseur(cbmarqFourniss);
                }
            });
        });
    });

        function Prixfournisseur(cbMarq) {
            var typeaction = "ajoutArtFournisseur";
            if (cbMarq != 0)
                typeaction = "modifArtFournisseur";
            else
                $("#AF_PrixAch").val($("#pxAchat").val());
            $("#panelFournisseur").dialog({
                resizable: false,
                height: "auto",
                width: 600,
                modal: true,
                buttons: {
                    "Valider": {
                        class: 'btn btn-primary',
                        text: 'Valider',
                        click: function () {
                                var af_principal = 0;
                                var element = $(this);
                                if ($("#AF_Principal").is(':checked'))
                                    af_principal = 1;
                                $.ajax({
                                    url: 'traitement/Creation.php?acte=' + typeaction + "&AR_Ref=" + $("#reference").val(),
                                    method: 'GET',
                                    dataType: 'json',
                                    data: "CT_Num=" + $("#fournisseurNum").val() + "&AF_RefFourniss=&AF_PrixAch=" + $("#AF_PrixAch").val() + "&AF_Unite=" + $("#AF_Unite").val() + "&AF_Conversion=" + $("#AF_Conversion").val() +
                                        "&AF_DelaiAppo=" + $("#AF_DelaiAppo").val() + "&AF_Garantie=" + $("#AF_Garantie").val() + "&AF_Colisage=" + $("#AF_Colisage").val() + "&AF_QteMini=" + $("#AF_QteMini").val() + "&AF_QteMont=" + $("#AF_QteMont").val() +
                                        "&EG_Champ=" + $("#EG_Champ").val() + "&AF_Principal=" + af_principal + "&AF_PrixDev=" + $("#AF_PrixDev").val() + "&AF_Devise=" + $("#AF_Devise").val() + "&AF_Remise=" + $("#AF_Remise").val() + "&AF_ConvDiv=" + $("#AF_ConvDiv").val() +
                                        "&AF_TypeRem=" + $("#AF_TypeRem").val() + "&AF_CodeBarre=" + $("#AF_CodeBarre").val() + "&AF_PrixAchNouv=" + $("#AF_PrixAchNouv").val() + "&AF_PrixDevNouv=" + $("#AF_PrixDevNouv").val() + "&AF_RemiseNouv=" + $("#AF_RemiseNouv").val() + "&AF_DateApplication=" + $("#AF_DateApplication").val(),
                                    async: false,
                                    success: function (data) {
                                        if(data[0].Error==0) {
                                            element.dialog("close");
                                            location.reload();
                                        }else{
                                            alert(data[0].Msg);
                                        }
                                    }
                                });

                        }
                    }
                }
            });
        }

    $("#nouveauFournisseur").click(function(){
        Prixfournisseur(0);
    });

    $("td[id^='codeCompte']").each(function () {

    });


    $("#qte_cond").keyup(function (e){
        
        if(e.keyCode == 13){
        valideCond();
        }
    });
    
    
    $("#titre_cond").keyup(function (e){
        if(e.keyCode == 13){
        valideCond();
        }
    });
    
    
    $("#prixV_cond").keyup(function (e){
        if(e.keyCode == 13){
        valideCond();
        }
    });
    
    $("#pxCond, #AC_Coef").keyup(function (e){
        if(e.keyCode == 13){
            $.ajax({
                url: 'traitement/Creation.php?acte=maj_prix_detail&prix='+$("#pxCond").val()+'&ref='+$("#reference").val()+'&val='+prixCond+'&Prix_TTC='+$("#COND_PrixTTC").val(),
                method: 'GET',
                dataType: 'html',
                data : "AC_Coef="+$("#AC_Coef").val(),
                success: function(data) {
                    $("#prixV_cond").val("");
                    $("#titre_cond").val("");
                    $("#qte_cond").val("");
                    $('#panel_cond').dialog('close');
                    window.location.replace("ficheArticle-"+$("#reference").val());
                }
            });
        }
    });
    
    function catalniv1(){
        $('#catalniv1 option').unbind('click');
        $('#catalniv2 option').unbind('click');
        $('#catalniv3 option').unbind('click');
        $('#catalniv1 option').click(function() {
            $('#catalniv2').html("<option value=0></option>");
            $('#catalniv3').html("<option value=0></option>");
            $('#catalniv4').html("<option value=0></option>");
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_famille&valide=0&FA_CodeFamille='+$("#famille").val()+'&niv=1&catal1='+$("#catalniv1").val()+'&val='+$("#catalniv1").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $(data).each(function() {
                        $('#catalniv2').append("<option value="+this.CL_No+">"+this.CL_Intitule+"</option>");
                        $('#catalniv2').prop('disabled', false);
                    //    $('#catalniv2').unbind('click');
                        $('#catalniv2').click(function(){
                            catalniv2();
                        });
                    });
                }
            });
        });
    }
    
    function catalniv2(){
        $('#catalniv2 option').unbind('click');
        $('#catalniv3 option').unbind('click');
        $('#catalniv2 option').click(function() {
            $('#catalniv3').html("<option value=0></option>");
            $('#catalniv4').html("<option value=0></option>");
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_famille&valide=0&FA_CodeFamille='+$("#famille").val()+'&niv=2&catal2='+$("#catalniv2").val()+'&val='+$("#catalniv2").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $(data).each(function() {
                        $('#catalniv3').append("<option value="+this.CL_No+">"+this.CL_Intitule+"</option>");
                        $('#catalniv3').prop('disabled', false);
                        $('#catalniv3').click(function(){
                            catalniv3();
                        });
                    });
                }
            });
        });
    }
    
    function catalniv3(){
        $('#catalniv3 option').unbind('click');
        $('#catalniv3 option').click(function() {
            $('#catalniv4').html("<option value=0></option>");
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_famille&valide=0&FA_CodeFamille='+$("#famille").val()+'&niv=3&catal3='+$("#catalniv3").val()+'&val='+$("#catalniv3").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $(data).each(function() {
                        $('#catalniv4').append("<option value="+this.CL_No+">"+this.CL_Intitule+"</option>");
                        $('#catalniv4').prop('disabled', false);
                    });
                }
            });
        });
    }
    
    catalniv1();
    catalniv2();
    catalniv3();
    
    function valideCond(){
        if(protect!=1){
        
        if($('#conditionnement').val()!=0){
            if($("#prixV_cond").val()!="" && $("#titre_cond").val()!="" && $("#qte_cond").val()!=""){
                if(modification==1){
                    $.ajax({
                        url: 'traitement/Creation.php?acte=maj_cond_detail&prix='+$("#prixV_cond").val()+'&val='+$("#val_cond").val()+'&enum='+$("#titre_cond").val()+'&AEnum='+$("#Atitre_cond").val()+'&qte='+$("#qte_cond").val()+'&ref='+$("#reference").val(),
                        method: 'GET',
                        dataType: 'html',
                        success: function(data) {
                            $("#prixV_cond").val("");
                            $("#titre_cond").val("");
                            $("#qte_cond").val("");
                            $('#panel_cond').dialog('close');
                        }
                    });
                    modification=0;
                }else {
                    $.ajax({
                        url: 'traitement/Creation.php?acte=creation_conditionnement&prix='+$("#prixV_cond").val()+'&nbCat='+prixCond+'&enumere='+$("#titre_cond").val()+'&qte='+$("#qte_cond").val()+'&AR_Ref='+$("#reference").val(),
                        method: 'GET',
                        dataType: 'html',
                        success: function(data) {
                            if(data.length==0){
                                $('#panel_cond').dialog('close');
                            }else{
                                if(data.length==1){
                                    alert("Enumere déjà utilisé !");
                                } else alert("Erreur à la création");
                            }
                        }
                    });
                }
            }
        }if($('#conditionnement').val()==0){
            
        } else alert("veuillez choisir un conditionnement !");
    }
    }
    if($("#cbMarqArticle").val()==0){
       $("#reference").prop('disabled', true);
    }

    $("#compteGSelectInput").autocomplete({
        source: "indexServeur.php?page=getComptegByCGNum",
        autoFocus: true,
        closeOnSelect: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#compteGSelectInput").val(ui.item.text)
            $("#comptegCode").val(ui.item.CG_Num)
            getCatComptaByArRef();
        }
    }).keypress(function (e, data, ui) {
        if (e.which == 13) {
            if($("#compteGSelectInput").val()=="")
                $("#comptegCode").val("")
            updateCatCompta($("#comptegCode").val())
        }
    })

    $("#taxeSelectInput").autocomplete({
        source: "indexServeur.php?page=getTaxeByTaCodeSearch",
        autoFocus: true,
        closeOnSelect: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#taxeSelectInput").val(ui.item.text)
            $("#taxeCode").val(ui.item.TA_Code)
        }
    }).keypress(function (e, data, ui) {
        if (e.which == 13) {
            if($("#taxeSelectInput").val()=="")
                $("#taxeCode").val("")
            updateCatCompta($("#taxeCode").val())
        }
    })

    function updateCatCompta(val){
        var type = $("#p_catcompta").val().slice(-1);
        var fcp_type = 0;
        if(type=="A")
            fcp_type=1;
        var acp_champ = $("#p_catcompta").val().replace(type,"");

        $.ajax({
            url: "indexServeur.php?page=majCatComptaByArRef&val="+val+"&champ="+$("#typeCatCompta").val(),
            method: 'GET',
            dataType: 'html',
            async : false,
            data : "ACP_Type="+fcp_type+"&ACP_Champ="+acp_champ+"&AR_Ref="+$("#reference").val()+"&cbMarq="+$("#cbMarqArtCompta").val(),
            success: function(data) {
                if(data=="") {
                    alert("la modification a bien été pris en compte !")
                    $("#typeCatCompta").val("")
                    $("#taxeCode").val("")
                    $("#taxeSelectInput").val("")
                    $("#compteGSelectInput").val("")
                    $("#comptegCode").val("")
                    getCatComptaByArRef()
                }
                else{
                    alert(data);
                }
            }
        });
    }

    $("#p_catcompta").change(function() {
        getCatComptaByArRef();
    });

    function getCatComptaByArRef(){
        var type = $("#p_catcompta").val().slice(-1);
        var fcp_type = 0;
        if(type=="A")
            fcp_type=1;
        var acp_champ = $("#p_catcompta").val().replace(type,"");
        $.ajax({
            url: "indexServeur.php?page=getCatComptaByArRef&ACP_Type="+fcp_type+"&ACP_Champ="+acp_champ+"&AR_Ref="+$("#reference").val(),
            method: 'GET',
            dataType: 'html',
            async : false,
            success: function(data) {
                $("#table_compteg >tbody").html("");
                $("#table_compteg >tbody").append(data);
                fonctionCodeCompte();
            }
        });
    }
    getCatComptaByArRef()

    function fonctionCodeCompte() {
        $("td[id^='codeCompte']").each(function () {

            $("#comptegSelect").hide()
            var compte = $(this).parent().find("#libCompte").html();

            $(this).click(function () {
                var libelle = $(this).parent().find("#intituleCompte").html()
                $("#typeCatCompta").val($(this).parent().find("#typeCompta").val())
                if (compte == "Code taxe 1" || compte == "Code taxe 2" || compte == "Code taxe 3") {
                    $("#taxeCode").val($(this).html())
                    $("#taxeSelectInput").val($(this).html()+" - "+libelle)
                    $("#taxeSelect").show()
                    $("#comptegSelect").hide()
                }
                else{
                    $("#comptegCode").val($(this).html())
                    $("#compteGSelectInput").val($(this).html()+" - "+libelle)
                    $("#taxeSelect").hide()
                    $("#comptegSelect").show()
                }
            });
        });
    }

    fonctionCodeCompte();

    protection();
});