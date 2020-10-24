<?php
/*$login = "";
$machine_pc = "";
$latitude = 0;
$longitude = 0;
*/
if(!isset($mobile)){
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
include("../Modele/ArtClientClass.php");
include("../Modele/P_CommunicationClass.php");
include("../Modele/CaisseClass.php");
include("../Modele/ArticleClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/P_ParametreLivrClass.php");
include("../Modele/DocReglClass.php");
include("../Modele/ReglEchClass.php");
include("../Modele/DepotUserClass.php");
include("../Modele/MailComplete.php");
include("../Modele/CompteGClass.php");
include("../Modele/JournalClass.php");
include("../Modele/TaxeClass.php");

$objet = new ObjetCollector();
//$login = $_SESSION["login"];
//$machine_pc = "";
//$mobile="";
}

if($_GET["acte"] =="regle") {

        if (isset($_GET["cbMarqEntete"]))
            $docEntete = new DocEnteteClass($_GET["cbMarqEntete"], $objet->db);

        $isVisu = 1;
        $type = $_GET["typeFacture"];
        $prot_no = 0;
        if (isset($_GET["PROT_No"])) {
            $protection = new ProtectionClass("", "");
            $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
            $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
            $isVisu = $docEntete->isVisu($protection->PROT_Administrator, $protection->protectedType($type), $protection->PROT_APRES_IMPRESSION,$isSecurite);
//        if (!$isVisu) {
            $comptet = new ComptetClass($docEntete->DO_Tiers, $objet->db);
            $rg_type = 0;
            $valideRegle = 1;
            if (isset($_GET["valideRegle"]))
                $valideRegle = $_GET["valideRegle"];
            $entete = $docEntete->DO_Piece;
            $caisse = $docEntete->CA_No;
            $do_domaine = $docEntete->DO_Domaine;
            $do_type = $docEntete->DO_Type;
            if ($valideRegle == 1) {
                if (!isset($_GET["valideRegltImprime"])) {
                    $mtt_avance = $_GET["montant_avance"];
                    $mtt = $_GET["montant_total"];
                    $mode_reglement = $_GET["mode_reglement"];
                    $date_reglt = $_GET["date_reglt"];
                    $lib_reglt = substr($_GET["lib_reglt"], 0, 30);
                    $date_ech = $date_reglt;
                    if (isset($_GET["date_ech"]))
                        $date_ech = $_GET["date_ech"];

                } else {
                    $mtt_avance = str_replace(" ", "", $_GET["mtt_avance"]);
                    $mtt = $docEntete->montantRegle();
                    $mode_reglement = $_GET["mode_reglement_val"];
                    $date_reglt = $objet->getDate($_GET["date_rglt"]);
                    $lib_reglt = substr($_GET["libelle_rglt"], 0, 30);
                    $date_ech = $objet->getDate($_GET["date_ech"]);
                }
                $creglement = new ReglementClass(0, $objet->db);
                if ($mtt_avance <> 0) {
                    $dr_no = $creglement->addCReglementFacture($_GET["cbMarqEntete"], $mtt_avance, $comptet->CT_Type, $mode_reglement, $caisse, $date_reglt, $lib_reglt, $date_ech,$_GET["PROT_No"]);
                    $creglement = new ReglementClass($dr_no,$objet->db);
                    //    $log = new LogFile();
                    //    $log->user = $_GET["PROT_No"];
                    //    $log->writeReglement("Ajout Règlement",$mtt_avance,$creglement->RG_No,$creglement->RG_Piece,$dr_no,'F_ARTSTOCK',$_GET["PROT_No"],$_GET["PROT_No"]);
                }
            }
            if (isset($_GET["valideRegltImprime"])) {
                if ($_GET["valideRegltImprime"] == "true")
                    doImprim($docEntete->cbMarq);
            }

            if (isset($_GET["cbMarqEntete"])) {
//                $docEntete = new DocEnteteClass(0, $objet->db);
//                header('Location: ../' . $docEntete->redirectToListe($_GET["typeFacture"]));
            }
        }
        //  }
    }


    function doImprim($cbMarq){
        $docEntete = new DocEnteteClass($cbMarq);
        $imprim = $docEntete->DO_Imprim;

        if ($imprim == 0) {
            $docEntete->maj("DO_Imprim", 1);
        }
    }

if(isset($_GET["Latitude"]))
    $latitude = $_GET["Latitude"];
if(isset($_GET["Longitude"]))
    $longitude = $_GET["Longitude"];

$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$modif=0;
$client = "";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
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
    $docEntete = new DocEnteteClass(0,$objet->db);
    if(isset($_SESSION)){
        $protectionClass = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"],$objet->db);
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

    $cloture = $docEntete->journeeCloture($_GET["date"],$_GET["ca_no"]);
    if($admin==0 && $cloture == 0) {
        echo json_encode($docEntete->ajoutEntete( isset($_GET["do_piece"]) ? $_GET["do_piece"] : "",
            $_GET["type_fac"], $_GET["date"], $_GET["date"], $_GET["affaire"], $_GET["client"], isset($_GET["userName"]) ? $_GET["userName"] : "",
            $mobile, isset($_GET["machineName"]) ? $_GET["machineName"] : "",
            isset($_GET["doCood2"]) ? $_GET["doCood2"] : "", isset($_GET["doCood3"]) ? $_GET["doCood3"] : "",isset($_GET["DO_Coord04"]) ? $_GET["DO_Coord04"] : "",
            $_GET["do_statut"], $latitude, $longitude, $_GET["de_no"], $_GET["cat_tarif"], $_GET["cat_compta"], $_GET["souche"], $_GET["ca_no"],
            $_GET["co_no"], str_replace("'","''",$_GET["reference"])));
    }
    else
        if($cloture > 0)
            echo "Cette journée est déjà cloturée !";
       else
           echo "la date doit être comprise entre $limitmoinsDate et $limitplusDate.";
}

