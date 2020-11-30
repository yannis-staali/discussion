<?php
require_once('data_base.php');

/**
 * Class Config
 * Permet de simplifier un module connexion
 */

class Config
{
  /**
   * @var object Permet la connexion
   */
  private $pdo;
  /**
   * @var string Recupère le login
   */
  private $login;
   /**
   * @var string Recupère le password
   */
  private $password;
  
      /**
       * .....
       */
      
      function __construct() //ici la construct ne sert qu'a connecter à la bdd
      {
          $this->pdo = connect();
          // $this->login = $login;
          // $this->password = $password; 
      }

      public function tout_remplis() //sert a verifier le formulaire
      {
          if(isset($_POST['submit']))
          {
            // $login = $_POST['login'];
            // $password = $_POST['password'];

            $this->login = $_POST['login'];
            $this->password = $_POST['password'];

                if(isset($_POST['login']) && isset($_POST['password']))
                {
                    // $ident = ["login"=>$login, "password"=>$password];
                    // return $ident;
                    return true;
                }
                else return false;
          }
      }

      public function check_login() //ici la check verifie que le login n'existe pas deja
      {
          $query = $this->pdo->prepare("SELECT*FROM utilisateurs WHERE login = ? ");
          $query->bindValue(1, $this->login);
          $query->execute();

          $row = $query->rowCount();
            if($row==1)
            {
              return $query; 
            }
            elseif($row==0)
            { 
              return false; 
            }
      } 

      public function check_password()//ici on verifie le password
      {
          $query = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login = ? ");
          $query->bindValue(1, $this->login);
          $query->execute();

          $ligne = $query->fetch(PDO::FETCH_ASSOC);
            if($ligne==true && $ligne['password']==$this->password)
            {
                return true;
            }
            else return false;
      }
      
      public function insert($login, $password) //ici on va faire une fonction d'insertion dans la bdd
      {
          $query = $this->pdo->prepare("INSERT INTO utilisateurs (login, password) VALUES (?, ?)");
          $query->bindValue(1, $login);
          $query->bindValue(2, $password);
          $query->execute();

      }

      public function create_session() //sert à creer une session identifiée grace à l'id
      {
          $query = $this->pdo->prepare("SELECT*FROM utilisateurs WHERE login = ? ");
          $query->bindValue(1, $this->login);
          $query->execute();

          $ligne = $query->fetch(PDO::FETCH_ASSOC);
          $_SESSION['connexion'] = $ligne['id'];
          header('location: profil.php');
          exit();
      }

}


?>


