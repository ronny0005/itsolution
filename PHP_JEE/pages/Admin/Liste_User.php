<script src="js/script_listeUser.js?d=<?php echo time(); ?>"></script>
<section class="bgcolorApplication" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">Liste utilisateur</h3>
</section>
<section class="mt-2">
<input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
<input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>

    <div class="card p-3 mt-3">
        <div>
            <a href="nouvelUtilisateur" class="btn btn-primary">Nouveau</a>
        </div>
        <div class="table-responsive" style="margin-top: 30px;clear:both">
            <table id="table" class="table table-striped">
                    <thead>
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

                    $protectioncial = new ProtectionClass("","");
                    $objet = new ObjetCollector();
                        $rows = $protectioncial->getUserList();
                        foreach ($rows as $row){
                            echo "<tr class='user' id='user'>
                                    <td>
                                        <input type='hidden' class='data-id' value='{$row->PROT_No}'>
                                        <a href='nouvelUtilisateur-{$row->PROT_No}'>{$row->PROT_User}</a></td>
                                     <td>{$row->PROT_Description}</td>
                                     <td>{$row->PROT_Email}</td>
                                     <td>{$objet->getDateDDMMYYYY($row->PROT_DateCreate)}</td>
                                     <td>{$objet->getDateDDMMYYYY($row->cbModification)}</td>
                                     <td>{$objet->getDateDDMMYYYY($row->PROT_LastLoginDate)}</td>
                                     <td>{$row->profil}</td>
                                     <td>{$row->Groupe}</td>
                                    </tr>";
                        }
            //      ?>
                </tbody>
            </table>
        </div>
    </div>
</section>