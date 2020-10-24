<?php
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/LogFile.php");
include("../Modele/ContatDClass.php");
include("../Modele/DocEnteteClass.php");
include("../Modele/DocLigneClass.php");
include("../Modele/ComptetClass.php");
include("../Modele/ReglementClass.php");
include("../Modele/CaisseClass.php");
include("../Modele/ArticleClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/EtatClass.php");
$objet = new ObjetCollector();

function dateDiff($date1, $date2){
    $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $retour = array();

    $tmp = $diff;
    $retour['second'] = $tmp % 60;

    $tmp = floor( ($tmp - $retour['second']) /60 );
    $retour['minute'] = $tmp % 60;

    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['hour'] = $tmp % 24;

    $tmp = floor( ($tmp - $retour['hour'])  /24 );
    $retour['day'] = $tmp;

    return $retour;
}
// Création de l'entete de document
if($_GET["acte"] =="ajout_entete"){
    $admin = 0;
    $limitmoinsDate = "";
    $limitplusDate = "";
    if(isset($_SESSION)){
        $protectionClass = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
        if($protectionClass->PROT_Right!=1) {
            if($protectionClass->getDelai()!=0) {
                $limitmoinsDate = date('d/m/Y', strtotime(date('Y-m-d') . " - " . $protectionClass->getDelai() . " day"));
                $limitplusDate = date('d/m/Y', strtotime(date('Y-m-d') . " + " . $protectionClass->getDelai() . " day"));
                $str = strtotime(date("M d Y ")) - (strtotime($_GET["date"]));
                $nbDay = abs(floor($str / 3600 / 24));
                if ($nbDay > $protectionClass->getDelai())
                    $admin = 1;
            }
        }
    }

    $docEntete = new DocEnteteClass(0);
    $cloture = 0;
    if($_GET["type_fac"]!="Entree" && $_GET["type_fac"]!="Sortie" && $_GET["type_fac"]!="Transfert" && $_GET["type_fac"]!="Transfert_detail" && $_GET["type_fac"]!="Transfert_emission")
    $cloture = $docEntete->journeeCloture($_GET["date"],$_GET["ca_no"]);

    if($admin==0 && $cloture == 0) {
        echo json_encode($docEntete->ajoutEntete( isset($_GET["do_piece"]) ? $_GET["do_piece"] : "%20",
            $_GET["type_fac"], $_GET["date"], $_GET["date"], $_GET["affaire"], $_GET["client"], isset($_GET["protNo"]) ? $_GET["protNo"] : "",
            "", isset($_GET["machineName"]) ? $_GET["machineName"] : "%20",
            isset($_GET["doCood2"]) ? $_GET["doCood2"] : "%20", isset($_GET["doCood3"]) ? $_GET["doCood3"] : "%20",isset($_GET["DO_Coord04"]) ? $_GET["DO_Coord04"] : "%20",
            isset($_GET["do_statut"])? $_GET["do_statut"] : "0", 0,0, $_GET["de_no"], isset($_GET["cat_tarif"]) ? $_GET["cat_tarif"] : "0"
            , isset($_GET["cat_compta"]) ? $_GET["cat_compta"] : "0", isset($_GET["souche"]) ? $_GET["souche"] : "0"
            , isset($_GET["ca_no"]) ? $_GET["ca_no"] : "0", isset($_GET["co_no"]) ? $_GET["co_no"] : "0", str_replace("'","''",$_GET["reference"])));
    }
    else
        if($cloture > 0)
            echo "Cette journée est déjà cloturée ! Contacter la direction où le superviseur !";
        else
            echo "la date doit être comprise entre $limitmoinsDate et $limitplusDate.";
}

// mise à jour de la référence
if( $_GET["acte"] =="ajout_reference"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    $docEntete->maj("DO_Ref",$docEntete->formatString($_GET["reference"]),$docEntete->cbMarq,$_SESSION["id"]);
}

if( $_GET["acte"] =="createReport"){
    $etat = new EtatClass();
    $data = $etat->createReport($_GET["param"],$_GET["filter"]);
    if(sizeof($data)>0){
        $content = "<table class='table table-striped'><thead>";
        foreach($data[0] as $key => $val){
            $content = $content."<th>$key</th>";
    ;    }
        $content = $content."</thead><tbody>";
        foreach($data as $row) {
            $first = $row;
            $content = $content."<tr>";
            foreach($row as $key => $val) {
                $content = $content."<td>$val</td>";
            }
            $content = $content."</tr>";
        }
        echo $content."</tbody></table>";
    }else
        echo "";
}

