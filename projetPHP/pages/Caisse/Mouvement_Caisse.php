<a href="Mouvement_Caisse.php"></a>
<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/script_caisse.js?d=<?php echo time(); ?>"></script>
<script type="text/javascript" src="js/jquery.js?d=<?php echo time(); ?>"></script>

</head>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
    $CA_Num="-1";
    $datedeb= date("dmy");
    $datefin= date("dmy");
    $ca_no=-1;
    $type=-1;

    $caisse = new CaisseClass(0);
    if($admin==0){
        $isPrincipal = 1;
        $rows = $caisse->getCaisseDepot($_SESSION["id"]);
        foreach($rows as $row)
            if($row->IsPrincipal==2)
                $ca_no = $row->CA_No;
    }else{
        $rows = $caisse->listeCaisseShort();
    }
    if($ca_no==-1)
    if(sizeof($rows)>0)
        $ca_no = $rows[0]->CA_No;

    $creglement = new ReglementClass(0);
$datapost = 0;
$modif= 0;
if(isset($_POST["RG_Modif"]))
    $modif = $_POST["RG_Modif"];

        if(isset($_POST["dateReglementEntete_deb"])) {
            $datedeb = $_POST["dateReglementEntete_deb"];
            $datapost=1;
        }
        if(isset($_POST["dateReglementEntete_fin"]))
            $datefin = $_POST["dateReglementEntete_fin"];

        if(isset($_POST["caisseComplete"]))
            $ca_no = $_POST["caisseComplete"];

        if(isset($_POST["type_mvt_ent"]))
            $type = $_POST["type_mvt_ent"];
        $cloture=0;
        if(isset($_POST["date"]))
            $cloture = $creglement->journeeCloture($objet->getDate($_POST['date']),$_POST['CA_No']);

        $messageMenu="";
        if($cloture>0)
            $messageMenu = "Cette journée a déjà été cloturée !";

        if(isset($_POST["libelle"]) && $cloture == 0) {
            $protection = new ProtectionClass("", "");
            $protection->connexionProctectionByProtNo($_SESSION["id"]);
            $isSecurite = $protection->IssecuriteAdminCaisse($_POST["CA_No"]);
            if ($isSecurite == 1) {

                $montant = str_replace(" ", "", $_POST["montant"]);
                $login = $_SESSION["id"];
                $CA_Num = "";
                if (isset($_POST["CA_Num"]))
                    $CA_Num = $_POST["CA_Num"];
                $libelle = str_replace("'", "''", $_POST['libelle']);
                $rg_typereg = 0;
                if (isset($_POST['rg_typereg']))
                    $rg_typereg = $_POST['rg_typereg'];
                $user = "";
                if (isset($_POST["user"]))
                    $user = $_POST["user"];
                if ($rg_typereg == 6) $libelle = $libelle;
                $caisse = new CaisseClass($_POST["CA_No"]);
                $co_nocaissier = $caisse->CO_NoCaissier;
                $ca_intitule = $caisse->CA_Intitule;
                $jo_num = $caisse->JO_Num;
                $collabClass = new CollaborateurClass($co_nocaissier);
                if ($collabClass == null) {
                } else {
                    $collaborateur_caissier = $collabClass->CO_Nom;
                }
                $cg_num = $_POST['CG_NumBanque'];
                $banque = 0;
                if ($rg_typereg == 2) $cg_num = "NULL";
                if ($rg_typereg == 6) {
                    // Pour les vrst bancaire mettre a jour le compteur du RGPIECE
                    $banque = 1;
                }
                if ($modif == 0)
                    if ($rg_typereg != 16) {
                        $rg_typeregVal = $rg_typereg;
                        if ($rg_typereg == 6)
                            $rg_typeregVal = 5;
                        if ($rg_typereg == 6) {
                            $caisse = new CaisseClass($_POST['CA_No']);
                            $creglement->setReglement('NULL', $objet->getDate($_POST['date']), $montant, $_POST["journalRec"], $cg_num, $_POST['CA_No'], $co_nocaissier, $objet->getDate($_POST['date']), $libelle, 0, 2, 1, $rg_typeregVal, 1, 1, $login);
                            $rg_no = $creglement->insertF_Reglement();
                            $creglement->setReglement('NULL', $objet->getDate($_POST['date']), $montant, $caisse->JO_Num, $cg_num, $_POST['CA_No'], $co_nocaissier, $objet->getDate($_POST['date']), $libelle."_".$caisse->JO_Num, 0, 2, 8, 4, 1, 1, $login);
                            $rg_noDest = $creglement->insertF_Reglement();
                            $creglement->insertF_ReglementVrstBancaire($rg_no, $rg_noDest);
                        } else {
                            $creglement->setReglement('NULL', $objet->getDate($_POST['date']), $montant, $jo_num, $cg_num, $_POST['CA_No'], $co_nocaissier, $objet->getDate($_POST['date']), $libelle, 0, 2, 1, $rg_typeregVal, 1, $banque, $login);
                            $rg_no = $creglement->insertF_Reglement();
                        }
                    } else {
                        $creglement->setReglement('NULL', $objet->getDate($_POST['date']), $montant, $jo_num, $cg_num, $_POST['CA_No'], $co_nocaissier, $objet->getDate($_POST['date']), $libelle, 0, 2, 1, 4, 1, $banque, $login);
                        $rg_no = $creglement->insertF_Reglement();
                        $caisseDest = new CaisseClass($_POST['CA_No_Dest']);
                        $creglement->setReglement('NULL', $objet->getDate($_POST['date']), $montant, $caisseDest->JO_Num, $cg_num, $caisseDest->CA_No, $caisseDest->CO_NoCaissier, $objet->getDate($_POST['date']), $libelle, 0, 2, 1, 5, 1, $banque, $login);
                        $rg_no = $creglement->insertF_Reglement();
                    }

                if ($modif == 0)
                    if ($_POST["CA_Num"] != "" && $_POST["CG_Analytique"] == 1) {
                        $creglement->insertCaNum($rg_no, $_POST["CA_Num"]);
                    }

                if ($modif == 0)
                    if ($rg_typereg == 4) {
                        $message = "SORTIE D' UN MONTANT DE {$objet->formatChiffre($montant)} POUR $libelle DANS LA CAISSE $ca_intitule  SAISI PAR $user LE " . date("d/m/Y", strtotime($objet->getDate($_POST['date'])));
                        $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Mouvement de sortie"));
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if ($rows != null) {
                            foreach ($rows as $row) {
                                $email = $row->CO_EMail;
                                $collab_intitule = $row->CO_Nom;
                                if (($email != "" || $email != null)) {
                                    $mail = new Mail();
                                    $mail->sendMail($message."<br/><br/><br/> {$objet->db->db}", $email,  "Mouvement de sortie");
                                }
                            }
                        }

                        $result = $objet->db->requete($objet->getCollaborateurEnvoiSMS("Mouvement de sortie"));
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if ($rows != null) {
                            foreach ($rows as $row) {
                                $telephone = $row->CO_Telephone;
                                if (($telephone != "" || $telephone != null)) {
                                    $message = "SORTIE DE {$objet->formatChiffre($montant)} POUR $libelle LE " . date('d/m/Y', strtotime($objet->getDate($_POST['date']))) . " DANS $ca_intitule";
                                    $contactD = new ContatDClass(1);
                                    $contactD->sendSms($telephone, $message);
                                }
                            }
                        }
                    }

                if ($modif == 0)
                    if ($rg_typereg == 6) {
                        $message = "VERSEMENT BANCAIRE D'UN MONTANT DE $montant DANS LA CAISSE $ca_intitule SAISI PAR $user LE {$objet->getDate($_POST['date'])}";
                        $result = $objet->db->requete($objet->getCollaborateurEnvoiMail("Versement bancaire"));
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if ($rows != null) {
                            foreach ($rows as $row) {
                                $email = $row->CO_EMail;
                                $collab_intitule = $row->CO_Nom;
                                $telephone = $row->CO_Telephone;
                                if (($email != "" || $email != null)) {
                                    $mail = new Mail();
                                    $mail->sendMail($message."<br/><br/><br/> {$this->db->db}", $email,  "Versement bancaire");
                                }
                            }
                        }

                        $result = $objet->db->requete($objet->getCollaborateurEnvoiSMS("Versement bancaire"));
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        if ($rows != null) {
                            foreach ($rows as $row) {
                                $telephone = $row->CO_Telephone;
                                if (($telephone != "" || $telephone != null)) {
                                    $message = "SORTIE DE $montant POUR $libelle LE {$objet->getDate($_POST['date'])} DANS $ca_intitule";
                                    $contactD = new ContatDClass(1);
                                    $contactD->sendSms($telephone, $message);
                                }
                            }
                        }
                    }

                if ($modif == 0)
                    if ($rg_typereg != 2)
                        $objet->incrementeCOLREGLEMENT();

                if ($modif == 1) {
                    if ($_POST["rg_typeregModif"] == 4 || $_POST["rg_typeregModif"] == 2 || $_POST["rg_typeregModif"] == 5) {
                        $creglement = new ReglementClass($_POST["RG_NoLigne"]);
                        $creglement->RG_Date = $objet->getDate($_POST["date"]);
                        $caisse = new CaisseClass($_POST["CA_No"]);
                        $creglement->JO_Num = $caisse->JO_Num;
                        $creglement->CA_No = $_POST["CA_No"];
                        $creglement->RG_Libelle = $_POST["libelle"];
                        $creglement->CG_Num = $_POST["CG_NumBanque"];
                        $creglement->RG_Montant = str_replace(" ", "", $_POST["montant"]);
                        $creglement->maj_reglement();
                    }

                    if ($_POST["rg_typeregModif"] == 6) {
                        $creglement = new ReglementClass($_POST["RG_NoLigne"]);
                        $creglement->RG_Date = $objet->getDate($_POST["date"]);
                        $creglement->CA_No = $_POST["CA_No"];
                        $creglement->RG_Libelle = $_POST["libelle"];
                        $creglement->CG_Num = $_POST["CG_NumBanque"];
                        $creglement->RG_TypeReg = 5;
                        $creglement->RG_Montant = str_replace(" ", "", $_POST["montant"]);
                        $creglement->JO_Num = $_POST["journalRec"];
                        $creglement->maj_reglement();
                    }

                    if ($_POST["rg_typeregModif"] == 16) {
                        $creglement = new ReglementClass($_POST["RG_NoLigne"]);
                        $creglement->RG_Date = $objet->getDate($_POST["date"]);
                        $creglement->CA_No = $_POST["CA_No"];
                        $caisse = new CaisseClass($_POST["CA_No"]);
                        $creglement->JO_Num = $caisse->JO_Num;
                        $creglement->RG_Libelle = $_POST["libelle"];
                        $creglement->CG_Num = $_POST["CG_NumBanque"];
                        $creglement->RG_TypeReg = 4;
                        $creglement->RG_Montant = str_replace(" ", "", $_POST["montant"]);
                        $creglement->maj_reglement();

                        $creglement = new ReglementClass($_POST["RG_NoDestLigne"]);
                        $creglement->RG_Date = $objet->getDate($_POST["date"]);
                        $creglement->CA_No = $_POST["CA_No_Dest"];
                        $caisse = new CaisseClass($_POST["CA_No_Dest"]);
                        $creglement->JO_Num = $caisse->JO_Num;
                        $creglement->RG_Libelle = $_POST["libelle"];
                        $creglement->CG_Num = $_POST["CG_NumBanque"];
                        $creglement->RG_TypeReg = 5;
                        $creglement->RG_Montant = str_replace(" ", "", $_POST["montant"]);
                        $creglement->maj_reglement();
                    }
                }
            }
        }

