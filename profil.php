<?php
session_start();
include_once("data_base.php"); // fonction de connexion à la BDD
include_once("Utlisateur.class.php"); // class utilisateur

if(!isset($_SESSION['connexion'])) // retour à l'envoyeur si pas de variable session crée
{
    header('location: connexion.php');
    exit();
}

//ici on stocke le contenu de la variable SESSION (l'id entré precedemment) dans $idverify
//pour pouvoir l'utiliser pour fixer la ligne lors de la requete UPDATE
$idverify = $_SESSION['connexion'];

$objet = new Utilisateur(connect()); //INSTANCIATION

      if(isset($_POST['submit']))
      {
      $login = htmlspecialchars($_POST['login']);
      $password = htmlspecialchars($_POST['password']);
      $password2 = htmlspecialchars($_POST['password2']);

      $check_fields = $objet->check_fields_profil(); //on verifie que tous les champs soient remplis

            if($check_fields==false)      
            {
            $checkinlog = $objet->check_login_profil($login);

                  if($checkinlog==false)
                  {
                  $checkinpass = $objet->check_same_password($password, $password2);
                        
                        if($checkinpass==false)
                        {
                              $hached_pass = password_hash($password, PASSWORD_DEFAULT);
                              $update = $objet->update($login, $hached_pass, $idverify);
                              echo $update;
                        }
                  }
            }
      }
?>

<!-- Header ------------------- -->
<?php include('header.php'); ?>

<!-- Formulaire ------------------- -->
<form  class="text-center border border-light p-5"  action="profil.php" method="post">
    <p class="h4 mb-4">Modifiez votre pseudo et mot de passe</p>

    <input type="text" id="defaultLoginFormText" class="form-control mb-4" placeholder="Pseudo" name="login">
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Mot de passe" name="password">
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Confirmez" name="password2">
   
    <button class="btn btn-info btn-block my-4" type="submit" name="submit">C'est parti !</button>
</form>


<!-- Footer ------------------- -->
<?php include('footer.php'); ?>