jQuery(function($){ 
    var modification = false;
    var lien="../../ServeurFacturationPHP/index.php?";
    var protect = 0;
    var listeMouvement;
    var impressionMouvement;
    var jeton = 0;
    var do_domaine = 0;
    var do_type= 0;
    var societe = "";

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
        })

    $("#dateentete").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    if($_GET("entete")==undefined) {
        $("#dateentete").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    };

    $( "#client" ).combobox();
    $( "#reference" ).combobox();
    $( "#reference_dest" ).combobox();
    $("#depot").combobox();
    $("#collaborateur").combobox();
    var cmp = 0;
    $(".custom-combobox").each(function(){
        if(cmp==0) $(this).find("input").addClass("comboDepotSource");
        if(cmp==1)
            if($_GET("type")=="Entree" || $_GET("type")=="Sortie")
                $(this).find("input").addClass("comboreference");
            else{
                $(this).find("input").addClass("comboDepotDest");
                $(this).css("width","");
            }
        if(cmp==2)
            if($_GET("type")!="Entree")
                $(this).find("input").addClass("comboreference");
            
        if(cmp==3)
            if($_GET("type")=="Transfert_detail")
                $(this).find("input").addClass("comboreferenceDest");
            
        cmp=cmp+1;
    });
    $(".comboreference").prop('disabled', true); 
    $(".comboreferenceDest").prop('disabled', true); 
    $(".comboreferenceDest").val("");    
    $(".comboDepotSource").val("");
    
    
    function getContrib(){
        $.ajax({
           url: "indexServeur.php?page=getNumContribuable",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    societe = this.D_RaisonSoc;
                });
            }
        });
    }
    getContrib();

    function alimLigne(){
        $("#tableLigne > tbody").html("");
        $.ajax({
            url: 'traitement/Facturation.php?acte=ligneFactureStock',
            method: 'GET',
            dataType: 'html',
            async: false,
            data : "cbMarqEntete="+$("#EntetecbMarq").val()+"&typeFac="+$_GET("type")+"&flagPxRevient="+$("#flagPxRevient").val(),
            success: function(data) {
                $("#tableLigne > tbody").html(data);
            },
            error : function (data){

            }
        });
    }

  function fichierTraitement(){
        var fich = $_GET("type");
        if(fich=="Transfert"){
            do_domaine = 2;
            do_type= 23;
            listeMouvement="indexMVC.php?module=4&action=1&type="+fich;
            if(societe=="SECODI SECODI"){
                if($_GET("entete")!=null)
                    impressionMouvement="etatspdf/MvtTransfertpdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val()+"&type="+fich;
                else
                    impressionMouvement="etatspdf/MvtTransfertpdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val()+"&type="+fich;
           }else
               if($_GET("entete")!=null)
                impressionMouvement="etatspdf/MvtTransfertpdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val()+"&type="+fich;
            else
                impressionMouvement="etatspdf/MvtTransfertpdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val()+"&type="+fich;
            return "Transfert.php";
        }
        if(fich=="Transfert_detail"){
            
            do_domaine = 0;
            do_type= 0;
            listeMouvement="indexMVC.php?module=4&action=9&type="+fich;
            if(societe=="SECODI SECODI"){
                if($_GET("entete")!=null)
                    impressionMouvement="etatspdf/MvtTransfertpdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val()+"&type="+fich;
                else
                    impressionMouvement="etatspdf/MvtTransfertpdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val()+"&type="+fich;
           }else
               if($_GET("entete")!=null)
                impressionMouvement="etatspdf/MvtTransfertpdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val()+"&type="+fich;
            else
                impressionMouvement="etatspdf/MvtTransfertpdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val()+"&type="+fich;
            return "Transfert_detail.php";
        }
        if(fich=="Entree"){
            do_domaine = 2;
            do_type= 20;
            listeMouvement="indexMVC.php?module=4&action=3&type="+fich;
            if(societe=="SECODI SECODI"){
                if($_GET("entete")!=null)
                    impressionMouvement="etatspdf/MvtEntreepdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val()+"&type="+fich;
                else
                    impressionMouvement="etatspdf/MvtEntreepdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val()+"&type="+fich; 
           }else
               if($_GET("entete")!=null)
                impressionMouvement="etatspdf/MvtEntreepdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val()+"&type="+fich;
            else
                impressionMouvement="etatspdf/MvtEntreepdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val()+"&type="+fich;    
            return "Entree.php";
        }
        if(fich=="Sortie"){
            do_domaine = 2;
            do_type= 21;
            listeMouvement="indexMVC.php?module=4&action=4&type="+fich;
            if(societe=="SECODI SECODI"){
                if($_GET("entete")!=null)
                    impressionMouvement="etatspdf/MvtSortiepdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val()+"&type="+fich;
                else
                    impressionMouvement="etatspdf/MvtSortiepdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val()+"&type="+fich; 
           }else
               if($_GET("entete")!=null)
                impressionMouvement="etatspdf/MvtSortiepdf.php?entete="+$_GET("entete")+"&CT_Num="+$("#client").val()+"&type="+fich;
            else
                impressionMouvement="etatspdf/MvtSortiepdf.php?entete="+$("#n_doc").val()+"&CT_Num="+$("#client").val()+"&type="+fich;    
            return "Sortie.php";
        }
        return "";
    }
    fichierTraitement();
    
    
    function entete_document(){
        if(($_GET("modif")==undefined && $_GET("visu")==undefined))
           $.ajax({
                url: 'traitement/Facturation.php?acte=entete_document',
                method: 'GET',
                dataType: 'json',
                async:false,
                data : 'do_souche=0&type_fac='+$_GET("type"),
                success: function(data) {
                    $("#n_doc").val(data.DC_Piece);
                }
            });
    }
    entete_document();
    var affichePxRevient = $("#flagPxRevient").val();
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_DOCUMENT_STOCK;
/*                    if(protect==1){
                        $(".comboclient").prop('disabled', true);
                        $("#cat_tarif").prop('disabled', true);
                        $("#cat_compta").prop('disabled', true);
                        $(".comboDepotSource").prop('disabled', true);
                        $(".comboDepotDest").prop('disabled', true);
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
                    */
                });
            }
        });
    }
    
    protection();

    $("#prix").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event);
        //else isNumber($("#prix"),event);       
    });
    $("#carat").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event);
        //else isNumber($("#prix"),event);
    });
    $("#quantite_dest").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event); 
        //else isNumber($("#prix"),event);       
    });
    
    $("#remise").keydown(function (event) {
        if(event.keyCode == 13)ajout_ligne(event); 
        else isRemise($("#remise"),event);       
    });
    
    $("#quantite_dest").keyup(function(){
        calculPrixDest();
    });
    
    $("#quantite").keyup(function(){
        calculPrixDest();
    });
    
    $("#prix").keyup(function(){
        calculPrixDest();
    });


    var negatif = true;
    if(($_GET("type")=="Vente" || $_GET("type")=="BonLivraison" || $_GET("type")=="VenteC" || $_GET("type")=="Achat" || $_GET("type")=="AchatC")&& $("#qte_negative").val()!=0)
        negatif = false;

    $("#prix").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0.00',
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

    function calculPrixDest(){
        var pfinal=0;
        if($("#quantite_dest").val()!=0)
            pfinal = Math.round(($("#prix").val().replace(/ /g,"")*$("#quantite").val().replace(/ /g,""))/$("#quantite_dest").val()*100)/100;
        if($("#quantite").val().replace(/ /g,"")!="" &&  $("#prix").val().replace(/ /g,"")!="" && $("#quantite_dest").val()!="")
                $("#prix_dest").val(pfinal);
    }
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

    if($_GET("visu")==1){
        calculTotal();
        $(".comboDepotSource").val($("#depot option:selected").text());
        $(".comboDepotDest").val($("#collaborateur option:selected").text());
        $("#ref").prop('disabled', true);
        $(".comboreference").prop('disabled', true);
        $("#designation").prop('disabled', true);
        $(".comboreferenceDest").prop('disabled', true);
        $("#designation_dest").prop('disabled', true);
        $("#prix").prop('disabled', true);
        $("#remise").prop('disabled', true);
        $("#quantite").prop('disabled', true);
        $("#quantite_dest").prop('disabled', true);
        $(".comboDepotSource").prop('disabled', true);
        $(".comboDepotDest").prop('disabled', true);
        $("#annuler").hide();
        $("#valider").hide();
        $("#imprimer").prop('disabled', false);
        bloque_entete();
    }


    var visu = $_GET("visu");
    if (visu != 1 && $("#do_imprim").val() == 1) {
        $(".comboDepotSource").val($("#depot option:selected").text());
        $(".comboDepotDest").val($("#collaborateur option:selected").text());
        $("#ref").prop('disabled', true);
        $(".comboreference").prop('disabled', true);
        $("#designation").prop('disabled', true);
        $(".comboreferenceDest").prop('disabled', true);
        $("#designation_dest").prop('disabled', true);
        $("#prix").prop('disabled', true);
        $("#remise").prop('disabled', true);
        $("#quantite").prop('disabled', true);
        $("#quantite_dest").prop('disabled', true);
        $(".comboDepotSource").prop('disabled', true);
        $(".comboDepotDest").prop('disabled', true);
        $("#annuler").hide();
        $("#valider").hide();
        $("#imprimer").prop('disabled', false);
        bloque_entete();
        !$("#form-ligne :input").hide();
        $("td[id^='modif_']").each(function () {
            $(this).hide();
        });
        $("td[id^='suppr_']").each(function () {
            $(this).hide();
        });
        /**/

    }

    function bloque_entete(){
        $(".comboDepotSource").prop('disabled', true);
        $("#souche").prop('disabled', true);
        $("#affaire").prop('disabled', true);
        $(".comboDepotDest").prop('disabled', true);
        $("#dateentete").prop('disabled', true);

    }
    
    if($_GET("modif")==1){
        bloque_entete();
        calculTotal();
        $(".comboDepotSource").val($("#depot option:selected").text());
        $(".comboDepotDest").val($("#collaborateur option:selected").text());
        $(".comboreference").prop("disabled",false);
        $("#quantite").prop("disabled",false);
        $("#carat").prop("disabled",false);
        $(".comboreferenceDest").prop("disabled",false);
        $("#quantite_dest").prop("disabled",false);
        $("#prix").prop("disabled",false);
        $("#remise").prop("disabled",false);
    }

    function returnDate(str){
        return "20"+str.substring(4,6)+"-"+str.substring(2,4)+"-"+str.substring(0,2);
    }
    function returnDateRglt(str){
        return "20"+str.substring(4,6)+"-"+str.substring(0,2)+"-"+str.substring(2,4);
    }
    $("#dateentete").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    if($("#n_doc").val()!=""){
        $(".comboclient").prop('disabled', true);
        $("#nclient").prop('disabled', true);     
    }
    if($("#reference").val()!=""){
        $("#reference").prop('disabled', true);
    }
    
    $( ".comboreference" ).focusout(function() {
        $.ajax({
           url: "indexServeur.php?page=getArticleByRef&AR_Ref="+$("#reference").val(),
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                if($(".comboreference").val()!=""){
                    $("#designation").val(data[0].AR_Design);
                    $( ".comboreference").val($("#reference").val()+" - "+data[0].AR_Design);
                    if(!modification) $("#prix").val(Math.round(data[0].AR_PrixAch*100)/100);
                    alimente_qteStock($("#reference").val());
                }
            }
        });
    });
    
    
    $( ".comboreferenceDest" ).focusout(function() {
        $.ajax({
           url: "indexServeur.php?page=getArticleByRef&AR_Ref="+$("#reference_dest").val(),
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $("#designation_dest").val(data[0].AR_Design);
                $( ".comboreferenceDest").val($("#reference_dest").val()+" - "+data[0].AR_Design);
        
            }
        });
    });
    
    function valideReference(reference){
        var AR_Ref = reference;
        $.ajax({
            url: "indexServeur.php?page=getPrixClient&AR_Ref="+reference+"&N_CatTarif=1&N_CatCompta=1",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                alimente_qteStock(reference);
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
    
    $('.comboDepotDest').keydown(function (e){
        if(e.keyCode == 13){
            valideEntete();
        }
    });
    
    $('#ref').keydown(function (e){
        if(e.keyCode == 13 && $("#n_doc").val()==""){
            valideEntete();
        }
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

    function valideEntete(){
        var affaire = "";
        if(($_GET("type")!="Transfert" && $(".comboDepotSource").val()!="") || ($_GET("type")=="Transfert" && $(".comboDepotSource").val()!=$(".comboDepotDest").val())){
        if($("#affaire").val()!="null") affaire = $("#affaire").val();
        $.ajax({
            url: "traitement/"+fichierTraitement()+"?type_fac="+$_GET("type")+"&do_type="+do_type+"&do_domaine="+do_domaine+"&do_piece="+$("#n_doc").val()+"&acte=ajout_entete&date="+returnDate($("#dateentete").val())+"&collaborateur="+$("#collaborateur").val()+"&depot="+$("#depot").val()+ "&reference="+$("#ref").val()+ "&affaire="+affaire+"&userName="+$("#userName").html()+"&machineName="+$("#machineName").html(),
            method: 'GET',
            async : false,
            dataType: 'json',
            success: function(data) {
                jeton=0;
                $("#n_doc").val(data.entete);
                $("#EntetecbMarq").val(data.cbMarq);
                $("#client").prop('disabled', true);
                $(".comboDepotSource").prop('disabled', true);
                $(".comboDepotDest").prop('disabled', true);
                $("#reference").prop('disabled', true);
                $("#nclient").prop('disabled', true);
                $(".comboarticle").prop('disabled', false);
                $("#dateentete").prop('disabled', true);
                $(".comboreference").prop('disabled', false);
                $(".comboreferenceDest").prop('disabled', false);
                if($_GET("type")!="Sortie") $("#prix").prop('disabled', false);
                $("#remise").prop('disabled', false);
                $("#quantite").prop('disabled', false);
                $("#quantite_dest").prop('disabled', false);
                if($("#database").val()==1){
                    $('#carat').prop('disabled', false);
                }
                $("#designation").html();
                $("#reference").html();
                listeDepot ();
                //listeDepotDest ();
                $(".comboreference").focus();

    },
            error : function(resultat, statut, erreur){
                alert(resultat.responseText);
            }
    });
        }
    }



    $('#dateentete').keydown(function (e){
        if(e.keyCode == 13){
            valideEntete();
        }
    });

    $('#ref').keydown(function (e){
        if(e.keyCode == 13){
            valideEntete();
        }
    });
    
    
    $('.comboDepotSource').keydown(function (e){
        if(e.keyCode == 13){
            valideEntete();    
        }
    });
    
    $('#ref').focusout(function() {
        if($("#ref").val()!=""){
            $.ajax({
                url: "traitement/Transfert.php?acte=ajout_reference&entete="+$("#n_doc").val()+"&reference="+$("#ref").val(),
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                }
              });
        }
        
    });
    
    $( "#dateentete" ).focusout(function() {
        $.ajax({
            url: "traitement/Facturation.php?acte=ajout_date&entete="+$("#n_doc").val()+"&date="+returnDate($("#dateentete").val()),
            method: 'GET',
            dataType: 'html',
            success: function(data) {
            }
        });
    });
    
    $( "#dialog-confirm" ).hide();
    $('.col-md-2').on('keydown', '#quantite', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    

          
    $('.message a').click(function(){
       $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
    
    $('#imprimer').click(function(){
        if($_GET("visu")!=null)
            choixFormat();
        else
            choixFormat();
    });

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
        $("<div>Choix du format</div>").dialog({
            resizable: false,
            height: "auto",
            width: "100",
            modal: true,
            buttons: {
                "A4": {
                    class: 'btn btn-primary',
                    text: 'A4',
                    click: function () {
                        window.open(impressionMouvement + "&format=A4", '_blank');
                        window.location.replace(listeMouvement);
                    }
                },
                "A5": {
                    class: 'btn btn-primary',
                    text: 'A5',
                    click: function () {
                        window.open(impressionMouvement + "&format=A5", '_blank');
                        window.location.replace(listeMouvement);
                    }
                }
            }
        });
    }
    $('#valider').click(function(){
        window.location.replace(listeMouvement); 
        $("#add_err").css('display', 'none', 'important');
        $("#add_err").css('display', 'inline', 'important');
        var typMvt = "";
        if($_GET("type")=="Sortie") typMvt = " de sortie ";
        if($_GET("type")=="Entree") typMvt = " d'entrée ";
        if($_GET("type")=="Transfert") typMvt = " de transfert ";
        if($_GET("type")=="Transfert_detail") typMvt = " de transfert ";
        alert('Mouvement '+typMvt+' enregistré!');
	$("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Mouvement '+typMvt+' enregistré!</div>');
    });
        
    $(".comboDepotSource").focusout(function(){
        listeDepot ();
    }); 
        if($_GET("modif")==1)
            listeDepot ();
    function listeDepot (){
        if($_GET("type")!="Entree"){
            var urlliste ="traitement/Transfert.php?acte=liste_article_source&depot="+$("#depot").val()+"&type="+$_GET("type");
            if($_GET("type")=="Transefert_detail")
                urlliste = "indexServeur.php?page=getAllArticleDispoByArRefTrsftDetail&depot"+$("#depot").val();
            $("#reference").html("");
            $("#designation").html("");
            $.ajax({
                url: urlliste,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(index, item) {
                        if(item.AR_Sommeil==0)
                        $("#reference").append(new Option(item.AR_Ref+" - "+item.AR_Design,item.AR_Ref));
                    });
                }
            });
        }
    }

    $('#quantite').keydown(function (e){
       ajout_ligne(e); 
    });
    
    function verifLigne(){
        if($("#quantite").val().replace(/ /g,"")!="" && $("#quantite_dest").val()!="" && $("#prix").val().replace(/ /g,"")!="" && $(".comboreference").val()!="" && $(".comboreferenceDest").val()!="" )
            return true;
        else return false;
    }
    function ajout_ligne(e){
        //if($("#quantite").val()>0){
        if(e.keyCode == 13){
            if(($_GET("type")=="Transfert_detail" && verifLigne()) || $_GET("type")!="Transfert_detail"){
                    var compl_dest = "";
                    if($_GET("type")=="Transfert_detail"){
                        var complref="";
                        if(!modification)
                            complref="&designation_dest="+$("#reference_dest").val();
                        else
                            complref="&designation_dest="+$(".comboreferenceDest").val();
                        compl_dest="&quantite_dest="+$("#quantite_dest").val()+"&prix_dest="+$("#prix_dest").val()+"&ADL_Qte_dest="+$("#ADL_Qte_dest").val()+"&APrix_dest="+$("#APrix_dest").val()+complref;
                    }
                var ajoutParam="";
                if($("#database").val()==1 && $_GET("type")=="Transfert"){
                    ajoutParam = "&carat="+$("#carat").val();
                }
                if($("#quantite").val().replace(/ /g,"")>0 && ($_GET("type")=="Entree" || (Math.round(Math.round($("#quantite_stock").val().replace(/ /g,"")) + Math.round($("#ADL_Qte").val()) ) >= Math.round($("#quantite").val().replace(/ /g,""))))){
                    var acte="ajout_ligne";
                    if(modification){
                        modification=false;
                        acte = "modif";

                        $.ajax({
                        url: "traitement/"+fichierTraitement()+"?type_fac="+$_GET("type")+"&do_type="+do_type+"&do_domaine="+do_domaine+"&acte="+acte+"&entete="+$("#n_doc").val()+"&id_sec="+$("#idSec").val()+"&quantite="+$("#quantite").val().replace(/ /g,"")+"&designation="+$(".comboreference").val()+"&prix="+$("#prix").val().replace(/ /g,"")+"&remise="+$("#remise").val()+"&cbMarq="+$("#cb_Marq").val()+"&ADL_Qte="+$("#ADL_Qte").val()+"&APrix="+$("#APrix").val()+"&depot="+$("#depot").val()+"&collaborateur="+$("#collaborateur").val()+compl_dest+"&userName="+$("#userName").html()+"&machineName="+$("#machineName").html(),
                        method: 'GET',
                        async:false,
                        dataType: 'json',
                        data : "cbMarqEntete="+$("#EntetecbMarq").val()+ajoutParam,
                        success: function(data) {
                            alimLigne();
                            tr_clickArticle();
                            $('.comboreference').prop('disabled', false);
                            $('.comboreferenceDest').prop('disabled', false);
                            $('.comboreference').val("");
                            $('#designation').val("");
                            if($_GET("type")=="Transfert_detail"){
                                $("#article_"+$("#cb_Marq").val()).find("#DL_Qte_dest").html((Math.round(data[0].DL_Qte_Dest*100)/100));
                                $("#article_"+$("#cb_Marq").val()).find("#DL_MontantHT_dest").html(Math.round(data[0].DL_MontantHT_Dest));
                            }
                            $('.comboreference').focus();
                            $("#ADL_Qte").val(0);
                        },
                            error : function(resultat, statut, erreur){
                                alert(resultat.responseText);
                            }
                      });
                    }else{
                        var cbmarq="";
                    $.ajax({
                    url: "traitement/"+fichierTraitement()+"?acte="+acte+"&type_fac="+$_GET("type")+"&do_type="+do_type+"&do_domaine="+do_domaine+"&depot="+$("#depot").val()+"&id_sec=0&collaborateur="+$("#collaborateur").val()+"&entete="+$("#n_doc").val()+"&quantite="+$("#quantite").val().replace(/ /g,"")+"&designation="+$("#reference").val()+"&prix="+$("#prix").val().replace(/ /g,"")+"&remise="+$("#remise").val()+"&cbMarq="+$("#cbMarq").val()+"&ADL_Qte="+$("#ADL_Qte").val()+compl_dest+"&APrix="+$("#APrix").val()+"&userName="+$("#userName").html()+"&machineName="+$("#machineName").html(),
                    method: 'GET',
                    async:false,
                    dataType: 'json',
                    data : "cbMarqEntete="+$("#EntetecbMarq").val()+ajoutParam,
                    success: function(data) {
                        alimLigne();
                        tr_clickArticle();
                        $('.comboreference').focus();
                        $("#ADL_Qte").val(0);
                    },
                    error : function(resultat, statut, erreur){
                        alert(resultat.responseText);
                    }
                    });
                }
            calculTotal();
            }else {
                        if($("#quantite").val().replace(/ /g,"")<=0)alert("La quantité doit être supérieure ou égale à 0.")
                        else
                        alert("La quantité doit être inférieure ou égale à "+(Math.round($("#ADL_Qte").val()) +Math.round($("#quantite_stock").val().replace(/ /g,"")))+" !");
                }
        }
    }
    //}else alert("La quantité doit être supérieur à 0 !");
}
    
    function supprElement(cbmarq_prem,cbmarq_sec,ref,qte,prixAch,depot,dest){
        $.ajax({
            url: "traitement/"+fichierTraitement()+"?acte=suppr&id="+cbmarq_prem+"&id_sec="+cbmarq_sec+"&AR_Ref="+ref+"&DL_Qte="+qte+"&AR_PrixAch="+prixAch+"&DE_No="+depot+"&DE_No_dest="+dest,
            method: 'GET',
                dataType: 'html',
                success: function(data) {
                    modification=false;
                    $('.comboreference').prop('disabled', false);
                    $("#article_"+cbmarq_prem).fadeOut(300, function() { $(this).remove(); });
                    calculTotal();
                }
        });
    }
    
    function actionClient(val){
        $(".comboDepotSource").prop('disabled', val);
        $(".comboDepotest").prop('disabled', val);
        $("#dateentete").prop('disabled', val);
        $("#souche").prop('disabled', val);
    }

function calculTotal(){
    var montantht=0;
    var totalqte=0;
    var montanthtDest=0;
    var totalqteDest=0;
    var i=0;
    $.ajax({
        url: "traitement/Facturation.php?acte=liste_article&cbMarq="+$("#EntetecbMarq").val()+"&type_fac="+$_GET("type")+"&do_domaine="+do_domaine+"&do_type="+do_type+"&entete="+$("#n_doc").val()+"&cattarif=0&catcompta=0",
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                dataTable=data;
                montantht=0;
                totalqte=0;
                montanthtDest=0;
                totalqteDest=0;
                if($_GET("type")=="Transfert"){
                    montantht=(montantht/2);
                    totalqte=(totalqte/2);
                }
            if(dataTable.length>0){
                $('#imprimer').prop('disabled', false);
                $('#annuler').prop('disabled', false);
                $('#valider').prop('disabled', false);
                bloque_entete();
                actionClient(true);
            }else {
                $('#imprimer').prop('disabled', true);
                $('#annuler').prop('disabled', true);
                $('#valider').prop('disabled', true);
                if($_GET("entete")==null)
                    actionClient(false);
                else
                    bloque_entete();
            }

            if($_GET("visu")==1) $('#imprimer').prop('disabled', false);

            //if(affichePxRevient>1){
                $("#piedPage").html(data);
                $("#totalht").html(montantht);
                $("#totalhtDest").html(montanthtDest);
            //}
            $("#totalqte").html(totalqte);
            $("#totalqteDest").html(totalqteDest);
            $('.comboreference').val("");
            $('.comboreferenceDest').val("");
            $("#quantite").val("");
            $("#prix").val("");
            $("#carat").val("");
            $("#quantite_dest").val("");
            $("#prix_dest").val("");
            $("#quantite_stock").val("");
            $("#remise").val("");
        },
        error : function(resultat, statut, erreur){
            alert(resultat.responseText);
        }
    });


}

    $('#annuler').click(function(){
        alert("pas encore géré");
    });
    
    function alimente_qteStock(reference){
        $.ajax({
            url: 'indexServeur.php?page=isStock&AR_Ref='+reference+'&DE_No='+$("#depot").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if($_GET("type")!="Entree")
                    if(!modification)
                        if (data[0].AS_QteSto > 0)
                            $("#prix").val(Math.round((data[0].AS_MontSto / data[0].AS_QteSto) * 100) / 100);
                        else
                            $("#prix").val("0");

                $("#quantite_stock").val(Math.round(data[0].AS_QteSto*100)/100);
                if(!modification && Math.round(data[0].AS_QteSto)>=1)
                    $("#quantite").val("1");
            },
            error : function(resultat, statut, erreur){
                alert(resultat.responseText);
            }
        });
    }
    

    
    function suppression(cbMarq,id_sec,AR_Ref,DL_Qte,DL_CMUP){
        $("<div>Voulez vous supprimer "+AR_Ref+" ?</div>").dialog({
        resizable: false,
        height: "auto",
        width: 500,
        modal: true,
        buttons: {
            "Oui": {
                class: 'btn btn-primary',
                text: 'Oui',
                click: function () {
                    if ($_GET("type") == "Transfert" || $_GET("type") == "Entree") {
                        var de_no = $("#depot").val();
                        var texte = $("#depot option:selected").text();
                        if ($_GET("type") == "Transfert") {
                            de_no = $("#collaborateur").val();
                            texte = $("#collaborateur option:selected").text();
                        }
                        verifSupprAjout(cbMarq, id_sec, AR_Ref, DL_Qte, DL_CMUP, de_no, texte);
                    } else
                        supprElement(cbMarq, id_sec, AR_Ref, DL_Qte, DL_CMUP, $("#depot").val(), $("#collaborateur").val());
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
    }
    
    function verifSupprAjout(cbMarq,id_sec,AR_Ref,DL_Qte,DL_CMUP,de_no,de_intitule){
        $.ajax({
        url: 'indexServeur.php?page=isStockDENo&AR_Ref='+AR_Ref+'&DE_No='+de_no+'&DL_Qte='+DL_Qte,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var test = parseInt(data[0].isSuppr);
            var stock = parseFloat(data[0].AS_QteSto);
            if(test==0)
                supprElement(cbMarq,id_sec,AR_Ref,DL_Qte,DL_CMUP,$("#depot").val(),$("#collaborateur").val());
            else
                alert("la quantité du depot "+de_intitule+" est inssufisante ! (Qte : "+stock.toLocaleString()+")");
        },
        error : function (data){
            alert("la quantité du depot "+de_intitule+" est inssufisante ! (Qte : 0)");
        }
        });
    }

    function tr_clickArticle() {
        $("tr[id^='article']").each(function () {
            $(this).unbind();
            var cbMarq = $(this).find("#cbMarq").html();
            var id_sec = $(this).find("#id_sec").html();
            var DL_Qte = $(this).find("#DL_Qte").html();
            var AR_Ref = $(this).find("#AR_Ref").html();
            var DL_Design = $(this).find("#DL_Design").html();
            var DL_Remise = $(this).find("#DL_Remise").html();
            var DL_PrixUnitaire = $(this).find("#DL_PrixUnitaire").html();
            var DL_CMUP = $(this).find("#DL_CMUP").html();
            $(this).find("#suppr_" + cbMarq).click(function () {
                suppression(cbMarq, id_sec, AR_Ref, DL_Qte, DL_CMUP);
            });

            $(this).find("#AR_Ref").click(function(){
                fiche_article(AR_Ref);
            });
        });

        if($_GET("type") !="Transfert") {
            $("tr[id^='article']").dblclick(function () {
                $(this).unbind();
                var cbMarq = $(this).find("#cbMarq").html();
                var DL_Qte = $(this).find("#DL_Qte").html();
                DL_Qte = DL_Qte.replace(",", ".");
                DL_Qte = DL_Qte.replace(/ /g, "");
                var AR_Ref = $(this).find("#AR_Ref").html();
                var DL_Design = $(this).find("#DL_Design").html();
                var DL_Remise = $(this).find("#DL_Remise").html();
                var DL_PrixUnitaire = $(this).find("#DL_PrixUnitaire").html();
                DL_PrixUnitaire = DL_PrixUnitaire.replace(",", ".");
                DL_PrixUnitaire = DL_PrixUnitaire.replace(/ /g, "");
                var id_sec = $(this).find("#id_sec").html();
                valideReference(AR_Ref);
                $('#reference').val(DL_Design);
                $('.comboreference').val(AR_Ref);
                $('#designation').val(DL_Design);
                $('#remise').val(DL_Remise);
                $('#prix').val(DL_PrixUnitaire);
                $('.comboreference').val(AR_Ref);
                $('#quantite').val(DL_Qte);
                $('#ADL_Qte').val(DL_Qte);
                $('#APrix').val(DL_PrixUnitaire);
                $('#cb_Marq').val(cbMarq);
                $('#idSec').val(id_sec);

                if ($("#database").val() == "1" && $_GET("type") == "Transfert") {
                    var carat = $(this).parent('tr').find("#carat").html();
                    $("#carat").val(carat);
                }

                $('.comboreference').prop('disabled', true);
                if ($_GET("type") == "Transfert_detail") {
                    $('.comboreferenceDest').prop('disabled', true);
                    $('#ADL_Qte_dest').val($(this).find("#DL_Qte_dest").html());
                    $('#APrix_dest').val(Math.round(($(this).find("#DL_MontantHT_dest").html() / $(this).find("#DL_Qte_dest").html()) * 100) / 100);
                    $('#quantite_dest').val($(this).find("#DL_Qte_dest").html());
                    $('#prix_dest').val(Math.round(($(this).find("#DL_MontantHT_dest").html() / $(this).find("#DL_Qte_dest").html()) * 100) / 100);
                    $('#designation_dest').val($(this).find("#DL_Design_dest").html());
                    $('#reference_dest').val($(this).find("#DL_Design_dest").html());
                    $('.comboreferenceDest').val($(this).find("#AR_Ref_dest").html());
                }
                alimente_qteStock(AR_Ref);
                modification = true;
            });

            $("tr[id^='article']").dblclick(function () {
                $(this).unbind();
                var cbMarq = $(this).find("#cbMarq").html();
                var DL_Qte = $(this).find("#DL_Qte").html();
                DL_Qte = DL_Qte.replace(",", ".");
                DL_Qte = DL_Qte.replace(/ /g, "");
                var AR_Ref = $(this).find("#AR_Ref").html();
                var DL_Design = $(this).find("#DL_Design").html();
                var DL_Remise = $(this).find("#DL_Remise").html();
                var DL_PrixUnitaire = $(this).find("#DL_PrixUnitaire").html();
                DL_PrixUnitaire = DL_PrixUnitaire.replace(",", ".");
                DL_PrixUnitaire = DL_PrixUnitaire.replace(/ /g, "");
                var id_sec = $(this).find("#id_sec").html();
                valideReference(AR_Ref);
                $('#reference').val(DL_Design);
                $('.comboreference').val(AR_Ref);
                $('#designation').val(DL_Design);
                $('#remise').val(DL_Remise);
                $('#prix').val(DL_PrixUnitaire);
                $('.comboreference').val(AR_Ref);
                $('#quantite').val(DL_Qte);
                $('#ADL_Qte').val(DL_Qte);
                $('#APrix').val(DL_PrixUnitaire);
                $('#cb_Marq').val(cbMarq);
                $('#idSec').val(id_sec);

                if ($_GET("type") == "Transfert_detail") {
                    $('.comboreferenceDest').prop('disabled', true);
                    $('#ADL_Qte_dest').val($(this).find("#DL_Qte_dest").html());
                    $('#APrix_dest').val(Math.round(($(this).find("#DL_MontantHT_dest").html() / $(this).find("#DL_Qte_dest").html()) * 100) / 100);
                    $('#quantite_dest').val($(this).find("#DL_Qte_dest").html());
                    $('#prix_dest').val(Math.round(($(this).find("#DL_MontantHT_dest").html() / $(this).find("#DL_Qte_dest").html()) * 100) / 100);
                    $('#designation_dest').val($(this).find("#DL_Design_dest").html());
                    $('#reference_dest').val($(this).find("#DL_Design_dest").html());
                    $('.comboreferenceDest').val($(this).find("#AR_Ref_dest").html());
                }
                alimente_qteStock(AR_Ref);
                modification = true;
            });
        }

        $("td[id^='modif_']").click(function () {
            $(this).unbind();
            $('.comboreference').prop('disabled', true);
            var cbMarq = $(this).parent('tr').find("#cbMarq").html();
            var DL_Qte = $(this).parent('tr').find("#DL_Qte").html();
            DL_Qte = DL_Qte.replace(",",".");
            DL_Qte = DL_Qte.replace(/ /g,"");
            var AR_Ref = $(this).parent('tr').find("#AR_Ref").html();
            var DL_Design = $(this).parent('tr').find("#DL_Design").html();
            var DL_Remise = $(this).parent('tr').find("#DL_Remise").html();
            var DL_PrixUnitaire = $(this).parent('tr').find("#DL_PrixUnitaire").html();
            DL_PrixUnitaire = DL_PrixUnitaire.replace(",",".");
            DL_PrixUnitaire = DL_PrixUnitaire.replace(/ /g,"");
            var id_sec = $(this).parent('tr').find("#id_sec").html();
            valideReference(AR_Ref);
            $('#reference').val(DL_Design);
            $('.comboreference').val(AR_Ref);
            $('#designation').val(DL_Design);
            $('#remise').val(DL_Remise);
            $('#prix').val(DL_PrixUnitaire);
            $('.comboreference').val(AR_Ref);
            $('#quantite').val(DL_Qte);
            $('#ADL_Qte').val(DL_Qte);
            $('#APrix').val(DL_PrixUnitaire);
            $('#cb_Marq').val(cbMarq);
            $('#idSec').val(id_sec);

            if($("#database").val()=="1" && $_GET("type")=="Transfert"){
                var carat = $(this).parent('tr').find("#carat").html();
                $("#carat").val(carat);
            }

            if ($_GET("type") == "Transfert_detail") {
                $('.comboreferenceDest').prop('disabled', true);
                $('#ADL_Qte_dest').val($(this).parent('tr').find("#DL_Qte_dest").html());
                $('#APrix_dest').val(Math.round(($(this).parent('tr').find("#DL_MontantHT_dest").html() / $(this).parent('tr').find("#DL_Qte_dest").html()) * 100) / 100);
                $('#quantite_dest').val($(this).parent('tr').find("#DL_Qte_dest").html());
                $('#prix_dest').val(Math.round(($(this).parent('tr').find("#DL_MontantHT_dest").html() / $(this).parent('tr').find("#DL_Qte_dest").html()) * 100) / 100);
                $('#designation_dest').val($(this).parent('tr').find("#DL_Design_dest").html());
                $('#reference_dest').val($(this).parent('tr').find("#DL_Design_dest").html());
                $('.comboreferenceDest').val($(this).parent('tr').find("#AR_Ref_dest").html());
            }
            alimente_qteStock(AR_Ref);
            modification = true;
        });

    }
    tr_clickArticle();

    function fiche_article(AR_Ref){
        $.ajax({
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

    function actualiseCode(){
        var type = $("#p_catcompta").val().slice(-1);
        var fcp_type = 0;
        if(type=="A")
            fcp_type=1;
        var acp_champ = $("#p_catcompta").val().replace(type,"");
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

    $('.comboreference').val("");
});
