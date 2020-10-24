<?php
$compl = "";
if($type=="Transfert_detail")
    $compl = "(Dépôt source)";
?>

<fieldset class="entete">
    <legend class="entete">Pied</legend>
    <div id="piedPage" class="form-group">
    </div>
</fieldset>
</div>
<div class="row">
<form action="indexMVC.php?action=1&module=4" method="GET" name="form-valider" id="form-valider">
    <input type="hidden" value="4" name="module"/>
    <input type="hidden" value="1" name="action"/>
        <input type="hidden" name="entete" id="valide_entete" value="0"/>
        <input type="hidden" name="client" id="valide_client" value="0"/>
        <input type="hidden" name="uid" id="uid" value="<?php echo $_SESSION["id"];?>"/>
        <input type="hidden" name="montant_avance" id="montant_avance" value="0"/>
        <input type="hidden" name="montant_total" id="montant_total" value="<?php if($flagPxRevient==0) echo $totalttc; ?>"/>
        <input type="hidden" id="imprime_val" name="imprime_val" value="0"/>
	     <button type="button" class="btn btn-primary" id="annuler" <?php if($isVisu==1 || !isset($_GET["cbMarq"])) echo "disabled"; ?> >Annuler</button>
        <button type="button" class="btn btn-primary" id="valider" <?php if($isVisu==1 || !isset($_GET["cbMarq"])) echo "disabled"; ?>>Valider</button>
        <input type="button"  class="btn btn-primary" value="Imprimer" id="imprimer" <?php if($isVisu==1 || !isset($_GET["cbMarq"])) echo "disabled"; ?>/>
    </form>
</div>

<div id="dialog-confirm" title="Suppression" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Voulez vous supprimez cette ligne ?</p>
</div>

<?php
echo "<div id='formArticleFactureBis' style='display: none;'>";

echo "</div>";
?>