?>
    <div id="milieu">    
        <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
    <?php
    if($messageMenu!=""){
        ?>
        <div class="alert alert-danger">
            <?= $messageMenu ?>
        </div>
            <?php
    } ?>
    <input type="hidden" class="form-control" id="flagAffichageValCaisse" value="<?= $flagAffichageValCaisse;/*$flagModifSupprComptoir;*/ ?>" />
    <input type="hidden" class="form-control" id="flagCtrlTtCaisse" value="<?= $flagCtrlTtCaisse/*$flagModifSupprComptoir;*/ ?>" />

</div>
                <fieldset class="entete">
                    <legend class="entete">Entete</legend>
                    <form class="form-horizontal" action="indexMVC.php?module=6&action=1" method="POST">
                        <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <label>Caisse</label>
                                    <input type="hidden" id="action" name="action" value="1"/>
                                    <input type="hidden" id="module" name="module" value="6"/>
                                    <input type="hidden" id="postData" name="postData" value="<?= $datapost; ?>"/>
                                    <select class="form-control" name="caisseComplete" id="caisseComplete">
                                        <?php
                                            $isPrincipal = 0;

                                        $caisse = new CaisseClass(0);
                                        if($admin==0){
                                            $isPrincipal = 1;
                                            $rows = $caisse->getCaisseDepot($_SESSION["id"]);
                                        }else{
                                            $rows = $caisse->listeCaisseShort();
                                        }
                                            if($rows==null){
                                            }else{
                                                if(sizeof($rows)>1)
                                                    echo "<option value='-1'>Sélectionner une caisse</option>";

                                                foreach($rows as $row) {
                                                    if ($isPrincipal == 0) {
                                                        echo "<option value='{$row->CA_No}'";
                                                        if ($row->CA_No == $ca_no) echo " selected";
                                                        echo ">{$row->CA_Intitule}</option>";
                                                    } else {
                                                        if ($row->IsPrincipal != 0 ) {
                                                            echo "<option value='{$row->CA_No}'";
                                                            if ($row->CA_No == $ca_no) echo " selected";
                                                            echo ">{$row->CA_Intitule}</option>";
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <label>Type</label>
                                    <select class="form-control" name="type_mvt_ent" id="type_mvt_ent">
                                        <option value="-1">Sélectionner un type</option>
                                        <?php
                                        if($profil_caisse==1 || $admin==1){
                                        ?>
                                            <option value="4" <?php if($type=="4") echo " selected"; ?>>Mouvement de sortie</option>
                                            <option value="5" <?php if($type=="5") echo " selected"; ?>>Mouvement d'entrée</option>
                                            <option value="2" <?php if($type=="2") echo " selected"; ?>>Fond de caisse</option>
                                            <option value="16" <?php if($type=="16") echo " selected"; ?>>Transfert de caisse</option>
                                        <?php
                                        }
                                        ?>
                                        <option value='6'<?php if($type=="6") echo " selected"; ?>>Verst bancaire</option>
                                    </select>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2">
                                    <label>Début</label>
                                    <input  type="text"  class="form-control" id="dateReglementEntete_deb" name="dateReglementEntete_deb" placeholder="Date" value="<?= $datedeb; ?>"/>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2">
                                    <label>Fin</label>
                                    <input  type="text"  class="form-control" id="dateReglementEntete_fin" name="dateReglementEntete_fin" placeholder="Date" value="<?= $datefin; ?>"/>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mt-3" style="margin-top: 10px">
                                    <button type="submit" class="btn btn-primary" id="recherche" name="recherche">Rechercher</button>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6  col-lg-6 mt-3 text-right" style="margin-top: 10px">
                                    <button type="button" class="btn btn-primary" id="imprimer">Imprimer</button>
                                </div>
                            </div>
                        
                    </form>
                </fieldset>

                <fieldset class="entete">
                    <legend class="entete">Ligne</legend>
                    <?php 
                    if(1==1){
                    ?>
                        <form class="form-horizontal" action="indexMVC.php?module=6&action=1" method="POST" name="form_ligne" id="form_ligne">
                        <div class="row">
                                <input type="hidden" id="action" name="action" value="1"/>
                                <input type="hidden" id="module" name="module" value="6"/>
                                <input type="hidden" id="caisseComplete_ligne" name="caisseComplete" value=""/>
                                <input type="hidden" id="type_mvt_ent_ligne" name="type_mvt_ent" value=""/>
                                <input type="hidden" id="dateReglementEntete_deb_ligne" name="dateReglementEntete_deb" value=""/>
                                <input type='hidden' id='RG_Modif' name='RG_Modif' value='0'/>
                                <input type='hidden' id='rg_typeregModif' name='rg_typeregModif' value='0'/>

                                <input type='hidden' id='RG_NoLigne' name='RG_NoLigne' value='0'/>
                                <input type='hidden' id='RG_NoDestLigne' name='RG_NoDestLigne' value='0'/>

                                <input type="hidden" id="dateReglementEntete_fin_ligne" name="dateReglementEntete_fin" value=""/>
                                <input type="hidden" id="cg_num_ligne" name="cg_num" value=""/>
                              <?php //if($flagDateMvtCaisse!=2){ ?>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2">
                                    <input type="text"  class="form-control" id="dateReglement" name="date" placeholder="Date" <?php if($flagDateMvtCaisse==2) echo "readonly"; ?>/>
                                </div>
                                <?php //} ?>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2">
                                    <select class="form-control" name="CA_No" id="caisseLigne" placeholder="caisse">
                                        <?php
                                            $caisseClass = new CaisseClass(0);
                                            if($admin==0){
                                                $isPrincipal = 1;
                                                $rows = $caisseClass->getCaisseDepot($_SESSION["id"]);
                                            }else{
                                                $rows = $caisseClass->listeCaisseShort();

                                            }
                                        if(sizeof($rows)>1)
                                            echo "<option value='-1'>Sélectionner une caisse</option>";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row) {
                                                if ($isPrincipal == 0) {
                                                    echo "<option value='{$row->CA_No}'";
                                                    if ($row->CA_No == $ca_no) echo " selected";
                                                    echo ">{$row->CA_Intitule}</option>";
                                                } else {
                                                    if ($row->IsPrincipal != 0) {
                                                        echo "<option value='{$row->CA_No}'";
                                                        if ($row->CA_No == $ca_no) echo " selected";
                                                        echo ">{$row->CA_Intitule}</option>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                    <input type="text" maxlength="27" class="form-control" id="libelleRec" name="libelle" placeholder="Libelle" />
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
                                    <input type="hidden" class="form-control" name="CG_NumBanque" id="CG_NumBanque" value=""/>
                                    <input type="hidden" class="form-control" name="CG_Analytique" id="CG_Analytique" value="0"/>
                                    <input type="text" class="form-control" name="banque" id="banque" value="" placeholder="Compte générale"/>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <select class="form-control" name="rg_typereg" id="type_mvt_lig">
                                        <?php 
                                        if(1==1){
                                           ?>
                                        <option value='4'>Mouvement de sortie</option>
                                            <option value="5">Mouvement d'entrée</option>
                                            <option value="2">Fond de caisse</option>
                                        <?php }
                                        if($protection->PROT_OUVERTURE_TOUTE_LES_CAISSES==0) echo "<option value='16'>Transfert caisse</option>";
                                        ?>
                                        <option value='6'>Verst bancaire</option>
                                    </select>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
                                    <input type="text" class="form-control" id="montantRec" name="montant" placeholder="Montant" />
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2" id="divCA_Num" style="display:none">

                                    <input type="hidden" class="form-control" name="CA_Num" id="CA_Num" value=""/>
                                    <input type="text" class="form-control" name="CA_Intitule" id="CA_Intitule" value="" placeholder="Compte analytique"/>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2" id="divJournalDest">
                                    <select class="form-control" id="journalRec" name="journalRec">
                                        <option value=""></option>
                                        <?php
                                        $journalRec = new JournalClass(0);
                                        $rows = $journalRec->getJournauxType(2,0);
                                        foreach ($rows as $row){
                                            ?>
                                            <option value="<?= $row->JO_Num ?>"><?= $row->JO_Num." - ".$row->JO_Intitule ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-2' id="divCaisseDest">
                                    <label>Caisse dest. :</label>
                                    <select style="float:left" class="form-control" name="CA_No_Dest" id="CA_No_Dest" placeholder="caisse">

                                        <option value="-1">Sélectionner une caisse</option>
                                        <?php
                                        $caisse = new CaisseClass(0);
                                        if($admin==0){
                                            $isPrincipal = 1;
                                            $rows = $caisse->getCaisseDepot($_SESSION["id"]);
                                        }else{
                                            $rows = $caisse->listeCaisseShort();
                                        }
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row) {
                                                if ($isPrincipal == 0) {
                                                    echo "<option value='{$row->CA_No}'";
                                                    if ($row->CA_No == $ca_no) echo " selected";
                                                    echo ">{$row->CA_Intitule}</option>";
                                                } else {
                                                    if ($row->IsPrincipal != 0) {
                                                        echo "<option value='{$row->CA_No}'";
                                                        if ($row->CA_No == $ca_no) echo " selected";
                                                        echo ">{$row->CA_Intitule}</option>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-xs-6 col-md-2  mt-4">
                                <button type="button" class="btn btn-primary" id = "validerRec" name= "validerRec">Valider</button>
                            </div>
                            </div>
                            <?php
                    echo "</form>";
                    }
    ?>
                        <table class="table table-striped" id="tableRecouvrement">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>N° Piece</th>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Montant</th>
                                    <th>Caisse</th>
                                    <th>Caissier</th>
                                    <th>Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    function typeCaisse($val){
                                        if($val==16) return "Transfert caisse";
                                        if($val==5) return "Entrée";
                                        if($val==4) return "Sortie";
                                        if($val==2) return "Fond de caisse";
                                        if($val==6) return "Vrst bancaire";
                                    }
                                    $reglement = new ReglementClass(0);
                                    $rows = $reglement->listeReglementCaisse($objet->getDate($datedeb),$objet->getDate($datefin),$ca_no,$type,$_SESSION["id"]);
                                    $reglement->afficheMvtCaisse($rows,$flagAffichageValCaisse,$flagCtrlTtCaisse);
                                ?>
                            </tbody>
                        </table>
    </div>
                        
                            
                        <div id="blocModal">
                            <div class='col-md-6'>
                            Libellé :<input type='text' class='form-control' id='libelleRecModif' placeholder='Libellé' />
                            </div>
                            <div class='col-md-6'>
                                Montant :<input type='text' class='form-control' id='montantRecModif' placeholder='Montant' />
                            </div>
                        </div>
                        </div>
                </fieldset>
            </div>
        </div>
</div>
        <div id="valide_vrst" title="VALIDATION VRST BANCAIRE DAF">
            <div class="form-group">
                <div class="col-lg-3">
                    <label>Bordereau</label>
                    <input class="form-control" name="bordereau" id="bordereau"/>
                </div>
                <div class="col-lg-3">
                    <label>Banque</label>
                    <input class="form-control" maxlength="8" name="libelle_banque" id="libelle_banque"/>
                </div>
                <div class="col-lg-3">
                    <label>Date</label>
                    <input class="form-control" maxlength="8" name="libelle_date" id="libelle_date"/>
                </div>
                <div id="fichier" class="col-md-3">
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]" multiple>
                    <!-- The global progress bar -->
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <!-- The container for the uploaded files -->
                    <div id="files" class="files"></div>
                </div>
            </div>
        </div>

</body>
</html>
