jQuery(function($){

/*
    function ajouterUser(){
        if($_GET("id")==null){
            $("#add_err").css('display', 'none', 'important');
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_user',
                method: 'GET',
                dataType: 'json',
                data : $("#formUser").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=8&action=1&Prot_No="+data.Prot_No);
                } 
            }); 
        }else {
            $("#add_err").css('display', 'none', 'important');
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_user',//&username='+$("#username").val()+'&description='+$("#description").val()+'&id='+$_GET("id")+'&password='+$("#password").val()+'&email='+$("#email").val()+'&groupeid='+$("#groupeid").val()+'&profiluser='+$("#profiluser").val()+'&changepass='+$("#changepass").val()+'&depot='+$("#depot").val()+'&caisse='+$("#caisse").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#formUser").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=8&action=1&Prot_No="+data.Prot_No);
                } 
            });
        }
    }
*/

    $("#depot").change(function(){
        $("#depotprincipal").empty();
        $("#depot > option:selected").each(function(){
            $("#depotprincipal").append(new Option($(this).text(),$(this).val()));
        });
        setSelectedPrincipaux();
    });


    tablePrincipal = "";
    function setSelectedPrincipaux(){
        $(tablePrincipal).each(function() {
            $('#depotprincipal option[value="'+$(this)[0].DE_No+'"]').attr("selected", "selected");
        });
    }

    function getPrincipal(){
        $.ajax({
            url: "indexServeur.php?page=getPrincipalDepot",
            method: 'GET',
            dataType: 'json',
            data: "id="+$("#id").val(),
            success: function(data) {
                tablePrincipal = data;
            }
        });
    }

    getPrincipal();

    function getDepotSoucheCaisse(caisse,depot,souche){
        $.ajax({
           url: "indexServeur.php?page=getCaisseDepotSouche",
           method: 'GET',
           dataType: 'json',
           data: "CA_No="+caisse+"&DE_No="+depot+"&CA_Souche="+souche,
           success: function(data) {
                $(data).each(function() {
                    $("#depot").val(this.DE_No);
                    $("#caisse").val(this.CA_No);
                    $("#souche").val(this.CA_Souche);
                });
            }
        });
    }   

    $("#depot").change(function(){
       getDepotSoucheCaisse(0,$("#depot").val(),0);
    });

    $("#caisse").change(function(){
       getDepotSoucheCaisse($("#caisse").val(),0,0);
    });

});