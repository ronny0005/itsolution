jQuery(function($){

        var protect=0;
        var type =0;
            
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
        
    $("#rechercher").click(function(){
        rechercher($("#dateDeb").val(),$("#dateFin").val(),$("#statut").val(),$('#caNumIntitule').select2('data')[0].id)
        rechercherNonComptabilisable($("#dateDeb").val(),$("#dateFin").val(),$("#statut").val(),$('#caNumIntitule').select2('data')[0].id)
    })

    $("#caNumIntitule").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {

    });

    function rechercher(dateDeb,dateFin,statut,caNum){
        $.ajax({
            url: 'indexServeur.php?page=listeTable&dateDeb='+dateDeb+"&dateFin="+dateFin+"&statut="+statut+"&caNum="+caNum,
            method: 'GET',
            async:false,
            dataType: 'html',
            async : false,
            success: function (data) {
                $("#listeTable").html(data)
            },
            error: function(data) {
            }
        })
    }

    function rechercherNonComptabilisable(dateDeb,dateFin,statut,caNum){
        if(statut==0)
        $.ajax({
            url: 'indexServeur.php?page=listeTableNonComptabiliser&dateDeb='+dateDeb+"&dateFin="+dateFin+"&caNum="+caNum,
            method: 'GET',
            async:false,
            dataType: 'html',
            async : false,
            success: function (data) {
                if(data!="") {
                    $("#nonComptabilisable").html(data)
                    $("#nonComptabilisable").show()
                }else
                    $("#nonComptabilisable").hide()
            },
            error: function(data) {
            }
        })
    }

    rechercher($("#dateDeb").val(),$("#dateFin").val(),$("#statut").val(),$('#caNumIntitule').select2('data')[0].id)

    rechercherNonComptabilisable($("#dateDeb").val(),$("#dateFin").val(),$("#statut").val(),$('#caNumIntitule').select2('data')[0].id)

    $("#dateDeb").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"})
    $("#dateFin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"})

    $("#majCompta").click(function(){
       if($("#statut").val()==0)
           $("#form-entete").submit()
    });
});