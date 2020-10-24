<?php
include("module/includeHeader.php");

$etatClass = new EtatClass();
$list =  $etatClass->menuCaParDepot(20);
?>
<data>
<?php
foreach($list as $elt){
?>
    <point>
        <label><?= $elt->DE_Intitule ?></label>
        <y><?= $elt->TotCATTCNet ?></y>
    </point>
<?php
}
?>
</data>
