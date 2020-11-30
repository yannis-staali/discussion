<?php
session_start();

//variables intermédiaires de connexion
$DB_DSN = 'mysql:host=localhost;dbname=livreor';
$DB_USER = 'root';
$DB_PASS = '';

try
{
//configuration des erreurs et enlever l'emulation des requetes préparées
$options =
[
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_EMULATE_PREPARES => false
];

  $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);
  $request = $PDO->prepare("SELECT commentaires.date, utilisateurs.login, commentaires.commentaire FROM commentaires INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id ORDER BY date DESC ");  
  $request -> setFetchMode(PDO::FETCH_ASSOC);       
  $request->execute();                      
}
catch(PDOException $pe)
{
   echo 'ERREUR : '.$pe->getMessage();
}
?>

<?php

include('header.php');

?>

<?php  
        echo "<table class='comm'>";
        while($resultat = $request->fetch())
        {
          echo "<tr><td> Posté le :  $resultat[date] </td>  <td> par : $resultat[login] </td> <td> $resultat[commentaire] </td></tr>" ;
           
        }
        echo "</table>";

        if(isset($_SESSION['connexion']))
        {
          echo "<a class='btn btn-primary' href='commentaire.php' role='button'>Laisser un commentaire</a>";
        }
?>

<!-- Footer ------------------- -->
<?php
include('footer.php');
?>