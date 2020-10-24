jQuery(function($){

    var protect=0;
    var type =0;
    var EC_No = 0;
    var borneMin = 0;
    var borneMax = 0;
    var isContrepartie = 0;
    var EC_MontantImpute = 0;
    var totalMontantA = 0;
    
    $("#EC_Jour").val(1);  
    $( "#CG_Num, #CT_Num" ).combobox();

    $("#Ajouter").prop('disabled', true);
    var saisijourn = $("#saisiejourn").val();
    $("#formAnalytique").hide();
    var cmp = 0;
    $(".custom-combobox").each(function(){
        if(cmp==0) $(this).attr("id", "CG_Num_select");
        if(cmp==1) $(this).attr("id", "CT_Num_select");
        //if(cmp==2) $(this).attr("id", "CA_Num_select");
        cmp=cmp+1;
    });

function inputMask() {

    $("#totalJournalDebit, #totalJournalCredit, #EC_MontantDebit, #EC_MontantCredit").inputmask({
        'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: false,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: true
    });
}
//    $("#CA_Num_select :input").val("");
    var nomFichier = "";
    var pendingList = [];
    function sendAll() {
            pendingList.forEach(function (data) { data.submit(); });
            pendingList = [];
     }    
        var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'upload/';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                maxNumberOfFiles: 1,
                autoUpload: false,
                async : false,
                add: function (e, data) {
                    pendingList = [];
                    pendingList.push(data);
                },

                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        nomFichier = file.name;
                        //$('<p/>').text(file.name).appendTo('#files');
                    });
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                    $('#progress .progress-bar').css(
                        'background-color',
                        '#286090'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

    function calculEnteteJournal(){
        var totalDebit=0,totalCredit=0,montantDebit=0,montantCredit=0;
        borneMin = 0;
        borneMax = 0;
        $("#tableEcritureC > tbody tr[id^='emodeler_']").each(function() {
            montantDebit = Math.round($(this).find("#tabEC_MontantDebit").html().replace(" ","")*100,0)/100;
            montantCredit = Math.round($(this).find("#tabEC_MontantCredit").html().replace(" ","")*100,0)/100;
            if(Number.isInteger(montantDebit))
                totalDebit = totalDebit + Math.round($(this).find("#tabEC_MontantDebit").html().replace(" ","")*100,0)/100;
            if(Number.isInteger(montantCredit))
                totalCredit = totalCredit + Math.round($(this).find("#tabEC_MontantCredit").html().replace(" ","")*100,0)/100;
            if(totalDebit==totalCredit){
                isContrepartie = 0;
                $("#Ajouter").prop('disabled', false);
                $("#EC_Facture").val("");
                $("#EC_RefPiece").val("");
            }else{
                isContrepartie = 1;
                $("#Ajouter").prop('disabled', true);
            }

        });

        if(isContrepartie==1){
            Contrepartie();
        }
        $("#totalJournalDebit").val(totalDebit);
        $("#totalJournalCredit").val(totalCredit);
        inputMask();
    }
    calculEnteteJournal();

    
    function calculEnteteJournalAnal(){
        var totalQte=0,totalMontant=0;
        $("#table_anal > tbody tr[id^='emodeler_anal_']").each(function() {
            totalQte = totalQte + Math.round($(this).find("#tabA_Qte").html()*100,0)/100; 
            totalMontant = totalMontant + Math.round($(this).find("#tabA_Montant").html()*100,0)/100;
        });
        totalMontantA=totalMontant;
        $("#montant_imputer").html(EC_MontantImpute);
        $("#qte_timputer").html(totalQte);
        $("#montant_timputer").html(totalMontant);
        $("#montant_solde").html(EC_MontantImpute-totalMontant);
    }
    calculEnteteJournalAnal();
    
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
    
    $('#Ajouter').click(function(){
        Ajouter();
    });
        
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_DEPOT;
                    if(protect==1){
                        $('#intitule').prop('disabled', true);
                        $('#adresse').prop('disabled', true);
                        $('#complement').prop('disabled', true);
                        $('#cp').prop('disabled', true);
                        $('#region').prop('disabled', true);
                        $('#pays').prop('disabled', true);
                        $('#responsable').prop('disabled', true);
                        $('#cat_compta').prop('disabled', true);
                        $('#code_depot').prop('disabled', true);
                        $('#tel').prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection();  
    
    function calcRestantContrepartie(){
        $.ajax({
            url: 'indexServeur.php?CG_Num='+$("#CG_Num_select :input").val(),
            method: 'GET',
            dataType: 'html',
            success: function (data) {
                    $("#EC_Intitule").focus();
            }
        });
        if(isContrepartie==1){
            var diff = $("#totalJournalDebit").val()-$("#totalJournalCredit").val();
            if(diff<0)
            {
                $("#EC_MontantDebit").val(Math.abs(diff));
            }else 
                $("#EC_MontantCredit").val(diff);
        }
    }
    
    $("#CG_Num_select :input").focusout(function(){
       calcRestantContrepartie();
    });
    
    $("#EC_Intitule").focusout(function(){
        if(isContrepartie==1){
            var diff = $("#totalJournalDebit").val()-$("#totalJournalCredit").val();
            if(diff<0)
            {
                $("#EC_MontantDebit").focus();
            }else 
                $("#EC_MontantCredit").focus();
        }
    });
    
    function Contrepartie(){
        $.ajax({
            url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=contrepartie',
            method: 'GET',
            dataType: 'json',
            data : 'JO_Num='+$_GET("JO_Num"),
            async : false,
            success: function(data) {
                $("#CG_Num").val(data.CG_Num);
                $("#CG_Num_select :input").val(data.CG_Num);
            }
        });
    }
    
    
    function Ajouter(){
        /*$.ajax({
            url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=suppr',
            method: 'GET',
            dataType: 'html',
            data : 'JO_Num='+$_GET("JO_Num")+'&Annee_Exercice='+$_GET("exercice"),
            async : false,
            success: function(data) {
                sendAll();
                $("tr[id^='emodeler_']").each(function() {
                 var intitule = $(this).find("#tabEC_Intitule").html(),ec_facture = $(this).find("#tabEC_Facture").html(), ec_jour = $(this).find("#tabEC_Jour").html(), ec_ref = $(this).find("#tabEC_Facture").html()
                 ,ec_montantdebit = $(this).find("#tabEC_MontantDebit").html(), ec_montantcredit = $(this).find("#tabEC_MontantCredit").html(),ec_position = $(this).find("#tabEC_Position").html()
                 ,ec_echeance = $(this).find("#tabEC_Echeance").html(),ct_num = $(this).find("#tabCT_Num").html(),cg_num = $(this).find("#tabCG_Num").html();
                 $.ajax({
                     url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=ajout',
                     method: 'GET',
                     dataType: 'json',
                     data : "nomFichier="+nomFichier+'&JO_Num='+$_GET("JO_Num")+'&Annee_Exercice='+$_GET("exercice")+'&EC_Jour='+ec_jour+'&EC_Piece=&EC_RefPiece='+ec_ref+'&CG_Num='+cg_num+'&CG_NumCont='+cg_num+'&CT_Num='+ct_num+'&CT_NumCont='+ct_num+'&EC_Intitule='+intitule+'&N_Reglement=1&EC_Echeance='+ec_echeance+'&EC_MontantCredit='+ec_montantcredit+'&EC_MontantDebit='+ec_montantdebit+'&TA_Code=0',
                     async : false,
                     success: function(data) {
                         $("#Ajouter").prop("enabled","false");
                     } 
                 }); 
                });
            }
        });*/
        alert("La saisie a bien été prise en compte !"); 
        window.location.replace("indexMVC.php?module=9&action=13&acte=ajoutOK&JO_Num="+$_GET("JO_Num"));
    }
    
    function testChamps(){
        $("#EC_MontantDebit").keydown(function (event) {
            $("#EC_MontantCredit").val("");
        });
        $("#EC_MontantCredit").keydown(function (event) {
            $("#EC_MontantDebit").val("");
        });

        $("#EC_Jour").focusout(function(){
            var d = new Date();     

            d.setFullYear(($_GET("exercice")).substr(0,4),($_GET("exercice")).substr(4,2), 0);
            if($("#EC_Jour").val()>=1 && $("#EC_Jour").val()<=d.getDate()){

            }else {
                alert("Le jour est incorrect.");
                $("#EC_Jour").val(1);
            }
        });
    }
    testChamps();
    
    
    function testChampsAnal(){
    }
    testChampsAnal();
    
    function ajoutLigneOption(){
        $("#EC_Jour").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
        $("#EC_Facture").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
        $("#EC_RefPiece").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
        $("#CG_Num_select").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
        $("#CT_Num_select").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
        $("#EC_Intitule").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
        $("#EC_Echeance").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
        $("#EC_MontantDebit").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
        $("#EC_MontantCredit").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigne();
        });
    }
    
    function ajoutLigneOptionAnalytique(){
        /*$("#CA_Num_select :input").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigneAnalytique();
        });*/
        $("#A_Qte").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigneAnalytique();
        });
        $("#A_Montant").keydown(function (event) {
            if(event.keyCode == 13)
                ajoutLigneAnalytique();
        });
    }
    ajoutLigneOption();
    ajoutLigneOptionAnalytique();
    
    function ajoutLigne(){
        var val=true;
        if($("#CG_Num_select :input").val()=="" || ($("#EC_MontantDebit").val()=="" && $("#EC_MontantCredit").val()=="") )
            val=false;
        if(val){
            sendAll();
            var intitule = $("#EC_Intitule").val(),ec_reference = $("#EC_RefPiece").val(), ec_jour = $("#EC_Jour").val(), ec_ref = $("#EC_Facture").val()
            ,ec_montantdebit = $("#EC_MontantDebit").val(), ec_montantcredit = $("#EC_MontantCredit").val(),ec_position = $("#EC_Position").val()
            ,ec_echeance = $("#EC_Echeance").val(),ct_num = $("#CT_Num").val(),cg_num = $("#CG_Num").val();
            $.ajax({
                url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=ajout',
                method: 'GET',
                dataType: 'json',
                data : "nomFichier="+nomFichier+'&JO_Num='+$_GET("JO_Num")+'&Annee_Exercice='+$_GET("exercice")
                +'&EC_Jour='+ec_jour+'&EC_Piece=&EC_RefPiece='+ec_ref+'&EC_Reference='+ec_reference+'&CG_Num='+cg_num
                +'&CG_NumCont='+cg_num+'&CT_Num='+ct_num+'&CT_NumCont='+ct_num+'&EC_Intitule='+intitule
                +'&N_Reglement=1&EC_Echeance='+ec_echeance+'&EC_MontantCredit='+ec_montantcredit.replace(/ /g, "")+'&EC_MontantDebit='+ec_montantdebit.replace(/ /g, "")
                +'&TA_Code=0',
                async : false,
                success: function(data) {
                    EC_No = data.EC_No;
                    $.ajax({
                        url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=afficheLigne',
                        method: 'GET',
                        dataType: 'html',
                        data : 'JO_Num='+$_GET("JO_Num")+'&Annee_Exercice='+$_GET("exercice"),
                        async : false,
                        success: function(data) {
                            $("#tableEcritureC > tbody").html(data);
                            setDblClick ();
                            clear();
                            validsaisAnal(cg_num,ec_montantdebit,ec_montantcredit);
                            calculEnteteJournal();
                            $("#CG_Num_select :input").focus();
                        }
                    });
                }
            });
        }
    }
    
    function validsaisAnal(cg_num,mDebit,mCredit){
        $.ajax({
            url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=ouvreAnalytique',
            method: 'GET',
            dataType: 'json',
            data : "CG_Num="+cg_num,
            async : false,
            success: function(data) {
                if(data.JO_SaisAnal==1){
                    if(mDebit!=0 && mDebit!="")
                        EC_MontantImpute = mDebit;
                    else 
                        EC_MontantImpute = mCredit;
                    formAnalytique(EC_No);
                }
            }
        });
    }
    
    function ajoutLigneAnalytique(){
        var val=true;
        if(/*$("#CA_Num_select :input").val()=="" ||*/$("#CA_Num").val()!="" && ($("#A_Qte").val()=="" || $("#A_Montant").val()=="") ){
            
        }else val=false;
        if(val){
            var ca_num = $("#CA_Num").val(),A_Qte = $("#A_Qte").val(), A_Montant = $("#A_Montant").val();
            $.ajax({
                    url: 'traitement/Structure/Comptabilite/SaisieJournalExerciceAnal.php?acte=ajout',
                    method: 'GET',
                    dataType: 'html',
                    data : 'CA_Num='+$("#CA_Num").val()+'&A_Qte='+A_Qte+'&A_Montant='+A_Montant+'&EC_No='+EC_No+"&N_Analytique="+$("#N_Analytique").val(),
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
    
    function actionModif(emodeler){
        $("#EC_Jour").keydown(function (event) {
        if(event.keyCode == 13)
            valideLigne(emodeler);
        });
        $("#EC_Facture").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigne(emodeler);
        });
        $("#EC_RefPiece").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigne(emodeler);
        });
        $("#CG_Num_select").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigne(emodeler);
        });
        $("#CT_Num_select").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigne(emodeler);
        });
        $("#EC_Intitule").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigne(emodeler);
        });
        $("#EC_Echeance").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigne(emodeler);
        });
        $("#EC_MontantDebit").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigne(emodeler);
        });
        $("#EC_MontantCredit").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigne(emodeler);
        });
    }
    
    
    function actionModifAnal(emodeler){
        $("#A_Montant").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigneAnal(emodeler);
        });
        $("#A_Qte").keydown(function (event) {
            if(event.keyCode == 13)
            valideLigneAnal(emodeler);
        });
    }
    
    function clear(){
        $("#CG_Num_select :input").val("");
        $("#CT_Num_select :input").val("");
        $("#CT_Num").val("");
        $("#CG_Num").val("");
        $("#EC_Piece").val("");
    
        //$("#EC_Intitule").val("");
        if(isContrepartie==0){
            $("#EC_Facture").val("");
            $("#EC_RefPiece").val("");
            //$("#EC_Jour").val("1");
        }
        $("#EC_MontantDebit").val("");
        $("#EC_MontantCredit").val("");
        $("#EC_Echeance").val("");
    }
    
    function clearAnal(){
        //$("#CA_Num_select :input").val("");
        $("#CA_Num").val("");
        $("#A_Qte").val("");
        $("#A_Montant").val("");
    }
    $("#saisieAnal").prop("disabled",true);

    $("#saisieAnal").click(function(){
        formAnalytique(EC_No);
    });

    $("#N_Analytique").change(function(){
        formAnalytique(EC_No);
    });

    function formAnalytique(valEC_No){
            
            $.ajax({
                url: 'traitement/Structure/Comptabilite/SaisieJournalExerciceAnal.php?acte=ligneAnal',
                method: 'GET',
                dataType: 'html',
                data : 'EC_No='+valEC_No+'&N_Analytique='+$("#N_Analytique").val(),
                async : false,
                success: function(data) {
                    $("#table_anal > tbody").html(data);
                    setDblClickAnal();
                    calculEnteteJournalAnal();
                    $("#CA_Num").empty();
                    $.ajax({
                        url: 'indexServeur.php?page=getPlanAnalytique',
                        method: 'GET',
                        dataType: 'json',
                        data: 'N_Analytique=' + $("#N_Analytique").val() + '&type=0',
                        async: false,
                        success: function (data) {
                            $.each(data, function(index, item) {
                                $("#CA_Num").append(new Option(item.CA_Num+" - "+item.CA_Intitule,item.CA_Num));
                            });
                        }
                    });
                }
            });
           $("#formAnalytique").dialog({
            resizable: false,
            height: "auto",
            width: 1000,
            modal: true,
            title : "Mode de règlement",
            buttons: {
                "Valider": function() {
                    if(EC_MontantImpute==totalMontantA)
                        $( this ).dialog( "close" );
                    else 
                        alert("La saisie n'est pas équilibrée !");
                    
                } 
            }
        });
    
    }
    function valideLigne(emodeler){
        var intitule = $("#EC_Intitule").val(),ec_reference = $("#EC_RefPiece").val(), ec_jour = $("#EC_Jour").val(), ec_ref = $("#EC_RefPiece").val()
        ,ec_montantdebit = $("#EC_MontantDebit").val().replace(" ",""), ec_montantcredit = $("#EC_MontantCredit").val().replace(" ",""),ec_position = $("#EC_Position").val()
        ,ec_echeance = $("#EC_Echeance").val(),ct_num = $("#CT_Num").val(),cg_num = $("#CG_Num").val();
        $.ajax({
            url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=modif',
            method: 'GET',
            dataType: 'html',
            data : 'nomFichier='+nomFichier+'&EC_Reference='+ec_reference+'&EC_No='+emodeler.find("#tabEC_No").html()+'&JO_Num='+$_GET("JO_Num")+'&Annee_Exercice='+$_GET("exercice")+'&EC_Jour='+ec_jour+'&EC_Piece=&EC_RefPiece='+ec_ref+'&CG_Num='+cg_num+'&CG_NumCont='+cg_num+'&CT_Num='+ct_num+'&CT_NumCont='+ct_num+'&EC_Intitule='+intitule+'&N_Reglement=1&EC_Echeance='+ec_echeance+'&EC_MontantCredit='+ec_montantcredit+'&EC_MontantDebit='+ec_montantdebit+'&TA_Code=0',
            async : false,
            success: function(data) {
                emodeler.find("#tabEC_Jour").html(ec_jour);
                emodeler.find("#tabEC_Piece").html($("#EC_Piece").val());
                emodeler.find("#tabEC_Facture").val($("#EC_Facture").val());
                emodeler.find("#tabEC_RefPiece").html(ec_ref);
                emodeler.find("#tabCG_Num").html(cg_num);
                emodeler.find("#tabCT_Num").html(ct_num);
                emodeler.find("#tabEC_Intitule").html(intitule);
                emodeler.find("#tabEC_Echeance").html(ec_echeance);
                emodeler.find("#tabEC_Position").html($("#EC_Position").val());
                emodeler.find("#tabEC_MontantDebit").html(ec_montantdebit);
                emodeler.find("#tabEC_MontantCredit").html(ec_montantcredit);
                calculEnteteJournal();
                clear();
                enleveAction ();
                validsaisAnal(cg_num);
                setDblClick();
                ajoutLigneOption();
                $("#CG_Num_select :input").focus();
            }
        });
    }
    
    
    
    function valideLigneAnal(emodeler){
        $.ajax({
            url: 'traitement/Structure/Comptabilite/SaisieJournalExerciceAnal.php?acte=modif',
            method: 'GET',
            dataType: 'html',
            data : 'cbMarq='+emodeler.find("#tabcbMarq").html()+'&CA_Num='+$("#CA_Num").val()+'&A_Qte='+$("#A_Qte").val()+'&A_Montant='+$("#A_Montant").val()+'&EC_No='+EC_No+"&N_Analytique="+$("#N_Analytique").val(),
            async : false,
            success: function(data) {
                emodeler.find("#tabCA_Num").html($("#CA_Num option:selected").text());
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
    
    
    function enleveAction (){
        $("#EC_Jour").unbind();
        $("#EC_Piece").unbind();
        $("#EC_Facture").unbind();
        $("#EC_RefPiece").unbind();
        $("#CG_Num_select").unbind();
        $("#CT_Num_select").unbind();
        $("#EC_Intitule").unbind();
        $("#EC_Echeance").unbind();
        $("#EC_Position").unbind();
        $("#EC_MontantDebit").unbind();
        $("#EC_MontantCredit").unbind();
    }
    function enleveActionAnal (){
        //$("#CA_Num_select").unbind();
        $("#A_Montant").unbind();
        $("#A_Qte").unbind();
    }
    
    function setDblClick (){
        $("td[id^='modif_']").each(function(){
            $(this).click(function() {
                var emodeler = $(this).parent();
                $(this).unbind();
                enleveAction();
                testChamps();
                inputMask();
                var cg_analytique = emodeler.find("#tabCG_Analytique").html();
                if(cg_analytique==0) {
                    $("#saisieAnal").prop("disabled",true);
                }
                else{
                    $("#saisieAnal").prop("disabled",false);
                    EC_No = emodeler.find("#tabEC_No").html();
                    if(emodeler.find("#tabEC_MontantDebit").html()!=0 && emodeler.find("#tabEC_MontantDebit").html()!="")
                        EC_MontantImpute = emodeler.find("#tabEC_MontantDebit").html().replace(" ","");
                    else 
                        EC_MontantImpute = emodeler.find("#tabEC_MontantCredit").html().replace(" ","");
                }
                $("#EC_Jour").val(emodeler.find("#tabEC_Jour").html());
                $("#EC_Piece").val(emodeler.find("#tabEC_Piece").html());
                $("#EC_Facture").val(emodeler.find("#tabEC_Facture").html());
                $("#EC_RefPiece").val(emodeler.find("#tabEC_RefPiece").html());
                $("#CT_Num").val(emodeler.find("#tabCT_Num").html());
                $("#CG_Num").val(emodeler.find("#tabCG_Num").html()); 
                $("#CT_Num_select :input").val($("#CT_Num option:selected").text());
                $("#CG_Num_select :input").val($("#CG_Num option:selected").text());
                $("#EC_Intitule").val(emodeler.find("#tabEC_Intitule").html());
                $("#EC_Echeance").val(emodeler.find("#tabEC_Echeance").html());
                $("#EC_Position").val(emodeler.find("#tabEC_Position").html());
                $("#EC_MontantDebit").val(emodeler.find("#tabEC_MontantDebit").html().replace(" ",""));
                $("#EC_MontantCredit").val(emodeler.find("#tabEC_MontantCredit").html().replace(" ",""));
                setDblClick ();
                actionModif(emodeler);
                
            });
        });
        
        $("td[id^='suppr_']").each(function(){
            $(this).click(function() {
                var emodeler = $(this).parent();
                    $.ajax({
                        url: 'traitement/Structure/Comptabilite/SaisieJournalExercice.php?acte=supprEcriture',
                        method: 'GET',
                        dataType: 'html',
                        data : 'EC_No='+emodeler.find("#tabEC_No").html(),
                        async : false,
                        success: function(data) {
                            emodeler.remove();
                            calculEnteteJournal();
                        }
                    });
            });
        });
    }
    setDblClick();
    
    
    
    function setDblClickAnal (){
        
        $("td[id^='modif_anal_']").each(function(){
            $(this).click(function() {
                var emodeler = $(this).parent();
                $(this).unbind();
                enleveActionAnal();
                testChampsAnal();
                $("#CA_Num option:contains("+emodeler.find("#tabCA_Num").html()+")").attr('selected', 'selected');
                //$("#CA_Num_select :input").val(emodeler.find("#tabCA_Num").html());
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
                    url: 'traitement/Structure/Comptabilite/SaisieJournalExerciceAnal.php?acte=suppr',
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
    
    $("#compteRat_select").keyup(
        function (event) {
        if(event.keyCode == 13){
            $("#CompteRattache").append("<option value='"+$("#compteRat").val()+"'>"+$(this).val()+"</option>");
            $(this).val("");
        } 
    });
    
    $("#CompteRattache").dblclick(function() {
        $("#CompteRattache option[value='"+$(this).find(":selected").val()+"']").remove();
    });
    
    
});
