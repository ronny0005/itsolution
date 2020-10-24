jQuery(function($){

    $('#ajouterCaisse').click(function(){
        ajouterCaisse();
    });


    function ajouterCaisse(){
        if($("#CA_No").val()==0){
            var num ='';
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_caisse',
                method: 'GET',
                dataType: 'json',
                data : $("#formCaisse").serialize(),
                success: function(data) {
                    window.location.replace("listeCaisse-1-"+data.CA_No);
                }, 
                error: function(data) {
                    alert(data);
                }
                
            }); 
        }else {
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_caisse',
                method: 'GET',
                dataType: 'json',
                data : $("#formCaisse").serialize(),
                success: function(data) {
                    window.location.replace("listeCaisse-2-"+data.CA_No);
                } , 
                error: function(data) {
                    alert(data);
                }
            });
        }
    }

    $("#caissier").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {

    })

    $("#journal").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {

    })
});