<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeUser.js?d=<?php echo time(); ?>"></script>
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
<legend class="entete">Liste Utilisateurs</legend>

<div class="form-group">
<form action="indexMVC.php?module=8&action=1" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
        <td style="float:right"><a href="indexMVC.php?module=8&action=4"><button type="button" id="nouveau" class="btn btn-success">Nouveau</button></a></td>
        </tr>
        </form>
</table>
<table id="table" class="table">
        <thead style="background-color: #dbdbed;">
            <th>Nom</th>
            <th>Description</th>
            <th>Mail</th>
            <th>Date creation</th>
            <th>Date Modification</th>
            <th>Dernière Connexion</th>
            <th>Profil</th>
            <th>Groupe</th>
        </thead>
    <tbody id="liste_user">
        <?php
        $objet = new ObjetCollector();
        $result=$objet->db->requete($objet->getAllUsers());     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $row = (array)$row;
            $i++;
            if($i%2==0) $classe = "info";
            else $classe="";
            //Intitule des groupes			
            $idgroupe=$row['PROT_Right'];
            if($idgroupe == 1){
               $intitulegroupe='Administrateur';
            }else if($idgroupe==2){
               $intitulegroupe='Utilisateur';
            }else $intitulegroupe='Pas de groupe associé';
			
             //intitule des profil
            $intituleprofil='Pas de profil associé';
            $resultprofil=$objet->db->requete($objet->UsersByid($row['PROT_UserProfil']));
            if ($row['PROT_UserProfil']==0 || $row['PROT_UserProfil']==NULL){
                $intituleprofil='Pas de profil associé';     
            }else{
                    $rowsprofil = $resultprofil->fetchAll(PDO::FETCH_OBJ);
                   //var_dump($rowsprofil);die();
                   if($rowsprofil==null){
                       echo "Aucun élément trouvé !";
                   }else{
                       foreach ($rowsprofil as $rowprofil){
                           $rowprofil = (array)$rowprofil;
                           $intituleprofil=$rowprofil['PROT_User'];
                       }
                   }  
            }

            if ($row['PROT_LastLoginDate']=='1900-01-01 00:00:00') $row['PROT_LastLoginDate']='Pas encore connecté';
            $iduser=$row['PROT_No'];
            echo "<tr class='user' id='user'>"
                    . "<td><input type='hidden' class='data-id' value='".$row['PROT_No']."' ><a href='indexMVC.php?module=8&action=4&id=".$row['PROT_No']."'>".$row['PROT_User']."</a></td>"
                    //. "<td><input type='hidden' class='data-id' value='".$row['PROT_No']."' >".$row['PROT_User']."</td>"
                    . "<td>".$row['PROT_Description']."</td>"
                    . "<td>".$row['PROT_EMail']."</td>" 
                    . "<td>".$row['PROT_DateCreate']."</td>"
                    . "<td>".$row['cbModification']."</td>"
                    . "<td>".$row['PROT_LastLoginDate']."</td>"
                    . "<td>".$intituleprofil."</td>"
                    . "<td>".$intitulegroupe."</td></tr>";
            }
        }        die();

        //      ?>
</tbody>
</table>
 </div>   
</div>
 
</div>
