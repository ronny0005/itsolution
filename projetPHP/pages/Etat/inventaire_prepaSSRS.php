
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/script_etat.js"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
include("enteteParam.php");
?>
<div id="milieu">    
    <div class="container">
            
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<form action="indexMVC.php?module=5&action=2" method="GET">
    <table style="margin-bottom: 20px">
    <thead>
        <tr>
            <td style="width:50px;vertical-align: middle">Date :</td>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="2" name="action"/>
            <td><input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" disabled/></td>
            <td><select style="margin-left: 10px;" class="form-control" id="choix_inv" name="choix_inv">
                    <option value="1" <?php if($choix_inv==1) echo "selected"; ?>>Cumul de stock</option>
                    <option value="2" <?php if($choix_inv==2) echo "selected"; ?>>date indiqué</option></select></td>
            <td style="padding-left: 10px;width:60px;vertical-align: middle"> Depot :</td>
            <td style="padding-left: 10px;width:200px;">
                <select class="form-control" name="depot" id="depot">
                    <option value="0">Tous</option>
                    <?php
                    $result=$objet->db->requete($objet->depot());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    //$depot="";
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            echo "<option value=".$row->DE_No."";
                            if($row->DE_No==$depot_no) echo " selected";
                            echo ">".$row->DE_Intitule."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
            <td>Rupture par agence <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> /></td>
            <td><input type="submit" id="valider" class="btn btn-primary" value="Valider"/></td>
            <td style="padding-left:30px"><input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportInventairePrep.php?type=mvtStock&choix_inv=$choix_inv&datedeb=".$datedeb."&datefin=0&depot=".$depot_no."&rupture=".$rupture."')\""; ?>/></td>
        </tr>
</table>
</form>
<?php
require_once 'SSRSReport.php';
define("REPORT", "/Rapports/Inventaire_preparatoire");
define("FILENAME", "Mvt_Stock.pdf");
$settings = parse_ini_file("app.config", 1);

$parameters = array();
$parameters[0] = new ParameterValue();
$parameters[0]->Name = "Agence";
$parameters[0]->Value = "$depot_no";
$parameters[1] = new ParameterValue();
$parameters[1]->Name = "Date";
$parameters[1]->Value = "".$objet->getDate($datedeb)."";
$ruptureSSRS= "false";
if($rupture==1) $ruptureSSRS="true";
$parameters[2] = new ParameterValue();
$parameters[2]->Name = "rupture";
$parameters[2]->Value = "$ruptureSSRS";
$parameters[3] = new ParameterValue();
$parameters[3]->Name = "Type";
$parameters[3]->Value = "$choix_inv";
try
{
    $rs = new SSRSReport(new Credentials($settings["UID"], $settings["PASWD"]),$settings["SERVICE_URL"]);
    if (isset($_REQUEST['rs:Command']))
    {
        switch($_REQUEST['rs:Command'])
        {
            case 'Sort':
                $rs->Sort2($_REQUEST['rs:SortId'],
                    $_REQUEST['rs:SortDirection'],
                    $_REQUEST['rs:ClearSort'],
                    PageCountModeEnum::$Estimate,
                    $ReportItem,
                    $ExecutionInfo);
                break;
            default:
                echo 'Unknown :' . $_REQUEST['rs:Command'];
                exit;
        }
    }
    else
    {
        $executionInfo = $rs->LoadReport2(REPORT, NULL);
        $rs->SetExecutionParameters2($parameters);
    }

    $renderAsHTML = new RenderAsHTML();
    //The ReplcementRoot option of HTML rendering extension is used to
    //redirect all calls to reporting serice server to this php file.
    //The StreamRoot option of HTML rendering extension used instruct
    //HTML rendering extension about how to construct the URLs to images in the
    //report.
    //Please refer description of Sort2, Render2 and RenderStream API in
    //the userguide (./../../../docs/User Guide.html) for more details
    //about these options.



    $renderAsHTML->ReplacementRoot = getPageURL();
    $renderAsHTML->StreamRoot = './images/';
    $result_html = $rs->Render2($renderAsHTML,
        PageCountModeEnum::$Actual,
        $Extension,
        $MimeType,
        $Encoding,
        $Warnings,
        $StreamIds);
    foreach($StreamIds as $StreamId)
    {
        $renderAsHTML->StreamRoot = null;
        $result_png = $rs->RenderStream($renderAsHTML,
            $StreamId,
            $Encoding,
            $MimeType);

        if (!$handle = fopen("./images/" . $StreamId, 'wb'))
        {
            echo "Cannot open file for writing output";
            exit;
        }

        if (fwrite($handle, $result_png) === FALSE)
        {
            echo "Cannot write to file";
            exit;
        }
        fclose($handle);
    }
    echo '<div style="clear:both"></div>
	<div align="center">';
    echo '<div style="overflow:auto;">';
    echo $result_html;
    echo '</div>';
    echo '</div>';
}
catch(SSRSReportException $serviceExcprion)
{
    echo  $serviceExcprion->GetErrorMessage();
}

/**
 *
 * @return <url>
 * This function returns the url of current page.
 */
function getPageURL()
{

    $PageUrl = isset($_SERVER["HTTPS"]) == "on"? 'https://' : 'http://';
    $uri = $_SERVER["REQUEST_URI"];
    $index = strpos($uri, '?');
    if($index !== false)
    {
        $uri = substr($uri, 0, $index);
    }
    $PageUrl .= $_SERVER["SERVER_NAME"] .
        ":" .
        $_SERVER["SERVER_PORT"] .
        $uri;
    return $PageUrl;
}

    ?>