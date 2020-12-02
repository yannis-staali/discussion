<?php
session_start();

include_once("librairie.php");

$check_fields ='';
$checkinlog= '';
$checkinpass = '';

//INSTANCIATION
$objet = new Config();


    if(isset($_POST['submit']))
    {       
          $check_fields = $objet->check_fields();
          $checkinlog = $objet->check_login();  
          //var_dump($checkinlog);
          $checkinpass = $objet->check_password();
          
          if($checkinlog==false && $checkinpass==false)
          {
            $create = $objet->create_session();
          }
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
    <button class="btn btn-info btn-block my-4" type="submit" name="submit">C'est parti !</button>

    <?php
       if($check_fields==true)
       {
         echo $check_fields;
         exit();
       }
       if($checkinlog==true)
       {
         echo $checkinlog;
     
       }
       if($checkinpass==true)
       {
       echo $checkinpass;
       }
      
      
    ?>
</form>

<!-- Footer ------------------- -->
<?php
include('footer.php');
?>