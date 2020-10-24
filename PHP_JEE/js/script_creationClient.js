jQuery(function($){

    $("#depot").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {

    })

    $("#CO_No").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {

    })

    $("#CA_Num").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {

    })

    $("#CG_NumPrinc").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {

    })

    $('#ajouterClient').click(function(e){
        e.preventDefault();
        if($("#cbMarqTiers").val()==0) {
            if ($("#CT_Num").val() == "")
                alert("le numéro de compte doit être renseigné !");
            else {
                $.ajax({
                    url: 'traitement/Creation.php?acte=clientByIntitule',
                    method: 'POST',
                    dataType: 'html',
                    async: true,
                    data: "CT_Intitule=" + $("#intitule").val(),
                    success: function (data) {
                        if (data != "")
                            alert(data);
                        else
                            ajouterClient();
                    },
                    error: function (resultat, statut, erreur) {
                        alert(resultat.responseText);
                    }
                });
            }
        }
        else{
            ajouterClient()
        }
    });

    $("#CT_Encours").inputmask({   'alias': 'numeric',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 0,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '',
        allowPlus: true,
        allowMinus: false
    })

    function ajouterClient(){
        if($("#cbMarqTiers").val()==0){
            var num ='';
            $("#add_err").css('display', 'none', 'important');
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_client',
                method: 'GET',
                dataType: 'json',
                data : $("#form-creationClient").serialize(),
                success: function(data) {
                    window.location.replace("listeTiers-1-"+$("#type").val()+"-"+data.CT_Num);
                },

                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                }

            });
        }else {
            var num ='';
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_client&page=insertClientMin',
                method: 'GET',
                dataType: 'json',
                data : $("#form-creationClient").serialize()+"&CT_Num="+$("#CT_Num").val(),
                success: function(data) {
                    window.location.replace("listeTiers-2-"+$("#type").val()+"-"+data.CT_Num);
                },

                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                }
            });
        }
    }
});