// mise à jour de la référence
if( $_GET["acte"] =="ajout_reference"){
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->majLigneByCbMarq("DO_Ref",str_replace("'","''",$_GET["reference"]),$_GET["cbMarq"],$_SESSION["id"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="modif_nomClient"){
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->majByCbMarq("DO_Coord04",$_GET["DO_Coord04"],$_GET["cbMarq"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article_source"){
    $article = new ArticleClass(0,$objet->db);
    $depot=$_GET["depot"];
    $rows = Array();
    if($depot!="null") {
        if ($_GET["type"] == "Ticket" || $_GET["type"] == "Vente" || $_GET["type"] == "BonLivraison" || $_GET["type"] == "Sortie" || $_GET["type"] == "Transfert" || $_GET["type"] == "Transfert_detail")
            $rows = $article->getAllArticleDispoByArRef($depot);
        else
            $rows = $article->all(0);
    }
    echo json_encode($rows);
}

// mise à jour de la référence
if( $_GET["acte"] =="rafraichir_listeClient"){
    $typefac= $_GET["typefac"];
    if($typefac!="Achat" && $typefac!="PreparationCommande") {
        $comptet = new ComptetClass(0,$objet->db);
        $rows = $comptet->allClients();
    }
    else{
        $comptet = new ComptetClass(0,$objet->db);
        $rows = $comptet->allFournisseur();
    }
    echo json_encode($rows);
}

// mise à jour de la référence
if( $_GET["acte"] =="entete_document") {
    $docEntete = new DocEnteteClass(0,$objet->db);
    $type_fac = $_GET["type_fac"];
    $docEntete->setTypeFac($type_fac);
    $do_souche = (isset($_GET["do_souche"])) ? ($_GET["do_souche"]=="") ? 0 : $_GET["do_souche"] : 0;
    $do_piece=$docEntete ->getEnteteDocument($do_souche);
    $data = array('DC_Piece' => $do_piece);
    echo json_encode($data);
}

// mise à jour de la référence
if( $_GET["acte"] =="ajout_statut"){
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->majByCbMarq("DO_Statut",$_GET["do_statut"],$_GET["EntetecbMarq"]);
}


// mise à jour de la référence
if( $_GET["acte"] =="reste_a_payer"){
    $docEntete = new DocEnteteClass($_GET["EntetecbMarq"],$objet->db);
    $reste_a_payer = $docEntete->resteAPayer;
    $data = array('reste_a_payer' => $reste_a_payer);
    echo json_encode($data);
}

// mise à jour de la référence
if( $_GET["acte"] =="ajout_date"){
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->majByCbMarq("DO_Date",$_GET["date"],$_GET["cbMarq"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="doImprim") {
    doImprim($_GET["cbMarq"]);
}

// mise à jour de la référence
if( $_GET["acte"] =="maj_collaborateur"){
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->majLigneByCbMarq("CO_No",$_GET["collab"],$_GET["cbMarq"],$_SESSION["id"]);
}

if( $_GET["acte"] =="maj_Depot"){
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->majByCbMarq("DE_No",$_GET["DE_No"],$_GET["cbMarq"]);
}

if( $_GET["acte"] =="client"){
    $tiers = new ComptetClass(0,$objet->db);
    $data = array("valeur" => $tiers-> tiersByCTIntitule($_GET["CT_Intitule"]));
    echo json_encode($data);
}

// mise à jour de la référence
if( $_GET["acte"] =="maj_affaire"){
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->majLigneByCbMarq("CA_Num",$_GET["affaire"],$_GET["cbMarq"],$_SESSION["id"]);
}
// mise à jour de la référence
if( $_GET["acte"] == "liste_article"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    $entete = $docEntete->DO_Piece;
    $typefac = $_GET["type_fac"];
    $catcompta = (isset($_GET["catcompta"]))? $_GET["catcompta"]:0;
    $cattarif = (isset($_GET["cattarif"])) ? $_GET["cattarif"] : 0;
    $totalHT = 0;
    $totalTTC = 0;
    $totalQte = 0;
    $totalDevise = 0;
    $totalCarat = 0;
    $totalPureway = 0;
    $do_domaine = $docEntete->DO_Domaine;
    $do_type = $docEntete->DO_Type;
    $table = array();
    $tabLib = array();

    $libMontantHT = "Montant HT";
    if($objet->db->flagDataOr == 1) $libMontantHT = "Montant dollar";
    array_push ($tabLib, $libMontantHT);
    array_push ($table, 0);
    $type=0;
    if($do_domaine!=0)
        $type=1;

    $i=0;
    $rowsligne=Array();

    $docligne = new DocLigneClass(0,$objet->db);
        if($entete!=null)
            $rowsligne=$docEntete->listeLigneFacture();
        foreach ($rowsligne as $row) {
            $docligne= new DocLigneClass($row->cbMarq);
            $totalQte = $totalQte + $docligne->DL_Qte;
            if ($typefac == "Retour") {
                $totalHT = $totalHT - $docligne->DL_MontantHT;
                $totalTTC = $totalTTC - $docligne->DL_MontantTTC;
            } else {
                $totalHT = $totalHT + $docligne->DL_MontantHT;
                $totalTTC = $totalTTC + $docligne->DL_MontantTTC;
            }
            $prix = $docligne->DL_PUTTC;
            $rem = 0;
            if ($docligne->DL_TTC == 0)
                $prix = $docligne->DL_PrixUnitaire;
            $catcomptafinal = $catcompta;
            if ($do_type == 11)
                $catcomptafinal = $docligne->DL_NoColis;
            if($catcomptafinal=="")
                $catcomptafinal = 0;
            $rowsPrix = $docligne->getPrixClientHT($docligne->AR_Ref, $catcomptafinal, $cattarif, $prix, $rem, $docligne->DL_Qte, $type);
            $pos = getItem($tabLib, $rowsPrix->IntituleT1);
            if ($pos == -1) {
                array_push($tabLib, $rowsPrix->IntituleT1);
                if ($typefac == "Retour")
                    array_push($table, -$docligne->MT_Taxe1);
                else
                    array_push($table, $docligne->MT_Taxe1);
            } else {
                if ($typefac == "Retour")
                    $table[$pos] = $table[$pos] - $docligne->MT_Taxe1;
                else
                    $table[$pos] = $table[$pos] + $docligne->MT_Taxe1;
            }
            $pos = getItem($tabLib, $rowsPrix->IntituleT2);
            if ($pos == -1) {
                array_push($tabLib, $rowsPrix->IntituleT2);

                if ($typefac == "Retour")
                    array_push($table, -$docligne->MT_Taxe2);
                else
                    array_push($table, $docligne->MT_Taxe2);
            } else {
                if ($typefac == "Retour")
                    $table[$pos] = $table[$pos] - $docligne->MT_Taxe2;
                else
                    $table[$pos] = $table[$pos] + $docligne->MT_Taxe2;
            }
            $pos = getItem($tabLib, $rowsPrix->IntituleT3);
            if ($pos == -1) {
                array_push($tabLib, $rowsPrix->IntituleT3);
                if ($typefac == "Retour")
                    array_push($table, -$docligne->MT_Taxe3);
                else
                    array_push($table, $docligne->MT_Taxe3);
            } else {
                if ($typefac == "Retour")
                    $table[$pos] = $table[$pos] - $docligne->MT_Taxe3;
                else
                    $table[$pos] = $table[$pos] + $docligne->MT_Taxe3;
            }
        }

    $table[0]=$totalHT;
    array_push($tabLib, "Total quantité");
    array_push($table, $totalQte);

    if($do_domaine!=2) {
        array_push($tabLib, "Montant TTC");
        array_push($table, $totalTTC);
    }

    if($objet->db->flagDataOr==1 && $do_domaine==0 && $do_type==6){
        array_push ($tabLib, "Total Devise");
        array_push ($table, ($totalHT*$docEntete->DO_Cours));
        array_push ($tabLib, "Total Carat");
        array_push ($table, $totalCarat);
        array_push ($tabLib, "Total Pureway");
        array_push ($table, $totalPureway);
    }
    if(sizeof($rowsligne)>0){
        for($i=0;$i<sizeof($tabLib);$i++){
            if($tabLib[$i]!=""){
                $montant = $table[$i];
                if($do_domaine==2 && $do_type==23)
                    $montant = $montant /2;
                echo "<b>{$tabLib[$i]} : <br/>";
                echo $objet->formatChiffre($montant)."<br/><br/></b>";
            }
        }
    }
}

function getItem($table,$val){
    $pos=-1;
    for($i=0;$i<sizeof($table);$i++){
        if(strcmp($table[$i],$val)==0){
            $pos = $i;
        }
    }
    return $pos;
}
// mise à jour de la référence
if( $_GET["acte"] =="calcul_pied"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    echo json_encode($docEntete->getLigneFacture());
}

if($_GET["acte"] =="saisie_comptable") {
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    $trans = 0;
    if(isset($_GET["TransDoc"]))
        $trans = $_GET["TransDoc"];
    echo json_encode(saisie_comptable($docEntete->DO_Piece,$docEntete->DO_Domaine,$docEntete->DO_Type,$trans));
}

if($_GET["acte"] =="majComptaFonction") {
    $objet = new ObjetCollector();
    $typeTransfert = $_GET["typeTransfert"];
    if($typeTransfert ==1 || $typeTransfert ==2) {
        $docEntete = new DocEnteteClass(0,$objet->db);
        $listeFacture = $docEntete->getListeFactureMajComptable($_GET["typeTransfert"], $objet->getDate($_GET["datedebut"])
            , $objet->getDate($_GET["datefin"]),$_GET["facturedebut"], $_GET["facturefin"], $_GET["souche"]
            , $_GET["transfert"], $_GET["catCompta"], $_GET["caisse"]);
        $compta = 0;
        $error = "";
        foreach($listeFacture as $liste){

            $reglement = new ReglementClass(0,$objet->db);
            $listeRglt = $reglement->getReglementByFacture($liste->DO_Domaine,$liste->DO_Type,$liste->DO_Piece);
            if(sizeof($listeRglt)!=0) {
                $allEcritureC = saisieComptableCaisse($liste->cbMarq,0);
                if($allEcritureC!=null)
                foreach($allEcritureC as $ecritureC)
                {
                    if($ecritureC->EC_Montant===0){
                        $compta = 1;
                        $error = "Le montant du document {$ecritureC->EC_RefPiece} est égale à 0 !";
                    }
                    if($ecritureC->JO_Num===""){
                        $compta = 1;
                        $error = "Le journal du document {$ecritureC->EC_RefPiece} est vide !";
                    }
                    if($ecritureC->CG_Num===""){
                        $compta = 1;
                        $error = "Le compte général du document {$ecritureC->EC_RefPiece} est vide !";
                    }
                }
            }
            $allEcritureC = saisie_comptable($liste->cbMarq,0);

            if($allEcritureC!=null)
            foreach($allEcritureC as $ecritureC)
            {

                if($ecritureC->EC_Montant===0){
                    $compta = 1;
                    $error = "Le montant du document {$ecritureC->EC_RefPiece} est égale à 0 !";
                }
                if($ecritureC->JO_Num===""){
                    $compta = 1;
                    $error = "Le journal du document {$ecritureC->EC_RefPiece} est vide !";
                }
                if($ecritureC->CG_Num===""){
                    $compta = 1;
                    $error = "Le compte général du document {$ecritureC->EC_RefPiece} est vide !";
                }
            }

            $result = $objet->db->requete($objet->getParametrecial());
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows[0]->P_Analytique=="2" && $docEntete->DO_Domaine==1) {
                $allEcritureA = saisie_comptableAnal($liste->cbMarq, 1);
                if ($allEcritureA != null)
                    foreach ($allEcritureA as $ecritureA) {
                        $caNumPlanAffaire = $objet->getCANumPlanAffaire();
                        if ($ecritureA->CA_Num === "" && sizeof($caNumPlanAffaire) == 0)
                            $compta = 1;
                    }
            }
        }
        $id=1;
        if($compta == 0) {
            foreach ($listeFacture as $liste) {
                $reglement = new ReglementClass(0, $objet->db);
                $listeRglt = $reglement->getReglementByFacture($liste->DO_Domaine, $liste->DO_Type, $liste->DO_Piece);
                if (sizeof($listeRglt) != 0) {
                    majComptaCaisse($liste->cbMarq, 0, $id);
                }
                majCompta($liste->cbMarq, 0, $id);

                $doTypeCible = 7;
                if ($liste->DO_Domaine == 1) $doTypeCible = 17;
                $docEntete->majEnteteComptable($liste->cbMarq, $doTypeCible);
                $id++;
            }
        } else
            echo $error;
    }
    if($typeTransfert ==3 || $typeTransfert ==4){
        $reglement = new ReglementClass(0,$objet->db);
        $listeFacture = $reglement->getListeReglementMajComptable($_GET["typeTransfert"], $objet->getDate($_GET["datedebut"]), $objet->getDate($_GET["datefin"]), $_GET["caisse"], $_GET["transfert"]);
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

function majComptaCaisse($cbMarq,$trans,$id){
    $allEcritureC = saisieComptableCaisse($cbMarq,$trans);
    foreach($allEcritureC as $elem) {
        $Annee_Exercice = $elem->Annee_Exercice;
        $mois = substr($Annee_Exercice, -2);
        $annee = substr($Annee_Exercice, 0, 4);
        $JM_Date = $annee . "-" . $mois . "-01";
        $resultat=ajoutEcritureC($elem->JO_Num, $JM_Date, $elem->EC_Jour, date('Y-m-d'), $id, $elem->EC_RefPiece,
            "", $elem->CG_Num, $elem->CG_NumCont, $elem->CT_Num, $elem->EC_Intitule, $elem->N_Reglement,
            $elem->EC_Echeance, $elem->EC_Sens, $elem->EC_Montant, $elem->CT_NumCont, $elem->TA_Code, $elem->EC_Reference,
            $elem->TA_Provenance, $elem->EC_StatusRegle,  $elem->EC_Lettrage, $elem->EC_MontantRegle);
        $objet = new ObjetCollector();
        $docEntete = new DocEnteteClass(0);
        if($elem->EC_Sens==1)
            $docEntete->majReglementComptabilise($resultat["EC_No"],$cbMarq);
    }
}

function majComptaCaisseReglement($RG_No){
    $allEcritureC = saisieComptableCaisseReglement($RG_No,0);
    $cmpt = 0;
    foreach($allEcritureC as $elem) {
        $Annee_Exercice = $elem->Annee_Exercice;
        $mois = substr($Annee_Exercice, -2);
        $annee = substr($Annee_Exercice, 0, 4);
        $JM_Date = $annee . "-" . $mois . "-01";

        $resultat=ajoutEcritureC($elem->JO_Num, $JM_Date, $elem->EC_Jour, date('Y-m-d'), "", $elem->EC_RefPiece,
            "", $elem->CG_Num, $elem->CG_NumCont, $elem->CT_Num, $elem->EC_Intitule, $elem->N_Reglement,
            $elem->EC_Echeance, $elem->EC_Sens, $elem->EC_Montant, $elem->CT_NumCont, $elem->TA_Code, $elem->EC_Reference,
            $elem->TA_Provenance, $elem->EC_StatusRegle,  $elem->EC_Lettrage, $elem->EC_MontantRegle);
        if($cmpt == 0)
            $EC_No = $resultat["EC_No"];
        $cmpt++;
    }
    $reglement = new ReglementClass($RG_No);
    $reglement->RG_Compta=1;
    $reglement->EC_No=$EC_No;
    $reglement->maj_reglement();

}

function majCompta($cbMarq,$trans,$id){

    $allEcritureC = saisie_comptable($cbMarq,$trans);
    $objet = new ObjetCollector();
    $docEntete = new DocEnteteClass($cbMarq);
    foreach($allEcritureC as $elem){
        $Annee_Exercice = $elem->Annee_Exercice;
        $mois = substr($Annee_Exercice, -2);
        $annee = substr($Annee_Exercice, 0, 4);
        $JM_Date  = $annee."-".$mois."-01";

        $ec_no =ajoutEcritureC($elem->JO_Num, $JM_Date, $elem->EC_Jour, date('Y-m-d'), "", $elem->EC_RefPiece,
            "", $elem->CG_Num, $elem->CG_NumCont, $elem->CT_Num, $elem->EC_Intitule, $elem->N_Reglement,
            $elem->EC_Echeance, $elem->EC_Sens, $elem->EC_Montant, $elem->CT_NumCont, $elem->TA_Code, $elem->EC_Reference,
            $elem->TA_Provenance, $elem->EC_StatusRegle,  $elem->EC_Lettrage, $elem->EC_MontantRegle);

        $result = $objet->db->requete($objet->getParametrecial());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows[0]->P_Analytique=="2" && $docEntete->DO_Domaine==1) {
            $allEcritureA = saisie_comptableAnal($cbMarq,1);
            if($allEcritureA!=null)
            foreach ($allEcritureA as $elemA) {
                if (isset ($elem->CbMarq)) {
                    $tabExplode = (explode(",", $elem->CbMarq));
                    foreach ($tabExplode as $tab) {
                        if ($tab == $elemA->EC_No && $elem->EC_Intitule != "") {
                            $N_Anal = 1;
                            if ($elemA->N_Analytique != "")
                                $N_Anal = $elemA->N_Analytique;
                            $caNumPlanAffaire = $objet->getCANumPlanAffaire();
                            $caNum = $elemA->CA_Num;
                            if(sizeof($caNumPlanAffaire)>0)
                                if($elemA->CA_Num==="")
                                    $caNum = $caNumPlanAffaire[0]->CA_Num;
                            ajoutEcritureA($ec_no["EC_No"], $N_Anal, $caNum, $elemA->A_Montant, $elemA->A_Qte);
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
    $docEntete = new DocEnteteClass($cbMarq);
    return $docEntete->majCompta();
}

function getItemCompta($table,$val){
    $pos=-1;
    if($table!=null)
    for($i=0;$i<sizeof($table);$i++){
        if(strcmp($table[$i]["CG_Num"],$val)==0){
            $pos = $i;
        }
    }
    return $pos;
}

if($_GET["acte"] =="saisie_comptableAnal") {
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    echo json_encode(saisie_comptableAnal($docEntete->DO_Piece,$docEntete->DO_Domaine,$docEntete->DO_Type));
}

function saisie_comptableAnal($cbMarq,$insert=0){
    $docEntete = new DocEnteteClass($cbMarq);
    return $docEntete->majAnalytique();
}

if($_GET["acte"] =="clotureVente") {
    $docEntete = new DocEnteteClass(0,$objet->db);
    $docEntete->clotureVente($_GET["CA_Num"]);
}

if($_GET["acte"] =="stockMinDepasse") {
    $article = new ArticleClass($_GET["AR_Ref"],$objet->db);
    echo json_encode($article->stockMinDepasse($_GET["DE_No"]));
}

if($_GET["acte"] =="saisie_comptableCaisse") {
    $trans = 0;
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    if(isset($_GET["TransDoc"]))
        $trans = $_GET["TransDoc"];
    echo json_encode(saisieComptableCaisse($_GET["cbMarq"],$trans));
}

function saisieComptableCaisse($cbMarq,$TransDoc){
    $docEntete = new DocEnteteClass($cbMarq);
    $reglement = new ReglementClass(0);
    $listReglt = $reglement->getReglementByFacture($docEntete->DO_Domaine,$docEntete->DO_Type,$docEntete->DO_Piece);

    $result = array();
    foreach ($listReglt as $rglt){
        foreach (saisieComptableCaisseReglement($rglt->RG_No,$TransDoc) as $elem)
        array_push($result, $elem);
    }
    return $result;

}



    function saisieComptableCaisseReglement($RG_No,$TransDoc=0){
        $reglement = new ReglementClass($RG_No);
        return $reglement->getMajComptaListe();
    }

if($_GET["acte"] =="saisieDevise"){
    $docEntete = new DocEnteteClass(0,$objet->db);
    $dateDevise = $_GET["dateDevise"];
    $clientSource = $_GET["clientSource"];
    $depotSource = $_GET["depotSource"];
    $articleSource = $_GET["articleSource"];
    $prixVenteSource = $_GET["prixVenteSource"];
    $qteSource = $_GET["qteSource"];
    $qteSourceMax = $_GET["qteSourceMax"];
    $devise = $_GET["devise"];
    $prixVenteDest = 0;
    if(isset($_GET["prixVenteDest"]))
        $prixVenteDest = $_GET["prixVenteDest"];
    $insert = $_GET["insert"];
    $cbMarq = $_GET["cbMarq"];
    $docEntete->venteDevise($dateDevise,$clientSource,$depotSource,$qteSource,$articleSource,$prixVenteSource,$prixVenteDest,$devise,$insert,$cbMarq);
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
    $docligne = new DocLigneClass($cbMarq,$objet->db);
    $isVisu = 1;
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"],$objet->db);
    $type=$_GET["type_fac"];
    $prot_no = 0;

    $cloture = $docEntete->journeeCloture($docEntete->DO_Date,$docEntete->CA_No);

    if(isset($_GET["PROT_No"]) && $cloture==0) {
        $protection = new ProtectionClass("","",$objet->db);
        $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
        $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
        if($_GET["type_fac"]!="Devis")
        $isVisu = $docEntete->isVisu($protection->PROT_Administrator,$protection->protectedType($type),$protection ->PROT_APRES_IMPRESSION,$isSecurite);
        else
            $isVisu =false;
        if(!$isVisu){
            echo $docligne->ajout_ligneFacturation($_GET["quantite"],
                isset($_GET["designation"])? $_GET["designation"]:""
                ,$_GET["cbMarqEntete"],$_GET["type_fac"],
                $_GET["cat_tarif"],$_GET["prix"],$_GET["remise"],
                $_GET["machineName"], $_GET["acte"],$_GET["PROT_No"]);
        }
    } else{
        echo "Cette journée est déjà cloturée !";
    }
}

if($_GET["acte"]=="ligneFacture"){
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"],$objet->db);
    $flagPxRevient=$_GET["flagPxRevient"];
    $flagPxAchat=$_GET["flagPxAchat"];
    $protectionClass = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"],$objet->db);
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
            $docligne = new DocLigneClass($row->cbMarq,$objet->db);
            $typefac = 0;
            $rows = $docligne->getPrixClientHT($docligne->AR_Ref, $docEntete->N_CatCompta, $cat_tarif, 0, 0, $docligne->DL_Qte, $fournisseur);
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
$isSecurite = $protectionClass->IssecuriteAdmin($docEntete->DE_No);

$isVisu = $docEntete->isVisu($protectionClass->PROT_Administrator,$protectionClass->protectedType($typeDocument),$protectionClass->PROT_APRES_IMPRESSION,$isSecurite);
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
                <td style='display:none' id='DL_PieceBL'><?= $docligne->DL_PieceBL; ?></td>

                <td style='display:none' id='DL_NoColis'><?= $docligne->DL_NoColis; ?></td>
                <td style='display:none' id='cbMarq'><?= $docligne->cbMarq; ?></td>
                <td style='display:none' id='DL_CMUP'><?= $docligne->DL_CMUP; ?></td>
                <td style='display:none' id='DL_TYPEFAC'><?= $typefac; ?></td>
                <?php
            if ((!$isVisu && ($typeDocument == "PreparationCommande" || $typeDocument == "AchatPreparationCommande")))
                echo "<td id='lignea_" . $docligne->cbMarq . "'><i class='fa fa-sticky-note fa-fw'></i></td>";
            if ($protectionClass->PROT_Administrator || $protectionClass->PROT_Right)
                echo "  <td id='modif_" . $docligne->cbMarq . "'>
                            <i class='fa fa-pencil fa-fw'></i>
                        </td>
                        <td id='suppr_" . $docligne->cbMarq . "'>
                            <i class='fa fa-trash-o'></i>
                        </td>";
            else
                if(!$isVisu)
                    echo "<td id='modif_" . $docligne->cbMarq . "'>
                            <i class='fa fa-pencil fa-fw'></i></td>
                            <td id='suppr_" . $docligne->cbMarq . "'><i class='fa fa-trash-o'></i></a></td>";
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
    $docligne = new DocLigneClass(0,$objet->db);
    $docligne->ligneConfirmationVisuel($_GET["cbMarq"]);
}

if($_GET["acte"]=="confirmation_document"){
    $cbMarq = $_GET["cbMarq"];
    $docEntete = new DocEnteteClass($cbMarq,$objet->db);
    $ligne = $docEntete->getLignetConfirmation();

    $docEnteteTransfert = new DocEnteteClass(0,$objet->db);
    $entete=$docEntete->addDocenteteTransfertProcess($docEntete->DO_Date, $docEntete->DO_Ref, $docEntete->DO_Tiers,
        $docEntete->CA_Num,$docEntete->DE_No, $docEntete->longitude, $docEntete->latitude,"Transfert");

    foreach($ligne as $row) {
        $docligne = new DocLigneClass(0, $objet->db);
        $docligne->addDocligneTransfertProcess($row->AR_Ref, $row->DL_PrixUnitaire, $row->DL_Qte
            , "3", $docligne->MACHINEPC, $entete->cbMarq, "", "", 0);
        $docligne = new DocLigneClass($row->cbMarqLigneFirst, $objet->db);
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
            $article = new ArticleClass($ref_article, $objet->db);
            $docligne->addDocligneEntreeMagasinProcess($ref_article, $cbMarqEntete, $qte, "1", 0, $prix, "Entree", $_SESSION["login"], "", "");
           $article->updateArtStock($depot, $qte, ($prix * $qte),$_SESSION["id"],"confirmation_document");
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
            $article = new ArticleClass($ref_article, $objet->db);
            $isStock = $article->isStock($depot);
            $article->updateArtStock($depot, -$qte, -($prix * $qte),$_SESSION["id"],"confirmation_document");
        }
        $docligne->delete($_SESSION["id"]);
        $docligne->deleteConfirmationbyCbmarq($row->cbMarq);
    }
    $docEntete->delete();
}

if($_GET["acte"]=="ligneFactureStock"){
    $protNo = $_GET["PROT_No"];
    $protection = new ProtectionClass("","");
    $protection->connexionProctectionByProtNo($protNo);
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"],$objet->db);
                $typeDocument = $_GET["typeFac"];
    $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);

    $isVisu = $docEntete->isVisu($protection->PROT_Administrator,$protection->protectedType($typeDocument ),$protection->PROT_APRES_IMPRESSION,$isSecurite);
    $docligne = new DocLigneClass(0,$objet->db);
    $totalqte = 0;

    if($typeDocument=="Transfert")
        $rows=$docEntete->getLigneTransfert();
    else if($typeDocument=="Transfert_confirmation")
        $rows=$docEntete->getLigneTransfert();
    else if($typeDocument=="Transfert_detail")
        $rows = $docEntete->getLigneTransfert_detail();
    else if($typeDocument=="Transfert_valid_confirmation")
        $rows=$docEntete->getLignetConfirmation();
    else
        $rows=$docEntete->getLigneFactureTransfert();
    $flagPxRevient = $_GET["flagPxRevient"];
    $i=0;
    $id_sec=0;
    $classe="";
    if($rows==null){
    }else{
        foreach ($rows as $row){
            $i++;
            $docligne = new DocLigneClass($row->cbMarq,$objet->db);
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

            if($typeDocument!="Transfert_detail") {
                echo "<tr class='facture $classe' id='article_" . $row->cbMarq . "'";
                echo "><td id='AR_Ref' style='color:blue;text-decoration: underline'>" . $row->AR_Ref . "</td>"
                    . "<td id='DL_Design' style='align:left'>" . $row->DL_Design . "</td>";
                ?>
                <td id='DL_PrixUnitaire' style="<?php
                if ($flagPxRevient != 0)
                    echo "display:none"; ?>"><?= $objet->formatChiffre(round($row->DL_PrixUnitaire, 2)); ?> </td>
                <?php
                echo "<td id='DL_Qte'>" . $objet->formatChiffre(round($row->DL_Qte * 100) / 100) . "</td>";
                //. "<td id='DL_Remise'>".$row->DL_Remise."</td>"
                if ($flagPxRevient == 0)
                    echo "<td id='DL_MontantHT'>" . $objet->formatChiffre($row->DL_MontantHT) . "</td>";
                else "<td></td>";
                echo "<td style='display:none' id='cbMarq'>" . $row->cbMarq . "</td>"
                    . "<td style='display:none' id='id_sec'>" . $row->idSec . "</td>";

                    if(!$isVisu && $typeDocument!="Transfert" && $typeDocument!="Transfert_confirmation" && $typeDocument!="Transfert_detail")
                        echo "<td id='modif_".$row->cbMarq."'><i class='fa fa-pencil fa-fw'></i></td>";
                    if(!$isVisu && $typeDocument!="Transfert_valid_confirmation")
                        echo "<td id='suppr_".$row->cbMarq."'><i class='fa fa-trash-o'></i></td>";

                    if($protection->PROT_CBCREATEUR!=2)
                        echo "<td>{$docligne->getcbCreateurName()}</td>";
                    echo"</tr>";
                }else{
                $montantHT = round($row->DL_MontantHT*100)/100;
                $montantHT_dest = round($row->DL_MontantHT_dest*100)/100;
                ?>
                <tr class='facture <?= $classe ?>' id='article_<?= $row->cbMarq ?>'>
                    <td id='AR_Ref'><?= $row->AR_Ref ?></td>
                    <td id='DL_Design'><?= $row->DL_Design ?></td>
                    <td id='DL_PrixUnitaire'><?= round($row->DL_PrixUnitaire,2); ?></td>
                    <td id='DL_Qte'><?= (round($row->DL_Qte*100)/100) ?></td>
                    <td id='DL_MontantHT'><?= $montantHT ?></td>
                    <td style='display:none' id='cbMarq'><?= $row->cbMarq ?></td>
                    <td style='display:none' id='id_sec'><?= $row->idSec ?></td>
                    <td id='AR_Ref_dest'><?= $row->AR_Ref_Dest ?></td>
                             <td id='AR_Design_dest'><?= $row->DL_Design_Dest ?></td>
                                <td id='DL_Qte_dest'><?= (round($row->DL_Qte_dest*100)/100) ?></td>
                                <td id='DL_MontantHT_dest'><?= $montantHT_dest ?></td>
                <?php
                if(!isset($_GET["visu"])) echo "<td id='suppr_{$row->cbMarq}'><i class='fa fa-trash-o'></i></td>";
                if($protection->PROT_CBCREATEUR!=2)
                    echo "<td>{$docligne->getcbCreateurName()}</td>";
                echo "</tr>";
            }
        }
    }
}
//suppression d'article
if($_GET["acte"] =="suppr"){
    $type_fac=$_GET["type_fac"];
    $docligne = new DocLigneClass($_GET["id"]);
    $docEntete = new DocEnteteClass($docligne->getcbMarqEntete());
    $isModif = 1;
    $isVisu = 1;
    $type=$_GET["type_fac"];
    $prot_no = 0;
    if(isset($_GET["PROT_No"])) {
        $protection = new ProtectionClass("","");
        $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
        $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
        $isModif = $docEntete->isModif($protection->PROT_Administrator,$protection->PROT_Right,$protection->protectedType($type),$protection ->PROT_APRES_IMPRESSION,$isSecurite);
        if($type_fac!="Devis") {
            $isVisu = $docEntete->isVisu($protection->PROT_Administrator, $protection->protectedType($type), $protection->PROT_APRES_IMPRESSION, $isSecurite);
        }else
            $isVisu=0;
        if(!$isVisu){
            $AR_PrixAch = $docligne->DL_CMUP;
            $DL_Qte = $docligne->DL_Qte;
            $AR_Ref = $docligne->AR_Ref;
            $DE_No = $docEntete->DE_No;
            $DO_Piece = $docligne->DO_Piece;
            $AR_Ref = $docligne->AR_Ref;
            $AR_Design = $docligne->DL_Design;
            $article = new ArticleClass($AR_Ref,$objet->db);
            $docligne->delete($_GET["PROT_No"]);
            if($type_fac=="AchatPreparationCommande" || $type_fac=="PreparationCommande" || $type_fac=="Achat" || $type_fac=="AchatRetour") {
                $article->updateArtStock($DE_No,-$DL_Qte,-($AR_PrixAch * $DL_Qte),$_GET["PROT_No"],"suppr_ligne");
            }else {
                if ($type_fac != "PreparationCommande" && $type_fac != "Devis") {
                    $article->updateArtStock($DE_No,+$DL_Qte,+($AR_PrixAch * $DL_Qte),$_GET["PROT_No"],"suppr_ligne");
                }
            }
            $result=$objet->db->requete($objet->getZFactReglSuppr($docEntete->DO_Domaine,$docEntete->DO_Type,$docEntete->DO_Piece));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows!=null){
                $result = $objet->db->requete($objet->getInfoRAFControleur());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        $nom= $row->CO_Prenom." ".$row->CO_Nom;
                        $corpsMail="
            La facture $DO_Piece a été modifié par ".$_SESSION["login"]."<br/>
            La ligne concernant l'article $AR_Ref - $AR_Design de quantité ".$objet->formatChiffre($DL_Qte)." a été supprimée <br/><br/>
            Cordialement.<br/><br/>
           ";

                        if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
                            $mail = new Mail();
                            $mail->sendMail($corpsMail."<br/><br/><br/> {$this->db->db}", $email, "Suppression de ligne dans la facture $DO_Piece");
                        }
                    }
                }
            }
        }
    }
}


if($_GET["acte"] =="canTransform") {
    $cbMarqBL=$_GET["cbMarq"];
    $docEnteteBL= new DocEnteteClass($cbMarqBL);
    $type_trans= $_GET["type_trans"];
    $type=$_GET["type"];
    $do_type=3;
    $type_res="Vente";
    if($type_trans==3) $type_res="BonLivraison";
    if($type=="Devis") $do_type=0;
    $listeArticle="";
    if($type!="BonLivraison" && Sizeof($docEnteteBL->getStatutVente($type_res))>0) {
        $listeArticle = $docEnteteBL->canTransform();
    }
    echo $listeArticle;
}

if($_GET["acte"] == "transBLFacture"){
    $docEnteteBL = new DocEnteteClass($_GET["cbMarq"]);
    $docEnteteBL->transformBL_Dev_Facture ($_GET["conserv_copie"],$_GET["canTransform"],$_GET["type_trans"],$_GET["reference"],$_GET["type"]);
}

if( $_GET["acte"] =="suppr_factureConversion"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"], $objet->db);
    $protection = new ProtectionClass("","");
    $protection->connexionProctectionByProtNo($_SESSION["id"]);
    $isSecurite = $protection->IssecuriteAdmin($docEntete->DE_No);
    if($isSecurite==0){
        echo "securiteAdmin";
        return ;
    }

    $rows = $docEntete->getLigneFacture();
    if (sizeof($rows) > 0) {
        $docligne = new DocLigneClass($rows[0]->cbMarq);
        echo "Voulez vous transformer le document {$docEntete->DO_Piece} vers {$docligne->DL_PieceBL} ?";
    }
}

                if( $_GET["acte"] =="transformDoc"){
                    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
                    $type = $_GET["type"];
                    $rows = $docEntete->getLigneFacture();
                    if(sizeof($rows)>0){
                        $docligne = new DocLigneClass($rows[0]->cbMarq);
                        $docEnteteDevis = new DocEnteteClass(0);
                        $docEnteteDevis->setTypeFac("Devis");
                        $doPieceDevis = $docEnteteDevis->getEnteteDocument($docEntete->DO_Souche);
                        $docEnteteBL = new DocEnteteClass(0);
                        $docEnteteBL->setTypeFac("BonLivraison");
                        $doPieceBL = $docligne->DL_PieceBL; //$docEnteteBL->getEnteteDocument($docEntete->DO_Souche);
                        if(substr($doPieceDevis,0,4) == substr($docligne->DL_PieceBL,0,4)){
                            $docEnteteBL =  $docEnteteDevis;
                            $doPieceBL = $docligne->DL_PieceBL;
                        }
                        $data = $docEnteteBL->ajoutEntete($doPieceBL,$docEnteteBL->type_fac,$docligne->DL_DateBC,$docEntete->DO_Date,$docEntete->CA_Num
                            ,$docEntete->DO_Tiers,"","","",$docEntete->DO_Coord02
                            ,$docEntete->DO_Coord03,$docEntete->DO_Coord04,$docEntete->DO_Statut,$docEntete->latitude
                            ,$docEntete->longitude,$docEntete->DE_No,$docEntete->DO_Tarif,$docEntete->N_CatCompta
                            ,$docEntete->DO_Souche,$docEntete->CA_No,$docEntete->CO_No,$docEntete->DO_Ref,1);
                        $cbMarq = $data['cbMarq'];
                        $docEnteteTransform = new DocEnteteClass($cbMarq);
                        foreach($rows as $row)  {
                            $docligneTransform = new DocLigneClass($row->cbMarq);
                            $docligneFinal = new DocLigneClass(0);
                            $docligneFinal->ajout_ligneFacturation($docligneTransform->DL_Qte,$docligneTransform->AR_Ref,$cbMarq,$docEnteteBL->type_fac
                                ,$docEnteteTransform->DO_Tarif,$docligneTransform->DL_PrixUnitaire,""
                                ,"","ajout_ligne",$_SESSION["id"]);
                            $docligneTransform->delete();
                        }
                        $docEntete->deleteEntete();
                    }
                }


if( $_GET["acte"] =="transformDocLigne"){
    $docligne = new DocLigneClass($_GET["cbMarq"],$objet->db);
    $docEntete = new DocEnteteClass($_GET["cbMarqEntete"]);
    $docEnteteDevis = new DocEnteteClass(0);
    $docEnteteDevis->setTypeFac("Devis");
    $doPieceDevis = $docEnteteDevis->getEnteteDocument($docEntete->DO_Souche);
    $docEnteteBL = new DocEnteteClass(0);
    $docEnteteBL->setTypeFac("BonLivraison");
    $doPieceBL = $docligne->DL_PieceBL; //$docEnteteBL->getEnteteDocument($docEntete->DO_Souche);
    if(substr($doPieceDevis,0,4) == substr($docligne->DL_PieceBL,0,4)){
        $docEnteteBL =  $docEnteteDevis;
        $doPieceBL = $docligne->DL_PieceBL;
    }
    $result = $docEnteteBL->getEnteteByDOPiece($doPieceBL);
    $cbMarq=0;
    if($result==null) {
        $data = $docEnteteBL->ajoutEntete($doPieceBL, $docEnteteBL->type_fac, $docligne->DL_DateBC, $docEntete->DO_Date, $docEntete->CA_Num
            , $docEntete->DO_Tiers, "", "", "", $docEntete->DO_Coord02
            , $docEntete->DO_Coord03, $docEntete->DO_Coord04, $docEntete->DO_Statut, $docEntete->latitude
            , $docEntete->longitude, $docEntete->DE_No, $docEntete->DO_Tarif, $docEntete->N_CatCompta
            , $docEntete->DO_Souche, $docEntete->CA_No, $docEntete->CO_No, $docEntete->DO_Ref,1);
        $cbMarq = $data['cbMarq'];
    }else{
        $cbMarq = $docEnteteBL->getDocumentByDOPiece($doPieceBL,$docEnteteBL->DO_Domaine,$docEnteteBL->DO_Type)->cbMarq;
    }
    $docEnteteBL = new DocEnteteClass($cbMarq);
    $docligneFinal = new DocLigneClass(0);
    $docligneFinal->ajout_ligneFacturation($docligne->DL_Qte,$docligne->AR_Ref,$cbMarq,$docEnteteBL->type_fac
        ,$docEnteteBL->DO_Tarif,$docligne->DL_PrixUnitaire,""
        ,"","ajout_ligne",$_SESSION["id"]);
    $docligne->delete($_SESSION["id"]);
}

                // mise à jour de la référence
if( $_GET["acte"] =="suppr_facture"){
    $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
    $rows = $docEntete->getLigneFacture();
    if ($rows != null) {
        foreach ($rows as $row){
            $docligne = new DocLigneClass($row->cbMarq,$objet->db);
            $DL_Qte=$row->DL_Qte;
            $DE_No=$row->DE_No;
            $AR_PrixAch=$row->AR_PrixAch;
            $AR_Ref=$row->AR_Ref;
            $article = new ArticleClass($AR_Ref,$objet->db);
            $docligne ->delete($_SESSION["id"]);
            if($_GET["type"]=="Vente" ||$_GET["type"]=="BonLivraison"||$_GET["type"]=="Sortie")
                $article->updateArtStock($DE_No,+$DL_Qte,+($AR_PrixAch*$DL_Qte),$_SESSION["id"],$_GET["acte"]);
            if($_GET["type"]=="Entree" || $_GET["type"]=="Achat")
                $article->updateArtStock($DE_No,-$DL_Qte,-($AR_PrixAch*$DL_Qte),$_SESSION["id"],$_GET["acte"]);
            if($_GET["type"]=="Transfert"){
                if($row->DL_MvtStock==3)
                    $article->updateArtStock($DE_No,+$DL_Qte,+($AR_PrixAch*$DL_Qte),$_SESSION["id"],$_GET["acte"]);
                else
                    $article->updateArtStock($DE_No,-$DL_Qte,-($AR_PrixAch*$DL_Qte),$_SESSION["id"],$_GET["acte"]);
            }
        }
    }
    $type=$_GET["type"];
    $docEntete->suppressionReglement();
    $ajout="";
        if(isset($_GET["datedebut"]))
            $ajout=$ajout."&datedebut=".$_GET["datedebut"];
        if(isset($_GET["datefin"]))
            $ajout=$ajout."&datefin=".$_GET["datefin"];
        if(isset($_GET["depot"]))
            $ajout=$ajout."&depot=".$_GET["depot"];
}


if($_GET["acte"] =="redirect") {
    $docEntete = new DocEnteteClass(0, $objet->db);
    header('Location: ../' . $docEntete->redirectToListe($_GET["typeFacture"]));
}
if($_GET["acte"] =="listeArticle"){
    $article = new ArticleClass(0,$objet->db);
    if($_GET["type"]=="Vente" ||$_GET["type"]=="BonLivraison")
        $rows = $article->getAllArticleDispoByArRef($depot);
    else
        $rows = $article->all();
    echo "<ul>";
    if($rows==null){
    }else{
        foreach($rows as $row){
            echo "<li><span='ref'>".$row->AR_Ref."</span>";
            echo "<span ref='design'>".$row->AR_Ref." - ".$row->AR_Design."</span></li>";
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
            echo "<tr id='emodeler_anal_".$row->cbMarq."'>
                    <td id='tabCA_Num'>".$row->CA_Num." - ".$row->CA_Intitule."</td>
                    <td id='tabA_Qte'>".ROUND($row->EA_Quantite,2)."</td>
                    <td id='tabA_Montant'>".ROUND($row->EA_Montant,2)."</td>
                    <td id='data' style='visibility:hidden' ><span style='visibility:hidden' id='tabcbMarq'>".$row->cbMarq."</span></td>
                    <td id='tabCA_NumVal' style='visibility:hidden' >".$row->CA_Num."</td>
                    <td id='modif_anal_'><i class='fa fa-pencil fa-fw'></i></td><td id='suppr_anal_'><i class='fa fa-trash-o'></i></td>
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
