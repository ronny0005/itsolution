jQuery(function($) {

    $( "#sortable" ).sortable({
        revert: true
    })

    $("li[id^='draggable']").each(function(){
        $( this ).draggable({
            connectToSortable: "#sortable",
            helper: "clone",
            revert: "invalid"
        })
    })

    $( "ul, li" ).disableSelection()


    function deleteItem() {
        $("#sortable").each(function () {
            $(this).find("#supprItem").each(function () {
                $(this).click(function(){
                    $(this).parent().remove();
                });
            })
        })
    }

    $("#valider").click(function(){
        deleteItem()
        datas =[]
        filter = []
        $("#sortable").each(function(){
            $(this).find(".item").each(function(){
                datas.push($(this).find("#info").html())
            })
        })
        $("#filter").each(function(){
            if($(this).find("#selection").val()!=="")
                filter.push($(this).find("#selection").val()+";"+$(this).find("#item1").val()+";"+$(this).find("#item2").val())
        })
        $.ajax({
            url: "Traitement/Facturation.php?acte=createReport",
            method: 'GET',
            dataType: 'html',
            data : "param="+datas+"&filter="+filter,
            success: function (data) {
                $("#result").html(data);
            }
        });
    })

    $("#addFilter").click(function(){
        $("#listFilter").append("<div id=\"filter\" class=\"row\">\n" +
            "                        <select id=\"selection\" class=\"col-5 form-control\">\n" +
            "                            <option value=\"\"></option>\n" +
            "                            <option value=\"date\">Date</option>\n" +
            "                            <option value=\"client\">Client</option>\n" +
            "                            <option value=\"fournisseur\">Fournisseur</option>\n" +
            "                            <option value=\"article\">Article</option>\n" +
            "                        </select>\n" +
            "                        <input id=\"item1\" type=\"text\" class=\"ml-2 col-3 form-control\"/>\n" +
            "                        <input id=\"item2\" type=\"text\" class=\"ml-2 col-3 form-control\"/>\n" +
            "                        <span class=\"ml-2\"><i id=\"removeFilter\" class=\"fas fa-close\" style=\"color:red;font-size: 25px\"></i></span>\n" +
            "                    </div>")
            removeFilter()
            filterValue()
    })

    function filterValue(){
        $("#listFilter").each(function(){
            $(this).find("[id^='filter']").each(function(){
                var selection = $(this).find("#selection")
                var item1 = $(this).find("#item1")
                var item2 = $(this).find("#item2")
                selection.change(function(){
                    item1.datepicker( "destroy" );
                    item1.removeClass("hasDatepicker");
                    item2.datepicker( "destroy" );
                    item2.removeClass("hasDatepicker");
                    if(selection.val() == "date"){
                        item1.datepicker({
                            dateFormat: "ddmmy",
                            altFormat: "ddmmy",
                            autoclose: true
                        });
                        item2.datepicker({
                            dateFormat: "ddmmy",
                            altFormat: "ddmmy",
                            autoclose: true
                        });
                    }
                    console.log($(this).val())
                })
                console.log("lop")

            })
        })
    }
    filterValue()

    function removeFilter() {
        $("[id^='removeFilter']").each(function () {
            $(this).unbind()
            $(this).click(function () {
                $(this).parent().parent().remove()
            })
        })
    }
    removeFilter()
});