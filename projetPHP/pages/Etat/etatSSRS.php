<script src="js/jquery.dynatable.js" type="text/javascript"></script>
    <script src="js/script_etat.js?d=<?php echo time(); ?>"></script>
</head>
<body>
<?php
set_time_limit(100);
include("module/Menu/BarreMenu.php");
include("enteteParam.php");
$module = $_GET["module"];
$action = $_GET["action"];
//$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
?>
<div id="milieu">
    <div class="container">
        <!--
To change this template, choose Tools | Templates
and open the template in the editor.
--><input type="hidden" name="PROT_Admin" id="PROT_Admin" value="<?= $protection->PROT_Administrator; ?>" />
        <input type="hidden" name="PROT_No" id="PROT_No" value="<?= $protection->Prot_No; ?>" />
        <input type="hidden" name="POST_Data" id="POST_Data" value="<?php if(isset($_POST)) echo "1"; else echo "0"; ?>" />
        <input type="hidden" name="ArticleDebutParam" id="ArticleDebutParam" value="<?php if(isset($_POST["ArticleDebut"])) echo $_POST["ArticleDebut"]; ?>" />
        <input type="hidden" name="ArticleFinParam" id="ArticleFinParam" value="<?php if(isset($_POST["ArticleFin"])) echo $_POST["ArticleFin"]; ?>" />
        <input type="hidden" name="ClientDebutParam" id="ClientDebutParam" value="<?php if(isset($_POST["ClientDebut"])) echo $_POST["ClientDebut"]; ?>" />
        <input type="hidden" name="ClientFinParam" id="ClientFinParam" value="<?php if(isset($_POST["ClientFin"])) echo $_POST["ClientFin"]; ?>" />
        <input type="hidden" name="typeTiersParam" id="typeTiersParam" value="<?php if(isset($_GET["typeTiers"])) echo $_GET["typeTiers"]; else if(isset($_POST["typeTiers"])) echo $_POST["typeTiers"]; else if(isset($_POST["typeTiersParam"])) echo $_POST["typeTiersParam"]; ?>" />
        <input type="hidden" name="dateIndique" id="dateIndique" value="<?= (isset($dateIndique)) ? "1":"0" ?>" />
        <form name="reportForm" id="reportForm" method="POST" action="indexMVC.php?module=<?php echo $module; ?>&action=<?php echo $action; ?>">
            <?php

            require_once 'SSRSReport.php';
            //load config file variables
            $settings = parse_ini_file(__DIR__ . "\..\..\config\app.config", 1);
            try
            {
                $ssrs_report = new SSRSReport(new Credentials($settings["UID"], $settings["PASWD"]),$settings["SERVICE_URL"]);
                $result_html = null;
                $controls = null;

                //check are process 'params'request parameter
                parsePostBack();

                //We need to get the report parameters, create controls, and fill in values
                //if(key_exists("reportName", $_REQUEST))
                //{

                $parmVals = getReportParameters();
                //this makes it easier to access the stored values below
                $arr = array();
                if(!empty ($parmVals))
                {
                    foreach ($parmVals as $key => $val)
                    {
                        //error checking code to print the values retrieved
                        //echo "\n<br />parameters[$key]=$val->Name:$val->Value";

                        $arr[$val->Name] = $val->Value;
                    }
                }

                //get report parameters based on either defaults or changed values
                $reportParameters = $ssrs_report->GetReportParameters($query, null, true, $parmVals, null);
                $i=0;
                $controls .= "\n<div>";

                foreach($reportParameters as $reportParameter)
                {
                    //are we opening or continuing a row?
                    //get the default value
                    $controls .= '<div class="form-group col-lg-3">';
                    $default = null;
                    foreach($reportParameter->DefaultValues as $vals)
                        foreach($vals as $key=>$def)
                            $default = $def;
                    if($reportParameter->Name!="AffichePrixVen" && $reportParameter->Name!="PROT_No")
                        $controls .= '<label>'.$reportParameter->Prompt . "</label>";
                    //If there is a list, then it needs to be a Select box
                    if(sizeof($reportParameter->ValidValues) > 0){
                        $dependencies = "";//empty($reportParameter->Dependencies) ? "onchange='getParameters();'" : "";
                        if($reportParameter->Name!="ArticleDebut"
                            && $reportParameter->Name!="ArticleFin" && $reportParameter->Name !="CG_Num"
                            && $reportParameter->Name!="ClientDebut" && $reportParameter->Name !="ClientFin") {
                            $style="";
                            if($reportParameter->Name=="PROT_Admin")
                                $style="display:none";
                            $controls .= "\n<select style='$style' class='form-control' name='$reportParameter->Name' id='$reportParameter->Name' $dependencies>";
                        }else{
                            $valueData="";
                            if (isset($_POST["ArticleDebut"]) && $reportParameter->Name=="ArticleDebut")
                                $valueData = $_POST["ArticleDebut"];
                            if (isset($_POST["ArticleFin"]) && $reportParameter->Name=="ArticleFin")
                                $valueData = $_POST["ArticleFin"];
                            if (isset($_POST["CG_Num"]) && $reportParameter->Name=="CG_Num")
                                $valueData = $_POST["CG_Num"];

                            if (isset($_POST["ClientDebut"]) && $reportParameter->Name=="ClientDebut")
                                $valueData = $_POST["ClientDebut"];
                            if (isset($_POST["ClientFin"]) && $reportParameter->Name=="ClientFin")
                                $valueData = $_POST["ClientFin"];

                            $controls .= "\n<input class='form-control' name='$reportParameter->Name' id='$reportParameter->Name' type='text'
                                            value='$valueData'/>";
                        }

                        if($reportParameter->Name=="Agence"){
                            $isPrincipal = 0;
                            $depotClass = new DepotClass(0,$objet->db);
                            if($admin==0){
                                $isPrincipal = 1;
                                $rows = $depotClass->getDepotUser($_SESSION["id"]);
                            }
                            else {
                                $rows = $depotClass->alldepotShortDetail();
                            }
                            $deNoValue = 0;
                            if(isset($_POST["Agence"])){
                                $deNoValue = $_POST["Agence"];
                            }
                            if($action==12)
                                $rows = $depotClass->alldepotShortDetail();

                            if(sizeof($rows)>1){
                                $controls .= "<option value='0'";
                                if(0==$deNoValue) $controls .= " selected";
                                $controls .= ">Tout</option>";
                            }
                            foreach($rows as $row) {
                                if ($isPrincipal == 0) {
                                    $controls .= "<option value='{$row->DE_No}'";
                                    if ($row->DE_No == $deNoValue) $controls .= " selected";
                                    $controls .= ">{$row->DE_Intitule}</option>";
                                } else {
                                    if ($row->IsPrincipal == 1) {
                                        $controls .= "<option value='{$row->DE_No}'";
                                        if ($row->DE_No == $deNoValue) $controls .= " selected";
                                        $controls .=  ">{$row->DE_Intitule}</option>";
                                    }
                                }
                            }
                        }
                        else if($reportParameter->Name=="Caisse"){
                            $isPrincipal = 0;
                            if($admin==0){
                                $isPrincipal = 1;
                                $result=$objet->db->requete($objet->getCaisseDepot($_SESSION["id"]));
                                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                            }
                            else {
                                $caisseClass = new CaisseClass(0,$objet->db);
                                $rows = $caisseClass->listeCaisseShort();
                            }
                            $caNoValue = 0;
                            if(isset($_POST["Caisse"])){
                                $caNoValue = $_POST["Caisse"];
                            }
                            if(sizeof($rows)>1){
                                $controls .= "<option value='0'";
                                if(0==$caNoValue) $controls .= " selected";
                                $controls .= ">Tout</option>";
                            }
                            foreach($rows as $row) {
                                if ($isPrincipal == 0) {
                                    $controls .= "<option value='{$row->CA_No}'";
                                    if ($row->CA_No == $caNoValue) $controls .= " selected";
                                    $controls .= ">{$row->CA_Intitule}</option>";
                                } else {
                                    if ($row->IsPrincipal == 1) {
                                        $controls .= "<option value='{$row->CA_No}'";
                                        if ($row->CA_No == $caNoValue) $controls .= " selected";
                                        $controls .=  ">{$row->CA_Intitule}</option>";
                                    }
                                }
                            }

                        }







                        else if($reportParameter->Name!="ArticleDebut"
                            && $reportParameter->Name!="ArticleFin" && $reportParameter->Name!="CG_Num"
                            && $reportParameter->Name!="ClientDebut" && $reportParameter->Name !="ClientFin"){
                            foreach ($reportParameter->ValidValues as $values) {
                                //choose the default value only if nothing is set

                                if ($parmVals == null) {
                                    $selected = ($values->Value == $default)
                                        ? "selected='selected'"
                                        : "";
                                    if($reportParameter->Name=="A_Analytique")
                                        if($values->Value == 1)
                                            $selected= "selected='selected'";
                                }
                                else {
                                    $selected = (key_exists($reportParameter->Name, $arr) && $values->Value == $arr[$reportParameter->Name])
                                        ? "selected='selected'"
                                        : "";
                                }
                                $controls .= "\n<option value='{$values->Value}' $selected>{$values->Label}</option>";
                            }
                        }
                        $controls .= "\n</select\n>";
                    }
                    //Boolean needs to be a CheckBox
                    else if($reportParameter->Type == "Boolean")
                    {
                        //choose the default value only if nothing is set
                        if($parmVals == null)
                            $selected = (!empty($default) && $default != "False")
                                ? "checked='checked'"
                                : "";
                        else
                            $selected = (key_exists($reportParameter->Name, $arr) && !empty($arr[$reportParameter->Name]))
                                ? "checked='checked'"
                                : "";
                        $controls .= "\n<input class='form-control' name='$reportParameter->Name' id='$reportParameter->Name' type='checkbox' $selected/>";
                    }
                    //the other types should be entered in TextBoxes (DateTime, Integer, Float)
                    else if($reportParameter->Type == "DateTime")
                    {
                        //choose the default value only if nothing is set
                        if($parmVals == null) {
                            if($default!="") {
                                if(DateTime::createFromFormat('m/d/Y H:i:s A', $default))
                                    $date = DateTime::createFromFormat('m/d/Y H:i:s A', $default);
                                else
                                    $date = DateTime::createFromFormat('d/m/Y H:i:s', $default);
                                $date_conv = $date->format("dmy");
                                $selected = (!empty($default))
                                    ? "value='" . $date_conv . "'"
                                    : "";
                            }
                        }
                        else {
                            $valDate ="";
                            if(key_exists($reportParameter->Name, $arr) && !empty($arr[$reportParameter->Name]))
                                $valDate = $arr[$reportParameter->Name];
                            $tabDate = explode('-' , trim(substr($valDate,0,10)));
                            $date = DateTime::createFromFormat('Y-m-d', $valDate);
                            $date_conv = $date->format("dmy");
                            $selected = (key_exists($reportParameter->Name, $arr) && !empty($arr[$reportParameter->Name]))
                                ? "value='" . $date_conv . "'"
                                : "";
                        }
                        $visible ="text";
                        if($reportParameter->Name=="AffichePrixVen"){
                            $visible="hidden";
                            $selected="value='$flagPxRevient'";
                        }


                        if($reportParameter->Name=="PROT_No"){
                            $visible="hidden";
                            $selected="value='".$protection->Prot_No."'";
                        }
                        $controls .= "\n<input class='form-control' name='$reportParameter->Name' id='$reportParameter->Name' type='$visible' $selected/>";
                    }
                    //the other types should be entered in TextBoxes (DateTime, Integer, Float)
                    else
                    {
                        //choose the default value only if nothing is set
                        if($parmVals == null)
                            $selected = (!empty($default))
                                ? "value='" . $default . "'"
                                : "";
                        else
                            $selected = (key_exists($reportParameter->Name, $arr) && !empty($arr[$reportParameter->Name]))
                                ? "value='" . $arr[$reportParameter->Name] . "'"
                                : "";
                        $visible ="text";

                        if($reportParameter->Name=="AffichePrixVen"){
                            $visible="hidden";
                            $selected="value='$flagPxRevient'";
                        }

                        if($reportParameter->Name=="PROT_No"){
                            $visible="hidden";
                            $selected="value='".$protection->Prot_No."'";
                        }

                        $controls .= "\n<input class='form-control' name='$reportParameter->Name' id='$reportParameter->Name' type='$visible' $selected/>";
                    }

                    $controls .= "</div>";
                    $i++;
                }
                $namerep="";
                $reportNameTab = explode("/", $query);
                $namerep=$reportNameTab[sizeof($reportNameTab)-1];
                $controls .= "\n</div>";
                $controls .= "\n<div class='form-inline' style='display:inline; float: right'>";
                $controls .= "\n<input type='button' onclick=\"renderReportRTC('HTML5');\" class='btn btn-primary' value='Valider' style='float: right;' />";
                $controls .= "\n<input type='button' onclick=\"renderReportRTC('EXCEL');\" class='btn btn-primary' value='Export excel' style='margin-right:10px ;float: right;' />";
                $controls .= "\n<input type='button' onclick=\"renderReportRTC('PDF');\" class='btn btn-primary' value='Imprimer' style='margin-right:10px ;float: right;' />";
                $controls .= getExportFormats($ssrs_report);
                //$controls .= "\n<a style='float: right;' href='indexMVC.php?module=5&action=1'>Liste des états</a>";
                $controls .= "\n</div>";

                $controls .= "\n<input type='hidden' value='' name='parameters' id='parameters' />";
                $controls .= "\n<div id='exportReportDiv' style='visibility: hidden; ' >";
                $controls .= "\n<div class='form-group col-lg-3' >
                                <label>Type d'impression:</label>
                                <input class='form-control' name='exportName' value='$namerep' type='text' onkeypress='submitenter(event);' />
                            </div>";
                $controls .= "\n</div>";
                //We need to get the list of available reports
                //Play with the Types to create a hierarchical menu

                if((isset($_REQUEST['rs:Command']))
                    || (key_exists("reportName", $_REQUEST) && (key_exists("parameters", $_REQUEST) && $_REQUEST["parameters"] != 'true')))
                {
                    if (isset($_REQUEST['rs:ShowHideToggle']))
                    {
                        $ssrs_report->ToggleItem($_REQUEST['rs:ShowHideToggle']);
                    }
                    else if (isset($_REQUEST['rs:Command']))
                    {
                        switch($_REQUEST['rs:Command'])
                        {
                            case 'Sort':
                                $ssrs_report->Sort2($_REQUEST['rs:SortId'],
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
                        $parameters = getReportParameters();

                        if (isset($_REQUEST['ps:OrginalUri']))
                        {
                            $length = strlen($settings["SERVICE_URL"]);
                            $parameters = getReportParametersFromGet();
                        }

                        $executionInfo = $ssrs_report->LoadReport2($query, NULL);
                        //Use these if the SSRS DataSource is configured to use user prompt credentials
                        $dsCredential = new DataSourceCredentials();
                        $dsCredential->DataSourceName = $settings["DATA_SOURCE"]; /*AdventureWorks*/
                        $dsCredential->UserName = $settings["USERNAME"]; /*PHPDemoUser*/
                        $dsCredential->Password = $settings["PWD"]; /*Passw0rd!*/
                        //$ssrs_report->SetExecutionCredentials2(array($dsCredential));
                        $ssrs_report->SetExecutionParameters2($parameters);
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
                    $params = getStreamRootParams();
                    $renderAsHTML->ReplacementRoot = getPageURL();
                    //append form params with ReplacementRoot for preserving them
                    //upon sort/toggle clicks.
                    $renderAsHTML->ReplacementRoot .= $params;
                    $renderAsHTML->StreamRoot = './images/';
                    $result_html = $ssrs_report->Render2($renderAsHTML,
                        PageCountModeEnum::$Actual,
                        $Extension,
                        $MimeType,
                        $Encoding,
                        $Warnings,
                        $StreamIds);
                    foreach($StreamIds as $StreamId)
                    {
                        $renderAsHTML->StreamRoot = null;
                        $result_png = $ssrs_report->RenderStream($renderAsHTML,
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
                }

                echo "\n" . '<div align="center">';
                echo "\n" . '<div style="overflow:auto;">';
                echo "\n<div  align='left'>";
                echo $controls;
                echo "\n</div>";
                echo "<div style='margin-top: 5%;margin-right: 10%;margin-left: 10%;'>$result_html</div>";
                echo "\n" . '</div>';
                echo "\n" . '</div>';
            }
            catch(SSRSReportException $serviceExcprion)
            {
                echo  "\n<br/>" . $serviceExcprion->GetErrorMessage();
                $trace = str_replace("#", "<br />", $serviceExcprion->getTraceAsString());
                echo  "<br />" . $trace;
            }
            echo "\n";

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

            /**
             * Parse params varible and populate the
             * $_REQUEST object.
             */
            function parsePostBack()
            {
                if(!key_exists("params", $_REQUEST))
                {
                    return;
                }

                //Check for Drill down, means user navigate to a new report so the params
                //are not valid. We can assume user moved to new page if ps:OrginalUri
                //is set and no sort or toggle flags are on.
                if(key_exists("ps:OrginalUri", $_REQUEST) &&
                    !key_exists("rs:Command", $_REQUEST) &&
                    !key_exists("rs:ShowHideToggle", $_REQUEST))
                {
                    unset($_REQUEST['params']);
                    $settings = parse_ini_file("app.config", 1);
                    $length = strlen($settings["SERVICE_URL"]);
                    //$query = substr($_REQUEST['ps:OrginalUri'], $length + 2); //adding for ?
                    $_REQUEST['reportName'] = $query;
                }

                $parameters = array();
                $params = explode('$$', $_REQUEST['params']);
                foreach($params as $param)
                {
                    $keyval = explode('=', $param);
                    if(count($keyval) == 2)
                    {
                        $_REQUEST[$keyval[0]] = $keyval[1];
                    }
                }
                unset($_REQUEST['params']);
            }

            /**
             * The RenderAsHTML::StreamRoot memeber variable can be used to preserve
             * form variables upon sort/toggle clicks. This function will create a string
             * of keyvalue pairs (form variable name and value) seperated by '$$' symbol.
             */
            function getStreamRootParams()
            {
                $params = null;
                $module = null;
                $i=0;
                foreach($_REQUEST as $key => $post)
                {
                    if($key == "params")
                        continue;
                    if(strpos($key,'rc:') === 0)
                        continue;
                    if(strpos($key,'rs:') === 0)
                        continue;
                    if(strpos($key,'ps:') === 0)
                        continue;
                    if($key!="module" && $key!="action")
                    {
                        if(!empty($post))
                        {
                            $params .= $key . '=' . $post . '$$';
                            $i++;
                        }
                    }else{
                        if($key=="module")
                            $module .= $key . '=' . $post . '&';
                        if($key=="action")
                            $module .= $key . '=' . $post . '';
                        $i++;
                    }
                    if($i > 100)
                        break;
                }

                return ($params == null ? null: '?params=' . $params);
            }

            function getReportParameters()
            {
                if(key_exists("parameters", $_REQUEST))
                {
                    $parameters = array();
                    $i=0;
                    foreach($_REQUEST as $key => $post)
                    {
                        if($key == "reportName")
                            continue;
                        if($key == "parameters")
                            continue;
                        if($key == "exportSelect")
                            continue;
                        if($key == "exportName")
                            continue;
                        if($key == "params")
                            continue;
                        if(strpos($key,'rc:') === 0)
                            continue;
                        if(strpos($key,'rs:') === 0)
                            continue;
                        if(strpos($key,'ps:') === 0)
                            continue;
                        if(!empty($post))
                        {
                            if($key!="action" && $key!="module") {
                                $parameters[$i] = new ParameterValue();
                                $parameters[$i]->Name = $key;
                                $parameters[$i]->Value = $post;
                                $i++;
                            }
                        }
                        if($i > 100)
                            break;
                    }
                    return $parameters;
                }
                else
                    return null;
            }

            function getReportParametersFromGet()
            {
                $parameters = array();
                $i=0;
                foreach($_GET as $key => $post)
                {
                    if(strrpos($key, ":"))
                        continue;
                    if(!empty($post))
                    {
                        if($key!="action" && $key!="module"){
                            $parameters[$i] = new ParameterValue();
                            $key = substr($key, strpos($key, ";") + 1);
                            $parameters[$i]->Name = $key;
                            $parameters[$i]->Value = $post;
                            $i++;
                        }
                    }
                }

                return $parameters;
            }

            function getExportFormats($ssrs_report)
            {
                $extensions = $ssrs_report->ListRenderingExtensions();
                $result = array();
                foreach($extensions as $extension)
                {
                    $result[] = $extension->Name;
                }

                /*$controls = "Format d'impression: <select id='exportSelect' class='form-control' name='exportSelect' onchange='exportType(value)' >";
                foreach ($result as $format)
                {
                    $selected = ($format == "HTML4.0")
                        ? "selected='selected'"
                        : "";

                    if($format != "RGDI" && $format != "RPL")
                        $controls .= "\n<option value='$format' $selected>$format</option>";
                }
                $controls .= "\n</select>";
                return $controls;*/
                return "<input type='hidden' id='exportSelect' class='form-control' name='exportSelect'/>";
            }

            ?>
            <input type="hidden" id="reportName" name="reportName"
                   value="<?php /*if(key_exists("reportName", $_REQUEST))*/ echo $query;//$_REQUEST["reportName"]; ?>" />
        </form>

        <script type="text/javascript">
            function exportType(value)
            {
                /*if(value.match("HTML."))
                    exportReportDiv.style.visibility = 'hidden';
                else
                    exportReportDiv.style.visibility = '';*/
            }

            function getParameters()
            {
                reportForm.parameters.value = true;
                reportForm.submit();
            }

            function setReport(report)
            {
                if(report != "")
                {
                    reportForm.reportName.value = report;
                    reportForm.submit();
                }
            }

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

            function renderReport()
            {
                var ancienDebut = $("#DateDebut").val();
                var ancienFin = $("#DateFin").val();
                $("#DateDebut").val("20" +$("#DateDebut").val().substr(4, 2) + "-" + $("#DateDebut").val().substr(2, 2)+ "-" +$("#DateDebut").val().substr(0, 2));
                $("#DateFin").val("20" +$("#DateFin").val().substr(4, 2) + "-" + $("#DateFin").val().substr(2, 2)+ "-" +$("#DateFin").val().substr(0, 2));
                $("#ArticleDebutParam").val($("#ArticleDebut").val())
                $("#ClientDebutParam").val($("#ClientDebut").val())
                $("#ClientFinParam").val($("#ClientFin").val())
                value = reportForm.exportSelect.value;
                reportForm.parameters.value = false;
                if(reportForm.exportName.value == "" && !value.match("HTML."))
                {
                    alert("Please enter a name for the report!");
                    return;
                }

                if(value.match("HTML."))
                    reportForm.action = "indexMVC.php?module="+$_GET("module")+"&action="+$_GET("action");
                else{
                    reportForm.setAttribute("target", "_blank");
                    reportForm.action = "pages/Etat/Download.php";
                }
                reportForm.submit();
                reportForm.setAttribute("target", "");
            }

            function renderReportRTC($val) {
                var ancienDebut = $("#DateDebut").val();
                var ancienFin = $("#DateFin").val();
                $("#ArticleDebut").val($("#ArticleDebutParam").val())
                $("#ArticleFin").val($("#ArticleFinParam").val())
                $("#ClientDebut").val($("#ClientDebutParam").val())
                $("#ClientFin").val($("#ClientFinParam").val())
                value = reportForm.exportSelect.value;
                reportForm.parameters.value = false;
                //$("#montant").val($("#montant").val().replace(/ /g,"").replace(",","."));
                if ($val == "HTML5") {
                    reportForm.action = "indexMVC.php?module="+$_GET("module")+"&action="+$_GET("action");
                    //$("#DateDebut").val("20" + $("#DateDebut").val().substr(4, 2) + "-" + $("#DateDebut").val().substr(2, 2) + "-" + $("#DateDebut").val().substr(0, 2));
                    //$("#DateFin").val("20" + $("#DateFin").val().substr(4, 2) + "-" + $("#DateFin").val().substr(2, 2) + "-" + $("#DateFin").val().substr(0, 2));
                        if ($("#dateIndique").val() == 0) {
                            if($("#DateDebut").val()!=undefined && $("#DateFin").val()!=undefined) {
                                $("#DateDebut").val("20" + $("#DateDebut").val().substr(4, 2) + "-" + $("#DateDebut").val().substr(2, 2) + "-" + $("#DateDebut").val().substr(0, 2));
                                $("#DateFin").val("20" + $("#DateFin").val().substr(4, 2) + "-" + $("#DateFin").val().substr(2, 2) + "-" + $("#DateFin").val().substr(0, 2));
                            }
                        } else {
                            if($("#DateDebut").val()!=undefined)
                            $("#DateDebut").val("2020-01-01")
                        }
                    reportForm.submit();
                    reportForm.setAttribute("target", "");
                }
                else {
                    if ($("#dateIndique").val() == 0){
                    }else{
                        $("#DateDebut").val("200101")
                        $("#DateFin").val("200101")
                    }
                    reportForm.exportSelect.value = $val;
                    reportForm.setAttribute("target", "_blank");
                    reportForm.action = "pages/Etat/Download.php";
                    reportForm.submit();
                    reportForm.setAttribute("target", "");
                }
            }

            function submitenter(e)
            {
                var keycode;
                if (window.event) keycode = window.event.keyCode;
                else if (e) keycode = e.which;
                else return true;

                if (keycode == 13)
                {
                    renderReport();
                    return false;
                }
                else
                    return true;
            }

        </script>
