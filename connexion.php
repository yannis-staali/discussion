<?php
session_start();
include_once("data_base.php"); //fonction de connexion à la BDD
include_once("Utlisateur.class.php"); //class utilisateur

$objet = new Utilisateur(connect()); //INSTANCIATION

$check_fields ='';  //variables intermédiaires
$checkinlog= '';
$checkinpass = '';

    if(isset($_POST['submit']))
    { 
      $check_fields = $objet->check_fields(); //permet de verifier que tous les champs sont remplis
      $login = htmlspecialchars($_POST['login']); 
      $password = htmlspecialchars($_POST['password']);       
      
        if($check_fields==false)
        {
          $checkinlog = $objet->check_login($login);  
          
          $checkinpass = $objet->check_password($login, $password); // passord verify inclu
              
              if($checkinlog==false && $checkinpass==false)
              {
                $create = $objet->create_session($login);
              }
        }
    }
?>

<!-- Header ------------------- -->
<?php include('header.php'); ?>

<!-- Formulaire ---------------- -->
<form  class="text-center border border-light p-5"  action="connexion.php" method="post">
    <p class="h4 mb-4">Connectez-vous</p>
    <input type="text" id="defaultLoginFormText" class="form-control mb-4" placeholder="Pseudo" name="login">
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Mot de passe" name="password">
    <button class="btn btn-info btn-block my-4" type="submit" name="submit">C'est parti !</button>

    <?php if($check_fields==true) { echo $check_fields; exit(); } //affichage des messages d'erreur
       if($checkinlog==true) { echo $checkinlog; }
       if($checkinpass==true) { echo $checkinpass; }
    ?>
</form>

<!-- Footer ------------------- -->
<?php include('footer.php'); ?>