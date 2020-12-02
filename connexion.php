<?php
session_start();

include_once("librairie.php");


//if(isset($_POST['login']) && isset($_POST['password']))
//INSTANCIATION
$objet = new Config();
$tout = $objet->tout_remplis();

    if($tout==false)
    {              
      //verification disponibilité du login et du password
      // $checkinlog = $objet->check_login($_POST['login']);  
      // $checkinpass = $objet->check_password($_POST['login'], $_POST['password']);

          $checkinlog = $objet->check_login();  
          $checkinpass = $objet->check_password();
          
          if($checkinlog==true && $checkinpass==true)
          {
            $create = $objet->create_session($checkinlog);
          }
          // else $error ='mot de passe ou login incorect';
    }
    //else echo "<p class='erreur_ins'> Veuillez renseignez tous les champs</p>";
?>

<!-- Header ------------------- -->
<?php
include('header.php');
?>

<!-- Formulaire ---------------- -->
<form  class="text-center border border-light p-5"  action="connexion.php" method="post">
    <p class="h4 mb-4">Connectez-vous</p>

    <input type="text" id="defaultLoginFormText" class="form-control mb-4" placeholder="Pseudo" name="login">
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Mot de passe" name="password">
    <?php
      if($tout==true)
      {
        echo $tout;
      }
    ?>
    <button class="btn btn-info btn-block my-4" type="submit" name="submit">C'est parti !</button>
</form>

<!-- Footer ------------------- -->
<?php
include('footer.php');
?>