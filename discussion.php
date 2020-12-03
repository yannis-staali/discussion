<?php
session_start();
include_once("data_base.php"); //fonction de connexion à la BDD

if(!isset($_SESSION['connexion'])) // retour à l'envoyeur si pas de variable session crée
{
    header('location: connexion.php');
    exit();
}

// connexion et requete SELECT puis recupération des messages
$PDO = connect(); 
$request = $PDO->prepare("SELECT messages.date, utilisateurs.login, messages.message FROM messages INNER JOIN utilisateurs ON messages.id_utilisateur = utilisateurs.id ORDER BY date DESC ");  
$request -> setFetchMode(PDO::FETCH_ASSOC);       
$request->execute();    

if(isset($_POST['submit']))
{
$commentaire = htmlspecialchars($_POST['com']);
$iduser = htmlspecialchars($_SESSION['connexion']);
  
        // requete d'insertion d'un nouveau message
        $request2 = $PDO->prepare("INSERT INTO messages (message, id_utilisateur)  VALUES (?, ?) ");         
        $request2->bindValue(1, $commentaire);
        $request2->bindValue(2, $iduser);
        $request2->execute(); 
        
        $delai=1; 
        $url='discussion.php';
        header("Refresh: $delai;url=$url");
    
} 
?>

<!-- Header  ---------------------------------->
<?php include('header.php'); ?>

<!-- Affichage des messages  ----------------------->
<p class='titre'>historique de conversation</p>
<?php  
        echo "<div class='contain_discussion'> ";
        while($resultat = $request->fetch())
        {
          echo "<div class='message'><p> Posté le :  $resultat[date]<br/> par : $resultat[login] <br/> $resultat[message] </div></p>" ;
           
        }
        echo "</div> ";

        if(isset($_SESSION['connexion']))
        {
          echo 
          "<form  class='text-center border border-light p-5'  action='discussion.php' method='post'>
          <p class='h4 mb-4'>Laissez un commentaire</p>
          <div class='form-group'>
          <textarea class='form-control' id='exampleTextarea' rows='3' name='com'></textarea>
          </div>
          <button class='btn btn-info btn-block my-4' type='submit' name='submit'>C'est parti !</button>
          </form> ";
        }
?>


<!-- Footer ------------------- -->
<?php include('footer.php'); ?>

<!-- Style CSS  ------------------->
<style>
.contain_discussion{
  display: flex;
  flex-direction:column;
  align-items: center;
}
.message{
  background-color: #047AFB ; 
  width: 500px;
  min-height: 50px;
  color: white;
  padding: 5px;
  border: 2px solid black;
  border-radius: 15px;
  
}
.titre{
  background-color: #047AFB;
  width:400px; 
  text-align: center;
  color: white;
}
</style>