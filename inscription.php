<?php
session_start();
include_once("data_base.php"); //fonction de connexion  à la BDD
include_once("Utlisateur.class.php"); // class utilisateur

$check_fields ='';  //variables intermédiaires
$checkinlog= '';
$checkinpass = '';

$objet = new Utilisateur(connect()); //INSTANCIATION

      if(isset($_POST['submit']))
      {
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        $password2 = htmlspecialchars($_POST['password2']);

        $check_fields = $objet->check_fields_inscription(); //verifie que tous les champs sont remplis

            if($check_fields==false)
            {
            $checkinlog = $objet->check_login_inscription($login);
                
                    if($checkinlog==false)
                    {    
                    $checkinpass = $objet->check_same_password($password, $password2);
                    
                        if($checkinpass==false)
                        {
                            $hached_pass = password_hash($password, PASSWORD_DEFAULT);
                            $insert = $objet->insert($login, $hached_pass);
                            header('location: connexion.php');
                            exit(); 
                        }
                    }
            }
      } 
?>

<!-- Header --------------------------->
<?php include('header.php'); ?>

<!-- Formulaire ------------------------------>
<div class="card col-md-auto">
<div class="card-body">
<form  class="text-center border border-light p-5"  action="inscription.php" method="post">
    <p class="h4 mb-4">Inscrivez-vous</p>

    <input type="text" id="defaultLoginFormText" class="form-control mb-4" placeholder="Pseudo" name="login">
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Mot de passe" name="password">
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Confirmez" name="password2">
    <button class="btn btn-info btn-block my-4" type="submit" name="submit">C'est parti !</button>
    <?php if($check_fields==true) { echo $check_fields; exit(); } //affichage des messages d'erreur
       if($checkinlog==true) { echo $checkinlog; }
       if($checkinpass==true) { echo $checkinpass; }
    ?>
</form>
<div>
</div>


<!-- Footer ------------------- -->
<?php include('footer.php'); ?>