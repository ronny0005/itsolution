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
<legend class="entete">Liste Profils</legend>

<div class="form-group">
    <div class="row text-right">
<div class="col-12">
    <a href="indexMVC.php?module=8&action=3" class="btn btn-primary text-right">Nouveau</a>
</div>
    </div>
<table id="table" class="table">
        <thead style="background-color: #dbdbed;">
            <th>Intitule</th>
            <th>Date creation</th>
            <th>Date Modification</th>
        </thead>
    <tbody id="liste_groupe">
        <?php
        
        $objet = new ObjetCollector();   
        
        $result=$objet->db->requete($objet->getAllProfils());     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
            $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='groupe' id='groupe'>
                     <td><input type='hidden' class='data-id' value='{$row->PROT_No}' ><a href='indexMVC.php?module=8&action=3&id={$row->PROT_No}&u={$row->PROT_User}&gu={$row->PROT_Pwd}'>{$row->PROT_User}</a></td>
                        <td><input type='hidden' class='data2-id' value='{$row->PROT_User}' >{$row->PROT_DateCreate}</td>
                        <td><input type='hidden' class='data3-id' value='{$row->PROT_Pwd}' >{$row->cbModification}</td></tr>";
            }
        }
//      ?>
</tbody>
</table>
 </div>   
</div>
 
</div>
