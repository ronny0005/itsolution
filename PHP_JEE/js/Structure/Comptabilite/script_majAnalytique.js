jQuery(function($){

        var protect=0;
        var type =0;

    $('#Ajouter').click(function(){
        Ajouter();
    });
        
    $("#rechercher").click(function(){
        rechercher($("#dateDeb").val(),$("#dateFin").val(),$("#statut").val(),$('#caNumIntitule').select2('data')[0].id)
    })

    $("#caNumIntitule").select2({
        theme: "bootstrap"
    }).on("select2:select", function (e) {

    });


    $("#table").DataTable(
        {
            scrollY:        "300px",
            paging:         false,
            searching:      false,
            scrollCollapse: true,
            fixedColumns:   true,
            info:           false,
            "language": {
                "url":      "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
        }
    );

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

    rechercher($("#dateDeb").val(),$("#dateFin").val(),$("#statut").val(),$('#caNumIntitule').select2('data')[0].id)

    $("#dateDeb").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"})
    $("#dateFin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"})

    $("#majCompta").click(function(){
       if($("#statut").val()==0)
           $("#form-entete").submit()
    });
});