jQuery(function($){

    $("tr[id^='ligneTENo']").each(function () {
        $(this).find("#blocValue :checkbox").each(function () {
            $(this).click(function(){
                var check = 0;
                if($(this).prop('checked'))check=1;
                $(this).parent().parent().find('td input[type="checkbox"]').each(function(){
                    $(this).prop('checked', false);
                });
                if(check)
                    $(this).prop('checked', true);
                var PROT_No = $(this).parent().parent().find("#PROT_No").html();
                var TE_No = $(this).parent().find("#TE_No").html();
                var pageData = 'configProfilUtilisateur';
                    $.ajax({
                        url: 'indexServeur.php',
                        method: 'GET',
                        dataType: 'html',
                        data: 'page='+pageData+'&PROT_No=' + PROT_No + "&TE_No="+ TE_No,
                        async: false,
                        success: function (data) {

                        }
                    });
            });
        });
    });
});