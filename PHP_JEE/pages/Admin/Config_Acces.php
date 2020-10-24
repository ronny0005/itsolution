<?php
$prot_no = 0;
if(isset($_POST["PROT_No"]))
    $prot_no = $_POST["PROT_No"];

$objet = new ObjetCollector();
?>
    <script src="js/script_configProfil.js?d=<?php echo time(); ?>"></script>
    <script>
        $( function() {
            $( "#accordion" ).accordion({
                collapsible: true
            });
        } );
</script>
    </head>
    <body>
    <?php
    include("module/Menu/BarreMenu.php");
    ?>
    </head>
    <div id="milieu">
        <div class="container">

            <div class="container clearfix">
                <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
                    <?php echo $texteMenu; ?>
                </h4>
            </div>
            <form id="codeClient" class="codeClient" action="indexMVC.php?module=8&action=10" method="POST">
                <input name="action" value="10" type="hidden"/>
                <input name="module" value="8" type="hidden"/>
                <div class="col-lg-3">
                    <label>Profil :</label>
                <select class="form-control " name="PROT_No" id="PROT_No">
                    <?php
                    $protectionClass = new ProtectionClass("","");
                    $rows = $protectionClass->getProfilAdminMain();
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            echo "<option value='".$row->PROT_No."'";
                            if($prot_no==$row->PROT_No) echo "selected";
                            echo ">".$row->Prot_User;
                                echo "</option>";
                        }
                    }
                    ?>
                </select>

                <input type="button" value="valider" style="margin-top:10px" name="valide" id="valide" class="btn btn-primary"/>

                </div>
                <div id="accordion" class="col-lg-4">
                    <?php
                    $rows = $protectionClass->getProtectionListTitre();
                    if ($rows != null) {
                        foreach ($rows as $row) {
                            echo "<h3>" . $row->TE_Intitule . "</h3>";
                            $rowstr = $protectionClass->getProtectionListElement($row->TE_No);
                            echo "<div>";
                            if ($rowstr != null) {
                                foreach ($rowstr as $rowtr) {
                                    echo "<p>" .$rowtr->TE_Intitule;
                                    $rowstritem = $protectionClass->getDataUserNo($rowtr->TE_No,$prot_no);
                                    if ($rowstritem != null) {
                                        foreach ($rowstritem as $rowtritem) {
                                            if($rowtritem->TypeFlag==0) {
                                                echo "
                                    <span id='TE_No'  style='display: none'>" . $rowtritem->TE_No . "</span>
                                    <select class='form-control' name='selectProtect' id='selectProtect'>
                                    <option value='1'";
                                                if ($rowtritem->EPROT_Right == 1) echo "selected";
                                                echo ">écriture</option>
                                    <option value='2'";
                                                if ($rowtritem->EPROT_Right == 2) echo "selected";
                                                echo ">lecture et écriture</option>
                                    <option value='3'";
                                                if ($rowtritem->EPROT_Right == 3) echo "selected";
                                                echo ">suppression</option>
                                    <option value='-1'";
                                                if ($rowtritem->Prot_No == 0) echo "selected";
                                                echo ">aucune</select>";
                                                echo "<input type='hidden' name='modif' id='modif' value='0'/>";
                                            }else{
                                                echo "<span id='TE_No'  style='display: none'>" . $rowtritem->TE_No . "</span>
                                                    <select class='form-control' name='selectProtect' id='selectProtect'>
                                                    <option value='0'";
                                                                if ($rowtritem->EPROT_Right == 0) echo "selected";
                                                                echo ">non</option>
                                                    <option value='2'";
                                                                if ($rowtritem->EPROT_Right == 2) echo "selected";
                                                                echo ">oui</option></select>";
                                                echo "<input type='hidden' name='modif' id='modif' value='0'/>";
                                            }
                                        }
                                    }
                                    echo "</p>";
                                }
                            }
                            echo "</div>";
                        }
                    }

                    ?>
                </div>

            </form>
<?php

?>