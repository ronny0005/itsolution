<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/script_etat.js?d=<?php echo time(); ?>"></script>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
include("enteteParam.php");
?>
<div id="milieu">
    <div class="container">
        <!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
        <form name="reportForm" id="reportForm" method="POST" action="indexMVC.php?module=5&action=1">
            <?php
            /**
             *
             * Copyright (c) 2009, Persistent Systems Limited
             *
             * Redistribution and use, with or without modification, are permitted
             *  provided that the following  conditions are met:
             *   - Redistributions of source code must retain the above copyright notice,
             *     this list of conditions and the following disclaimer.
             *   - Neither the name of Persistent Systems Limited nor the names of its contributors
             *     may be used to endorse or promote products derived from this software
             *     without specific prior written permission.
             *
             * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
             * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
             * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
             * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
             * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
             * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
             * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
             * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
             * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
             * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
             * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
             */

            require_once 'SSRSReport.php';
            //load config file variables
            $settings = parse_ini_file("app.config", 1);

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

                    $query = "/RapportsZUMI/Echeance client";//$_REQUEST["reportName"];
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
                        $controls .= '<div class="form-group col-lg-3" >';
                        $default = null;
                        foreach($reportParameter->DefaultValues as $vals)
                            foreach($vals as $key=>$def)
                                $default = $def;
                        $controls .= '<label>'.$reportParameter->Prompt . "</label>";
                        //If there is a list, then it needs to be a Select box
                        if(sizeof($reportParameter->ValidValues) > 0){
                            $dependencies = empty($reportParameter->Dependencies) ? "onchange='getParameters();'" : "";
                            $controls .= "\n<select class='form-control' name='$reportParameter->Name' id='$reportParameter->Name' $dependencies>";
                            foreach($reportParameter->ValidValues as $values)
                            {
                                //choose the default value only if nothing is set
                                if($parmVals == null)
                                    $selected = ($values->Value == $default)
                                        ? "selected='selected'"
                                        : "";
                                else
                                    $selected = (key_exists($reportParameter->Name, $arr) && $values->Value == $arr[$reportParameter->Name])
                                        ? "selected='selected'"
                                        : "";
                                $controls .= "\n<option value='" . $values->Value . "' $selected>" . $values->Label . "</option>";
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
                                $tabDate = explode('/' , trim(substr($default,0,10)));
                                print_r($tabDate);
                                $date_conv  = substr('0'.$tabDate[1],-2).substr('0'.$tabDate[0],-2).substr($tabDate[2],2,2);
                                $selected = (!empty($default))
                                    ? "value='" . $date_conv . "'"
                                    : "";
                            }
                            else {
                                $valDate ="";
                                if(key_exists($reportParameter->Name, $arr) && !empty($arr[$reportParameter->Name]))
                                    $valDate = $arr[$reportParameter->Name];
                                $tabDate = explode('/' , trim(substr($default,0,10)));
                                $date_conv  = substr('0'.$tabDate[1],-2).substr('0'.$tabDate[0],-2).substr($tabDate[2],2,2);
                                $selected = (key_exists($reportParameter->Name, $arr) && !empty($arr[$reportParameter->Name]))
                                    ? "value='" . $date_conv . "'"
                                    : "";
                            }
                            $visible ="text";
                            if($reportParameter->Name=="AffichePrixVen"){
                                $visible="hidden";
                                $selected="value='$flagPxRevient'";
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
                            $controls .= "\n<input class='form-control' name='$reportParameter->Name' id='$reportParameter->Name' type='$visible' $selected/>";
                        }

                        $controls .= "</div>";
                        $i++;
                    }
                    $namerep="";
                    if(isset($_REQUEST["reportName"])) {
                        $reportNameTab = explode("/", $_REQUEST["reportName"]);
                        $namerep=$reportNameTab[sizeof($reportNameTab)-1];
                    }
                    $controls .= "\n</div>";
                    $controls .= "\n<div style='float: right; width: 200px;'>";
                    $controls .= "\n<input type='button' onclick=\"renderReportRTC('HTML5');\" class='btn btn-primary' value='Valider' style='float: right;' />";
                    $controls .= "\n<input type='button' onclick=\"renderReportRTC('EXCEL');\" class='btn btn-primary' value='Export excel' style='float: right;' />";
                    $controls .= "\n<input type='button' onclick=\"renderReportRTC('PDF');\" class='btn btn-primary' value='Imprimer' style='float: right;' />";
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
                //}
                //We need to get the list of available reports
                //Play with the Types to create a hierarchical menu
                /*else
                {

                    $catalogItems = $ssrs_report->ListChildren("/RapportsZUMI", true);
                    $reports = array();
                    $controls = "Liste des etats : <select id='report' name='report' class='form-control' style='width:200px' onchange='setReport(value);'>";
                    $controls .= "\n<option value=''>Choississez un etat</option>";
                    foreach ($catalogItems as $catalogItem)
                    {
                        if($catalogItem->Type == "Report" && $catalogItem->Type == "Report" )
                            $controls .= "\n<option value='$catalogItem->Path'>$catalogItem->Name</option>";
                    }
                    $controls .= "\n</select>";
//                    $controls = "Liste des etats :";

                }
*/
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
                        $query = $_REQUEST["reportName"];
                        $parameters = getReportParameters();

                        if (isset($_REQUEST['ps:OrginalUri']))
                        {
                            $length = strlen($settings["SERVICE_URL"]);
                            $query = substr($_REQUEST['ps:OrginalUri'], $length);
                            $parameters = getReportParametersFromGet();
                        }

                        $executionInfo = $ssrs_report->LoadReport2($query, NULL);
                        //Use these if the SSRS DataSource is configured to use user prompt credentials
