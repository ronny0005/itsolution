<html>
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css" media="screen" />
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link href="css/jquery-ui.theme.css" rel="stylesheet">
    <link href="css/fieldset.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

    <script src="js/jquery.js"></script>
    <script src="js/notify.js"></script>
    <script src="js/jquery_ui.js"></script>
    <script src="js/bootstrap-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.js"></script>
    <script src="js/scriptCombobox.js"></script>
    <script src="js/jqModal.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/jquery.fileupload.js"></script>
    <script src="js/scriptFonctionUtile.js?d=<?php echo time(); ?>"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/select2-bootstrap.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

    <script>
        jQuery(function ($) {
            var nomFichier = "";
            var pendingList = [];

            function sendAll() {
                pendingList.forEach(function (data) { data.submit(); });
                pendingList = [];
            }
$("#send").click(function(){
    sendAll()
})
            var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'upload/';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                maxNumberOfFiles: 1,
                autoUpload: false,
                process: [
                    {
                        action: 'load',
                        fileTypes: /^image\/(gif|jpeg|png)$/,
                        maxFileSize: 20000000 // 20MB
                    },
                    {
                        action: 'resize',
                        maxWidth: 200,
                        maxHeight: 200,
                        minWidth: 80,
                        minHeight: 80
                    },
                    {
                        action: 'save'
                    }
                ],
                async: false,
                add: function (e, data) {
                    pendingList = [];
                    pendingList.push(data);
                },

                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        nomFichier = file.name;
                        alert(nomFichier)
                        $.ajax({
                            url: "testCodeBarre.php",
                            method: 'GET',
                            data : "nomFichier="+nomFichier,
                            dataType: 'json',
                            success: function(data) {
                                alert(data.codeBarre);
                            }
                        });
                    });
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                    $('#progress .progress-bar').css(
                        'background-color',
                        '#286090'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        })
</script>
</head>
<body>

<div id="fichier" class="col-md-3">
    <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload" type="file" name="files[]"  accept="image/*" capture="camera" multiple>
    <!-- The global progress bar -->
    <hr>
    <div id="images-to-upload">
    </div><!-- end #images-to-upload -->

    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    <input type="button" id="send" value="send"/>
</div>


<?php


exec('C:\\"Program Files (x86)"\\ZBar\\bin\\zbarimg -q C:\\ean13.jpg', $result);
print_r($result);
?>
</body>
</html>
