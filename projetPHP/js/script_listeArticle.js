jQuery(function($){  

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


    if($_GET("acte")=="ajoutOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>L\'article '+$_GET("AR_Ref")+' a bien été enregistré !</div>');
    }

    if($_GET("acte")=="modifOK"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>L\'article '+$_GET("AR_Ref")+' a bien été modifié !</div>');
    }

    if($_GET("acte")=="supprOK"){
            $("#add_err").css('display', 'inline', 'important');
            $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>L\'article  '+$_GET("AR_Ref")+' a bien été supprimé !</div>');
    }

    if($_GET("acte")=="supprKO"){
        $("#add_err").css('display', 'inline', 'important');
        $("#add_err").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>La suppression de l\'article '+$_GET("AR_Ref")+' a échoué !</div>');
    }

    $("#sommeil").change(function(){
        window.location.replace("indexMVC.php?module=3&action=3&sommeil="+$(this).val()+"&stockFlag="+$("#stockFlag").val()+"&prixFlag="+$("#prixFlag").val())      ;
    });

    $("#stockFlag").change(function(){
        window.location.replace("indexMVC.php?module=3&action=3&sommeil="+$("#sommeil").val()+"&stockFlag="+$(this).val()+"&prixFlag="+$("#prixFlag").val())      ;
    });

    $("#prixFlag").change(function(){
        window.location.replace("indexMVC.php?module=3&action=3&sommeil="+$("#sommeil").val()+"&stockFlag="+$("#stockFlag").val()+"&prixFlag="+$(this).val())      ;
    });

$('#table').dynatable({
    inputs: {
    queryEvent: 'keyup'
    }
});

function referencement(){
    $("table.table > tbody > tr").on('click', function() {
        document.location.href = "indexMVC.php?module=&action=1&AR_Ref="+$(this).find("td a").html();
    }); 
}

$("#dynatable-query-search-table").keyup(function(e){
    referencement(); 
});

referencement();


var protect = 0;
var sommeil = -1;
var prixFlag = -1;
var stockFlag = -1;
if($_GET("sommeil")!=undefined)
    sommeil = $_GET("sommeil");
if($_GET("prixFlag")!=undefined)
    prixFlag = $_GET("prixFlag");
if($_GET("stockFlag")!=undefined)
    stockFlag = $_GET("stockFlag");
    var info = [            {"data": "AR_Ref",
        "render": function(data, type, row, meta) {
            if (type === 'display') {
                data = '<a href="indexMVC.php?module=3&action=1&AR_Ref=' + data + '">' + data + '</a>';
            }
            return data;
        }
    },
        {"data": "AR_Design"},
        {"data": "AS_QteSto",
            "render": function(data, type, row, meta) {
                if (type === 'display') {
//                    data = Math.round(data, 2);
                }
                data= parseFloat(data).toLocaleString();
                return data;
            }}
    ];

    if($("#flagPxAchat").val()==0)
        info.push({"data": "AR_PrixAch",
            "render": function(data, type, row, meta) {
                if (type === 'display') {
                }
                data= parseFloat(data).toLocaleString();
                return "<span style='float:right'>"+data+"</span>";
            }});

    if($("#flagInfoLibreArticle").val()!=2) {
        info.push({
            "data": "AR_PrixVen",
            "render": function (data, type, row, meta) {
                if (type === 'display') {
//                    data = Math.round(data,2);
                }
                data = parseFloat(data).toLocaleString();
                return "<span style='float:right'>"+data+"</span>";
            }
        });
    }

    if($("#flagPxRevient").val()!=2)
        info.push(         {"data": "AS_MontSto",
        "render": function(data, type, row, meta) {
            if (type === 'display') {
//                    data = Math.round(data, 2);
            }
            data= parseFloat(data).toLocaleString();
            return "<span style='float:right'>"+data+"</span>";
        }});

    var suppr = {"data" : "AR_Ref","render": function(data, type, row, meta) {
            if (type === 'display') {
                data = "<a href='Traitement\\Creation.php?acte=suppr_article&AR_Ref="+data+"' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer " + data+" ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a>";
            }//
            return data;
        }
    }

    if($("#supprProtected").val()==1)
        info.push(suppr);

    if($("#flagCreateur").val()==1) {
        info.push({
            "data": "PROT_User",
            "render": function (data, type, row, meta) {
                if (data == null) return "";
                else
                    return data;
            }
        });
    }

    $("#imprimer").click(function(){
        window.open('./export/exportCSV.php?&AR_Sommeil='+sommeil+"&prixFlag="+prixFlag+"&stockFlag="+stockFlag, "Fiche Article", "height=100,width=100");
    });

    $('#users').DataTable({
        "columns": info,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: 'traitement/Creation.php?acte=listeArticle&PROT_No='+$("#PROT_No").val()+'&AR_Sommeil='+sommeil+'&flagPxAchat='+$("#flagPxAchat").val()+'&flagPxRevient='+$("#flagInfoLibreArticle").val()+"&prixFlag="+prixFlag+"&stockFlag="+stockFlag,
            type: 'POST'
        },
        "initComplete": function(settings, json) {
            $("#users_filter").find(":input").addClass("form-control");
            $("#users_length").find(":input").addClass("form-control");
        }
    });

    function protection(){
    $.ajax({
       url: "indexServeur.php?page=connexionProctection",
       method: 'GET',
       dataType: 'json',
        success: function(data) {
            $(data).each(function() {
                protect=this.PROT_ARTICLE;
                if(protect==1){
                    $("#nouveau").hide();
                }
            });
        }
    });
}

protection(); 


});