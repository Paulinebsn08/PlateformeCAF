<!--modale connexion administrateur-->
 <div id="modal-container-admin">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal" onclick="FermeConnexionAdmin()"><img id="croixblanche" src="../Graphismes/Popup/croixblanche.png">
                </button>
                <h4 class="modal-title">CONNEXION ACC&Egrave;S ADMINISTRATEUR</h4>
            </div>
            <div class="modal-body">
                <p class="connexion-infos">Adresse E-mail :</p><br>
                <input id="mail" type="text" name="email" placeholder="jean-paul.dubois@cafcharleville.cnafmail.fr"><br>
                <p class="connexion-infos">Mot de passe :</p><br>
                <input class="mdp2" id="mdp-administrateur" type="password" class="masked" name="password" placeholder="***********">
                <button type="button" id="oeil" onclick="AffichMdpAdministrateur()">
                    <img id="imgoeil3" src="../Graphismes/Profil/oeil.png" alt="oeil">
                </button>
            </div>
            <div class="modal-footer">
                <input type="submit" class="seconnecter-bouton" name="envoyer-administrateur" value="SE CONNECTER">
            </div>
        </div>
    </div>

    <!--modale connexion formateur-->
    <div id="modal-container-formateur">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal" onclick="FermeConnexionFormateur()"><img id="croixblanche" src="../Graphismes/Popup/croixblanche.png">
                </button>
                <h4 class="modal-title">CONNEXION ACC&Egrave;S FORMATEUR</h4>
            </div>
            <div class="modal-body">
                <p class="connexion-infos">Adresse E-mail :</p><br>
                <input id="mail" type="text" name="email" placeholder="jean-paul.dubois@cafcharleville.cnafmail.fr"><br>
                <p class="connexion-infos">Mot de passe :</p><br>
                <input class="mdp2" id="mdp-formateur" type="password" class="masked" name="password" placeholder="***********">
                <button type="button" id="oeil" onclick="AffichMdpFormateur()">
                    <img id="imgoeil2" src="../Graphismes/Profil/oeil.png" alt="oeil" />
                </button>
            </div>
            <div class="modal-footer">
                <input type="submit" value="SE CONNECTER" class="seconnecter-bouton" name="envoyer-formateur">
            </div>
        </div>
    </div>


    <!--modale connexion apprenant-->
    <div id="modal-container-apprenant">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal" onclick="FermeConnexionApprenant()"><img id="croixblanche" src="../Graphismes/Popup/croixblanche.png">
                </button>
                <h4 class="modal-title">CONNEXION ACC&Egrave;S APPRENANT</h4>
            </div>
            <div class="modal-body">
                <p class="connexion-infos">Adresse E-mail :</p><br>
                <input id="mail" type="text" name="email" placeholder="jean-paul.dubois@cafcharleville.cnafmail.fr"><br>
                <p class="connexion-infos" >Mot de passe :</p><br>
                <input class="mdp2" id="mdp-apprenant" type="password" class="masked" name="password" placeholder="***********">
                <button type="button" id="oeil" onclick="AffichMdpApprenant()">
                    <img id="imgoeil1" src="../Graphismes/Profil/oeilcache.png" alt="oeil" />
                </button>
            </div>
            <div class="modal-footer">
                <input type="submit" class="seconnecter-bouton" name="envoyer-apprenant" value="SE CONNECTER">
            </div>
        </div>
    </div>


    <!--En php, je voudrais gérer l'accès au profil. Donc que la personne qui sur la base de données a "Adminitrateur" avec un booléen à 1 soit connecté, que sinon ça le redirige vers une modale "erreur de connexion" -->
    <?php
    if(isset($_REQUEST['envoyer-administrateur']))
            {
                include ("../config/bdd.php");
                include ("../config/fonctions.php");
                
                // Selectionne la ligne de l'utilisateur qui tente l'accès et récupérer la colonne Admin
                $req="SELECT administrateur from utilisateurs WHERE email='$email'";
                $res=mysqli_query($lien,$req);
                $row = $res->fetch(MYSQLI_ASSOC);
                if($row[0] != 1){ // tu compares ta ligne de ta colonne 'admin' 
                    header("Location: modale-erreur-connexion.html"); // different de 1 donc redirection
                }
                // Sinon on execute le code normalement
                else { 
                    $lien=mysqli_connect($serveur,$loginbdd,$mdpbdd,$bdd);
                    $email=nettoyage($lien,$_REQUEST['email']);
                    $pwd=$_REQUEST['pwd'];
                    $req="SELECT * from utilisateurs WHERE email='$email'";
                    $res=mysqli_query($lien,$req);
                    if(!$res){
                        echo "Erreur SQL".mysqli_error($lien);
                    }else {
                        $existe=mysqli_num_rows($res);
                        if ($existe) {
                            $infos=mysqli_fetch_array($res);
                            if(password_verify($pwd,$infos['pwd'])){
                                session_start() ;
                                $_SESSION['idu']=$infos['idu'];
                                $_SESSION['nom']=$infos['nom'];
                                $_SESSION['prénom']=$infos['prénom'];
                                $_SESSION['email']=$infos['email'];
					        }else{     
                                echo "Infos incorrectes";
                            }
                        }
                    }     
                mysqli_close($lien);
                }   
            }
                
?>