//           $dsCredential = new DataSourceCredentials();
//           $dsCredential->DataSourceName = $settings["DATA_SOURCE"]; /*AdventureWorks*/
//           $dsCredential->UserName = $settings["UID"]; /*PHPDemoUser*/
//           $dsCredential->Password = $settings["PASWD"]; /*Passw0rd!*/
//           $ssrs_report->SetExecutionCredentials2(array($dsCredential));
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
                echo "<div style='padding-left :100px'>$result_html</div>";
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
                    $query = substr($_REQUEST['ps:OrginalUri'], $length + 2); //adding for ?
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

                    if(!empty($post))
                    {
                        $params .= $key . '=' . $post . '$$';
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
                   value="<?php if(key_exists("reportName", $_REQUEST)) echo $_REQUEST["reportName"]; ?>" />
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
            function renderReport()
            {
                var ancienDebut = $("#DateDebut").val();
                var ancienFin = $("#DateFin").val();
                $("#DateDebut").val("20" +$("#DateDebut").val().substr(4, 2) + "-" + $("#DateDebut").val().substr(2, 2)+ "-" +$("#DateDebut").val().substr(0, 2));
                $("#DateFin").val("20" +$("#DateFin").val().substr(4, 2) + "-" + $("#DateFin").val().substr(2, 2)+ "-" +$("#DateFin").val().substr(0, 2));

                value = reportForm.exportSelect.value;
                reportForm.parameters.value = false;
                if(reportForm.exportName.value == "" && !value.match("HTML."))
                {
                    alert("Please enter a name for the report!");
                    return;
                }

                if(value.match("HTML."))
                    reportForm.action = "indexMVC.php?module=5&action=1";
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

                value = reportForm.exportSelect.value;
                reportForm.parameters.value = false;

                if ($val == "HTML5") {
                    reportForm.action = "indexMVC.php?module=5&action=1";
                    $("#DateDebut").val("20" + $("#DateDebut").val().substr(4, 2) + "-" + $("#DateDebut").val().substr(2, 2) + "-" + $("#DateDebut").val().substr(0, 2));
                    $("#DateFin").val("20" + $("#DateFin").val().substr(4, 2) + "-" + $("#DateFin").val().substr(2, 2) + "-" + $("#DateFin").val().substr(0, 2));
                    reportForm.submit();
                    reportForm.setAttribute("target", "");
                }
                else {
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
