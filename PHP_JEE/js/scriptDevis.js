jQuery(function($){ 
    //var lien="http://192.168.1.14:1820/api/";
    var montantht=0;
    var tva = 0;
    var precompte = 0;
    var marge = 0;
    var montantttc=0;
    var nbarticle=0;
    var modification = false;
    var pmin=0;
    var pmax=0;
    var lien="../../ServeurFacturationPHP/index.php?";
    if($("#n_doc").val()!=""){
        $(".comboclient").prop('disabled', true);
        $("#nclient").prop('disabled', true);
        
    }
    
    $("#depot").focusout(function(){
        $("#reference").html("");
        $("#designation").html("");
        $.ajax({
            url: "traitement/Transfert.php?acte=liste_article_source&depot="+$("#depot").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $.each(data, function(index, item) {
                    $("#reference").append(new Option(item.AR_Ref+" - "+item.AR_Design,item.AR_Ref));
                });
            }
        });
    });
    
    $("#prix").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event); 
        else isNumber($("#prix"),event);       
    });
    
    $("#remise").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event); 
        else isRemise($("#remise"),event);       
    });
    
    function isRemise(donnee,event){
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ((donnee.val().length >0 && event.keyCode >= 85 && (donnee.val().indexOf("U")<0 && donnee.val().indexOf("u")<0  && donnee.val().indexOf("%")<0)) || 
                (event.keyCode >= 48 && event.keyCode <= 57 &&(donnee.val().indexOf("U")<0 && donnee.val().indexOf("u")<0  && donnee.val().indexOf("%")<0)) || 
            (event.keyCode >= 96 && event.keyCode <= 105 && (donnee.val().indexOf("U")<0 && donnee.val().indexOf("u")<0 && donnee.val().indexOf("%")<0)) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || (donnee.val().length >0 && donnee.val().indexOf(".")<0 && donnee.val().indexOf(",")<0 && event.keyCode == 188) || (donnee.val().length >0 && donnee.val().indexOf(".")<0  && donnee.val().indexOf(",")<0 && event.keyCode == 110)) {

        } else {
            event.preventDefault();
        }
    }
    
    function isNumber(donnee,event){
        if (event.shiftKey == true) {
            event.preventDefault();
        }
        if ((event.keyCode >= 48 && event.keyCode <= 57) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || (donnee.val().indexOf(".")<0 && donnee.val().indexOf(",")<0 && event.keyCode == 188) || (donnee.val().indexOf(".")<0  && donnee.val().indexOf(",")<0 && event.keyCode == 110)) {

        } else {
            event.preventDefault();
        }
    }
    var protect = 0;
  
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_DOCUMENT_VENTE_DEVIS;
                    if(protect==1){
                        $(".comboclient").prop('disabled', true);
                        $("#cat_tarif").prop('disabled', true);
                        $("#cat_compta").prop('disabled', true);
                        $("#caisse").prop('disabled', true);
                        $("#souche").prop('disabled', true);
                        $("#affaire").prop('disabled', true);
                        $("#dateentete").prop('disabled', true);
                        $("#depot").prop('disabled', true);
                        $("#collaborateur").prop('disabled', true);
                        $("#ref").prop('disabled', true);
                        $("#n_doc").prop('disabled', true);
                        $(".comboreference").prop('disabled', true);
                        $("#designation").prop('disabled', true);
                        $("#quantite").prop('disabled', true);
                        $("#prix").prop('disabled', true);
                        $("#quantite_stock").prop('disabled', true);
                        $("#remise").prop('disabled', true);
                        $("#valider").prop('disabled', true);
                        $("#annuler").prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection(); 
    
    if($("#reference").val()!=""){
        $("#reference").prop('disabled', true);
    }
  
    $('#mtt_avance').prop('disabled', true);
    $( ".valideReglement" ).hide();
    
    $("#liste_reglement").hide();
    
    $("#nclient").click(function(){
        $("#nouveauClient").dialog({
            resizable: false,
            height: "auto",
            width: 700,
            modal: true
        });
    });
    
    
    function actionClient(val){
        $(".comboclient").prop('disabled', val);
        $('#cat_tarif').prop('disabled', val);
        $('#cat_compta').prop('disabled', val);
        $("#dateentete").prop('disabled', val);
    }
    $("#nouveauClient").hide();

    $('#ajouterClient').click(function () {
        $('#nouveauClient').dialog('close');
    });
    
    
    $(".comboreference").prop('disabled', true);
    
    $( ".comboreference" ).focusout(function() {
        $.ajax({
           url: "indexServeur.php?page=getArticleByRef&AR_Ref="+$("#reference").val(),
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $("#designation").val(data[0].AR_Design);
                valideReference($("#reference").val());
            }
        });
    });
    
    $("#collaborateur").focusout(function(){
        if($("#n_doc").val()!="")
            $.ajax({
            url: "traitement/Facturation.php?acte=maj_collaborateur&collab="+$("#collaborateur").val()+"&entete="+$("#n_doc").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {

            }
        });
    });
    
    function valideReference(reference){
        $.ajax({
            url: "indexServeur.php?page=getPrixClient&AR_Ref="+reference+"&N_CatTarif="+$("#cat_tarif").val()+"&N_CatCompta="+$("#cat_compta").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $( ".comboreference").val(reference+" - "+data[0].AR_Design);
                pmin = Math.round(data[0].Prix_Min*100)/100;
                pmax = Math.round(data[0].Prix_Max*100)/100;
                $.ajax({
                url: 'indexServeur.php?page=isStock&AR_Ref='+reference+'&DE_No='+$("#depot").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $("#quantite_stock").val(Math.round(data[0].AS_QteSto));
                }
                });
                $("#prix").val(Math.round((data[0].PrixVente)*100)/100);
                $("#taxe1").val(data[0].taxe1);
                $("#taxe2").val(data[0].taxe2);
                $("#taxe3").val(data[0].taxe3);
            }
          });
    }
    
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
    
    if($_GET("visu")==1){
        $("#ref").prop('disabled', true);
        $(".comboreference").prop('disabled', true);
        
        $(".comboDepotSource").prop('disabled', true);
        $(".comboDepotDest").prop('disabled', true);
        $("#prix").prop('disabled', true);
        $("#remise").prop('disabled', true);
        $("#quantite").prop('disabled', true);
        $("#annuler").hide();
        $("#valider").hide();
        $("#liste_reglement").show("slow");
    }
    
    $("#cat_tarif").change(function(){
        if($(".comboreference").val()!="")
            valideReference($("#reference").val());
    });
    
    $("#cat_compta").change(function(){
        if($(".comboreference").val()!="")
            valideReference($("#reference").val());
    });
    function ajout_entete(){
        if($('.comboclient').val()!=""){
            if($('#n_doc').val()==""){
                $.ajax({
                    url: "traitement/Devis.php?acte=ajout_entete&souche="+$("#souche").val()+"&de_no="+$("#depot").val()+"&date="+$("#dateentete").val()+"&client="+$("#client").val()+"&reference="+$("#ref").val()+"&co_no="+$("#collaborateur").val()+"&cat_compta="+$("#cat_compta").val()+"&cat_tarif="+$("#cat_tarif").val()+"&ca_no="+$("#caisse").val(),
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $("#n_doc").val(data.entete);
                        $('#cat_tarif').prop('disabled', false);
                        $('#caisse').prop('disabled', true);
                        $('#cat_compta').prop('disabled', true);
                        $("#reference").prop('disabled', true);
                        $("#souche").prop('disabled', true);
                        $("#nclient").prop('disabled', true);
                        $("#depot").prop('disabled', true);
                        if($("#ref").val()!="") 
                        $("#ref").prop('disabled', true);
                        $("#dateentete").prop('disabled', true);
                        $(".comboclient").prop('disabled', true);
                        $(".comboreference").prop('disabled', false);
                        $("#prix").prop('disabled', false);
                        $("#remise").prop('disabled', false);
                        $("#quantite").prop('disabled', false);
                    }
                });
            }else {
                $.ajax({
                    url: "traitement/Facturation.php?acte=maj_client&client="+$("#client").val()+"&entete="+$("#n_doc").val(),
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {

                    }
                });
            }
        }
    };
    
    $('.comboclient').keydown(function (e){
        if(e.keyCode == 13){
            ajout_entete();
        }
    });
    
    $('#ref').keydown(function (e){
        if(e.keyCode == 13){
            ajout_entete();
        }
    });
    
    $('#dateentete').keydown(function (e){
        if(e.keyCode == 13){
            ajout_entete();
        }
    });
    $('#ref').focusout(function() {
        if($("#ref").val()!=""){
            $.ajax({
                url: "traitement/Devis.php?acte=ajout_reference&entete="+$("#n_doc").val()+"&reference="+$("#ref").val(),
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    $("#ref").prop('disabled', true);
                }
              });
        }
    });
    
    $( "#dateentete" ).focusout(function() {
        if($("#ref").val()!=""){
            $.ajax({
                url: "traitement/Facturation.php?acte=ajout_date&entete="+$("#n_doc").val()+"&date="+$("#dateentete").val(),
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                }
              });
        }
    });
    
    $( "#dialog-confirm" ).hide();
    $('.col-md-2').on('keydown', '#quantite', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    

          
    $('.message a').click(function(){
       $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
    
    $('#imprimer').click(function(){
        if($_GET("visu")!=null)
            window.open("etatspdf/devispdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val(),'_blank');
        else
            window.open("etatspdf/devispdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val(),'_blank');
        window.location.replace("indexMVC.php?module=2&action=2"); 

    });

    $('#valider').click(function(){
        $("#add_err").css('display', 'none', 'important');
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Devis enregistré!</div>');
        window.location.replace("indexMVC.php?module=2&action=2"); 
    });
    
    $('#quantite').keydown(function (e){
       ajout_ligne(e); 
    });

    function ajout_ligne(e){
        if(e.keyCode == 13){
            var valfloat = (Math.round($("#prix").val()*100)/100);
            if(parseFloat(valfloat)>=parseFloat(pmin) && parseFloat(valfloat)<=parseFloat(pmax)){
            var acte="ajout_ligne";
            if(modification){
                modification=false;
                acte = "modif";
                $.ajax({
                url: "traitement/Devis.php?cat_tarif="+$("#cat_tarif").val()+"&cat_compta="+$("#cat_compta").val()+"&acte="+acte+"&entete="+$("#n_doc").val()+"&DE_No="+$("#depot").val()+"&quantite="+$("#quantite").val()+"&designation="+$(".comboreference").val()+"&prix="+$("#prix").val()+"&remise="+$("#remise").val()+"&cbMarq="+$("#cbMarq").val()+"&ADL_Qte="+$("#ADL_Qte").val(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var remise = data[0].DL_Remise;
                    var type_rem ="P";
                    if(remise.length!=0){
                        if(remise.indexOf("%")>=0){
                            remise=remise.replace("%","");
                            type_rem="P";
                        }
                        if(remise.indexOf("U")>=0){
                            remise=remise.replace("U","");
                            type_rem="U";
                        }
                    }else remise=0;
                    var rem=0;
                    if(type_rem=="U") 
                        rem = remise;
                    if(type_rem =="P")  
                        rem = data[0].DL_PrixUnitaire * remise / 100;   
                        montantht_min=Math.round((data[0].DL_PrixUnitaire- rem)*data[0].DL_Qte);
                        tva_min = Math.round((montantht_min * $("#taxe1").val())/100);
                        precompte_min = Math.round((montantht_min * $("#taxe2").val())/100);
                        marge_min = Math.round((montantht_min * $("#taxe3").val())/100);
                        montantttc_min= Math.round((montantht_min+tva_min+precompte_min)+marge_min);

                    $("#article_"+$("#cbMarq").val()).find("#DL_Qte").html(Math.round(data[0].DL_Qte));
                    $("#article_"+$("#cbMarq").val()).find("#DL_Remise").html(data[0].DL_Remise);
                    $("#article_"+$("#cbMarq").val()).find("#DL_MontantTTC").html(montantttc_min);
                    $("#article_"+$("#cbMarq").val()).find("#DL_MontantHT").html(montantht_min);
                    $('.comboreference').prop('disabled', false);
                    $('.comboreference').val("");
                    $('#designation').val("");
                }
              });
            }else{
                var cbmarq="";
            $.ajax({
            url: "traitement/Devis.php?cat_tarif="+$("#cat_tarif").val()+"&cat_compta="+$("#cat_compta").val()+"&acte="+acte+"&entete="+$("#n_doc").val()+"&quantite="+$("#quantite").val()+"&DE_No="+$("#depot").val()+"&designation="+$("#reference").val()+"&prix="+$("#prix").val()+"&remise="+$("#remise").val()+"&cbMarq="+$("#cbMarq").val()+"&ADL_Qte="+$("#ADL_Qte").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                    cbmarq=data[0].cbMarq;
                    nbarticle=nbarticle+1;
                    var remise = data[0].DL_Remise;
                    var type_rem ="P";
                    if(remise.length!=0){
                        if(remise.indexOf("%")>=0){
                            remise=remise.replace("%","");
                            type_rem="P";
                        }
                        if(remise.indexOf("U")>=0){
                            remise=remise.replace("U","");
                            type_rem="U";
                        }
                    }else remise=0;
                    var rem=0;
                    if(type_rem=="U") 
                        rem = remise;
                    if(type_rem =="P")  
                        rem = data[0].DL_PrixUnitaire * remise / 100;   
                        montantht_min=Math.round((data[0].DL_PrixUnitaire- rem)*data[0].DL_Qte);
                        tva_min = Math.round((montantht_min * $("#taxe1").val())/100);
                        precompte_min = Math.round((montantht_min * $("#taxe2").val())/100);
                        marge_min = Math.round((montantht_min * $("#taxe3").val())/100);
                        montantttc_min= Math.round((montantht_min+tva_min+precompte_min)+marge_min);
                    var new_item = $("<tr id='article_"+data[0].cbMarq+"'><td id='AR_Ref'>"+data[0].AR_Ref+"</td><td id='DL_Design'>"+data[0].DL_Design+
                "</td><td id='DL_PrixUnitaire'>"+(Math.round(data[0].DL_PrixUnitaire*100)/100)+"</td><td id='DL_Qte'>"+Math.round(data[0].DL_Qte)+"</td><td id='DL_Remise'>"+data[0].DL_Remise+
                "</td><td id='DL_MontantHT'>"+montantht_min+"</td><td id='DL_MontantTTC'>"+montantttc_min+"</td><td style='display:none' id='cbMarq'>"+data[0].cbMarq+
                "</td><td>M</td><td id='suppr_"+data[0].cbMarq+"'>X</td></tr>").hide();
                    $("#article_body").append(new_item).on('click', '#article_'+data[0].cbMarq, function () {
                    $('.comboreference').prop('disabled', true);
                    $('#reference').val($(this).find("#DL_Design").html());
                    $('#designation').val($(this).find("#DL_Design").html());
                    $('.comboreference').val($(this).find("#AR_Ref").html());
                    $('#remise').val($(this).find("#DL_Remise").html());
                    $('#prix').val($(this).find("#DL_PrixUnitaire").html());
                    $('.comboreference').val($(this).find("#AR_Ref").html());
                    $('#quantite').val($(this).find("#DL_Qte").html());
                    $('#ADL_Qte').val($(this).find("#DL_Qte").html());
                    $('#cbMarq').val($(this).find("#cbMarq").html());
                    modification=true;
                }).on('click', '#suppr_'+data[0].cbMarq, function () {
                    $.ajax({
                        url: "traitement/Devis.php?acte=suppr&id="+data[0].cbMarq+"&AR_Ref="+data[0].AR_Ref+"&DL_Qte="+$("#article_"+data[0].cbMarq).find("#DL_Qte").html()+"&AR_PrixAch="+data[0].DL_CMUP+"&DE_No="+$("#depot").val(),
                        method: 'GET',
                        dataType: 'html',
                        success: function(data) {
                            modification=false;
                            $('.comboreference').prop('disabled', false);
                            $("#article_"+cbmarq).fadeOut(300, function() { $(this).remove(); });
                            calculTotal();
                            nbarticle=nbarticle-1;
                            if(nbarticle>0){
                                actionClient(true);
                            }
                            else{
                                actionClient(false);
                            }
                        }
                    });
                });
                if(nbarticle>0){
                    actionClient(true);
                }
                else{
                    actionClient(false);
                }
                new_item.show('normal');
            }
            });
        }
        
    calculTotal();
    } else alert("Le prix doit être compris entre "+pmin+" et "+pmax);
}    
    }
    
function calculTotal(){
    var montantht=0;
    var montantht_brut=0;
    var tva = 0;
    var precompte = 0;
    var marge = 0;
    var montantttc=0;
    var taxe1=0;
    var taxe2=0;
    var taxe3=0;
    var i=0;
    $.ajax({
            url: "traitement/Facturation.php?acte=liste_article&entete="+$("#n_doc").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    var classe = "";
                    if(i%2==0) classe = "info";
                    else classe="";
                    i=i+1;
                    var cbMarq= this.cbMarq;
                    var AR_Ref= this.AR_Ref;
                    var DL_Qte= this.DL_Qte;
                    var DL_CMUP= this.DL_CMUP;
                    var remise = this.DL_Remise;
                    var type_rem ="P";
                    if(remise.length!=0){
                        if(remise.indexOf("%")>=0){
                            remise=remise.replace("%","");
                            type_rem="P";
                        }
                        if(remise.indexOf("U")>=0){
                            remise=remise.replace("U","");
                            type_rem="U";
                        }
                    }else remise=0;
                    var rem=0;
                    if(type_rem=="U") 
                        rem = remise;
                    if(type_rem =="P")  
                        rem = this.DL_PrixUnitaire * remise / 100;   
                        montantht=montantht + Math.round((this.DL_PrixUnitaire- rem)*this.DL_Qte);
                        montantht_brut=montantht_brut + ((this.DL_PrixUnitaire- rem)*this.DL_Qte);
                        taxe1=this.DL_Taxe1;
                        taxe2=this.DL_Taxe2;
                        taxe3=this.DL_Taxe3;
            });
            tva= ((montantht_brut * taxe1)/100);
            precompte = ((montantht_brut * taxe2)/100);
            marge = ((montantht_brut * taxe3)/100);
            montantttc= Math.round(montantht+tva+precompte+marge);
            if(i>0){
                $('#imprimer').prop('disabled', false);
                $('#annuler').prop('disabled', false);
                $('#valider').prop('disabled', false);
            }else {
                $('#imprimer').prop('disabled', true);
                $('#annuler').prop('disabled', true);
                $('#valider').prop('disabled', true);
            }
            $("#totalht").html(montantht);
            $("#totaltva").html(Math.round(tva));
            $("#totalprecompte").html(Math.round(precompte));
            $("#totalmarge").html(Math.round(marge));
            $("#totalttc").html(montantttc);
            $('.comboreference').val("");
            $('#designation').val("");
            $("#quantite").val("");
            $("#prix").val("");
            $("#quantite_stock").val("");
            $("#remise").val("");
        }
    });
    
   
}
 
    $('#credit').click(function(){
        if($('#credit').is(':checked')){
            $('#comptant').prop('checked', false);
            $('#mtt_avance').prop('disabled', false);
            $('#mtt_avance').val($("#totalttc").html());
        }
    });
        
    $('#comptant').click(function(){
        if($('#comptant').is(':checked')){
            $('#credit').prop('checked', false);
            $('#mtt_avance').prop('disabled', true);
        }
    });
        
    $('#annuler').click(function(){
        alert("pas encore géré");
    });
        
    $("tr[id^='article']").click(function() {
        $('#reference').val($(this).find("#DL_Design").html());
        $('#designation').val($(this).find("#DL_Design").html());
        $('.comboreference').val($(this).find("#AR_Ref").html());
        $('#remise').val($(this).find("#DL_Remise").html());
        $('#prix').val($(this).find("#DL_PrixUnitaire").html());
        $('.comboreference').val($(this).find("#AR_Ref").html());
        $('#quantite').val($(this).find("#DL_Qte").html());
        $('#ADL_Qte').val($(this).find("#DL_Qte").html());
        $('#cbMarq').val($(this).find("#cbMarq").html());
        modification=true;
    });
        
    $('.comboreference').val("");
    
});