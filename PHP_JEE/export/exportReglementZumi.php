<?php 
ob_start();

include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
$objet = new ObjetCollector();   
$nomSociete="";
$bp="";
$rcn="";
$nc="";
$cp="";
$ville = "";
$pays = "";
$tel = "";
$email = "";
$profession = "";
$type=0;
$client="0";
if($_GET["CT_Num"]!="")
    $client =$_GET["CT_Num"];
$treglement=0;
$caisse=0;
if(isset($_GET["datedeb"]))
    $datedeb=date_format(date_create($_GET["datedeb"]),"d/m/Y");
if(isset($_GET["datefin"]))
    $datefin=date_format(date_create($_GET["datefin"]),"d/m/Y");
if(isset($_GET["datedeb"]))
    $datedeb=$_GET["datedeb"];
if(isset($_GET["datefin"]))
    $datefin=$_GET["datefin"];
if(isset($_GET["type"]))
    $type=$_GET["type"];
if(isset($_GET["type"])) $type=$_GET["type"];
if(isset($_GET["caisse"])) $caisse=$_GET["caisse"];
if(isset($_GET["mode_reglement"])) $treglement=$_GET["mode_reglement"];
$result=$objet->db->requete($objet->getNumContribuable());     
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}
else{
    $nomSociete=$rows[0]->D_RaisonSoc;
    $cp = $rows[0]->D_CodePostal; 
    $ville = $rows[0]->D_Ville;
    $pays=$rows[0]->D_Pays;
    $email = $rows[0]->D_EmailSoc;
    $tel = $rows[0]->D_Telephone;
    $profession = $rows[0]->D_Profession;
    
    $bp=$rows[0]->D_CodePostal." ".$rows[0]->D_Ville." ".$rows[0]->D_Pays;
    $rcn=$rows[0]->D_Identifiant;
    $nc=$rows[0]->D_Siret;
}
$intitule="";
$result=$objet->db->requete($objet->getClientByCTNum($_GET["CT_Num"]));     
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}
else{
    $intitule=$rows[0]->CT_Intitule;
}
$requete="SELECT ISNULL(RC_Montant,0) AS RC_Montant, C.RG_No,DO_PIECE,RIGHT( '00'+CAST(DAY(RG_Date) AS VARCHAR(2)),2)+'/'+RIGHT( '00'+CAST(MONTH(RG_Date)AS VARCHAR(2)),2)+'/'+CAST(YEAR(RG_Date) AS VARCHAR(4))  AS RG_Date,RG_Libelle,RG_Montant,CA_No
FROM F_CREGLEMENT C
LEFT JOIN (SELECT RG_No,DO_PIECE,sum(RC_Montant) AS RC_Montant FROM F_REGLECH GROUP BY RG_No,DO_PIECE) R ON R.RG_No=c.RG_No
WHERE RG_Date BETWEEN '$datedeb' AND '$datefin' ORDER BY RG_DATE DESC;";
$typeRegl="Client";
if(isset($_GET["typeRegl"]))
    $typeRegl=$_GET["typeRegl"];
$typeSelectRegl = 0;
if($typeRegl!="Client") $typeSelectRegl = 1;
$collab= 0;
if($typeRegl=="Collaborateur") $collab=1;
$result=$objet->db->requete($objet->getReglementByClient2($client, $caisse, $type, $treglement, $datedeb, $datefin, 0, $collab, $typeSelectRegl));
//$result=$objet->db->requete($objet->getReglement($client,$type,$treglement,$datedeb,$datefin,$caisse,0));
//$result=$objet->db->requete($requete);     
$rows = $result->fetchAll(PDO::FETCH_OBJ);

$total = 0;
        for($i=0;$i<count($rows);$i++){
            $total=$total+round($rows[$i]->RC_Montant,0);
        }
    ?>
<style>
#bloc{
    font-size:14px;
}
table.facture {
}
table.facture th , table.facture td{
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
}
table.facture td {
}

