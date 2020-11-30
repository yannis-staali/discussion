<?php
session_start();

include_once("librairie.php");


      //ici on verifie que le boutton submit est utilisé
      if(isset($_POST['submit']))
      {
      $login = $_POST['login'];
      $password = $_POST['password'];
      $password2 = $_POST['password2'];

          //ici on verifie que tous les champs sont remplis
          if($login && $password && $password2)
          {
              //ici on verifie si les mots de passe sont similaires
              if($password==$password2)
              {
        
              //on connecte la base de donnée et on lance la requete préparée pour verifier que le pseudo est disponible
              $objet2= new Config();
              $checkin = $objet2->check_login($login);
              if($checkin==false) 
              {
                  $insert = $objet2->insert($login, $password);
                  header('location: connexion.php');
                  exit();
              }
              else echo 'Pas dispo';
              
              

              // $request = $PDO->prepare("SELECT*FROM utilisateurs WHERE login = ? ");         
              // $request->bindValue(1, $login);
              // $request->execute();
                  
              // $row = $request->rowCount();
            

                    //  if($row==0)
                    //  {

                    //   echo 'Pseudo Inexistant';
                      //  $request2 = $PDO->prepare("INSERT INTO utilisateurs (login, password) VALUES (?, ?)");
                      //  $request2->bindValue(1, $login);
                      //  $request2->bindValue(2, $password);
                      //  $request2->execute();
                      
                      //  $request2->closeCursor();
                       
                      //  header('location: connexion.php');
                      //  exit();

                    //  }
                    //  else echo 'Le pseudo existe';
                    //  else $erreur= "<p class='erreur_ins'>Ce login est deja utilisé</p>";
                     
              }
              // else $erreur= "<p class='erreur_ins'>Les mots de passes ne sont pas similaires</p>";
          }
          // else $erreur= "<p class='erreur_ins'> Veuillez renseignez tous les champs</p>";
      } 



?>

<?php

include('header.php');

?>

<div class="card col-md-auto">
<div class="card-body">
<form  class="text-center border border-light p-5"  action="inscription.php" method="post">
    <p class="h4 mb-4">Inscrivez-vous</p>

    <input type="text" id="defaultLoginFormText" class="form-control mb-4" placeholder="Pseudo" name="login">
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Mot de passe" name="password">
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Confirmez" name="password2">
   
    <button class="btn btn-info btn-block my-4" type="submit" name="submit">C'est parti !</button>
    <?php if(isset($erreur)){echo $erreur ;}?>
</form>
<div>
</div>


<!-- Footer ------------------- -->
<?php
include('footer.php');
?>