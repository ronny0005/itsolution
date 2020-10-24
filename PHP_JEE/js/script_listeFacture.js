jQuery(function($){

    var protect = 0;
    if($("#PROT_CbCreateur").val()!=2)
        $('[data-toggle="tooltip"]').tooltip();
$("#menu_transform").hide();

    function lien (){
        return $("#lienMenuNouveau").val();
    }

    function referencement(){
    }

$("table.table > tbody > tr #transform").on('click', function() {
    var cbMarq = $(this).parent().parent().find("#cbMarq").html();
    var entete = $(this).parent().parent().find("#entete a").html();
        $("#menu_transform").dialog({
                title : "Transformation du document "+entete,
                resizable: false,
                height: "auto",
                width: 200,
                modal: true,
                buttons: {
                    "Valider": {
                        class: 'btn btn-primary',
                        text: 'Valider',
                        click: function () {
                            transformeEntete(cbMarq);
                        }
                    }
                }

            });
        });


    function transformeEntete(cbMarq){
        var check=0;
        if($('#conserv_copie').is(':checked')) check=1;

        $.ajax({
            url: "Traitement/BonLivraison.php?acte=transBLFacture&type_trans="+$("#type_trans").val()+"&type="+$("#typeDoc").val()+"&cbMarq="+cbMarq+"&date="+$("#date_transform").val()+"&conserv_copie="+check+"&reference="+$("#reference").val(),
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                if(data.trim()!="") alert("La quantité en stock des "+data+" est inssufisante !");
                if(!$('#conserv_copie').is(':checked')) {
                    $.ajax({
                        url: "Traitement/Facturation.php?page=bonLivraison&acte=suppr_facture&cbMarq="+cbMarq,
                        method: 'GET',
                        dataType: 'html',
                        success: function(data) {
                            alert("La transormation a été effectuée !");
                            if($("#typeDoc").val()=="Devis")
                                window.location.replace("indexMVC.php?module=2&action=2&type="+$("#typeDoc").val()+"&depot="+$("#depot").val());
                            else
                                window.location.replace("indexMVC.php?module=2&action=5&type="+$("#typeDoc").val()+"&depot="+$("#depot").val());
                        }
                    });
                } else{
                    alert("La transormation du document a été effectuée !");
                    window.location.replace("indexMVC.php?module=2&action=5&type="+$("#typeDoc").val()+"&depot="+$("#depot").val());
                }
            }
        });
    }
    referencement();
    $("#nouveau").on('click', function() {
        document.location.href = lien ();
    });

    $(".dynatable-page-link").on('click', function(){
        referencement();
    });

    $("#dynatable-query-search-table").keyup(function(e){
        referencement();
    });


    $("#client").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&TypeFac=" + $("#typeDoc").val()+"&all=1",
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#client").val(ui.item.label)
            $("#CT_Num").val(ui.item.value)
        }
    })


    $("#datefin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#datedebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});

    if($("#post").val()==0) {
        $("#datefin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        $("#datedebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }

    $("#tableListeFacture").DataTable(
        {
            scrollY:        "300px",
            scrollCollapse: true,
            fixedColumns:   true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
            ,"initComplete": function(settings, json) {
                $("#tableListeFacture_wrapper").addClass("row").addClass("p-3")
                $("#tableListeFacture_length").addClass("col-6")
                $("#tableListeFacture_filter").addClass("col-6")
                $("#tableListeFacture_filter").find(":input").addClass("form-control");
                $("#tableListeFacture_length").find(":input").addClass("form-control");
            }

        }
    );


    $("#tableListeFacture_filter").find(":input").addClass("form-control")
    if($("#date_transform").val()=="")
        $("#date_transform").datepicker({dateFormat:"ddmmy"}).datepicker("setDate",new Date());

    if($("#ClotureVente").val()!="undefined"){
        $("#ClotureVente").click(function(){
            $("#FormClotureVente").dialog({
                resizable: false,
                height: "auto",
                width: 500,
                modal: true,
                async: false,
                title : "Cloture vente",
                buttons: {
                    "Valider": {
                        class: 'btn btn-primary',
                        text: 'Valider',
                        click: function () {
                            $.ajax({
                                url: "traitement/Facturation.php?acte=clotureVente",
                                method: 'GET',
                                dataType: 'html',
                                data: "CA_Num=" + $("#affaire").val(),
                                async: false,
                                success: function (data) {
                                    if (data == "")
                                        alert("La cloture s'est bien déroulée !");
                                    else
                                        alert(data);
                                }
                            });
                            $(this).dialog("close");
                        }
                    }
                }
            });
        });
    }



        $("#valider").click(function () {
        $("#valideLigne").submit()
    })
});