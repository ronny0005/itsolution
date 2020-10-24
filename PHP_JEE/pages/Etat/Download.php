<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>
<body>
<form name="reportForm" id="reportForm" method="POST" action="Download.php">
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
    $settings = parse_ini_file(__DIR__."\..\..\config\app.config", 1);


    try
    {
        $ssrs_report = new SSRSReport(new Credentials($settings["UID"], $settings["PASWD"]),$settings["SERVICE_URL"]);
        $controls = null;
        if(key_exists("DateDebut", $_POST)) {
            $_POST["DateDebut"] = "20".substr($_POST["DateDebut"],4,2)."-".substr($_POST["DateDebut"],2,2)."-".substr($_POST["DateDebut"],0,2);
        }
        if(key_exists("DateFin", $_POST)) {
            $_POST["DateFin"] = "20".substr($_POST["DateFin"],4,2)."-".substr($_POST["DateFin"],2,2)."-".substr($_POST["DateFin"],0,2);
        }
            if(key_exists("exportSelect", $_POST))
        {
            $executionInfo = $ssrs_report->LoadReport2($_POST["reportName"], NULL);
            $parameters = getReportParameters(true);
            $ssrs_report->SetExecutionParameters2($parameters);
            $render = getRenderType($_POST["exportSelect"]);
            $result_html = $ssrs_report->Render2($render,
                PageCountModeEnum::$Estimate,
                $Extension,
                $MimeType,
                $Encoding,
                $Warnings,
                $StreamIds);

            if($_POST["exportSelect"]=="PDF"){
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="' . $saveName . '"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                echo $result_html;
            }else{
                $saveName = $_POST["exportName"] . getExtension($_POST["exportSelect"]);
                if (!$handle = fopen("" . $saveName, 'wb')) {
                    echo "Cannot open file for writing output";
                    exit;
                }

                if (fwrite($handle, $result_html) === FALSE) {
                    echo "Cannot write to file";
                    exit;
                }
                fclose($handle);

                echo "<script type='text/javascript'>window.location.replace('./dllFiles.php?fichier=$saveName');setTimeout(function () { window.close();}, 3000);</script>";
            }
        }
        echo "<script type='text/javascript'>alert('Export failed'); window.close();</script>";
    }
    catch(SSRSReportException $serviceExcprion)
    {
        echo  "\n<br/>" . $serviceExcprion->GetErrorMessage();
        $trace = str_replace("#", "<br />", $serviceExcprion->getTraceAsString());
        echo  "<br />" . $trace;
    }

    function getRenderType($type)
    {

        switch($type)
        {
            case "CSV":
                return new RenderAsCSV();

            case "EXCEL":
                return new RenderAsEXCEL();

            case "IMAGE":
                return new RenderAsIMAGE();

            case "PDF":
                return new RenderAsPDF();

            case "WORD":
                return new RenderAsWORD();

            case "XML":
                return new RenderAsXML();

            default:
                return null;
        }
    }

    function getExtension($type)
    {

        switch($type)
        {
            case "CSV":
                return ".csv";

            case "EXCEL":
                return ".xls";

            case "IMAGE":
                return ".jpg";

            case "PDF":
                return ".pdf";

            case "WORD":
                return ".doc";

            case "XML":
                return ".xml";

            default:
                return null;
        }
    }

    function getReportParameters($ex)
    {

        $parameters = array();
        $i=0;
        foreach($_POST as $key => $post)
        {
            if($ex && $key == "reportName")
                continue;
            if($key == "parameters")
                continue;
            if($key == "exportSelect")
                continue;
            if($key == "exportName")
                continue;
            if(!empty($post))
            {
                $parameters[$i] = new ParameterValue();
                $parameters[$i]->Name = $key;
                $parameters[$i]->Value = $post;
                $i++;
            }
            if($i > 100)
                break;
        }
        return $parameters;
    }
    ?>

    <div align="center">
        <div style='background-color:gray; width:700px; height: 50px; text-align: left;' align='left'>
            <?php echo $controls; ?>
        </div>
    </div>
</form>
</body>
</html>
