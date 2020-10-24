jQuery(function($){  
   $('#table').dynatable();

$("table.table > tbody > tr").on('dblclick', function() {
    iduser = $(this).find(".data-id").val();
    idu = $(this).find(".data2-id").val();
    idp = $(this).find(".data3-id").val();
    document.location.href = "indexMVC.php?module=8&action=3&id="+iduser+"&u="+idu+"&gu="+idp;
}); 
   
});

