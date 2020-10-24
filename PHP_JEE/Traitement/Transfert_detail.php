<?php
$login = "";
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/Objet.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/ComptetClass.php");
    include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ArticleClass.php");
    $objet = new ObjetCollector();
    $login = $_SESSION["login"];
    $mobile = "";
}
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

//ajout article
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){

    if($_GET["quantite"]!=""){
        $qte=$_GET["quantite"];
        $qte_dest=$_GET["quantite_dest"];
        $ref_article = $_GET["designation"];
        $ref_article_dest = $_GET["designation_dest"];
        $prix = $_GET["prix"];
        $prix_dest = $_GET["prix_dest"];
        $cbMarqEntete = $_GET["cbMarqEntete"];
        $cbMarq = $_GET["cbMarq"];
        $machine = $_GET["machineName"];
        $protNo = $_GET["PROT_No"];
        if($_GET["acte"] =="ajout_ligne"){
            $docligne = new DocLigneClass(0);
            echo json_encode($docligne->addDocligneTransfertDetailProcess($qte, $prix, $qte_dest, $prix_dest, $cbMarq, $cbMarqEntete, $protNo,$_GET["acte"] ,$ref_article ,$ref_article_dest,$machine));
        }else{
/*            $objet->modifDocligneFactureMagasin($entete,$ref_article,$qte,$cbMarq,$prix,4,41,$login,$typefac);
            $objet->modifDocligneFactureMagasin($entete,$ref_article_dest,$qte_dest,$id_sec,$prix_dest,4,40,$login,$typefac);

            $article = new ArticleClass($ref_article);
            $article->updateArtStock($depot,($aqte-$qte),(($Aprix*$aqte)-($prix*$qte)));

            $article = new ArticleClass($ref_article_dest);
            $article->updateArtStock($collaborateur,(-$aqte_dest+$qte_dest),(($prix_dest*$qte_dest)-($Aprix_dest*$aqte_dest)));

            $result=$objet->db->requete($objet->lastLigneBycbMarqTrsftDetail($cbMarq,$id_sec));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
*/
            echo json_encode($rows);
        }
    }
}

?>