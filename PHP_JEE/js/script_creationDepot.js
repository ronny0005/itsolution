jQuery(function($){

    $('#ajouterDepot').click(function(){
        ajouterDepot();
    });

    function ajouterDepot(){
        if($("#DE_No").val()==0){
            var num ='';
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_depot',
                method: 'GET',
                dataType: 'json',
                data : $("#formDepot").serialize(),
                success: function(data) {
                    window.location.replace("listeDepot-1-"+data.DE_No);
                } 
            }); 
        }else {
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_depot',
                method: 'GET',
                dataType: 'json',
                data : $("#formDepot").serialize(),
                success: function(data) {
                    
                    window.location.replace("listeDepot-2-"+data.DE_No);
                } 
            });
        }
    }
});