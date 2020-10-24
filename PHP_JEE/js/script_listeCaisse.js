jQuery(function($){

    $('#table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        },
        "initComplete": function(settings, json) {
            $("#table_filter").find(":input").addClass("form-control");
            $("#table_length").find(":input").addClass("form-control");
        }
    });

});