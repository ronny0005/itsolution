<?php
    $objet = new ObjetCollector(); 
    $affaire="";
    $souche="";
    $co_no=0;
    $depot_no=0;
    $client="";
    $caisse = 0;
    $type=-1;
    $result=$objet->db->requete($objet->getParametre($_SESSION["id"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows==null){
    }else{ 
        $affaire=$rows[0]->CA_Intitule;
        $caisse=$rows[0]->CA_No;
        $souche=$rows[0]->DO_Souche;
        $co_no=$rows[0]->CO_No;
        $depot_no=$rows[0]->DE_No;
    }
    if(isset($_GET["client"])) $client=$_GET["client"];
    if(isset($_GET["type"])) $type=$_GET["type"];
    if(isset($_GET["filtre_lieu"])) $type=$_GET["filtre_lieu"];
    
    if(isset($_POST["acte"]) && $_POST["acte"]=="Valider"){ 
        $date = $_POST["date"];
        $libelle = $_POST["libelle"];
        $montant = $_POST["montant"];
////        $flie = $_FILES['icone']['name'];
////        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
////        $extension_upload = strtolower(  substr(  strrchr($flie, '.')  ,1)  );
////        //mkdir('upload/1/', 0777, true);
////        $nom = md5(uniqid(rand(), true));
////        $nom = "avatars/{$id_membre}.{$extension_upload}";
////        $resultat = move_uploaded_file($_FILES['icone']['tmp_name'],$nom);
//        
//        mkdir('upload/', 0777, true);
//        $content_dir = $_SERVER['DOCUMENT_ROOT']. "/facturationPHP_DEV/upload/"; // dossier où sera déplacé le fichier
//        $tmp_file = $_FILES['fichier']['name'];
//        // on vérifie maintenant l'extension
//        $type_file = $_FILES['fichier']['type'];
////        if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
////            echo "Le fichier n'est pas une image";
//        // on copie le fichier dans le dossier de destination
//        $name_file = $_FILES['fichier']['name'];
//        echo $_SERVER['DOCUMENT_ROOT']. "/facturationPHP_DEV/"."<br>";
//        echo $content_dir . $name_file.'/'.$tmp_file;
//        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
//            echo "Impossible de copier le fichier dans $content_dir";
//        else
//            echo "Le fichier a bien été uploadé";
//        
        if($type==0){
            $objet->addReglement($client,1,$date,$montant,$libelle,0);  
        }
        else {
            $objet->db->requete($objet->addCReglement_Ligne($client, $date, $montant,$libelle));     
        }
    }
?>
        <script src="js/scriptRecouvrement.js?d=<?php echo time(); ?>"></script>
        <script src="js/scriptCombobox.js?d=<?php echo time(); ?>" type="text/javascript"></script>
 </head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
       <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
        <div class="container">
            <div class="col-md-12">
                <div class="err" id="add_err"></div>
                <fieldset class="entete">
                    <legend class="entete">Entete</legend>
                    <form id="form-client" action="indexMVC.php?action=4&module=1" method="GET" class="form-horizontal" >
                        <input type="hidden" value="1" name="module"/>
                        <input type="hidden" value="4" name="action"/>
                        <input type="hidden" value="<?php echo $co_no; ?>" id="co_no" name="co_no"/>
 
                        <div class="form-group">
                            <div style="height: 48px;"> 
                            <label for="inputdateofbirth" class="col-md-1 control-label">Client</label>
                            <div class="col-md-3">
                                <select class="form-control" name="client" id="client">
                                    <?php
                                        $result=$objet->db->requete($objet->allClients());     
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        $depot="";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row){
                                                echo "<option value=".$row->CT_Num."";
                                                if($row->CT_Num==$client) echo " selected";
                                                echo ">".$row->CT_Intitule."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <label for="inputdateofbirth" class="col-md-1 control-label">Caisse </label>
                            <div class="col-md-2">
                                <select class="form-control" name="caisse" id="caisse">
                                    <?php
                                        $result=$objet->db->requete($objet->caisse());     
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        $depot="";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row){
                                                echo "<option value=".$row->CA_No."";
                                                if($row->CA_No==$caisse) echo " selected";
                                                echo ">".$row->CA_Intitule."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            </div>
                            <div>
                            <div style="margin-left:90px" class="col-md-3">
                                <select class="form-control" style="width:200px" name="type" id="type">
                                    <option value="-1">Tout les règlements</option>
                                    <option value="1">Règlements imputés</option>
                                    <option value="0">Règlements non imputés</option>
                                </select>
                            </div>
                            <div style="margin-left:90px" class="col-md-3">
                            <select style="width:90px;float:left;margin-right: 10px" class="form-control" name="filtre_lieu" id="filtre_lieu">
                                    <option value="0" <?php if(isset($_GET["filtre_lieu"]) && $_GET["filtre_lieu"]==0) echo "selected"; ?> >local</option>
                                    <option value="1" <?php if(isset($_GET["filtre_lieu"]) && $_GET["filtre_lieu"]==1) echo "selected"; ?> >en ligne</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-success" name="rechercher" id="recherche" value="Rechercher"/>
                            </div>
                            </div>    



                        </div>

                    </form>
                </fieldset>

                <fieldset class="entete">
                    <form id="form-valider" action="indexServeur.php?page=ajoutReglementLigne" method="POST" class="form-horizontal"  enctype="multipart/form-data">
                        <input type="hidden" value="1" name="module"/>
                        <input type="hidden" value="4" name="action"/>
                        <legend class="entete">Ligne</legend>
                        <div class="form-group">
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="dateRec" name="date" placeholder="Date" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="12345" />
                                <input type="file" name="image" accept="image/*" />
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="libelleRec" name="libelle" placeholder="Libelle" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="montantRec" name="montant" placeholder="Montant" />
                            </div>
                            <div class="col-md-3">
                                <input name="client" id="client_valide" type="hidden" value="2" name="action"/>
                                <select style="width:150px;float:left;margin-right: 10px" class="form-control" name="lieu" id="lieu">
                                    <option value="0">local</option>
                                    <option value="1">en ligne</option>
                                </select>
                                <button type="submit" class="btn btn-success">Valider</button> <!--name="acte" id = "validerRec" value="Valider" />-->
                            </div>
                        </div>
                    </form>

                    <div class="form-group">
                        <table class="table" id="tableRecouvrement">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Montant</th>
                                    <?php if(isset($_GET["filtre_lieu"]) && $_GET["filtre_lieu"]==0) echo "<th>Solde</th>"; ?>
                                    <?php if(isset($_GET["filtre_lieu"]) && $_GET["filtre_lieu"]==0) echo "<th>Caisse</th>"; ?>
                                    <?php if(isset($_GET["filtre_lieu"]) && $_GET["filtre_lieu"]==0) echo "<th>Caissier</th>"; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($_GET["filtre_lieu"]) && $_GET["filtre_lieu"]==0)
                                        $result=$objet->db->requete($objet->getReglementByClient($client,$caisse,$type));    
                                    else 
                                        $result=$objet->db->requete($objet->getReglementByClient_Ligne($client));
                                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                    $i=0;
                                    $classe="";
                                    if($rows==null){
                                        echo "<tr><td>Aucun élément trouvé ! </td></tr>";
                                    }else{
                                        foreach ($rows as $row){
                                        $i++;
                                        if($i%2==0) $classe = "info";
                                                else $classe="";
                                        echo "<tr class='reglement $classe' id='reglement_".$row->RG_No."'>"
                                                . "<td id='RG_Date'>".$row->RG_Date."</td>"
                                                . "<td id='RG_Libelle'>".$row->RG_Libelle."</td>"
                                                . "<td id='RG_Montant'>".round($row->RG_Montant)."</td>";
                                                if(isset($_GET["filtre_lieu"]) && $_GET["filtre_lieu"]==0) echo "<td id='RC_Montant'>".round($row->RC_Montant)."</td>
                                                <td>".$row->CA_Intitule."</td>
                                                <td>".$row->CO_NoCaissier."</td>
                                                <td style='display:none' id='RG_Impute'>".$row->RG_Impute."</td>";
                                                echo "<td style='display:none' id='RG_No'>".$row->RG_No."</td>"
                                                . "</tr>";
                                        }
                                    }

                                ?>
                            </tbody>
                        </table>
                        <table class="table" id="tableFacture">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th>Avance</th>
                                    <th>TTC</th>
                                </tr>
                            </thead>
                            <tbody id="Listefacture">
                            </tbody>
                        </table>
 
                    </div>

                </fieldset>

            </div>
        </div>
        <div id="confirm_change">
            Voulez vous validez ce règlement ?
        </div>