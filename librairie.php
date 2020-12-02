<?php

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
        //ici partie connexion à la base de donnée -------------
        $DB_DSN = 'mysql:host=localhost;dbname=livreor';
        $DB_USER = 'root';
        $DB_PASS = '';
            try
            {
            $connexion = new PDO($DB_DSN, $DB_USER, $DB_PASS);
            $connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
            }
            catch(PDOexception $e)
            {
            echo "connexion failed" .$e->getMessage();
            }

          $this->pdo = $connexion;
        // ------------------------------------------------------

          // $this->login = $login;
          // $this->password = $password; 
      }

      public function check_fields() //sert a verifier le formulaire et retourne false si tout est rempli
      {
          if(isset($_POST['submit']))
          {
            // $login = $_POST['login'];
            // $password = $_POST['password'];

            $this->login = $_POST['login'];
            $this->password = $_POST['password'];

                if(empty($_POST['login']) && empty($_POST['password']))
                {
                    $error = 'Veuillez renseigner tous les champs' ;
                    return $error;
                }
                if(empty($_POST['login']))
                {
                   $error='Veuillez renseigner le login';
                    return $error;
                }
                if(empty($_POST['password']))
                {
                    $error='Veuillez renseigner le password';
                    return $error;
                }
               else return false;
          }
          
      }   
  
      public function check_login() //ici le check verifie si le login existe deja et retourne false si c'est le cas
      {
          $query = $this->pdo->prepare("SELECT*FROM utilisateurs WHERE login = ? ");
          $query->bindValue(1, $this->login);
          $query->execute();

          $row = $query->rowCount();
            if($row==1)
            {
              return false; 
            }
            elseif($row==0)
            { 
                 $error="login incorrect et/ou";
                return $error; 
            }
      } 

      public function check_password()//ici on verifie le password et retourne false si il existe en bdd
      {
          //password_verify ici
          $query = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login = ? ");
          $query->bindValue(1, $this->login);
          $query->execute();

          $ligne = $query->fetch(PDO::FETCH_ASSOC);
            if($ligne==true && $ligne['password']==$this->password)
            {
                return false;
            }
            else
            $error= ' mot de passe incorrect';
            return $error;
      }
      
      public function insert($login, $password) //ici on va faire une fonction d'insertion dans la bdd
      {
          //password hach ici
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


