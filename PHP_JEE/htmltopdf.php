<?php

// get the HTML
ob_start();
include("".$_GET["nom_page"].".php");
$content = ob_get_clean();

// convert in PDF
require_once('htmltopdf/vendor/autoload.php');
try
{
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
//      $html2pdf->setModeDebug();
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('exemple00.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
