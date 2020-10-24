jQuery(function($){  
    var lien = 2;
    var typeTiers = 0;
    if($("#typeTiers").val()=="fournisseur")
        typeTiers = 1;
    if($("#typeTiers").val()=="salarie")
        typeTiers = 2;
    var sommeil = 0;

    var donnee = [
        {"data": "CT_Num",
            "render": function(data, type, row, meta) {
                if (type === 'display') {
                    data = '<a href="'+$("#ficheTiers").val()+'-'+$("#typeTiersNum").val()+'-' + data + '">' + data + '</a>';
                }
                return data;
            }
        },
        {"data": "CT_Intitule"},
        {"data": "CG_NumPrinc"},
        {"data": "LibCatTarif"},
        {"data": "LibCatCompta"},
    ];

    var suppr = {"data" : "CT_Num","render": function(data, type, row, meta) {
            if (type === 'display') {
                data = "<a href='Traitement\\Creation.php?acte=suppr_client&type="+typeTiers+"&CT_Num="+data+"' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer " + data+" ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a>";
            }//
            return data;
    }}

    if($("#supprProtected").val()==1)
        donnee.push(suppr);

    if($("#flagCreateur").val()==1) {
        donnee.push({
            "data": "PROT_User",
            "render": function (data, type, row, meta) {
                if (data == null) return "";
                else
                    return data;
            }
        });
    }

    $('#users').DataTable({
        scrollY:        "300px",
        scrollCollapse: true,
        fixedColumns:   true,
        "columns": donnee,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            },

        "processing": true,
            "serverSide": true,
            "ajax": {
                url: 'traitement/Creation.php?acte=listeClient&CT_Type='+typeTiers+'&CT_Sommeil='+sommeil,
                type: 'POST'
            },
            "initComplete": function(settings, json) {
                $("#users_filter").find(":input").addClass("form-control");
                $("#users_length").find(":input").addClass("form-control");
            }
        });


$("#sommeil").change(function(){
    window.location.replace($("#lienTiers").val()+"&sommeil="+$(this).val());
});

var protect = 0;
  
    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    if($_GET("action")=="8")
                    protect=this.PROT_FOURNISSEUR;
                        else
                    protect=this.PROT_CLIENT;
                    if(protect==1){
                        $("#nouveau").prop('disabled', true);
                    }
                });
            }
        });
    }
    
    protection();    
});