if( $_GET["acte"] =="modif_nomClient"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
	$docEntete->maj("DO_Coord04",str_replace("'","''",$_GET["DO_Coord04"]),$docEntete->cbMarq,$_SESSION["id"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article_source"){
    $article = new ArticleClass(0);
	echo $article->liste_article_source($_GET["type"],$_GET["depot"]);
}


// mise à jour de la référence
if( $_GET["acte"] =="rafraichir_listeClient"){
    $comptet = new ComptetClass(0);
	echo $comptet->rafraichir_listeClient($_GET["typefac"]);
}


// mise à jour de la référence
if( $_GET["acte"] =="entete_document") {
    $docEntete = new DocEnteteClass(0);
    $type_fac = $_GET["type_fac"];
    $do_souche = (isset($_GET["do_souche"])) ? ($_GET["do_souche"]=="") ? 0 : $_GET["do_souche"] : 0;
    $do_piece=$docEntete ->entete_document($type_fac,$do_souche);
    $data = array('DC_Piece' => $do_piece);
    echo json_encode($data);
}

// mise à jour de la référence
if( $_GET["acte"] =="ajout_statut"){
    $docEntete = new DocEnteteClass($_GET["EntetecbMarq"]);
	$docEntete->maj("DO_Statut",str_replace("'","''",$_GET["do_statut"]),$docEntete->cbMarq,$_SESSION["id"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="reste_a_payer"){
    $docEntete = new DocEnteteClass($_GET["EntetecbMarq"]);
    $reste_a_payer = $docEntete->resteAPayer;
    $data = array('reste_a_payer' => $reste_a_payer);
    echo json_encode($data);
}

// mise à jour de la référence
if( $_GET["acte"] =="ajout_date"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
	$docEntete->maj("DO_Date",str_replace("'","''",$_GET["date"]),$docEntete->cbMarq,$_SESSION["id"]);
}

function doImprim($cbMarq){
    $docEntete = new DocEnteteClass($cbMarq);
	$docEntete->doImprim();
}
// mise à jour de la référence
if( $_GET["acte"] =="doImprim") {
    doImprim($_GET["cbMarq"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="maj_collaborateur"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    $docEntete->maj_collaborateur($_GET["collab"]);
}

if( $_GET["acte"] =="maj_Depot"){
	$docEntete = new DocEnteteClass($_GET["cbMarq"]);
	$docEntete->maj("DE_No",str_replace("'","''",$_GET["DE_No"]),$docEntete->cbMarq,$_SESSION["id"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="maj_affaire"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    $docEntete->maj_affaire($_GET["affaire"]);
}
// mise à jour de la référence
if( $_GET["acte"] == "liste_article"){
    $docEntete = new DocEnteteClass(0);
    $typefac = $_GET["type_fac"];
    $cbMarq = $_GET["cbMarq"];
    $catcompta = (isset($_GET["catcompta"]))? $_GET["catcompta"]:0;
    $cattarif = (isset($_GET["cattarif"])) ? $_GET["cattarif"] : 0;
    echo $docEntete->getApiString("/getPiedPage&cbMarq=$cbMarq&typeFacture=$typefac&catCompta=$catcompta&catTarif=$cattarif");
}

// mise à jour de la référence
if( $_GET["acte"] =="calcul_pied"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    echo json_encode($docEntete->getLigneFacture());
}

if($_GET["acte"] =="saisie_comptable") {
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    $trans = 0;
    if(isset($_GET["TransDoc"]))
        $trans = $_GET["TransDoc"];

    $list = $docEntete->saisieComptable($_GET["cbMarq"],$trans);
    foreach($list as $elt) {
        ?>
        <tr>
            <td><?= $elt->jo_Num ?></td>
            <td><?= $elt->annee_Exercice ?></td>
            <td><?= $elt->ec_Jour ?></td>
            <td><?= $elt->ec_RefPiece ?></td>
            <td><?= $elt->ec_Reference ?></td>
            <td><?= $elt->cg_Num ?></td>
            <td><?= $elt->ct_Num ?></td>
            <td><?= $elt->ec_Intitule ?></td>
            <td><?= $docEntete->formatDateAffichage(substr($elt->ec_Echeance,0,10)) ?></td>
            <td><?= $docEntete->formatChiffre($elt->ec_MontantDebit) ?></td>
            <td><?= $docEntete->formatChiffre($elt->ec_MontantCredit) ?></td>
        </tr>
        <?php
    }
}

if($_GET["acte"] =="majComptaFonction") {
    $typeTransfert = $_GET["typeTransfert"];
    if($typeTransfert ==1 || $typeTransfert ==2) {
        $docEntete = new DocEnteteClass(0,$objet->db);
        $listeFacture = $docEntete->getListeFactureMajComptable($_GET["typeTransfert"], $objet->getDate($_GET["datedebut"]), $objet->getDate($_GET["datefin"]),
            $_GET["facturedebut"], $_GET["facturefin"], $_GET["souche"], $_GET["transfert"], $_GET["catCompta"], $_GET["caisse"]);
        foreach ($listeFacture as $liste) {
            $reglement = new ReglementClass(0,$objet->db);
            $listeRglt = $reglement->getReglementByFacture($liste->DO_Domaine,$liste->DO_Type,$liste->DO_Piece);

            if(sizeof($listeRglt)!=0)
                majComptaCaisse($liste->DO_Piece, $liste->DO_Domaine, $liste->DO_Type, 0);
            majCompta($liste->DO_Piece, $liste->DO_Domaine, $liste->DO_Type, 0);
            $doTypeCible = 7;
            if ($liste->DO_Domaine == 1) $doTypeCible = 17;
            $docEntete->majEnteteComptable($liste->DO_Piece, $liste->DO_Domaine, $liste->DO_Type,$doTypeCible);
        }
    }

    if($typeTransfert ==3 || $typeTransfert ==4){
        $reglement = new ReglementClass(0,$objet->db);
        $listeFacture = $reglement->getListeReglementMajComptable($_GET["typeTransfert"], $objet->getDate($_GET["datedebut"]), $objet->getDate($_GET["datefin"]),$_GET["transfert"], $_GET["caisse"]);
        foreach ($listeFacture as $liste) {
            majComptaCaisseReglement($liste->RG_No);
        }
    }
}


if($_GET["acte"] =="majCompta") {
    $trans = 0;
    if(isset($_GET["TransDoc"]))
        $trans = $_GET["TransDoc"];
    majCompta($DO_Piece,$DO_Domaine,$DO_Type,$trans);
}

function majComptaCaisse($DO_Piece,$DO_Domaine,$DO_Type,$trans){
    $allEcritureC = saisieComptableCaisse($DO_Piece,$DO_Domaine,$DO_Type,$trans);
    foreach($allEcritureC as $elem) {
        $Annee_Exercice = $elem['Annee_Exercice'];
        $mois = substr($Annee_Exercice, -2);
        $annee = substr($Annee_Exercice, 0, 4);
        $JM_Date = $annee . "-" . $mois . "-01";
        $EC_Date = $annee . "-" . $mois . "-01";
        $EC_TresoPiece = '';
        if (isset($elem["EC_MontantDebit"]))
            $EC_Montant = $elem["EC_MontantDebit"];
        if (isset($elem["EC_MontantCredit"]))
            if ($elem["EC_MontantCredit"] != 0) {
                $EC_Montant = $elem["EC_MontantCredit"];
            }
        $TA_Code = NULL;

        $resultat=ajoutEcritureC($elem['JO_Num'], $JM_Date, $elem['EC_Jour'], $EC_Date, '', $elem['EC_RefPiece'],
            $EC_TresoPiece, $elem['CG_Num'], $elem['CG_NumCont'], $elem['CT_Num'], $elem['EC_Intitule'], $elem['N_Reglement'],
            $elem['EC_Echeance'], $elem['EC_Sens'], $EC_Montant, $elem['CT_NumCont'], $elem['TA_Code'], $elem['EC_Reference'], $elem['TA_Provenance'], $elem['EC_StatusRegle'], $elem['EC_Lettrage'], $elem['EC_MontantRegle']);
        $objet = new ObjetCollector();
        if($elem['EC_Sens']==1)
            $objet->db->query($objet->majReglementComptabilise($resultat["EC_No"],$DO_Type,$DO_Domaine,$DO_Piece));
    }
}

function majComptaCaisseReglement($RG_No){
    $allEcritureC = saisieComptableCaisseReglement($RG_No);
    $EC_Sens = 0;
    $EC_No=0;
    foreach($allEcritureC as $elem) {
        $Annee_Exercice = $elem['Annee_Exercice'];
        $mois = substr($Annee_Exercice, -2);
        $annee = substr($Annee_Exercice, 0, 4);
        $JM_Date = $annee . "-" . $mois . "-01";
        $EC_Date = $annee . "-" . $mois . "-01";
        $EC_TresoPiece = '';
        if (isset($elem["EC_MontantDebit"]))
            $EC_Montant = $elem["EC_MontantDebit"];
        if (isset($elem["EC_MontantCredit"]))
            if ($elem["EC_MontantCredit"] != 0) {
                $EC_Montant = $elem["EC_MontantCredit"];
            }
        $TA_Code = NULL;

        $resultat=ajoutEcritureC($elem['JO_Num'], $JM_Date, $elem['EC_Jour'], $EC_Date, '', $elem['EC_RefPiece'],
            $EC_TresoPiece, $elem['CG_Num'], $elem['CG_NumCont'], $elem['CT_Num'], $elem['EC_Intitule'], $elem['N_Reglement'],
            $elem['EC_Echeance'], $elem['EC_Sens'], $EC_Montant, $elem['CT_NumCont'], $elem['TA_Code'], $elem['EC_Reference'], $elem['TA_Provenance'], $elem['EC_StatusRegle'], $elem['EC_Lettrage'], $elem['EC_MontantRegle']);
        if($elem['EC_Sens']==1){
            $EC_Sens = $elem['EC_Sens'];
            if(isset($resultat["EC_No"]))
                $EC_No = $resultat["EC_No"];
        }
    }
    if($EC_Sens==1) {
        $reglement = new ReglementClass($RG_No);
        $reglement ->RG_Compta=1;
        $reglement ->EC_No=$EC_No;
        $reglement ->cbEC_No=$EC_No;
        $reglement ->maj_reglement();
    }
}

function majCompta($DO_Piece,$DO_Domaine,$DO_Type,$trans){
    $allEcritureC = saisie_comptable($DO_Piece,$DO_Domaine,$DO_Type,$trans);
    /*if(isset($_GET["JO_Num"]))
        $JO_Num = $_GET["JO_Num"];*/
    foreach($allEcritureC as $elem){
        $Annee_Exercice = $elem['Annee_Exercice'];
        $mois = substr($Annee_Exercice, -2);
        $annee = substr($Annee_Exercice, 0, 4);
        $JM_Date  = $annee."-".$mois."-01";
        $EC_Date = $annee."-".$mois."-01";
        $EC_TresoPiece = '';
        $EC_Sens = 0;
        if($DO_Domaine==0) $EC_Sens = 1;
        if(isset($elem["EC_MontantDebit"]))
            $EC_Montant = $elem["EC_MontantDebit"];
        if(isset($elem["EC_MontantCredit"]))
            if($elem["EC_MontantCredit"]!=0){
                $EC_Sens = 1;
                if($DO_Domaine==0) $EC_Sens = 0;
                $EC_Montant = $elem["EC_MontantCredit"];
            }
        $TA_Code = NULL;
        $ec_no =ajoutEcritureC($elem['JO_Num'],$JM_Date,$elem['EC_Jour'],$EC_Date,'',$elem['EC_RefPiece'],
            $EC_TresoPiece,$elem['CG_Num'],$elem['CG_NumCont'],$elem['CT_Num'],$elem['EC_Intitule'],$elem['N_Reglement'],
            $elem['EC_Echeance'],$EC_Sens,$EC_Montant,$elem['CT_NumCont'],$elem['TA_Code'],$elem['EC_Reference'],$elem['TA_Provenance'],$elem['EC_StatusRegle'],$elem['EC_Lettrage'],$elem['EC_MontantRegle']);
        if($DO_Domaine!=0) {
            $allEcritureA = saisie_comptableAnal($DO_Piece,$DO_Domaine,$DO_Type,1);
            foreach ($allEcritureA as $elemA) {
                if (isset ($elem["CbMarq"])) {
                    $tabExplode = (explode(",", $elem["CbMarq"]));
                    foreach ($tabExplode as $tab) {
                        if ($tab == $elemA["EC_No"] && $elem['EC_Intitule'] != "") {
                            $N_Anal = 1;
                            if ($elemA['N_Analytique'] != "") $N_Anal = $elemA['N_Analytique'];
                            ajoutEcritureA($ec_no["EC_No"], $N_Anal, $elemA['CA_Num'], $elemA['A_Montant'], $elemA['A_Qte']);
                        }
                    }
                }
            }
        }
    }
}

function ajoutEcritureA($EC_No,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite){
    $objet =  new ObjetCollector();
    $result = $objet->db->requete($objet->insertFEcritureA($EC_No,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));
}

function ajoutEcritureC($JO_Num,$JM_Date,$EC_Jour,$EC_Date,$EC_Piece,$EC_RefPiece,$EC_TresoPiece,$CG_Num,$CG_NumCont,$CT_Num,$EC_Intitule,$N_Reglement,$EC_Echeance,$EC_Sens,$EC_Montant,$CT_NumCont,$TA_Code,$EC_Reference,$TA_Provenance,$EC_StatusRegle,$EC_Lettrage,$EC_MontantRegle){
    $objet =  new ObjetCollector();
    $result = $objet->db->requete($objet->searchJMouv($JO_Num,$JM_Date));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
        }
    }else{
        $result = $objet->db->requete($objet->insertJMouv($JO_Num,$JM_Date));
    }
    $result = $objet->db->requete($objet->insertFComptetC($JO_Num,$JM_Date,$EC_Jour,$EC_Date,$EC_Piece,$EC_RefPiece,$EC_TresoPiece,$CG_Num,$CG_NumCont,$CT_Num,$EC_Intitule,$N_Reglement,$EC_Echeance,$EC_Sens,$EC_Montant,$CT_NumCont,$TA_Code,$EC_Reference,$TA_Provenance,$EC_StatusRegle,$EC_Lettrage,$EC_MontantRegle));

    $result = $objet->db->requete($objet->getMaxEC_No());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach($rows as $row){
        $fichier = "";//$_GET['nomFichier'];
        if($fichier!="")
            $result=$objet->db->requete($objet->insert_ECRITURECPIECE($row->EC_No,$fichier));
        $data = array('EC_No' => $row->EC_No);
        return $data;
    }
}

function saisie_comptable ($cbMarq,$trans){
    $docEntete = new DocEnteteClass(0);
    return $docEntete->saisieComptable($cbMarq,$trans);
}

if($_GET["acte"] =="saisie_comptableAnal") {
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    $list = $docEntete->saisieCompteAnal($_GET["cbMarq"], 0);
    foreach($list as $elt) {
        ?>
        <tr>
            <td><?= $elt->jo_Num ?></td>
            <td><?= $elt->a_Intitule ?></td>
            <td><?= $elt->cg_Num ?></td>
            <td><?= $elt->anneExercice ?></td>
            <td><?= $elt->ca_Num ?></td>
            <td><?= $docEntete->formatChiffre($elt->ea_Quantite) ?></td>
            <td><?= $docEntete->formatChiffre($elt->ea_Montant) ?></td>
        </tr>
        <?php
    }

}

function saisie_comptableAnal($cbMarq,$insert=0){
    $docEntete = new DocEnteteClass(0);
    echo json_encode($docEntete->saisieCompteAnal($cbMarq,$insert));
}

if($_GET["acte"] =="stockMinDepasse") {
    $article = new ArticleClass($_GET["AR_Ref"],$objet->db);
    echo json_encode($article->stockMinDepasse($_GET["DE_No"]));
}

if($_GET["acte"] =="saisie_comptableCaisse") {
    $trans = 0;
    if($_GET["cbMarq"]!=0) {
        $docEntete = new DocEnteteClass($_GET["cbMarq"], $objet->db);
        if (isset($_GET["TransDoc"]))
            $trans = $_GET["TransDoc"];
        $list = $docEntete->saisieComptableCaisse($_GET["cbMarq"], $trans);
        foreach($list as $elt) {
            ?>
            <tr>
                <td><?= $elt->jo_Num ?></td>
                <td><?= $elt->annee_Exercice ?></td>
                <td><?= $elt->ec_Jour ?></td>
                <td><?= $elt->ec_RefPiece ?></td>
                <td><?= $elt->ec_Reference ?></td>
                <td><?= $elt->cg_Num ?></td>
                <td><?= $elt->ct_Num ?></td>
                <td><?= $elt->ec_Intitule ?></td>
                <td><?= $docEntete->formatDateAffichage(substr($elt->ec_Echeance,0,10)) ?></td>
                <td><?= $docEntete->formatChiffre($elt->ec_MontantDebit) ?></td>
                <td><?= $docEntete->formatChiffre($elt->ec_MontantCredit) ?></td>
            </tr>
        <?php
        }
    }
}

function saisieComptableCaisse($cbMarq,$TransDoc){
    $docEntete = new DocEnteteClass(0);
    return $docEntete->saisieComptable($cbMarq,$TransDoc);
}

function saisieComptableCaisseReglement($RG_No){
    $objet = new ObjetCollector();
    $reglement  = new ReglementClass($RG_No,$objet->db);
    $docEntete  = new DocEnteteClass(0,$objet->db);
    $listeDocEntete = $docEntete->getEnteteByRG_No($RG_No);
    $jo_num="";
    $cg_num="";
    $alldata=null;
    $date_ech="";
    $cmpcol=0;
    $dateEntete=$reglement->RG_Date;
    $client=$reglement->CT_NumPayeur;
    $souche = $reglement->RG_Souche;
    $affaire="";
    $reference=$reglement->RG_Libelle;
    $caisse = $reglement->CA_No;
    $total_regle=$reglement->RG_Montant;
    $caisseClaisse = new CaisseClass($caisse,$objet->db);
    $jo_num=$caisseClaisse->JO_Num;

    $do_piece ="";

    foreach($listeDocEntete as $liste){
        $do_piece = $liste->DO_Piece;
    }
    $comptetClass = new ComptetClass($client);
    if($comptetClass->CG_NumPrinc!=""){
        $cg_num=$comptetClass->CG_NumPrinc;
        $comptegClass = new CompteGClass($cg_num);
        if($comptegClass->CG_Tiers==0)
            $client="";
    }

    $date_ech="1900-01-01";
    $data = array("nomFichier" =>"","JO_Num" => $jo_num,"Annee_Exercice" =>substr($dateEntete,0,4).substr($dateEntete,5,2),
        "EC_Jour" => substr($dateEntete,8,2),"EC_RefPiece" =>$do_piece , "EC_Reference" =>"","CG_Num"=> $cg_num,
        "TA_Provenance" => 0,"EC_StatusRegle" => 0,"EC_MontantRegle" => 0,"EC_Sens" => 1,"EC_Lettrage" => "","CG_NumCont" => "","CT_Num" =>$client,"CT_NumCont" =>"","EC_Intitule"=>$reference,"N_Reglement"=>1,"EC_Echeance"=>$date_ech,"EC_MontantCredit"=>"",
        "EC_MontantDebit"=>$total_regle,"TA_Code"=>"");
    $alldata[$cmpcol] = $data;
    $cmpcol++;
    $cg_numold = $cg_num;
    $ct_numold = $client;
    $journalClass = new JournalClass($jo_num);
    if($journalClass->CG_Num!=""){
        $cg_num=$journalClass->CG_Num;
        $comptegClass = new CompteGClass($cg_num);
        if($comptegClass->CG_Tiers==0)
            $client="";
    }

    $data = array("nomFichier" =>"","JO_Num" => $jo_num,"Annee_Exercice" =>substr($dateEntete,0,4).substr($dateEntete,5,2),
        "EC_Jour" => substr($dateEntete,8,2),"EC_RefPiece" =>$do_piece , "EC_Reference" =>"","CG_Num"=> $cg_num,
        "TA_Provenance" => 0,"EC_StatusRegle" => 0,"EC_MontantRegle" => 0,"EC_Sens" => 0,"EC_Lettrage" => "","CG_NumCont" => $cg_numold,"CT_Num" =>$client,"CT_NumCont" =>$ct_numold,"EC_Intitule"=>$reference,"N_Reglement"=>1,"EC_Echeance"=>$date_ech,"EC_MontantCredit"=>$total_regle,
        "EC_MontantDebit"=>"","TA_Code"=>"");
    $alldata[$cmpcol] = $data;
    return $alldata;
}

if($_GET["acte"] =="verif_stock"){
    $result=$objet->db->requete($objet->isStock($_GET["DE_No"],$_GET["designation"]));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $msg="";
    foreach ($rows as $row){
        $AS_QteSto = $row->AS_QteSto;
        if(($AS_QteSto+$_GET["ADL_Qte"])>=($_GET["quantite"])){
        }else{
            $msg = "La quantité de ".$_GET["designation"]." ne doit pas dépasser ".ROUND($AS_QteSto+$_GET["ADL_Qte"],2)." !";
        }
    }
    $data = array('message' => $msg);
    echo json_encode($data);
}

//ajout article
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    $cbMarq = 0;
    if(isset($_GET["cbMarq"]))
        $cbMarq = $_GET["cbMarq"];
    $isVisu = 1;
    $type=$_GET["type_fac"];
    $prot_no = 0;
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"]);
    $cloture = $docEntete->journeeCloture($docEntete->DO_Date,$docEntete->CA_No);

    $docligne = new DocLigneClass($cbMarq);
    if(isset($_GET["PROT_No"]) && $cloture==0) {
        echo $docligne->ajout_ligneFacturation($_GET["quantite"],isset($_GET["designation"])? $_GET["designation"]:""
            ,$_GET["cbMarqEntete"],$_GET["type_fac"],$_GET["cat_tarif"],$_GET["prix"],$_GET["remise"],
            $_GET["machineName"], $_GET["acte"],$_GET["PROT_No"]);
    }else{
        echo "Cette journée est déjà cloturée !";
    }
}

if($_GET["acte"]=="ligneFacture"){

    $totalht = 0;
    $tva = 0;
    $precompte = 0;
    $marge = 0;
    $totalttc = 0;
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"]);
    $flagPxRevient=$_GET["flagPxRevient"];
    $flagPxAchat=$_GET["flagPxAchat"];
    $protectionClass = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
    $typeDocument = $_GET["typeFac"];
    $rows = $docEntete->listeLigneFacture();
    $do_domaine = $docEntete->DO_Domaine;
    $i = 0;
    $classe = "";
    $fournisseur = 0;
    if ($do_domaine != 0)
        $fournisseur = 1;
    if ($rows != null) {
        foreach ($rows as $row) {
            $docligne = new DocLigneClass($row->cbMarq);
            $typefac = 0;
            $rows = $docligne->getPrixClientHT($docligne->AR_Ref, $docEntete->N_CatCompta, 0, 0, 0, $docligne->DL_Qte, $fournisseur)[0];
            if ($rows != null) {
                $typefac = $rows->AC_PrixTTC;
            }
            $i++;
            if ($i % 2 == 0) $classe = "info";
            else $classe = "";
            $qteLigne = (round($docligne->DL_Qte * 100) / 100);
            $remiseLigne = $docligne->DL_Remise;


            $puttcLigne = ROUND($docligne->DL_PUTTC, 2);
            $montantHTLigne = ROUND($docligne->DL_MontantHT, 2);
            $montantTTCLigne = ROUND($docligne->DL_MontantTTC, 2);
            if ($typeDocument == "Retour") {
                $qteLigne = -$qteLigne;
                $montantTTCLigne = -$montantTTCLigne;
                $montantHTLigne = -$montantHTLigne;
            }
            $isVisu = $docEntete->isVisu($_SESSION["id"],$typeDocument);
            ?>
            <tr class='facture $classe' id='article_<?= $docligne->cbMarq; ?>'>
                <td id='AR_Ref' style='color:blue;text-decoration: underline'><?= $docligne->AR_Ref; ?></td>
                <td id='DL_Design' style='align:left'><?= $docligne->DL_Design; ?></td>
                <td id='DL_PrixUnitaire' style="<?php
                if((($typeDocument =="Achat" || $typeDocument =="AchatC" || $typeDocument =="AchatT" || $typeDocument =="AchatPreparationCommande"|| $typeDocument =="PreparationCommande")&& $flagPxAchat!=0))
                    echo "display:none";?>"><?= $objet->formatChiffre(round($docligne->DL_PrixUnitaire, 2)); ?> </td>
                <td id='DL_Qte'><?= $objet->formatChiffre($qteLigne) ?></td>
                <td id='DL_Remise'><?= $remiseLigne?></td>
                <td id='PUTTC' style="<?php
                if((($typeDocument =="Achat" || $typeDocument =="AchatC" || $typeDocument =="AchatT" || $typeDocument =="AchatPreparationCommande"|| $typeDocument =="PreparationCommande")&& $flagPxAchat!=0))
                    echo "display:none";?>"><?= $objet->formatChiffre($puttcLigne) ?></td>
                <td id='DL_MontantHT' style="<?php
                if((($typeDocument=="Achat" || $typeDocument =="AchatC" || $typeDocument =="AchatT" || $typeDocument =="AchatPreparationCommande"|| $typeDocument =="PreparationCommande")&& $flagPxAchat!=0))
                    echo "display:none";?>"><?= $objet->formatChiffre($montantHTLigne); ?></td>
                <td id='DL_MontantTTC' style="<?php
                if((($typeDocument =="Achat" || $typeDocument =="AchatC" || $typeDocument =="AchatT" || $typeDocument =="AchatPreparationCommande"|| $typeDocument =="PreparationCommande")&& $flagPxAchat!=0))
                    echo "display:none";?>"> <?= $objet->formatChiffre($montantTTCLigne); ?> </td>

            <td style='display:none' id='DL_NoColis'><?= $docligne->DL_NoColis; ?></td>
                <td style='display:none' id='cbMarq'><?= $docligne->cbMarq; ?></td>
                <td style='display:none' id='DL_CMUP'><?= $docligne->DL_CMUP; ?></td>
                <td style='display:none' id='DL_TYPEFAC'><?= $typefac; ?></td>
                <?php
            if ((!$isVisu && ($typeDocument == "PreparationCommande" || $typeDocument == "AchatPreparationCommande")))
                echo "<td id='lignea_{$docligne->cbMarq}'><i class='fa fa-sticky-note fa-fw'></i></td>";
            if ($protectionClass->PROT_Administrator || $protectionClass->PROT_Right)
                echo "  <td id='modif_{$docligne->cbMarq}'>
                            <i class='fa fa-pencil fa-fw'></i>
                        </td>
                        <td id='suppr_{$docligne->cbMarq}'>
                            <i class='fa fa-trash-o'></i>
                        </td>";
            else
                if(!$isVisu)
                    echo "<td id='modif_{$docligne->cbMarq}'>
                            <i class='fa fa-pencil fa-fw'></i></td>
                            <td id='suppr_{$docligne->cbMarq}'><i class='fa fa-trash-o'></i></a></td>";
                if($protectionClass->PROT_CBCREATEUR!=2)
                    echo "<td></td><td>{$docligne->getcbCreateurName()}</td>";
                echo"</tr>";
            $totalht = $totalht + ROUND($docligne->DL_MontantHT, 2);
            $tva = $tva + ROUND($docligne->MT_Taxe1, 2);
            $precompte = $precompte + ROUND($docligne->MT_Taxe2, 2);
            $marge = $marge + ROUND($docligne->MT_Taxe3, 2);
            $totalttc = $totalttc + ROUND($docligne->DL_MontantTTC, 2);
        }
    }
}

if($_GET["acte"]=="initLigneconfirmation_document") {
    $docligne = new DocLigneClass(0);
    $docligne->ligneConfirmationVisuel($_GET["cbMarq"]);
}

if($_GET["acte"]=="confirmation_document"){
    $cbMarq = $_GET["cbMarq"];
    $docEntete = new DocEnteteClass($cbMarq);
    $ligne = $docEntete->getLignetConfirmation();

    $docEnteteTransfert = new DocEnteteClass(0);
    $entete=$docEntete->addDocenteteTransfertProcess($docEntete->DO_Date, $docEntete->DO_Ref, $docEntete->DO_Tiers,
        $docEntete->CA_Num,$docEntete->DE_No, $docEntete->longitude, $docEntete->latitude,"Transfert");

    foreach($ligne as $row) {
        $docligne = new DocLigneClass(0);
        $docligne->addDocligneTransfertProcess($row->AR_Ref, $row->DL_PrixUnitaire, $row->DL_Qte
            , "3", $docligne->MACHINEPC, $entete->cbMarq, "", "", 0);
        $docligne = new DocLigneClass($row->cbMarqLigneFirst);
        $docligne->addDocligneTransfertProcess($docligne->AR_Ref, $docligne->DL_PrixUnitaire, $docligne->DL_Qte
            , "1", $docligne->MACHINEPC, $entete->cbMarq, $docligne->userName, "", 0);
        if ($row->DL_Qte > $docligne->DL_Qte) {
            $entete = "";
            $depot = $docEntete->DE_No;
            $date = $docEntete->DO_Date;

            $cbMarqEntete = $docEntete->addDocenteteEntreeInventaireProcess($date, 'inv du ' . $date, $depot, 0, 0, 0);
            $qte = $row->DL_Qte - $docligne->DL_Qte;
            $ref_article = $row->AR_Ref;
            $prix = $row->DL_PrixUnitaire;
            $article = new ArticleClass($ref_article);
            $docligne->addDocligneEntreeMagasinProcess($ref_article, $cbMarqEntete, $qte, "1", 0, $prix, "Entree", $_SESSION["login"], "", "");
            $isStock = $article->isStock($depot);
            if (sizeof($isStock) == 0) {
                $article->insertF_ArtStock($depot, ($prix * $qte), $qte);
            } else
                $article->updateArtStock($depot, $qte, ($prix * $qte));
        }

        if ($row->DL_Qte < $docligne->DL_Qte) {
            $entete = "";
            $depot = $docEntete->DE_No;
            $date = $docEntete->DO_Date;
            $entete = $docEntete->addDocenteteEntreeInventaireProcess21($date, 'inv du ' . $date, $depot, 0, 0, 0);
            $qte = $docligne->DL_Qte - $row->DL_Qte;
            $ref_article = $row->AR_Ref;
            $prix = $row->DL_PrixUnitaire;
            $docligne->addDocligneEntreeMagasinProcess21($ref_article, $entete, $qte, "3", $depot, $prix, $_SESSION["login"]);
            $article = new ArticleClass($ref_article);
            $isStock = $article->isStock($depot);
            $article->updateArtStock($depot, -$qte, -($prix * $qte));
        }
        $docligne->delete();
        $docligne->deleteConfirmationbyCbmarq($row->cbMarq);
    }
    $docEntete->delete();
}

if($_GET["acte"]=="ligneFactureStock"){
    $protNo = $_GET["PROT_No"];
    $type = $_GET["typeFac"];
    $flagPxRevient= $_GET["flagPxRevient"];
    $totalht=0;
    $totalqte=0;
    $tva =0;
    $precompte=0;
    $marge=0;
    $totalttc=0;
    $protection = new ProtectionClass("","");
    $protection->connexionProctectionByProtNo($protNo);
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"]);
                $typeDocument = $_GET["typeFac"];
    $isVisu = $docEntete->isVisu($_SESSION["id"],$typeDocument);
    $docligne = new DocLigneClass(0);
    $totalqte = 0;

      if($type=="Transfert")
          $rows=$docEntete->getLigneTransfert();
      else if($type=="Transfert_confirmation")
          $rows=$docEntete->getLigneTransfert();
      else if($type=="Transfert_valid_confirmation")
          $rows=$docEntete->getLignetConfirmation();
      else if($type=="Transfert_detail")
          $rows = $docEntete-> getLigneTransfert_detail();
        else
            $rows=$docEntete->getLigneFactureTransfert();
        $i=0;
        $id_sec=0;
        $classe="";
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $docligne = new DocLigneClass($row->cbMarq);
                $i++;
            $prix = $row->DL_PrixUnitaire;
            $remise = $row->DL_Remise;
            $qte=$row->DL_Qte;
            $type_remise = 0;
            $rem=0;
            if(strlen($remise)!=0){
                if(strpos($remise, "%")){
                    $remise=str_replace("%","",$remise);
                $rem = $prix * $remise / 100;
                }
                if(strpos($remise, "U")){
                    $remise=str_replace("U","",$remise);
                    $rem = $remise;
                }
            }else $remise=0;
            if($i%2==0)
                $classe = "info";
            else $classe = "";
                $a=round(($prix- $rem)*$qte,0);
                $b=round(($a * $row->DL_Taxe1)/100,0);
                $c=round(($a * $row->DL_Taxe2)/100,0);
                $d=($row->DL_Taxe3 * $qte);
                $totalht=$totalht+$a;
                $totalqte=$totalqte+$qte;
                $tva = $tva +$b;
                $precompte=$precompte+$c;
                $marge=$marge+$d;
                $totalttc=$totalttc+round(($a+$b+$c)+$d,0);

                echo "<tr class='facture $classe' id='article_{$row->cbMarq}'";
                    echo "><td id='AR_Ref' style='color:blue;text-decoration: underline'>{$row->AR_Ref}</td>"
                    . "<td id='DL_Design' style='align:left'>{$row->DL_Design}</td>";
                    ?>
                <td id='DL_PrixUnitaire'
                    style="<?php
                    if($flagPxRevient!=0)
                        echo "display:none";?>">
                    <?= $objet->formatChiffre(round($row->DL_PrixUnitaire, 2)); ?>
                    <span style='display:none' id='cbMarq'><?= $row->cbMarq ?></span>
                    <span style='display:none' id='id_sec'><?= $row->idSec ?></span>
                </td>

                <?php
                echo "<td id='DL_Qte'>{$objet->formatChiffre(round($row->DL_Qte*100)/100)}</td>";
                if($flagPxRevient==0) echo    "<td id='DL_MontantHT'>{$objet->formatChiffre($row->DL_MontantHT)}</td>";
                if($type=="Transfert_detail")
                    echo "<td id='AR_Ref_dest'>{$row->AR_Ref_Dest}</td>
                             <td id='AR_Design_dest'>{$row->DL_Design_Dest}</td>
                                <td id='DL_Qte_dest'>{$objet->formatChiffre($row->DL_Qte_dest)}</td>
                                <td id='DL_MontantHT_dest'>{$objet->formatChiffre($row->DL_MontantHT_dest)}</td>";
                if(!$isVisu && $type!="Transfert" && $type!="Transfert_confirmation" && $type!="Transfert_detail")
                    echo "<td id='modif_{$row->cbMarq}'><i class='fa fa-pencil fa-fw'></i></td>";
                if(!$isVisu && $type!="Transfert_valid_confirmation")
                    echo "<td id='suppr_{$row->cbMarq}'><i class='fa fa-trash-o'></i></td>";
                if($protection->PROT_CBCREATEUR!=2)
                    echo "<td>{$docligne->getcbCreateurName()}</td>";
                echo"</tr>";
                }

                }

}
//suppression d'article
if($_GET["acte"] =="suppr"){
    $type_fac=$_GET["type_fac"];
    $idSec = (isset($_GET["id_sec"])) ? $_GET["id_sec"] : 0;
    $docligne = new DocLigneClass(0);
    $docligne->supprLigneFacture($_GET["id"],$idSec,$type_fac,$_SESSION["id"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="suppr_facture"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"]);
    $type=$_GET["type"];
    $docEntete->getApiExecute("/suppr_facture&cbMarq={$_GET["cbMarq"]}&typeFacture={$type}&protNo={$_SESSION["id"]}");

    $ajout="";
        if(isset($_GET["datedebut"]))
            $ajout="{$ajout}&datedebut={$_GET["datedebut"]}";
        if(isset($_GET["datefin"]))
            $ajout="{$ajout}&datefin={$_GET["datefin"]}";
        if(isset($_GET["depot"]))
            $ajout="{$ajout}&depot={$_GET["depot"]}";

		header("Location: ../{$docEntete->redirectToListe($type)}");
    }


if($_GET["acte"] =="regle") {
	
	$cbMarq = 0;
    if (isset($_GET["cbMarqEntete"]))
        $cbMarq = $_GET["cbMarqEntete"];
	$valideRegle = 1;
	if (isset($_GET["valideRegle"]))
		$valideRegle = $_GET["valideRegle"];
	
	$valideRegltImprime = 0;
	if (isset($_GET["valideRegltImprime"]))
		if($_GET["valideRegltImprime"]=="true")
			$valideRegltImprime	=1;
	
	$mode_reglement = 0;
	if(isset($_GET["mode_reglement"]))
		$mode_reglement = $_GET["mode_reglement"];
	if(isset($_GET["mode_reglement_val"]))
		$mode_reglement = $_GET["mode_reglement_val"];
	$lib_reglt="";
	if(isset($_GET["lib_reglt"]))
		$lib_reglt = substr($_GET["lib_reglt"], 0, 30);
	if(isset($_GET["libelle_rglt"]))
		$lib_reglt = substr($_GET["libelle_rglt"], 0, 30);
	
	$date_reglt = $_GET["date_rglt"];
	$date_ech = $date_reglt;
	if (isset($_GET["date_ech"]))
		$date_ech = $_GET["date_ech"];

    $docEntete = new DocEnteteClass($cbMarq);
    $mttAvance = str_replace(" ", "", $_GET["mtt_avance"]);
    $typeFacture = $_GET["typeFacture"];
    $protNo = $_GET["PROT_No"];
    $lib_reglt = substr($lib_reglt, 0, 30);
    $url = "/regle&cbMarq=$cbMarq&typeFacture={$docEntete ->formatString($typeFacture)}&protNo=$protNo&valideRegle=$valideRegle&valideRegltImprime=$valideRegltImprime&montantAvance=$mttAvance&modeReglement=$mode_reglement&dateReglt={$objet->getDate($date_reglt)}&libReglt={$docEntete->formatString($lib_reglt)}&dateEch={$objet->getDate($date_ech)}";
	$docEntete->getApiString($url);
}

if($_GET["acte"] =="redirect") {
    $docEntete = new DocEnteteClass(0);
    header('Location: ../' . $docEntete->redirectToListe($_GET["typeFacture"]));
}
if($_GET["acte"] =="listeArticle"){
    $article = new ArticleClass(0);
    if($_GET["type"]=="Vente" ||$_GET["type"]=="BonLivraison")
        $rows = $article->getAllArticleDispoByArRef($depot);
    else
        $rows = $article->all();
    echo "<ul>";
    if($rows==null){
    }else{
        foreach($rows as $row){
            echo "<li><span='ref'>{$row->AR_Ref}</span>";
            echo "<span ref='design'>{$row->AR_Ref} - {$row->AR_Design}</span></li>";
        }
    }
    echo "</ul>";
}


if(strcmp($_GET["acte"],"ligneAnal") == 0){
    $cbMarq = $_GET["cbMarq"];
    $N_Analytique = $_GET["N_Analytique"];
    afficheLigne($cbMarq,$N_Analytique);
}

function afficheLigne($cbMarq,$N_Analytique){
    $objet = new ObjetCollector();
    $result =  $objet->db->requete($objet->getSaisieAnalLigneA($cbMarq,$N_Analytique));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows !=null){
        foreach ($rows as $row){
            echo "<tr id='emodeler_anal_{$row->cbMarq}'>
                    <td id='tabCA_Num'>{$row->CA_Num} - {$row->CA_Intitule}</td>
                    <td id='tabA_Qte'>".ROUND($row->EA_Quantite,2)."</td>
                    <td id='tabA_Montant'>".ROUND($row->EA_Montant,2)."</td>
                    <td id='data' style='visibility:hidden' ><span style='visibility:hidden' id='tabcbMarq'>{$row->cbMarq}</span></td>
                    <td id='tabCA_NumVal' style='visibility:hidden' >{$row->CA_Num}</td>
                    <td id='modif_anal_'><i class='fa fa-pencil fa-fw'></i></td>
					<td id='suppr_anal_'><i class='fa fa-trash-o'></i></td>
                </tr>";
        }
    }
}

if(strcmp($_GET["acte"],"ajout_ligneA") == 0){
    $cbMarq = $_GET["cbMarq"];
    $N_Analytique= $_GET["N_Analytique"];
    $CA_Num = $_GET["CA_Num"];
    $EA_Montant = $_GET["EA_Montant"];
    $EA_Quantite= $_GET["EA_Quantite"];
    if($_GET["EA_Quantite"]=="")
        $EA_Quantite=0;
    $result = $objet->db->requete($objet->insertFLigneA($cbMarq,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));
    afficheLigne($cbMarq,$N_Analytique);
}


if(strcmp($_GET["acte"],"suppr_ligneA") == 0){
    $cbMarq = $_GET["cbMarq"];
    $result = $objet->db->requete($objet->supprLigneA($cbMarq));
    $data = array('TA_Code' => 0);
    echo json_encode($data);
}
if(strcmp($_GET["acte"],"modif_ligneA") == 0){
    $cbMarq = $_GET["cbMarq"];
    $cbMarqLigne = $_GET["cbMarqLigne"];
    $N_Analytique= $_GET["N_Analytique"];
    $CA_Num = $_GET["CA_Num"];
    $EA_Montant = $_GET["EA_Montant"];
    $EA_Quantite= $_GET["EA_Quantite"];
    $result = $objet->db->requete($objet-> modifLigneA($cbMarq,$cbMarqLigne,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));
    $result = $objet->db->requete($objet->getLastFCompteA());
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    foreach( $rows as $row){
        afficheLigne($cbMarqLigne,$N_Analytique);
    }
}


if(strcmp($_GET["acte"],"modif_ligneAL") == 0){
    $cbMarq = $_GET["cbMarq"];
    $N_Analytique= $_GET["N_Analytique"];
    $CA_Num = $_GET["CA_Num"];
    $EA_Montant = $_GET["EA_Montant"];
    $EA_Quantite= $_GET["EA_Quantite"];
    $result = $objet->db->requete($objet-> modifLigneAL($cbMarq,$N_Analytique,$CA_Num,$EA_Montant,$EA_Quantite));

}




?>
