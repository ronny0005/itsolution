jQuery(function($){
    var protect=0;
    
    $('#valider').click(function(){
        Valider();
    })
    
    function Valider(){
        if($("#CO_No").val()==0){
            $.ajax({
                url: 'traitement/Collaborateur.php?acte=ajout',
                method: 'GET',
                dataType: 'json',
                data : $("#formCollab").serialize(),
                success: function(data) {
                    window.location.replace("listeCollaborateur-1-"+data[0].CO_No);
                },
                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                }
            }); 
        }else {
            $.ajax({
                url: 'traitement/Collaborateur.php?acte=modif',
                method: 'GET',
                dataType: 'json',
                data : $("#formCollab").serialize(),
                success: function(data) {
                    window.location.replace("listeCollaborateur-2-"+data.CO_No);
                } 
            });
        }
    }
        
});