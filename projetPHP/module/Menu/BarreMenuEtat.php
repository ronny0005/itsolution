<?php 

//$objet = new ObjetCollector();

//$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
if($protection->Prot_No!="") {
    if ($_GET["module"] == 5 && $_GET["action"] == 1)
        $texteMenu = "Mouvement de stock";
    if ($_GET["module"] == 5 && $_GET["action"] == 2)
        $texteMenu = "Inventaire préparatoire";
    if ($_GET["module"] == 5 && $_GET["action"] == 3)
        $texteMenu = "Equation de stock";
    if ($_GET["module"] == 5 && $_GET["action"] == 4)
        $texteMenu = "Statistique article par agence";
    if ($_GET["module"] == 5 && $_GET["action"] == 5)
        $texteMenu = "Statistique client par agence";
    if ($_GET["module"] == 5 && ($_GET["action"] == 6 || $_GET["action"] == 26)) {
        $texteMenu = "Echeance client";
        if (isset($_GET["typeTiers"]))
            if ($_GET["typeTiers"] == 1)
                $texteMenu = "Echeance fournisseur";
    }
    if ($_GET["module"] == 5 && $_GET["action"] == 7)
        $texteMenu = "Règlement client";
    if ($_GET["module"] == 5 && $_GET["action"] == 8)
        $texteMenu = "Rélévé compte client";
    if ($_GET["module"] == 5 && $_GET["action"] == 9)
        $texteMenu = "Etat caisse";
    if ($_GET["module"] == 5 && $_GET["action"] == 10)
        $texteMenu = "Etat des dettes";
    if ($_GET["module"] == 5 && $_GET["action"] == 11)
        $texteMenu = "Statistique collaborateur par client";
    if ($_GET["module"] == 5 && $_GET["action"] == 12)
        $texteMenu = "Livre d'inventaire";
    if ($_GET["module"] == 5 && $_GET["action"] == 13)
        $texteMenu = "Statistique collaborateur par article";
    if ($_GET["module"] == 5 && $_GET["action"] == 14)
        $texteMenu = "Versement distant";
    if ($_GET["module"] == 5 && $_GET["action"] == 15)
        $texteMenu = "Versement bancaire";
    if ($_GET["module"] == 5 && $_GET["action"] == 16)
        $texteMenu = "Etat de contrôle des reports fond de caisse";
    if ($_GET["module"] == 5 && $_GET["action"] == 17)
        $texteMenu = "Reglement de ";
    if ($_GET["module"] == 5 && $_GET["action"] == 18)
        $texteMenu = "Statistique des Achats analytique";
    if ($_GET["module"] == 5 && $_GET["action"] == 19)
        $texteMenu = "Statistique des Achats";
    if ($_GET["module"] == 5 && $_GET["action"] == 20)
        $texteMenu = "Statistique des articles par fournisseur";
    if ($_GET["module"] == 5 && $_GET["action"] == 21)
        $texteMenu = "Balance des tiers";
    if ($_GET["module"] == 5 && $_GET["action"] == 22)
        $texteMenu = "Ech tiers";
    if ($_GET["module"] == 5 && $_GET["action"] == 23)
        $texteMenu = "Etat de réapprovisionnement";
    if ($_GET["module"] == 5 && $_GET["action"] == 24)
        $texteMenu = "Caisse d'exploitation";
    if ($_GET["module"] == 5 && $_GET["action"] == 25)
        $texteMenu = "Transfert de caisse";
    if ($_GET["module"] == 5 && $_GET["action"] == 27)
        $texteMenu = "Stock grand depot";
    if ($_GET["module"] == 5 && $_GET["action"] == 29)
        $texteMenu = "Fichier central";
    if ($_GET["module"] == 5 && $_GET["action"] == 30)
        $texteMenu = "Etat client agé";
    $lien = "http://209.126.69.121/ReportServer/Pages/ReportViewer.aspx?%2fEtatFacturation%2fAccueil&rs:Command=Render";


    if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_MVT_STOCK == 0)) {
        ?>
            <li class="dropdown dropdown-submenu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Echéance client</a>
                <ul class="dropdown-menu">
                    <?php
                        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0)) {
                            ?>
                            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 6) if (isset($_GET["typeTiers"])) if ($_GET["typeTiers"] == 0) echo "active"; ?>">
                                <a href="indexMVC.php?module=5&action=6&typeTiers=0">Echéance client</a></li>
                            <?php
                        }
                        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0)) {
                            ?>
                            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 30) if (isset($_GET["typeTiers"])) echo "active"; ?>">
                                <a href="indexMVC.php?module=5&action=30&typeTiers=0">Echéance client agé</a></li>
                            <?php
                        }
                        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0)) {
                            ?>
                            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 26) if (isset($_GET["typeTiers"])) if ($_GET["typeTiers"] == 0) echo "active"; ?>">
                                <a href="indexMVC.php?module=5&action=26&typeTiers=0">Echéance client 2</a></li>
                            <?php
                        }
                        ?>
                </ul>
            </li>
            <li class="dropdown dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistique article</a>
                    <ul class="dropdown-menu">
                        <?php
                        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0)) {
                            ?>
                            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 4) echo "active"; ?>">
                                <a href="indexMVC.php?module=5&action=4">Statistique article par agence</a></li>
                            <?php
                        }
                        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_FRS==0)) {
                            ?>
                            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 20) echo "active"; ?>">
                                <a href="indexMVC.php?module=5&action=20">Statistique des articles par fournisseur</a></li>
                            <?php
                        }
                            ?>
                    </ul>
            </li>
            <li class="dropdown dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistique Achat</a>
                    <ul class="dropdown-menu">
                        <?php
                        if ($protection->PROT_Right == 1 || (1 == 1)) {
                            ?>
                            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 19) echo "active"; ?>">
                                <a href="indexMVC.php?module=5&action=19">Statistique des Achats</a></li>
                            <?php
                        }
                        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_FRS_PAR_ARTICLE == 0)) {
                            ?>
                            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 18) echo "active"; ?>">
                                <a href="indexMVC.php?module=5&action=18">Statistique des Achats analytique</a></li>
                            <?php
                        }
                        ?>
                    </ul>
            </li>
            <li class="dropdown dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistique collaborateur</a>
                    <ul class="dropdown-menu">
                        <?php
                        if ($profil_commercial == 0) {
                            if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_COLLAB_PAR_ARTICLE == 0)) {
                                ?>
                                <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 13) echo "active"; ?>">
                                    <a href="indexMVC.php?module=5&action=13">Statistique collaborateur par article</a></li>
                                <?php
                            }
                            if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_COLLAB_PAR_TIERS == 0)) {
                                ?>
                                <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 11) echo "active"; ?>">
                                    <a href="indexMVC.php?module=5&action=11">Statistique collaborateur par client</a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
            </li>

            <li class="dropdown dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistique client</a>
                    <ul class="dropdown-menu">
                        <?php
                        if ($profil_commercial == 0) {
                            if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_PALMARES_CLT == 0)) {
                                ?>
                                <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 5) echo "active"; ?>">
                                    <a href="indexMVC.php?module=5&action=5">Statistique client par agence</a></li>
                                <?php
                            }
                            if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_PALMARES_CLT == 0)) {
                                ?>
                                <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 5) echo "active"; ?>">
                                    <a href="indexMVC.php?module=5&action=39">Statistique client par article</a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
            </li>



        <li class="dropdown dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Etat compta</a>
            <ul class="dropdown-menu">
                <li class="<?= ($_GET["module"] == 5 && $_GET["action"] == 32) ? "active" :""; ?>">
                    <a href="indexMVC.php?module=5&action=32">Grand livre tiers commercial</a></li>
                <li class="<?= ($_GET["module"] == 5 && $_GET["action"] == 35) ? "active" :""; ?>">
                    <a href="indexMVC.php?module=5&action=35">Balance Analytique</a></li>
                <li class="<?= ($_GET["module"] == 5 && $_GET["action"] == 36) ? "active" :""; ?>">
                    <a href="indexMVC.php?module=5&action=36">Balance des comptes</a></li>
                <li class="<?= ($_GET["module"] == 5 && $_GET["action"] == 37) ? "active" :""; ?>">
                    <a href="indexMVC.php?module=5&action=37">Grand livre analytique</a></li>
                <li class="<?= ($_GET["module"] == 5 && $_GET["action"] == 38) ? "active" :""; ?>">
                    <a href="indexMVC.php?module=5&action=38">Journal</a></li>
            </ul>
        </li>
        <li class="<?php //if($_GET["module"]==5 && $_GET["action"]==1) echo "active";
        ?>"><a href="indexMVC.php?module=5&action=1">Mouvement de stock</a></li>
        <?php
    }
    /*if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_INVENTAIRE_PREP == 0)) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 2) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=2">Inventaire préparatoire</a></li>
        <?php
    }*/
    if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_MVT_STOCK == 0)) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 3) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=3">Equation de stock</a></li>
        <?php
    }
    if ($protection->PROT_Right == 1) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 33) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=33">Articles Absent Boutique</a></li>
        <?php
    }
    if ($protection->PROT_Right == 1) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 34) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=34">Articles Dormants</a></li>
        <?php
    }
    if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_RELEVE_ECH_FRS == 0)) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 6) if (isset($_GET["typeTiers"])) if ($_GET["typeTiers"] == 1) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=6&typeTiers=1">Echéance fournisseur</a></li>
        <?php
    }
    if ($protection->PROT_Right == 1 || (1 == 1)) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 7) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=7">Règlement client</a></li>
        <?php
    }
    if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_RELEVE_CPTE_CLIENT == 0)) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 8) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=8">Relevé compte client</a></li>
    <?php }
    if ($profil_commercial == 0) {
        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_CAISSE_MODE_RGLT == 0)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 9) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=9">Etat caisse</a></li>
            <?php //}
        }

    }
    if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_RELEVE_ECH_CLIENT == 0)) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 10) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=10">Etat des dettes</a></li>
        <?php
    }
    if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_LIVRE_INV == 0)) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 12) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=12">Livre d'inventaire</a></li>
    <?php }
    if ($profil_commercial == 0) {

        if ($protection->PROT_Right == 1 || ($protection->PROT_RISQUE_CLIENT == 0)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 14) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=14">Versement distant</a></li>
            <?php
        }
        if ($protection->PROT_Right == 1 || ($protection->PROT_RISQUE_CLIENT == 0)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 15) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=15">Versement bancaire</a></li>
            <?php
        }
        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE == 0)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 16) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=16">Ctrle report fond de caisse</a></li>
            <?php
        }
        if ($protection->PROT_Right == 1 || (1 == 1)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 21) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=21">Balance des tiers</a></li>
            <?php
        }
        if ($protection->PROT_Right == 1 || (1 == 1)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 22) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=22">Ech tiers</a></li>
            <?php
        }
        if ($protection->PROT_Right == 1 || (1 == 1)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 23) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=23">Etat de réapprovisionnement</a></li>
            <?php
        }
        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE==0)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 24) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=24">Etat d'exploitation</a></li>
            <?php
        }
        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_CAISSE_ARTICLE == 0)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 25) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=25">Transfert de caisse</a></li>
            <?php
        }
        if ($protection->PROT_Right == 1 ) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 27) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=27">Stock grand depot</a></li>
            <?php
        }
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 27) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=28">Etat du compte de résultat</a></li>
        <?php
        if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0)) {
            ?>
            <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 29) echo "active"; ?>">
                <a href="indexMVC.php?module=5&action=29">Fichier central rap</a></li>
            <?php
        }
        //if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0)) {
        ?>
        <li class="<?php if ($_GET["module"] == 5 && $_GET["action"] == 31) echo "active"; ?>">
            <a href="indexMVC.php?module=5&action=31">Ecriture comptable</a></li>
        <?php
        //}
        //if ($protection->PROT_Right == 1 || ($protection->PROT_ETAT_STAT_ARTICLE_PAR_ART == 0)) {
        ?>
        <?php
        //}
        ?>
        <li><a href="<?php echo $lien; ?>">Etats BI</a></li>

        <?php
    }
}
?>
