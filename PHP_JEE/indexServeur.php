<?php

include("Modele/DB.php");
include("Modele/ObjetCollector.php");
include("Modele/Objet.php");
include("Modele/ReglementClass.php");
include("Modele/DepotUserClass.php");
include("Modele/FamilleClass.php");
include("Modele/CaisseClass.php");
include("Modele/DepotClass.php");
include("Modele/DepotCaisseClass.php");
include("Modele/CollaborateurClass.php");
include("Modele/ComptetClass.php");
include("Modele/DocEnteteClass.php");
include("Modele/DocLigneClass.php");
include("Modele/LiaisonEnvoiMailUser.php");
include("Modele/LiaisonEnvoiSMSUser.php");
include("Modele/ProtectionClass.php");
include("Modele/ContatDClass.php");
require 'Send/class.phpmailer.php';
include("Modele/ArticleClass.php");
include("Modele/EtatClass.php");
include("Modele/JournalClass.php");
include("Modele/P_ParametreCialClass.php");
include("Modele/CompteGClass.php");
include("Modele/TaxeClass.php");
include("Modele/LogFile.php");


$objet = new ObjetCollector();
$texteMenu = "";

function envoiRequete($requete,$objet){
    $result=$objet->db->requete($requete);
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

function execRequete($requete,$objet){
    $objet->db->requete($requete);
}

function error(){
    echo "[{-1}]";
}

$val=$_GET["page"];
switch ($val) {
    case "depot":
        envoiRequete($objet->depot(), $objet);
        break;
    case "depotCount":
        envoiRequete($objet->depotCount(), $objet);
        break;
    case "getCollaborateur":
        envoiRequete($objet->getCollaborateurAll(), $objet);
        break;
    case "getCollaborateurCount":
        envoiRequete($objet->getCollaborateurCount(), $objet);
        break;
    case "piedPageFacturation":
        envoiRequete($objet->getCollaborateur(), $objet);
        break;
    case "getCANumByCaisse" :
        $caisse = new CaisseClass($_GET["CA_No"]);
        echo json_encode($caisse->getCaNum());
        break;
    case "getPrixClientAch":
        $docligne = new DocLigneClass(0);
        echo json_encode($docligne->getPrixClientAch($_GET['AR_Ref'], $_GET['N_CatCompta'], $_GET['N_CatTarif'], $_GET["CT_Num"]));
        break;
    case "getPrixClientAchHT":
        envoiRequete($objet->getPrixClientAchHT($_GET['AR_Ref'], $_GET['N_CatCompta'], $_GET['N_CatTarif'], $_GET['Prix'], $_GET['remise']), $objet);
        break;
    case "getLibTaxePied":
        envoiRequete($objet->getLibTaxePied($_GET['N_CatTarif'], $_GET['N_CatCompta']), $objet);
        break;
    case "getF_Artclient":
        envoiRequete($objet->getF_Artclient(), $objet);
        break;
    case "getF_ArtclientCount":
        envoiRequete($objet->getF_ArtclientCount(), $objet);
        break;
    case "testCorrectLigneA":
        $docEntete = new DocEnteteClass($_GET["cbMarq"]);
        echo json_encode($docEntete->testCorrectLigneA());
        break;

    case "getF_ArtCompta":
        envoiRequete($objet->getF_ArtCompta(), $objet);
        break;
    case "getF_ArtComptaCount":
        envoiRequete($objet->getF_ArtComptaCount(), $objet);
        break;
    case "getF_FamCompta":
        envoiRequete($objet->getF_FamCompta(), $objet);
        break;
    case "getF_FamComptaCount":
        envoiRequete($objet->getF_FamComptaCount(), $objet);
        break;
    case "getF_Taxe":
        $taxe = new TaxeClass(0);
        echo json_encode($taxe->all());
        break;
    case "getTaxeByTACode":
        echo json_encode(new TaxeClass($_GET["TA_Code"]));
        break;
    case "getF_TaxeCount":
        envoiRequete($objet->getF_TaxeCount(), $objet);
        break;

    case "connect":
        envoiRequete($objet->connectSage2($_GET["NomUser"], $_GET["Password"]), $objet);
        break;
    case "getDateEcheance":
        $docEntete = new DocEnteteClass(0);
        echo json_encode($docEntete->getDateEcgetTiersheance($_GET["CT_Num"], $_GET["Date"]));
        break;
    case "getTiersByIntitule":
        $client = new ComptetClass(0);
        $rows = $client->getTiersByIntitule($_GET["CT_Intitule"]);
        echo json_encode($rows);
        break;
    case "getTiersByNum":
        $client = new ComptetClass(0);
        $rows = $client->getTiersByNum($_GET["CT_Num"]);
        echo json_encode($rows);
        break;
    case "getTiersByNumIntitule":
        $client = new ComptetClass(0);
        $all = 1;
        if(isset($_GET["all"]))
            $all = $_GET["all"];
        echo json_encode($client->getTiersByNumIntitule($_GET["term"], $_GET["TypeFac"], $all));
        break;
    case "getTiersByNumIntituleSearch":
        $client = new ComptetClass(0);
        $searchTerm = "";
        if (isset($_GET['term']))
            $searchTerm = $_GET['term'];
        $type = 0;
        if (isset($_GET['type']))
            $type = $_GET['type'];
        echo json_encode($client->getTiersByNumIntituleSearch($_GET["term"], $_GET["type"], $_GET["ctSommeil"]));
        break;

    case "getDepotByIntitule":
        $depot = new DepotClass(0);
        $exclude = (isset($_GET["DE_NoSource"])) ? $_GET["DE_NoSource"] : -1;
        if (!isset($_POST['searchTerm'])) {
            $rows = $depot->getDepotByIntitule("", $exclude);
        } else {
            $rows = $depot->getDepotByIntitule($_POST['searchTerm'], $exclude);
        }
        echo json_encode($rows);
        break;

    case "getArticleByRefDesignation":
        $article = new ArticleClass(0);
        $de_no = $_GET["DE_No"];
        $searchTerm = "";
        if (isset($_GET['term']))
            $searchTerm = str_replace(" ", "%", $_GET['term']);
        echo json_encode($article->getApiJson("/getArticleByRefDesignation&deNo=$de_no&term=$searchTerm&typeFacture=" . $_GET["type"]));
        break;

    case "getDepotByDENoIntitule":
        session_start();
        $depot = new DepotClass(0);
        $searchTerm = "";
        if (isset($_GET['term']))
            $searchTerm = $_GET['term'];
        $exclude = -1;
        if (isset($_GET['exclude']))
            $exclude = $_GET['exclude'];
        $depotClass = new DepotClass(0, $objet->db);
        $isPrincipal = 0;
        $protection = new ProtectionClass("", "");
        if (isset($_SESSION))
            $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if ($protection->PROT_Administrator == 0)
            echo json_encode($depotClass->getDepotUserSearch($_SESSION["id"], $exclude, $searchTerm, $_GET["principal"]));
        else
            echo json_encode($depot->getDepotByIntitule($searchTerm, $exclude));
        break;

    case "getArticleByIntitule":
        $article = new ArticleClass(0);
        $rows = $article->getArticleByIntitule($_GET["AR_Design"]);
        echo json_encode($rows);
        break;

    case "getDateEcheanceSelect":
        $docEntete = new DocEnteteClass(0);
        echo json_encode($docEntete->getDateEcgetTiersheanceSelect($_GET["MR_No"], $_GET["N_Reglement"], $_GET["Date"]));
        break;

    case "connexionProctection":
        session_start();
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        echo json_encode($protection);
        break;
    case "getCaisseDepotSouche":
        envoiRequete($objet->getCaisseDepotSouche($_GET["CA_No"], $_GET["DE_No"], $_GET["CA_Souche"]), $objet);
        break;
    case "getDepotUser":
        envoiRequete($objet->getDepotUser($_GET["id"]), $objet);
        break;
    case "getArticleAndDepotUser":
        envoiRequete($objet->getArticleAndDepotUser($_GET["AR_Ref"], $_GET["protNo"]), $objet);
        break;
    case "getCaisseDepot":
        envoiRequete($objet->getCaisseDepot($_GET["id"]), $objet);
        break;
    case "connexionProctectionByProtNo":
        $protection = new ProtectionClass("", "");
        $protection->connexionProctectionByProtNo($_GET["Prot_No"]);
        echo json_encode($protection);
        break;
    case "getTarif":
        envoiRequete($objet->getTarif(), $objet);
        break;
    case "getTarifCount":
        envoiRequete($objet->getTarifCount(), $objet);
        break;
    case "depotByDENo":
        envoiRequete($objet->getDepotByDE_No($_GET["DE_No"]), $objet);
        break;
    case "getPlanComptableByCGNum":
        envoiRequete($objet->getPlanComptableByCGNum($_GET["CG_Num"]), $objet);
        break;
    case "insertF_ArtCompta":
        $result = $objet->db->requete("SELECT *
                                            FROM F_ARTCOMPTA
                                            WHERE ACP_Type=" . $_GET["ACP_Type"] . " AND ACP_Champ=" . $_GET["ACP_Champ"] . " AND AR_Ref='" . $_GET["AR_Ref"] . "'");
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            execRequete($objet->modifF_ArtCompta($_GET["AR_Ref"], $_GET["ACP_Type"], $_GET["ACP_Champ"], str_replace(" - ", "", $_GET["CG_Num"]), str_replace(" - ", "", $_GET["CG_NumA"]), str_replace(" - ", "", $_GET["TA_Code1"]), str_replace(" - ", "", $_GET["TA_Code2"]), str_replace(" -", "", $_GET["TA_Code3"])), $objet);
        } else {
            execRequete($objet->insertF_ArtCompta($_GET["AR_Ref"], $_GET["ACP_Type"], $_GET["ACP_Champ"], str_replace(" - ", "", $_GET["CG_Num"]), str_replace(" - ", "", $_GET["CG_NumA"]), str_replace(" - ", "", $_GET["TA_Code1"]), str_replace(" - ", "", $_GET["TA_Code2"]), str_replace(" -", "", $_GET["TA_Code3"])), $objet);
        }
        break;
    case "insertF_FamCompta":
        $result = $objet->db->requete("SELECT *
                                            FROM F_FAMCOMPTA
                                            WHERE FCP_Type=" . $_GET["FCP_Type"] . " AND FCP_Champ=" . $_GET["FCP_Champ"] . " AND FA_CodeFamille='" . $_GET["FA_CodeFamille"] . "'");
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            execRequete($objet->modifF_FamCompta($_GET["FA_CodeFamille"], $_GET["FCP_Type"], $_GET["FCP_Champ"], str_replace(" - ", "", $_GET["CG_Num"]), str_replace(" - ", "", $_GET["CG_NumA"]), str_replace(" - ", "", $_GET["TA_Code1"]), str_replace(" - ", "", $_GET["TA_Code2"]), str_replace(" -", "", $_GET["TA_Code3"])), $objet);
        } else {
            execRequete($objet->insertF_FamCompta($_GET["FA_CodeFamille"], $_GET["FCP_Type"], $_GET["FCP_Champ"], str_replace(" - ", "", $_GET["CG_Num"]), str_replace(" - ", "", $_GET["CG_NumA"]), str_replace(" - ", "", $_GET["TA_Code1"]), str_replace(" - ", "", $_GET["TA_Code2"]), str_replace(" -", "", $_GET["TA_Code3"])), $objet);
        }
        break;
    case "getPlanAnalytiqueByCANum":
        envoiRequete($objet->getPlanAnalytiqueByCANum($_GET["CA_Num"]), $objet);
        break;
    case "getPlanAnalytique":
        envoiRequete($objet->getPlanAnalytique($_GET["type"], $_GET["N_Analytique"]), $objet);
        break;
    case "getPlanAnalytiqueHorsTotal":
        envoiRequete($objet->getPlanAnalytiqueHorsTotal($_GET["type"], $_GET["N_Analytique"]), $objet);
        break;
    case "getModeleReglement":
        envoiRequete($objet->getModeleReglement(), $objet);
        break;
    case "getModeleReglementCount":
        envoiRequete($objet->getModeleReglementCount(), $objet);
        break;

    case "getJournauxByJONum":
        envoiRequete($objet->getJournauxByJONum($_GET["JO_Num"]), $objet);
        break;
    case "getJournaux":
        $journal = new JournalClass(0);
        echo json_encode($journal->getJournaux($_GET["JO_Sommeil"]));
        break;
    case "getJournauxCount":
        envoiRequete($objet->getJournauxCount($_GET["JO_Sommeil"]), $objet);
        break;
    case "configMail":
        $liaisonMail = new LiaisonEnvoiMailUser();
        $liaisonMail->getConfigMail($_GET["PROT_No"], $_GET["PROT_No_Profil"], $_GET["TE_No"], $_GET["Check"]);
        break;
    case "configSMS":
        $liaisonMail = new LiaisonEnvoiSMSUser();
        $liaisonMail->getConfigSMS($_GET["PROT_No"], $_GET["PROT_No_Profil"], $_GET["TE_No"], $_GET["Check"]);
        break;
    case "configAccess":
        $protection = new ProtectionClass("", "");
        $protection->updateEProtection($_GET["PROT_No_Profil"], $_GET["TE_No"], $_GET["Selected"]);
        break;
    case "configProfilUtilisateur":
        $protection = new ProtectionClass("", "");
        $protection->updateProfil($_GET["PROT_No"], $_GET["TE_No"]);
        break;

    case "ajoutCodeClient":
        $code = "";
        $libelle = "";
        $type = "";
        if (isset($_GET["code"]))
            $code = $_GET["code"];
        if (isset($_GET["libelle"]))
            $libelle = $_GET["libelle"];
        if (isset($_GET["type"]))
            $type = $_GET["type"];

        if ($code != "") {
            $result = $objet->db->requete($objet->supprCodeClientByCode());
            for ($i = 0; $i < sizeof($code); $i++) {
                $result = $objet->db->requete($objet->getCodeClientByCode($code[$i]));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    //maj
                    $result = $objet->db->requete($objet->majCodeClientByCode($code[$i], $libelle[$i], $type[$i]));
                } else {
                    //create
                    $result = $objet->db->requete($objet->insertCodeClientByCode($code[$i], $libelle[$i], $type[$i]));
                }
            }
        }
        break;

    case "stat_articleParAgenceByMonth":
        $result = $objet->db->requete($objet->stat_articleParAgenceByMonth($_GET["DE_No"], $_GET["datedeb"], $_GET["datefin"], $_GET["article"], $_GET["famille"]));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $depot = "";
        $val = array();
        $nbval = 0;
        $datapoints = array();
        if ($rows != null) {
            foreach ($rows as $row) {
                if ($depot == "") {
                    $depot = $row->DE_Intitule;
                    $datapoints = array();
                }
                if ($depot != $row->DE_Intitule) {
                    $data = array(type => "line", lineThickness => 3, showInLegend => true, name => "$row->DE_Intitule"
                    , axisYType => "secondary", dataPoints => json_encode($datapoints));
                    array_push($val, $data);
                    $depot = $row->DE_Intitule;
                    $datapoints = array();
                    $nbval++;
                } else {
                    $dataD = array("x:" => $row->ANNEE, "y:" => $row->CA_NET_HT);
                    array_push($datapoints, $dataD);
                }
            }
            if ($nbval == 0) {
                $data = array(type => "line", lineThickness => 3, showInLegend => true, name => "$row->DE_Intitule"
                , axisYType => "secondary", dataPoints => json_encode($datapoints, JSON_NUMERIC_CHECK));
                array_push($val, $data);
            }
        }
        echo json_encode($data);
        break;
    case "parametre":
        envoiRequete($objet->getParametre($_GET["id"]), $objet);
        break;
    case "compareVal":
        envoiRequete($objet->compareVal($_GET["ttc"], $_GET["avance"]), $objet);
        break;
    case "ResteARegler":
        $docEntete = new DocEnteteClass($_GET["cbMarq"]);

        echo json_encode($docEntete->ResteARegler($_GET["avance"]));
        break;
    case "caisse":
        envoiRequete($objet->caisse(), $objet);
        break;
    case "caisseCount":
        envoiRequete($objet->caisseCount(), $objet);
        break;
    case "getInventairePrepa":
        envoiRequete($objet->getInventairePrepa($_GET["P1"], $_GET["P2"], $_GET["P3"], $_GET["P4"], $_GET["P5"], $_GET["P6"]), $objet);
        break;
    case "getAllArticleDispoByArRef":
        envoiRequete($objet->getAllArticleDispoByArRef($_GET['DE_No']), $objet);
        break;
    case "getAllArticleDispoByArRefTrsftDetail":
        envoiRequete($objet->getAllArticleDispoByArRefTrsftDetail($_GET['DE_No'], 1), $objet);
        break;
    case "getAllArticle":
        envoiRequete($objet->getAllArticle(), $objet);
        break;
    case "recoiMsgSite":
        execRequete($objet->recoiMsgSite($_GET["nom"], $_GET["message"]), $objet);
        break;
    case "SendMsgSite":
        envoiRequete($objet->SendMsgSite(), $objet);
        break;
    case "ajoutEnteteFactureVente":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;

    case "ajout_article":
        $mobile = "android";
        include("Traitement/Creation.php");
        break;
    case "ajout_client":
        $mobile = "android";
        include("Traitement/Creation.php");
        break;
    case "getEnteteDocument":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteTicket":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteEntree":
        $mobile = "android";
        include("Traitement/Entree.php");
        break;
    case "verif_stock":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteSortie":
        $mobile = "android";
        include("Traitement/Sortie.php");
        break;
        break;
    case "ajoutEnteteTransfert":
        $mobile = "android";
        include("Traitement/Transfert.php");
        break;
        break;
    case "ajoutEnteteFactureDevis":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteFactureBonLivraison":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteFactureAvoir":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteFactureRetour":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutEnteteFactureAchat":
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneEntree":
        $mobile = "android";
        include("Traitement/Entree.php");
        break;
    case "ajoutLigneSortie":
        $mobile = "android";
        include("Traitement/Sortie.php");
        break;
    case "ajoutLigneTransfert":
        $mobile = "android";
        include("Traitement/Transfert.php");
        break;
    case "regleVente" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "regleTicket" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "regleAchat" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "regleBonLivraison" :
        $mobile = "android";
        include("Traitement/BonLivraison.php");
        break;
    case "ajoutLigneFactureVente" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneTicket" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureDevis" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;

    case "ajoutLigneFactureBonLivraison" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureAvoir" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureRetour" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "ajoutLigneFactureAchat" :
        $mobile = "android";
        include("Traitement/Facturation.php");
        break;
    case "vehicule":
        envoiRequete($objet->getVehicule(), $objet);
        break;
    case "getPlanCR":
        envoiRequete($objet->getPlanCR(), $objet);
        break;
    case "getNumContribuable":
        $protection = new ProtectionClass("", "");
        echo json_encode($protection->getNumContribuable());
        break;

    case "getPrixClient":
        $article = new ArticleClass(0);
        echo json_encode($article->getPrixClient($_GET['AR_Ref'], $_GET['N_CatCompta'], $_GET['N_CatTarif']));
        break;
    case "insertDepotClient":
        envoiRequete($objet->insertDepotClient($_GET['DE_No'], $_GET['CodeClient']), $objet);
        break;
    case "supprDepotClient":
        envoiRequete($objet->supprDepotClient($_GET['DE_No']), $objet);
        break;
    case "supprReglement":
        $creglement = new ReglementClass(0);
        $mvtCaisse = "false";
        if (isset($_GET["MvtCaisse"]))
            $mvtCaisse = "true";
        $creglement->supprReglementTiers($mvtCaisse, $_GET["RG_No"], $_GET["protNo"]);
        break;
    //test sms
    case "envoiSMSTest":
        execRequete($objet->envoiSMSTest(($_GET['Code']), ($_GET['Nom']), ($_GET['Numero'])), $objet);
        break;
    case "getPrincipalDepot":
        $depotUser = new DepotUserClass();
        echo json_encode($depotUser->getPrincipalDepot($_GET['id']));
        break;
    case "equationStkVendeur":
        envoiRequete($objet->equationStkVendeur($_GET['DE_No'], $_GET['datedeb'], $_GET['datefin']), $objet);
        break;
    case "stat_mouvementStock":
        $etat = new EtatClass();
        $result = $etat->stat_mouvementStock($_GET['DE_No'], $_GET['datedeb'], $_GET['datefin'], $_GET['articledebut'], $_GET['articlefin']);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($rows);
        break;
    case "stat_articleParAgence":
        envoiRequete($objet->stat_articleParAgence($_GET['DE_No'], $_GET['datedeb'], $_GET['datefin'], "0", "0", "0", "3"), $objet);
        break;
    case "stat_clientParAgence":
        $etat = new EtatClass();
        envoiRequete($etat->stat_clientParAgence($_GET['DE_No'], $_GET['datedeb'], $_GET['datefin'], "3"), $objet);
        break;
    case "etatCaisse":
        $etat = new EtatClass();
        envoiRequete($etat->etatCaisse($_GET['CA_No'], $_GET['datedeb'], $_GET['datefin'], "0", "-1"), $objet);
        break;
    case "invPreparatoire":
        $etat = new EtatClass(0);
        if ($_GET["type"] == 0)
            envoiRequete($etat->getPreparatoireCumul($_GET["DE_No"]), $objet);
        else
            envoiRequete($etat->getetatpreparatoire($_GET["DE_No"], $_GET['datedeb']), $objet);
        break;
    case "getPrixClientHT":
        $fdocligne = new DocLigneClass(0);
        return json_encode($fdocligne->getPrixClientHT($_GET['AR_Ref'], $_GET['N_CatCompta'], $_GET['N_CatTarif'], $_GET['Prix'], $_GET['remise'], $_GET['qte'], $_GET['fournisseur']));
        break;
    case "stat_articleParAgenceArticle":
        envoiRequete($objet->stat_articleParAgenceArticle($_GET["depot"], $_GET["datedeb"], $_GET["datefin"], $_GET["article"], $_GET["famille"]), $objet);
        break;
    case "stat_articleAchatByCANum":
        envoiRequete($objet->stat_articleAchatByCANum("AR.AR_Ref,AR_Design", $_GET["datedeb"], $_GET["datefin"], $_GET["famille"], $_GET["article"], $_GET["N_Analytique"]), $objet);
        break;
    case "isStock":
        $article = new ArticleClass($_GET['AR_Ref']);
        echo json_encode($article->isStock($_GET["DE_No"]));
        break;
    case "isStockDENo":
        $article = new ArticleClass($_GET['AR_Ref']);
        echo json_encode($article->isStockDENo($_GET['DE_No'], $_GET['AR_Ref'],str_replace(' ', '', str_replace(',', '.', $_GET["DL_Qte"]))));
        break;
    case "verifSupprAjout":
        $docligne = new DocLigneClass($_GET["cbMarq"]);
        echo json_encode($docligne->verifSupprAjout());
        break;
    case "getClientByCTNum":
        $comptet = new ComptetClass($_GET['CT_Num']);
        echo json_encode($comptet);
        break;
    case "getTypePlanComptableValue":
        envoiRequete($objet->getClientByCTNum($_GET['CT_Num']), $objet);
        break;
    case "getJournalLastDate":
        $journal = new JournalClass(0);
        $result = $journal->getJournalLastDate($_GET['JO_Num'],$_GET['Mois'],$_GET['Annee']);
        echo json_encode($result);
        break;
    case "getTotalJournal":
        $journal = new JournalClass(0);
        $ctNum = "";
        $cgNum = "";
        $dateDebut = "";
        $dateFin = "";
        $lettrage =-1;
        $typeInterrogation ="";
        if(isset($_GET["typeInterrogation"]))
            $typeInterrogation = $_GET["typeInterrogation"];
        if(isset($_GET["CT_Num"]))
            $ctNum = $_GET["CT_Num"];
        if(isset($_GET["dateDebut"]))
            $dateDebut = $journal->formatDateSageToDate($_GET["dateDebut"]);
        if(isset($_GET["dateFin"]))
            $dateFin = $journal->formatDateSageToDate($_GET["dateFin"]);
        if(isset($_GET["lettrage"]))
            $lettrage = $_GET["lettrage"];
        if($typeInterrogation!="Tiers"){
            $cgNum = $ctNum;
            $ctNum = "";
        }
        $result = $journal->getTotalJournal($_GET['JO_Num'],$_GET['Mois'],$_GET['Annee'],$_GET['EC_Sens'],$ctNum,$dateDebut,$dateFin,$lettrage,$cgNum);
        echo json_encode($result);
        break;
    case "getLettrage":
        $journal = new JournalClass(0);
        $ctNum = "";
        $cgNum = "";
        $dateDebut = "";
        $dateFin = "";
        $typeInterrogation ="";
        if(isset($_GET["CT_Num"]))
            $ctNum = $_GET["CT_Num"];
        if(isset($_GET["dateDebut"]))
            $dateDebut =  $journal->formatDateSageToDate($_GET["dateDebut"]);
        if(isset($_GET["dateFin"]))
            $dateFin = $journal->formatDateSageToDate($_GET["dateFin"]);
        if(isset($_GET["typeInterrogation"]))
            $typeInterrogation = $_GET["typeInterrogation"];
        if($typeInterrogation!="Tiers"){
            $cgNum = $ctNum;
            $ctNum = "";
        }
        $result = $journal-> getLettrage($ctNum,$dateDebut,$dateFin,$cgNum);
        echo json_encode($result);
        break;
    case "calculSoldeLettrage" :
        $journal = new JournalClass(0);
        echo json_encode($journal->calculSoldeLettrage($_GET["listCbMarq"]));
        break;
    case "pointerEcriture" :
        $journal = new JournalClass(0);
        echo json_encode($journal->pointerEcriture($_GET["annuler"],$_GET["listCbMarq"],$_GET["ecLettrage"]));
        break;
    case "getJournalPiece":
        $journal = new JournalClass(0);
        $result = $journal->getJournalPiece($_GET['JO_Num'],$_GET['Mois'],$_GET['Annee']);
        echo json_encode($result);
        break;
    case "getArticle":
        $article = new ArticleClass(0);
        echo json_encode($article->getShortList());
        break;
    case "getCalendarUser":
        $protection = new ProtectionClass("", "");
        echo json_encode($protection->getZ_Calendar_user($_GET["PROT_No"], 0));
        break;
    case "getTiers":
        $tiers = new ComptetClass(0);
        if ($_GET["type"] == 0)
            echo json_encode($tiers->allClientsSelect());
        else if ($_GET["type"] == 1)
            echo json_encode($tiers->allFournisseurSelect());
        else
            echo json_encode($tiers->all());

        break;
    case "getArticleWithStock":
        envoiRequete($objet->getArticleWithStock($_GET['DE_No']), $objet);
        break;
    case "getArticleWithStockMax":
        envoiRequete($objet->getArticleWithStockMax($_GET['DE_No']), $objet);
        break;
    case "getArticleWithStockAndroid":
        envoiRequete($objet->getArticleWithStockAndroid($_GET['DE_No']), $objet);
        break;
    case "getArticleWithStockAndroidCount":
        envoiRequete($objet->getArticleWithStockAndroidCount($_GET['DE_No']), $objet);
        break;
    case "getFacture":
        envoiRequete($objet->getFacture($_GET['DO_Tiers'], $_GET['datedeb'], $_GET['datefin']), $objet);
        break;
    case "selectDefautCompte":
        envoiRequete($objet->selectDefautCompte($_GET['ctype']), $objet);
        break;
    case "majCatCompta":
        session_start();
        if($_GET["cbMarq"]!="") {
            $docEntete = new DocEnteteClass($_GET["cbMarq"]);
            $docEntete->maj("N_CatCompta", $_GET["N_CatCompta"]);
            $docEntete->maj("DO_Tarif", $_GET["N_CatTarif"]);
        }
        break;
    case "getNextArticleByFam":
        $famille = new FamilleClass($_GET['codeFam']);
        echo json_encode($famille->getNextArticleByFam());
        break;
    case "getCaisseByCA_No":
        $caisse = new CaisseClass($_GET["CA_No"]);
        echo json_encode($caisse);
        break;

    case "getArticleByRef":
        envoiRequete($objet->getArticleByRef($_GET['AR_Ref']), $objet);
        break;
    case "getArticleByDesignation":
        envoiRequete($objet->getArticleByDesignation($_GET['Design']), $objet);
        break;
    case "getFamille":
        $famille = new FamilleClass(0);
        echo json_encode($famille->getShortList());
        break;
    case "getFamilleCount":
        $famille = new FamilleClass(0);
        echo json_encode($famille->getFamilleCount());
        break;
    case "getConditionnement":
        envoiRequete($objet->getConditionnement(), $objet);
        break;
    case "getConditionnementMax":
        envoiRequete($objet->getConditionnementMax(), $objet);
        break;

    case "menuCaParDepotXml" :
        $etat = new EtatClass();
        echo $etat->menuCaParDepotXml($_GET["protNo"]);
        break;
    case "getFactureByDENo":
        $docEntete = new DocEnteteClass(0);
        $listFacture = $docEntete->getListeFacture($_GET['DE_No'], $_GET['provenance'], $objet->getDate($_GET['datedeb']), $objet->getDate($_GET['datefin']), $_GET['client'], 0, 6);
        echo json_encode($listFacture);
        break;
    case "getTicketByDENo":
        envoiRequete($objet->getTicketByDENo($_GET['DE_No'], $_GET['provenance'], $_GET['datedeb'], $_GET['datefin'], $_GET['client']), $objet);
        break;
    case "getFactureAchatByDENo":
        $docEntete = new DocEnteteClass(0);
        $listFacture = $docEntete->getListeFacture($_GET['DE_No'], 0, $objet->getDate($_GET['datedeb']), $objet->getDate($_GET['datefin']), $_GET['client'], 1, 16);
        echo json_encode($listFacture);
        break;
    case "getBonLivraisonByDENo":
        $docEntete = new DocEnteteClass(0);
        $listFacture = $docEntete->getListeFacture($_GET['DE_No'], 0, $objet->getDate($_GET['datedeb']), $objet->getDate($_GET['datefin']), $_GET['client'], 0, 3);
        echo json_encode($listFacture);
        break;
    case "getFactureByDENoDevis":
        $docEntete = new DocEnteteClass(0);
        $listFacture = $docEntete->getListeFacture($_GET['DE_No'], 0, $objet->getDate($_GET['datedeb']), $objet->getDate($_GET['datefin']), $_GET['client'], 0, 0);
        echo json_encode($listFacture);
        break;
    case "getFactureByTransfert":
        $docEntete = new DocEnteteClass(0);
        $listFacture = $docEntete->listeTransfert($_GET['DE_No'], $objet->getDate($_GET['datedeb']), $objet->getDate($_GET['datefin']));
        echo json_encode($listFacture);
        break;
    case "getFactureByEntree":
        $docEntete = new DocEnteteClass(0);
        $listFacture = $docEntete->listeEntree($_GET['DE_No'], $objet->getDate($_GET['datedeb']), $objet->getDate($_GET['datefin']));
        echo json_encode($listFacture);
        break;
    case "getFactureByDENoSorite":
        $docEntete = new DocEnteteClass(0);
        $listFacture = $docEntete->listeSortie($_GET['DE_No'], $objet->getDate($_GET['datedeb']), $objet->getDate($_GET['datefin']));
        echo json_encode($listFacture);
        break;
    case "getFactureCO":
        envoiRequete($objet->getFactureCO($_GET['CO_No'], $_GET['CT_Num']), $objet);
        break;
    case "getFactureCORecouvrement":
        $collab = 0;
        if (isset($_GET["collab"]))
            $collab = $_GET["collab"];
        $docEntete = new DocEnteteClass(0);
        echo json_encode($docEntete->getFactureCORecouvrement($collab, $_GET['CT_Num']));
        break;
    case "getFactureCORecouvrementHtmlFacture":
        $collab = 0;
        if (isset($_GET["collab"]))
            $collab = $_GET["collab"];
        $docEntete = new DocEnteteClass(0);
        $rows = $docEntete->getFactureCORecouvrement($collab, $_GET['CT_Num']);
        $sommeAvance = 0;
        $sommeTTC = 0;
        foreach ($rows as $row) {
            $sommeAvance = $sommeAvance + $row->avance;
            $sommeTTC = $sommeTTC + $row->ttc;
            ?>
            <tr id="facture" class="facture">
                <td><input type="checkbox" id="check_facture" value="0"/></td>
                <td><?= $objet->getDateDDMMYYYY($row->DO_Date) ?></td>
                <td id="libelle"><?= $row->DO_Piece ?></td>
                <td><?= $row->DO_Ref ?></td>
                <td id="avance"><?= $row->avance ?></td>
                <td id="ttc"><?= $row->ttc ?></td>
                <td><input class="form-control" style="width:100px" type="text" id="montant_regle" disabled/><span
                            style="visibility:hidden;width:10px" id="avanceInit"><?= $row->avance ?></span></td>
                <td><span style="visibility:hidden;width:10px" id="DoType"><?= $row->DO_Type ?></span><span
                            style="visibility:hidden;width:10px" id="cbMarqEntete"><?= $row->cbMarq ?></span></td>
                <td><span style="visibility:hidden;width:10px" id="DoDomaine"><?= $row->DO_Domaine ?></span></td>
            </tr>
            <?php
        }
        ?>
        <tr id="facture_Total" style="background-color:grey;color:white;font-weight:bold">
            <td colspan="4">Total</td>
            <td><?= $sommeAvance ?></td>
            <td><?= $sommeTTC ?></td>
            <td></td>
        </tr>
        <?php
        break;
    case "getFactureCORecouvrementHtmlFactureDialog":
        $collab = 0;
        if (isset($_GET["collab"]))
            $collab = $_GET["collab"];
        $docEntete = new DocEnteteClass(0);
        $rows = $docEntete->getFactureCORecouvrement($collab, $_GET['CT_Num']);
        $sommeAvance = 0;
        $sommeTTC = 0;
        $sommeResteAPayer = 0;
        foreach ($rows as $row) {
            $sommeAvance = $sommeAvance + $row->avance;
            $sommeTTC = $sommeTTC + $row->ttc;
            $sommeResteAPayer = $sommeResteAPayer + ($row->ttc - $row->avance);
            ?>

            <tr id="facture_dialog" class="facture">
                <td><?= $objet->getDateDDMMYYYY($row->DO_Date) ?></td>
                <td id="libelleS"><?= $row->DO_Piece ?></td>
                <td><?= $row->DO_Ref ?></td>
                <td id="avanceS" class="text-right"><?= $objet->formatChiffre($row->avance) ?></td>
                <td id="ttcS" class="text-right"><?= $objet->formatChiffre($row->ttc) ?></td>
                <td class="text-right"><?= $objet->formatChiffre($row->ttc - $row->avance) ?></td>
            </tr>
            <?php
        }
        ?>
        <tr id="facture_dialog_Total" style="background-color:grey;color:white;font-weight:bold">
            <td>Total</td>
            <td></td>
            <td></td>
            <td class="text-right"><?= $objet->formatChiffre($sommeAvance) ?></td>
            <td class="text-right"><?= $objet->formatChiffre($sommeTTC) ?></td>
            <td class="text-right"><?= $objet->formatChiffre($sommeResteAPayer) ?></td>
        </tr>
        <?php
        break;
    case "getFactureRGNo":
        $reglement = new ReglementClass(0);
        echo json_encode($reglement->getFactureRGNo($_GET['RG_No']));
        break;
    case "updateDrRegle":
        $result = $objet->db->requete($objet->updateDrRegle($_GET['RG_No']));
        break;
    case "getSoucheDepotCaisse":
        $protection = new ProtectionClass("", "");
        echo json_encode($protection->getSoucheDepotCaisse($_GET["prot_no"], $_GET["type"], $_GET["souche"], $_GET["ca_no"], $_GET["DE_No"], $_GET["CA_Num"]));
        break;
    case "getSoucheVente":
        envoiRequete($objet->getSoucheVente(), $objet);
        break;
    case "getSoucheVenteByIndice":
        $protection = new ProtectionClass("", "");
        echo json_encode($protection->getPSoucheVente($_GET["indice"]));
        break;
    case "updateDrRegleByDOPiece":
        $result = $objet->db->requete($objet->isRegleFullDOPiece($_GET['DO_Piece']));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows != null) {
            if ($rows[0]->VAL == 1)
                $result = $objet->db->requete($objet->updateDrRegleByDOPiece($_GET['DO_Piece']));
        }
        break;
    case "updateImpute":
        $reglement = new ReglementClass($_GET['RG_No']);
        $reglement->updateImpute();
        break;
    case "getReglementByClient":
        $typeSelectRegl = 0;
        if (isset($_GET["typeSelectRegl"]))
            $typeSelectRegl = $_GET["typeSelectRegl"];
        $reglement = new ReglementClass(0);
        echo json_encode($reglement->getReglementByClient($_GET['CT_Num'], $_GET['CA_No'], $_GET['type'], $_GET['treglement'], $_GET['datedeb'], $_GET['datefin'], $_GET['caissier'], $_GET['collaborateur'], $typeSelectRegl));
        break;
    case "listeTypeReglement":
        envoiRequete($objet->listeTypeReglement(), $objet);
        break;
    case "getJournauxTreso":
        $journaux = new JournalClass(0);
        echo json_encode($journaux->getJournauxType(2));
        break;

    case "listeTypeReglementCount":
        envoiRequete($objet->listeTypeReglementCount(), $objet);
        break;

    case "convertTransToRegl":
        $result = $objet->db->requete($objet->getCaisseByCA_No($_GET["CA_No"]));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $co_nocaissier = $rows[0]->CO_NoCaissier;
        $jo_num = $rows[0]->JO_Num;
        envoiRequete($objet->convertTransToRegl($_GET["CA_No"], $co_nocaissier, $jo_num, $_GET["RG_No"]), $objet);
        break;

    case "getCaissier" :
        envoiRequete($objet->getCaissier(), $objet);
        break;
    case "majCatComptaByArRef" :
        session_start();
        $article = new ArticleClass(0);
        $article->insertFArtCompta($_GET["cbMarq"],$_GET['AR_Ref'],$_GET['ACP_Type'],$_GET['ACP_Champ'],$_GET['val'],$_GET['champ'],0,$_SESSION["id"]);
        break;
    case "getCatComptaByArRef" :
        $article = new ArticleClass(0);
        $list = $article->getCatComptaByArRef($_GET['AR_Ref'],$_GET['ACP_Champ'],$_GET['ACP_Type']);
        foreach ($list as $element) {
            ?>
            <tr>
                <input type="hidden" value="<?= $element->cbMarq ?>" id="cbMarqArtCompta" />
                <td style="display: none"><input type="hidden" value="ACP_ComptaCPT_CompteG" id="typeCompta"/></td>
                <td id='libCompte'>Compte général</td>
                <td id='codeCompte' style='text-decoration: underline;color:blue'><?= $element->CG_Num ?></td>
                <td id='intituleCompte'><?= $element->CG_Intitule ?></td>
                <td id='valCompte'></td>
            </tr>
            <tr>
                <td style="display: none"><input type="hidden" value="ACP_ComptaCPT_CompteA" id="typeCompta"/></td>
                <td id='libCompte'>Section analytique</td>
                <td id='codeCompte' style='text-decoration: underline;color:blue'><?= $element->CG_NumA ?></td>
                <td id='intituleCompte'><?= $element->CG_IntituleA ?></td>
                <td id='valCompte'></td>
            </tr>
            <tr>
                <td style="display: none"><input type="hidden" value="ACP_ComptaCPT_Taxe1" id="typeCompta"/></td>
                <td id='libCompte'>Code taxe 1</td>
                <td id='codeCompte' style='text-decoration: underline;color:blue'><?= $element->Taxe1 ?></td>
                <td id='intituleCompte'><?= $element->TA_Intitule1 ?></td>
                <td id='valCompte'><?= $article->formatChiffre($element->TA_Taux1) ?></td>
            </tr>
            <tr>
                <td style="display: none"><input type="hidden" value="ACP_ComptaCPT_Taxe2" id="typeCompta"/></td>
                <td id='libCompte'>Code taxe 2</td>
                <td id='codeCompte' style='text-decoration: underline;color:blue'><?= $element->Taxe2 ?></td>
                <td id='intituleCompte'><?= $element->TA_Intitule2 ?></td>
                <td id='valCompte'><?= $article->formatChiffre($element->TA_Taux2) ?></td>
            </tr>
            <tr>
                <td style="display: none"><input type="hidden" value="ACP_ComptaCPT_Taxe3" id="typeCompta"/></td>
                <td id='libCompte'>Code taxe 3</td>
                <td id='codeCompte' style='text-decoration: underline;color:blue'><?= $element->Taxe3 ?></td>
                <td id='intituleCompte'><?= $element->TA_Intitule3 ?></td>
                <td id='valCompte'><?= $article->formatChiffre($element->TA_Taux3) ?></td>
            </tr>
        <?php
        }
        break;
    case "getCatComptaByCodeFamille" :
        envoiRequete($objet->getCatComptaByCodeFamille($_GET['FA_CodeFamille'], $_GET['ACP_Champ'], $_GET['ACP_Type']), $objet);
        break;
    case "getCaissierByCaisse" :
        $collab = new CollaborateurClass(0);
        echo json_encode($collab->getCaissierByCaisse($_GET['CA_No']));
        break;
    case "getReglementByClientFacture":
        envoiRequete($objet->getReglementByClientFacture($_GET['CT_Num'], $_GET['DO_Piece']), $objet);
        break;
    case "getCompteg":
        $compteg = new CompteGClass(0);
        echo json_encode($compteg->all());
        break;
    case "getComptegCount":
        envoiRequete($objet->getComptegCount(), $objet);
        break;
    case "tableau":
        $date = getdate();
        if ($_GET["latitude"] != 0 && $_GET["longitude"] != 0)
            $file = $_GET["latitude"] . "_" . $_GET["longitude"] . "_" . $_GET["reponseIp"] . $_GET["contrib"] . $date["year"] . substr("00" . $date["mon"], -2) . substr("00" . $date["mday"], -2) . '.txt';
        else
            $file = $_GET["reponseIp"] . $_GET["contrib"] . $date["year"] . substr("00" . $date["mon"], -2) . substr("00" . $date["mday"], -2) . '.txt';
        fopen($file, "w+");
        $current = file_get_contents($file);
        $current .= "IP : " . $_GET["reponseIp"] . "\n";
        $current .= "Location: " . $_GET["reponseLocation"] . "\n";
        $current .= "latitude: " . $_GET["latitude"] . ", longitude: " . $_GET["latitude"];
        file_put_contents($file, $current);
        break;
    case "getCatCompta":
        envoiRequete($objet->getCatCompta(), $objet);
        break;
    case "getCatComptaAll":
        envoiRequete($objet->getCatComptaAll(), $objet);
        break;
    case "getCatComptaAllCount":
        envoiRequete($objet->getCatComptaAllCount(), $objet);
        break;

    case "getCatComptaCount":
        envoiRequete($objet->getCatComptaCount(), $objet);
        break;
    case "insertClient":
        envoiRequete($objet->createClientMin($_GET["CT_Num"], $_GET["CT_Intitule"], $_GET["CG_Num"], $_GET["adresse"], $_GET["cp"], $_GET["ville"], $_GET["coderegion"], $_GET["siret"], $_GET["ape"], $_GET["numpayeur"], $_GET["co_no"], $_GET["cattarif"], $_GET["catcompta"], $_GET["de_no"], $_GET["tel"], $_GET["anal"]) . ";" . $objet->getLastClient(), $objet);
        break;

    case "getArticleByRefDesignationMvtTransfert":
        $article = new ArticleClass(0);
        $de_no = $_GET["DE_No"];
        $searchTerm = "";
        if(isset($_GET['term']))
            $searchTerm = $_GET['term'];
        if($de_no!="null") {
            echo json_encode($article->all(0, $searchTerm,10,0));
        }
        break;
    case "modifReglement":
        $fcreglement = new ReglementClass(0);
        $boncaisse = 0;
        if (isset($_GET["boncaisse"]) && $_GET["boncaisse"] == 1) {
            $boncaisse = 1;
        }
        $fcreglement->majReglement($_GET["protNo"], $boncaisse, $_GET["rg_no"], $_GET["rg_libelle"], $_GET["rg_montant"], $_GET["rg_date"], $_GET["JO_Num"], $_GET["CT_Num"], $_GET["CO_No"]);
        break;
    case "removeFacRglt":
        $docEntete = new DocEnteteClass(0);
        $docEntete->removeFacRglt($_GET["cbMarqEntete"], $_GET["RG_No"]);
        break;
    case "supprRglt":
        $reglement = new ReglementClass($_GET["RG_No"]);
        $reglement->supprReglement();
        break;
    case "remboursementRglt":
        $reglement = new ReglementClass($_GET["RG_No"]);
        $reglement->remboursementRglt($_GET["RG_Date"], $_GET["RG_Montant"]);
        break;
    case "addReglement":

        $admin = 0;
        $limitmoinsDate = "";
        $limitplusDate = "";

        $mobile = "";
        if (isset($_GET["mobile"]))
            $mobile = $_GET["mobile"];
        else
            if (!isset($_SESSION))
                session_start();
        if (isset($_SESSION)) {
            $protectionClass = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
            if ($protectionClass->PROT_Right != 1) {
                $limitmoinsDate = date('d/m/Y', strtotime(date('Y-m-d') . " - " . $protectionClass->getDelai() . " day"));
                $limitplusDate = date('d/m/Y', strtotime(date('Y-m-d') . " + " . $protectionClass->getDelai() . " day"));
                $str = strtotime(date("M d Y ")) - (strtotime($_GET["date"]));
                $nbDay = abs(floor($str / 3600 / 24));
                if ($nbDay > $protectionClass->getDelai())
                    $admin = 1;
            }
        }

        if ($admin == 0) {
            $cg_num = "";
            $ct_intitule = "";
            $rg_no_lier = 0;
            $jo_num = "";
            if (isset($_GET["JO_Num"]))
                $jo_num = $_GET["JO_Num"];
            if (isset($_GET["RG_NoLier"]))
                $rg_no_lier = $_GET["RG_NoLier"];
            $ct_num = $_GET['CT_Num'];
            $ca_no = $_GET['CA_No'];
            $boncaisse = 0;
            $banque = 0;
            $co_no = 0;
            if (isset($_GET["boncaisse"]) && $_GET["boncaisse"] == 1) {
                $boncaisse = $_GET["boncaisse"];
                $co_no = $ct_num;
                $ct_num = "";
                $banque = 3;
            }

            $result = $objet->db->requete($objet->getClientByCTNum($ct_num));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if (sizeof($rows) > 0) {
                $cg_num = $rows[0]->CG_NumPrinc;
                $ct_intitule = $rows[0]->CT_Intitule;
            } else {
                $banque = 3;
                $ct_num = "";
            }
            $email = "";
            $telephone = "";
            $collab_intitule = "";
            $caissier_intitule = "";
            $libelle = $_GET['libelle'];
            $caissier = $_GET['caissier'];
            if (isset($_GET["boncaisse"]) && $_GET["boncaisse"] == 1)
                $caissier = $co_no;
            $rg_typereg = 0;
            if ($_GET["mode_reglementRec"] == "05") {
                $banque = 2;
                $libelle = "Verst distant" . $libelle;
            }
            if ($_GET["mode_reglementRec"] == "10") {
                $rg_typereg = 5;
            }
            $result = $objet->db->requete($objet->getCaisseByCA_No($ca_no));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows == null) {
            } else {
                $ca_intitule = $rows[0]->CA_Intitule;
            }

            $result = $objet->db->requete($objet->getCollaborateurByCOno($caissier));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows == null) {

            } else {
                $collaborateur_caissier = $rows[0]->CO_Nom;
                $email = $rows[0]->CO_EMail;
                $collab_intitule = $rows[0]->CO_Nom;
                $telephone = $rows[0]->CO_Telephone;
            }

            if ($rg_no_lier == 0) {
                $message = 'VERSEMENT DISTANT D\' UN MONTANT DE ' . $_GET['montant'] . ' AFFECTE AU COLLABORATEUR ' . $collaborateur_caissier . ' POUR LE CLIENT ' . $ct_intitule . ' A DATE DU ' . $_GET['date'];
                if (($email != "" || $email != null) && $_GET['mode_reglementRec'] == "05") {
                    $objet->envoiMail($message, "Versement distant", $email);
                }
            }

            $mobile = "";
            if (isset($_GET["mobile"]))
                $mobile = $_GET["mobile"];
            $creglement = new ReglementClass(0);
            $creglement->initVariables();
            $creglement->RG_Date = $_GET['date'];
            $creglement->RG_DateEchCont = $_GET['date'];
            $creglement->JO_Num = $jo_num;
            $creglement->CG_Num = $cg_num;
            $creglement->CA_No = $ca_no;
            $creglement->CO_NoCaissier = $caissier;
            $creglement->RG_Libelle = $libelle;
            $creglement->RG_Montant = $_GET['montant'];
            $creglement->RG_Impute = $_GET['impute'];
            $creglement->RG_Type = $_GET['RG_Type'];
            $creglement->N_Reglement = $_GET['mode_reglementRec'];
            $creglement->RG_TypeReg = $rg_typereg;
            $creglement->RG_Ticket = 0;
            $creglement->RG_Banque = $banque;
            $creglement->CT_NumPayeur = $ct_num;
            $creglement->setuserName("", $mobile);
            $RG_NoInsert = $creglement->insertF_Reglement();

            //  $result=$objet->db->requete($objet->addCReglement($ct_num, $_GET['date'], $_GET['montant'], $jo_num, $cg_num, $ca_no, $caissier, $_GET['date'], $libelle, $_GET['impute'],$_GET['RG_Type'],$_GET['mode_reglementRec'],$rg_typereg,0,$banque,$login));

            if (($telephone != "" || $telephone != null) && $_GET['mode_reglementRec'] == "05") {
                $contactD = new ContatDClass(1);
                $contactD->sendSms($telephone, $message);
            }

            if ($rg_no_lier == 0) {
                $message = 'VERSEMENT DISTANT D\' UN MONTANT DE ' . $_GET['montant'] . ' AFFECTE AU COLLABORATEUR ' . $collaborateur_caissier . ' POUR LE CLIENT ' . $ct_intitule . ' A DATE DU ' . date("d/m/Y", strtotime($_GET['date']));
                $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Versement distant"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        //$collab_intitule = $row->CO_Nom;
                        if (($email != "" || $email != null) && $_GET['mode_reglementRec'] == "05") {
                            $objet->envoiMail($message, "Versement distant", $email);
                        }
                    }
                }

                $result = $objet->db->requete($objet->getCollaborateurEnvoiSMS("Versement distant"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        //$collab_intitule = $row->CO_Nom;
                        $telephone = $row->CO_Telephone;
                        if (($telephone != "" || $telephone != null) && $_GET['mode_reglementRec'] == "05") {
                            $contactD = new ContatDClass(1);
                            $contactD->sendSms($telephone, $message);
                        }
                    }
                }
            }

            if ($rg_no_lier != 0) {
                $RG_No = 0;
                $result = $objet->db->requete($objet->lastLigneCReglement());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    $RG_No = $rows[0]->RG_No;
                }

                $objet->db->requete($objet->insertZ_RGLT_BONDECAISSE($RG_No, $rg_no_lier));

                $CA_No = 0;
                $CO_NoCaissier = 0;

                $result = $objet->db->requete($objet->getReglementByRG_No($rg_no_lier));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    $CA_No = $rows[0]->CA_No;
                    $CO_NoCaissier = $rows[0]->CO_NoCaissier;
                    $objet->db->requete($objet->getMajCaisseRGNo($CA_No, $CO_NoCaissier, $RG_No));
                }
                $objet->db->requete($objet->updateImpute($rg_no_lier));
            }
            $objet->incrementeCOLREGLEMENT();
            envoiRequete($objet->lastLigneCReglement(), $objet);
        } else
            echo "la date doit être comprise entre $limitmoinsDate et $limitplusDate.";
        break;

    case "ajoutReglementLigne" :
        $data['file'] = $_FILES;
        $data['text'] = $_POST;
        echo json_encode($data);
        break;
    case "ValideSaisie_comptable" :
        envoiRequete($objet->ValideSaisie_comptable($_GET["DO_Domaine"], $_GET["DO_Type"], $_GET["DO_Piece"]), $objet);
        break;
    case "getCaisseMvtEntree":
        $login = "";
        $mobile = "";
        if (!isset($mobile)) {
            session_start();
            $login = $_SESSION["id"];
        } else {
            $login = "";
        }
        $CA_Num = "";
        if (isset($_GET["CA_Num"]))
            $CA_Num = $_GET["CA_Num"];
        $libelle = str_replace("'", "''", $_GET['libelle']);
        $rg_typereg = $_GET['rg_typereg'];
        $user = "";
        if (isset($_GET["user"]))
            $user = $_GET["user"];
        if ($rg_typereg == 6) $libelle = "Verst bancaire " . $libelle;
        $result = $objet->db->requete($objet->getCaisseByCA_No($_GET['CA_No']));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $co_nocaissier = $rows[0]->CO_NoCaissier;
        $ca_intitule = $rows[0]->CA_Intitule;
        $jo_num = $rows[0]->JO_Num;

        $result = $objet->db->requete($objet->getCollaborateurByCOno($co_nocaissier));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if ($rows == null) {
        } else {
            $collaborateur_caissier = $rows[0]->CO_Nom;
        }
        $cg_num = $_GET['cg_num'];
        $banque = 0;
        if ($rg_typereg == 2) $cg_num = "NULL";
        if ($rg_typereg == 3) {
            // Pour les vrst bancaire mettre a jour le compteur du RGPIECE
            $banque = 2;
        }
        if ($rg_typereg != 16)
            $result = $objet->db->requete($objet->addCReglement('NULL', $_GET['date'], $_GET['montant'], $jo_num, $cg_num, $_GET['CA_No'], $co_nocaissier, $_GET['date'], $libelle, 0, 2, 1, $rg_typereg, 1, $banque, $login));
        else {
            $result = $objet->db->requete($objet->addCReglement('NULL', $_GET['date'], $_GET['montant'], $jo_num, $cg_num, $_GET['CA_No'], $co_nocaissier, $_GET['date'], $libelle, 0, 2, 1, 4, 1, $banque, $login));
            $result = $objet->db->requete($objet->getCaisseByCA_No($_GET['CA_No_Dest']));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            $co_nocaissierDest = $rows[0]->CO_NoCaissier;
            $result = $objet->db->requete($objet->addCReglement('NULL', $_GET['date'], $_GET['montant'], $jo_num, $cg_num, $_GET['CA_No_Dest'], $co_nocaissierDest, $_GET['date'], $libelle, 0, 2, 1, 5, 1, $banque, $login));
        }
        $result = $objet->db->requete($objet->getLastReglement());
        $rows = $result->fetchAll(PDO::FETCH_OBJ);

        if ($objet->db->flagDataOr == 1) {
            $creglement = new ReglementClass(0);
            $creglement->setuserName("", $mobile);
            $creglement->insertZ_REGLEMENT_ANALYTIQUE($rows[0]->RG_No, $CA_Num);
        }
        if ($rg_typereg == 4) {
            $message = 'SORTIE D\' UN MONTANT DE ' . $objet->formatChiffre($_GET['montant']) . ' POUR ' . $libelle . ' DANS LA CAISSE ' . $ca_intitule . '  SAISI PAR ' . $user . ' LE ' . date("d/m/Y", strtotime($_GET['date']));
            $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Mouvement de sortie"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $email = $row->CO_EMail;
                    $collab_intitule = $row->CO_Nom;
                    if (($email != "" || $email != null)) {
                        $objet->envoiMail($message, "Mouvement de sortie", $email);
                    }
                }
            }
            $result = $objet->db->requete($objet->getCollaborateurEnvoiSMS("Mouvement de sortie"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $telephone = $row->CO_Telephone;
                    if (($telephone != "" || $telephone != null)) {
                        $message = 'SORTIE DE ' . $objet->formatChiffre($_GET['montant']) . ' POUR ' . $libelle . ' LE ' . date("d/m/Y", strtotime($_GET['date'])) . ' DANS ' . $ca_intitule;
                        $contactD = new ContatDClass(1);
                        $contactD->sendSms($telephone, $message);
                    }
                }
            }
        }

        if ($rg_typereg == 3) {
            $message = 'VERSEMENT BANCAIRE D\' UN MONTANT DE ' . $_GET['montant'] . ' DANS LA CAISSE ' . $ca_intitule . '  SAISI PAR ' . $user . ' LE ' . $_GET['date'];
            $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Versement bancaire"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $email = $row->CO_EMail;
                    $collab_intitule = $row->CO_Nom;
                    $telephone = $row->CO_Telephone;
                    if (($email != "" || $email != null)) {
                        $objet->envoiMail($message, "Versement bancaire", $email);
                    }
                }
            }

            $result = $objet->db->requete($objet->getCollaborateurEnvoiSMS("Versement bancaire"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $telephone = $row->CO_Telephone;
                    if (($telephone != "" || $telephone != null)) {
                        $message = 'SORTIE DE ' . $_GET['montant'] . ' POUR ' . $libelle . ' LE ' . $_GET['date'] . ' DANS ' . $ca_intitule;
                        $contactD = new ContatDClass(1);
                        $contactD->sendSms($telephone, $message);
                    }
                }
            }
        }

        if ($rg_typereg != 2) $objet->incrementeCOLREGLEMENT();
        break;
    case "getConnect":
        session_start();
        echo json_encode($_SESSION);
        break;
    case "addEcheance":
        $type_regl = "";
        if (isset($_GET['type_regl']))
            $type_regl = $_GET['type_regl'];
        $fcreglement = new ReglementClass(0);
        $fcreglement->addEcheance($_GET["protNo"], $_GET["cr_no"], $type_regl, $_GET["cbMarqEntete"], round($_GET["montant"]));
        break;
    case "getLigneFacture":
        envoiRequete($objet->getLigneFacture($_GET['DO_Piece'], $_GET['DO_Domaine'], $_GET['DO_Type']), $objet);
        break;
    case "getAffaire":
        envoiRequete($objet->getAffaire(), $objet);
        break;
    case "updateReglementCaisse":
        $mobile = "";
        execRequete($objet->updateReglementCaisse(str_replace("'", "''", $_GET['RG_Libelle']), $_GET['RG_Montant'], $_GET['RG_No']), $objet);
        if ($objet->db->flagDataOr == 1) {
            $creglement = new ReglementClass(0);
            $creglement->setuserName("", $mobile);
            $creglement->majZ_REGLEMENT_ANALYTIQUE($_GET["RG_No"], $_GET["CA_Num"]);
            $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Modification mouvement de caisse"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if ($rows != null) {
                foreach ($rows as $row) {
                    $email = $row->CO_EMail;
                    $nom = $row->CO_Prenom . " " . $row->CO_Nom;
                    $tiers = new ComptetClass($creglement->CT_NumPayeur);
                    $corpsMail = "
                Le règlement {$creglement->RG_Piece} a été supprimé par " . $_SESSION["login"] . "<br/>
                    Le règlement concerne le client {$tiers->CT_Intitule}<br/> 
                    Libellé : {$creglement->RG_Libelle}<br/> 
                    Montant du règlement : {$objet->formatChiffre(ROUND($creglement->RG_Montant, 2))}<br/> 
                    Date du règlement : {$objet->getDateDDMMYYYY($creglement->RG_Date)} <br/><br/>
                Cordialement.<br/><br/>
                ";
                    if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email))
                        $objet->envoiMail($corpsMail, "Modification mouvement de caisse " . $creglement->RG_Piece, $email);
                }
            }
        }
        break;

    case "getComptegByCGNum":
        $compteg = new CompteGClass(0);
        echo json_encode($compteg->allSearch($_GET["term"],10));
        break;
    case "getTaxeByTaCodeSearch":
        $taxe = new TaxeClass(0);
        echo json_encode($taxe->allSearch($_GET["term"],10));
        break;


    case "updateReglementCaisseDAF":
        $fichier = $_GET['nomFichier'];
        if ($fichier != "")
            $result = $objet->db->requete($objet->insert_REGLEMENTPIECE($_GET['RG_No'], $fichier));
        execRequete($objet->updateReglementCaisseDAF(str_replace("'", "''", $_GET['RG_Libelle']), $_GET['RG_No']), $objet);
        break;
    case "listeReglementCaisse":
        envoiRequete($objet->listeReglementCaisse($_GET["datedeb"], $_GET["datefin"], $_GET["ca_no"], $_GET["type"]), $objet);
        break;

    case "listeTable":
        $reglement = new ReglementClass(0);
        $rows = $reglement->getMajAnalytique($objet->getDate($_GET["dateDeb"]),$objet->getDate($_GET["dateFin"]),$_GET["statut"],$_GET["caNum"]);
        foreach ($rows as $row){
            ?>
            <tr>
                <td><?= $row->RG_No ?></td>
                <td><?= $row->RG_Libelle ?></td>
                <td><?= $objet->formatChiffre($row->RG_Montant) ?></td>
                <td><?= $row->CA_Intitule ?></td>
                <td class="text-center"> -> </td>
                <td><?= $row->CA_Num ?></td>
                <td><?= $objet->formatChiffre($row->EA_Montant) ?></td>
            </tr>
            <?php
        }
        break;
    case "listeReglementCaisseFormat":
        session_start();
        $reglement = new ReglementClass(0);
        $rows = $reglement->listeReglementCaisse($objet->getDate($_GET["datedeb"]),$objet->getDate($_GET["datefin"]),$_GET["ca_no"],$_GET["type"]);
        $reglement->afficheMvtCaisse($rows,$_GET["flagAffichageValCaisse"],$_GET["flagCtrlTtCaisse"]);
        break;

    case "getCompteEntree":
        $pparametrecial = new P_ParametreCialClass();
        $compteg = new CompteGClass($pparametrecial->P_CreditCaisse);
        echo json_encode($compteg);
        break;
    case "getCompteSortie":
        $pparametrecial = new P_ParametreCialClass();
        $compteg = new CompteGClass($pparametrecial->P_DebitCaisse);
        echo json_encode($compteg);
        break;
    case "getPPreference":
        envoiRequete($objet->getPPreference(),$objet);
        break;
    case "clients":
        switch ($_GET["op"]) {
            case "tiers":
                envoiRequete($objet->allTiers(),$objet);
                break;
            case "tiersMax":
                envoiRequete($objet->allTiersMax(),$objet);
                break;
            case "all":
                envoiRequete($objet->allClients(),$objet);
                break;
            case "fournisseur":
                envoiRequete($objet->allFournisseur(),$objet);
                break;
            default:
                envoiRequete($objet->clientsByCT_Num($_GET["op"]), $objet);
                break;
        }
        break;
}



?>
