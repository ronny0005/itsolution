<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $val=0;
    $action=0;
    $module=0;
    $exercice = 0;
    $codeJournal = 0;
    $codeMois = 0;
    $annee_exercice=0;
    if(isset($_GET["codeJournal"]))
        $codeJournal = $_GET["codeJournal"];
    if(isset($_GET["codeMois"]))
        $codeMois = $_GET["codeMois"];
    if(isset($_GET["action"])) $action = $_GET["action"];
    if(isset($_GET["module"])) $module = $_GET["module"];

    if(isset($_GET["type"])) $val=$_GET["type"];
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_ARTICLE==1 || $rows[0]->PROT_ARTICLE==3) $protected = $rows[0]->PROT_ARTICLE;
    }
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_listeJournaux.js?d=<?php echo time(); ?>"></script>
</head>

<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete">
<legend class="entete">Journaux</legend>
<div class="form-group">
<form action="indexMVC.php?module=9&action=13" method="GET">
    <table style="margin-bottom: 20px;width:400px">
    <thead>
        <tr style="width: 400px">
            <td>
                <select class="form-control"  id='annee_exercice' name='annee_exercice' style="width: 200px">
             <?php
                    $result=$objet->db->requete($objet->annee_exercice());     
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    $i=0;
                    if($rows==null){
                        echo "<tr><td>Aucun élément trouvé ! </td></tr>";
                    }else{
                        foreach ($rows as $row){
                            if($i==0) {
                                $exercice = $row->ANNEE_EXERCICE;
                                if(!isset($_GET["annee_exercice"]))
                                    $annee_exercice = $exercice;
                                else
                                    $annee_exercice = $_GET["annee_exercice"];
                            }
                            echo "<option value='".$row->ANNEE_EXERCICE."' ";
                            if($annee_exercice==$row->ANNEE_EXERCICE) echo " selected";
                            echo ">".$row->ANNEE_EXERCICE."</option>";
                            $i++;
                        }
                    }
            ?>
                </select>
            </td>

            <td>
                <input type="hidden" value="<?php echo $module; ?>" name="module"/>
                <input type="hidden" value="<?php echo $action; ?>" name="action"/>
                <select name="type" id="type" class="form-control" style="width: 200px">
                    <option value="0" <?php if($val==0) echo " selected "; ?>>Tous</option>
                    <option value="1" <?php if($val==1) echo " selected "; ?>>Ouvert</option>
                    <option value="2" <?php if($val==2) echo " selected "; ?>>Non ouvert</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <b>Journal</b> <br/>
                <select class="form-control" style="width:200px;float:left" name="codeJournal" id="codeJournal">
                    <option value="0"></option>
                    <?php 
                        $result=$objet->db->requete($objet->getJournauxSaisieSelect($val,0,1));     
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        $i=0;
                        $classe="";
                        if($rows!=null){
                            foreach ($rows as $row){
                                echo "<option value='".$row->JO_Num."' ";
                                if($codeJournal == $row->JO_Num) echo "selected";
                                    echo ">".$row->JO_Num."</option>";
                            }
                        }
                    ?>
                </select>
            </td>
            <td>
                <b>Mois</b> <br/>
                <select class="form-control" style="width:200px"  name="codeMois" id="codeMois">
                    <option value="0"></option>
                    <?php 
                        $result=$objet->db->requete($objet->getJournauxSaisieSelect($val,1,0));     
                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                        $i=0;
                        $classe="";
                        if($rows!=null){
                            foreach ($rows as $row){
                                echo "<option value='".$row->NomMois."' ";
                                if($codeMois == $row->NomMois) echo "selected";
                                        echo ">".$row->NomMois."</option>";
                            }
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><input class="btn btn-primary" type="submit" value="Filtrer" name="filtre" id="filtre" /></td>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>

<table id="table" class="table">
    <thead style="background-color: #dbdbed;color:black">
        <th>Période</th>
        <th>Code</th>
        <th>Intitulé du journal</th>
    </thead>
    <tbody id="liste_journaux">
        <?php
        $result=$objet->db->requete($objet->getJournauxSaisie($val,$codeMois,$codeJournal,$annee_exercice));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            $i++;
            $val = '0'.$row->MonthNumber;
            $val = substr($val, -2);
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='article $classe' id='compte_".$row->JO_Num."'>"
                    . "<td>".$row->NomMois."</td>"
                    . "<td><a href='indexMVC.php?module=9&action=14&JO_Num=".$row->JO_Num."&exercice=$annee_exercice".$val."'>".$row->JO_Num."</a></td>"
                    . "<td>".$row->JO_Intitule."</td>";
                    echo "</tr>";
            }
        }
      ?>
</tbody>
</table>
 </div>

   
</div>
 
</div>
