<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeGroup.js?d=<?php echo time(); ?>"></script>
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
<legend class="entete">Liste Droits</legend>

<div class="form-group">
<table id="table" class="table">
        <thead style="background-color: #dbdbed;">
            <th>Numéro</th>
            <th>Description</th>
        </thead>
    <tbody id="liste_droit">
        <?php
        $objet = new ObjetCollector();
        $result=$objet->db->requete($objet->getAllDroits());     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='droit' id='droit'>"
                    . "<td>".$i."</td>"
                    . "<td>".$row->Libelle_Cmd."</td></tr>";
            }
        }
//      ?>
</tbody>
</table>
 </div>   
</div>
 
</div>
