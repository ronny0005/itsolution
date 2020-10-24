jQuery(function($){
$("#table").DataTable(
    {
        scrollCollapse: true,
        fixedColumns:   true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
        ,"initComplete": function(settings, json) {
            $("#table_wrapper").addClass("row").addClass("p-3")
            $("#table_length").addClass("col-6")
            $("#table_filter").addClass("col-6")
            $("#table_filter").find(":input").addClass("form-control");
            $("#table_length").find(":input").addClass("form-control");
        }

    }
);


});
