<?php
$etat = new EtatClass();
?>
<script>
    jQuery(function ($) {
        $(".se-pre-con").fadeOut("slow")

        $(document).ready(function () {
            $(".se-pre-con").fadeOut("slow")
        });
    })
</script>

<?php
$dataCa = array();
$dataLabels = array();
$dataPoints = array();
$dataPointsDetteJour = array();
$etat = new EtatClass();
$list =  $etat->top10Vente("MONTH");
$listTopVenteJour =  $etat->top10Vente("DAY");
$listStatCaisseDuJour =  $etat->statCaisseDuJour($_SESSION["id"]);
$listTopDetteJour =  $etat->detteDuJour($_SESSION["id"]);
foreach($list as $elt) {
    $value = array("label" => $elt->AR_Design,"y" => $elt->CATTCNet);
    array_push($dataPoints,$value);
}

foreach($listTopDetteJour as $elt) {
    $value = array("label" => $elt->CT_Intitule,"y" => $elt->Reste_A_Payer);
    array_push($dataPointsDetteJour,$value);
}

$data = array(
    'labels' => $dataLabels,
    'datasets' => array(
            array(
                'data' =>$dataCa,
                'backgroundColor' => array('#006400', '#008000', '#228B22', '#2E8B57', '#3CB371', '#66CDAA','#8FBC8F','#98FB98','#90EE90','#00FA9A','#00FF7F','#ADFF2F','#7FFF00','#7CFC00','#00FF00','#32CD32'),
                'borderColor' => 'white',
                'label' => 'Legend'
            )
    )
);
?>
<script>
    window.onload = function () {
        var chart = new CanvasJS.Chart("detteContainer", {
            animationEnabled: true,
            title: {
                text: "Dette du jour"
            },
            axisY: {
                includeZero: true,
            },
            data: [{
                type: "bar",
                yValueFormatString: "#,##0",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($dataPointsDetteJour, JSON_NUMERIC_CHECK); ?>
            }]
        });
        //chart.render();
    }
    </script>
<script>
    jQuery(function($) {
        $("#topVenteMois, #topVenteJour, #statCaisse/*, #detteJour*/").DataTable(
            {
                scrollY: "300px",
                autoWidth: true,
                paging: false,
                searching: false,
                info: false,
                scrollCollapse: true,
                fixedColumns: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                }
                , "initComplete": function (settings, json) {
                    $("#topVenteMois_wrapper").addClass("row").addClass("p-3")
                    $("#topVenteMois_length").addClass("col-6")
                    $("#topVenteMois_filter").addClass("col-6")
                    $("#topVenteMois_filter").find(":input").addClass("form-control");
                    $("#topVenteMois_length").find(":input").addClass("form-control");
                }

            }
        );


/*
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title:{
                text: "CA PAR MOIS"
            },
            data: [{
                type: "pie",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: " #percent%",
                yValueFormatString: "#,##0",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
*/

    })
</script>
<section>

            <?php
            $protectioncial = new ProtectionClass("","");
            $protectioncial->connexionProctectionByProtNo($_SESSION["id"]);
            $flagPxRevient = $protectioncial->PROT_PX_REVIENT;
                if($protectioncial->PROT_Right==1){
            ?>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="col-12 text-center mb-3">
                                <h5>Top Vente du mois</h5>
                            </div>
                            <table id="topVenteMois" class="table table-striped" style="font-size: 10px">
                                <thead>
                                <tr>
                                    <th>Désignation</th>
                                    <th style="width: 70px">CA</th>
                                    <?php if($flagPxRevient==0) echo "<th style=\"width: 70px\">Marge</th>" ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($list as $value){
                                    ?>
                                    <tr>
                                        <td><?= $value->AR_Design ?></td>
                                        <td class="text-right"><?= $protectioncial->formatChiffre($value->CATTCNet) ?></td>
                                        <?php if($flagPxRevient==0) echo "<td class=\"text-right\">{$protectioncial->formatChiffre($value->Marge)}</td>" ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-sm-6">
                            <table class="table table-striped">
                                <div class="col-12 text-center mb-3">
                                    <h5>Top Vente du jour</h5>
                                </div>
                                <table id="topVenteJour"  class="table table-striped" style="font-size: 10px">
                                    <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th style="width: 70px">CA</th>
                                        <?php if($flagPxRevient==0) echo "<th style=\"width: 70px\">Marge</th>" ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($listTopVenteJour as $value){
                                        ?>
                                        <tr>
                                            <td><?= $value->AR_Design ?></td>
                                            <td><?= $protectioncial->formatChiffre($value->CATTCNet) ?></td>
                                            <?php if($flagPxRevient==0) echo "<td class=\"text-right\">{$protectioncial->formatChiffre($value->Marge)}</td>" ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="col-12 text-center mb-3">
                                <h5>Statistique caisse</h5>
                            </div>
                            <table id="statCaisse" class="table table-striped" style="font-size: 10px">
                                <thead>
                                <tr>
                                    <th>Caisse</th>
                                    <th style="width: 70px">Entrée</th>
                                    <th style="width: 70px">Sortie</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($listStatCaisseDuJour as $value){
                                    ?>
                                    <tr>
                                        <td><?= $value->CA_Intitule ?></td>
                                        <td class="text-right"><?= $protectioncial->formatChiffre($value->CREDIT) ?></td>
                                        <td class="text-right"><?= $protectioncial->formatChiffre($value->DEBIT) ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div id="detteContainer"></div>
                            <table id="detteJour" class="table table-striped">
                                <div class="col-12 text-center mb-3">
                                    <h5>Dette du jour</h5>
                                </div>
                                <table class="table table-striped" style="font-size: 10px">
                                    <thead>
                                    <tr>
                                        <th>Intitule</th>
                                        <th style="width: 125px">Reste à payer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($listTopDetteJour as $value){
                                        ?>
                                        <tr>
                                            <td><?= $value->CT_Intitule ?></td>
                                            <td class="text-right"><?= $protectioncial->formatChiffre($value->Reste_A_Payer) ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </table>
                        </div>
                    </div>


            <?php
                }
            ?>

</section>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>