</style>
<div id="bloc">    
<table>
        <tr>
            <td style="width: 400px">
                <?php echo "<b>".$nomSociete."</b><br/>".$profession."<br/>BP ".$cp." ".$ville."<br/>"; ?>
            </td>
            <td>
            </td>
        </tr>
    </table>
    <br/>
    <div style="text-align:center; font-size:20px" id="numFacture"><b>REGLEMENT CLIENT</b><br/></div>
    <br/>
    <div style="text-align:right" id="date">Référence</div>
    <div>Cher client,<br/><br/>
    Nous avons bien recu votre règlement et nous vous en remercions.<br/>
    Veuillez prendre note des échéances auxquelles il se rapporte :<br/><br/>
    </div>
    <table>
        <tr>
            <td style="width: 350px">Règlement en date du <?php $datedebf = new DateTime($datedeb);$datefinf = new DateTime($datedeb); echo $datedebf->format("d/m/Y")." au ".$datefinf->format("d/m/Y"); ?></td>
            <td>Pour un montant de : <b><?php echo $objet->formatChiffre($total); ?></b></td></tr>
    </table>
<br/>        
        <table id="table" class="facture" style="">
            <thead>
            <tr>
                <th style="text-align:left">N de facture</th>
                <th style="text-align:left">N° Tiers</th>
                <th style="text-align:left">Date</th>
                <th style="text-align:left;width: 50px">Libellé règlement</th>
             <!--   <th style="text-align:left">Date échéance</th> -->
                <th style="text-align:left">Montant facture</th>
                <th style="text-align:left">Règlement</th>
                <th style="text-align:left">Reste à régler</th>
            </tr>
            </thead>
        <tbody>
<?php
        $somRG=0;
        $somRC=0;
        $somRegle=0;
        for($i=0;$i<count($rows);$i++){
            $somRG=$somRG+$rows[$i]->RG_Montant;
            $somRC=$somRC+$rows[$i]->RC_Montant;
            $somRegle=$somRegle+($rows[$i]->RG_Montant - $rows[$i]->RC_Montant);
            echo "<tr><td style='text-align:left'>".$rows[$i]->DO_Piece."</td>
                <td style='text-align:left'>".$rows[$i]->CT_NumPayeur."</td>
            <td style='text-align:left;width: 50px'>".$rows[$i]->RG_Date."</td><td style='text-align:left'>".$rows[$i]->RG_Libelle."</td>"
           //. "<td style='text-align:left'>".$rows[$i]->RG_Date."</td>"
            ."<td style='text-align:right'>".$objet->formatChiffre(round($rows[$i]->RG_Montant,0))."</td>"
            ."<td style='text-align:right'>".$objet->formatChiffre(round($rows[$i]->RC_Montant,0))."</td>"
            ."<td style='text-align:right'>".$objet->formatChiffre(ROUND($rows[$i]->RG_Montant - $rows[$i]->RC_Montant))."</td>"
                    ."</tr>";
        }
        echo "<tr style='font-weight:bold'><td colspan='4'>Total</td><td style='text-align:right'>".$objet->formatChiffre($somRG)."</td>"
                . "<td style='text-align:right'>".$objet->formatChiffre($somRC)."</td>"
                . "<td style='text-align:right'>".$objet->formatChiffre($somRegle)."</td></tr>";
        ?>
        </tbody>
        </table>
<br/>
<br/>
<br/>
<br/>
<br/>
<hr/>
<table style="width: 100%">
    <tr>
        <td style="font-size: 12px;width:300px;text-align: center"><?php echo "BP ".$cp." ".$ville; ?></td>
        <td style="font-size: 12px;width:500px;text-align: center">Situé à la <br/>N° Contrib : <?php echo $rcn." - RC ".$nc; ?></td>
        <td style="font-size: 12px;width:200px;text-align: center"><?php echo "Tel : ".$tel." <br/>Email : ".$email; ?></td>
    </tr>
</table>
        </div>
<?php        
    $content = ob_get_clean();

    // convert in PDF
    require_once("../vendor/autoload.php");
    try
    {
        
        $html2pdf = new HTML2PDF('L', 'A4', 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output('REGLEMNT.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>