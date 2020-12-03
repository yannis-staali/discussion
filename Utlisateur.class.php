<?php

class Utilisateur
{
  
  private $pdo;
  
  private $login;

  private $password;
      /**
       * .....
       */  
      function __construct($db) //ici la construct ne sert qu'a connecter à la bdd
      {
            $this->pdo = $db;
      }

      //Partie connexion -------------------------------------------
      public function check_fields() //sert a verifier le formulaire et retourne false si tout est rempli
      {
          if(isset($_POST['submit']))
          {
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
      
      public function check_login($login) //ici le check verifie si le login existe deja et retourne false si c'est le cas
      {
          $query = $this->pdo->prepare("SELECT*FROM utilisateurs WHERE login = ? ");
          $query->bindValue(1, $login);
          $query->execute();

          $row = $query->rowCount();
            if($row==1)
            {
              return false; 
            }
            elseif($row==0)
            { 
                 $error="login incorrect";
                 return $error; 
            }
        } 

        public function check_password($login, $password)//ici on verifie le password et retourne false si il existe en bdd
        {   
            $query = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login = ? ");
            $query->bindValue(1, $login);
            $query->execute();
  
            $ligne = $query->fetch(PDO::FETCH_ASSOC);
            $verify_pass = password_verify($password, $ligne['password']);

              if($verify_pass==true)
              {
                  return false;
              }
              else
              $error= ' mot de passe incorrect';
              return $error;
        }

        public function create_session($login) //sert à creer une session identifiée grace à l'id
        {
            $query = $this->pdo->prepare("SELECT*FROM utilisateurs WHERE login = ? ");
            $query->bindValue(1, $login);
            $query->execute();

            $ligne = $query->fetch(PDO::FETCH_ASSOC);
            $_SESSION['connexion'] = $ligne['id'];
            header('location: profil.php');
            exit();
        }

        //Fin partie connexion
        //--------------------------------------------------------------------------------
        //Debut partie inscription
        public function check_fields_inscription() //sert a verifier le formulaire et retourne false si tout est rempli
       {
           if(isset($_POST['submit']))
           {
 
                 if(empty($_POST['login']) && empty($_POST['password']) && empty($_POST['password2']))
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
                 if(empty($_POST['password2']))
                 {
                     $error='Veuillez renseigner le deuxieme password';
                     return $error;
                 }
                else return false;
             }
           
       }
      
        public function check_login_inscription($login) //ici le check verifie si le login existe deja et retourne false si c'est le cas
        {
            $query = $this->pdo->prepare("SELECT*FROM utilisateurs WHERE login = ? ");
            $query->bindValue(1, $login);
            $query->execute();
  
            $row = $query->rowCount();
              if($row==1)
              {
                    $error="login deja pris";
                    return $error;  
              }
              elseif($row==0)
              { 
                   return false;
              }
          } 

       public function check_same_password($password, $password2)
       {
         if($password == $password2)
         {
             return false;            
         }
         else 
         $error = 'les mots de passe ne correspondent pas';
         return $error;  
       }
     
      public function insert($login, $password) //ici on va faire une fonction d'insertion dans la bdd
      {
          $query = $this->pdo->prepare("INSERT INTO utilisateurs (login, password) VALUES (?, ?)");
          $query->bindValue(1, $login);
          $query->bindValue(2, $password);
          $query->execute();

      }

      //Fin partie inscription
        //--------------------------------------------------------------------------------
        //Debut partie profil

        public function check_fields_profil() //sert a verifier le formulaire et retourne false si tout est rempli
        {
            if(isset($_POST['submit']))
            {
  
                  if(empty($_POST['login']) && empty($_POST['password']) && empty($_POST['password2']))
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
                  if(empty($_POST['password2']))
                  {
                      $error='Veuillez renseigner le deuxieme password';
                      return $error;
                  }
                 else return false;
              }
            
        }

        public function check_login_profil($login) //ici le check verifie si le login existe deja et retourne false si ce n'est pas le cas
        {
            $query = $this->pdo->prepare("SELECT*FROM utilisateurs WHERE login = ? ");
            $query->bindValue(1, $login);
            $query->execute();
  
            $row = $query->rowCount();
              if($row==1)
              {
                    $error="login deja pris";
                    return $error;  
              }
              elseif($row==0)
              { 
                   return false;
              }
          }
          
        public function update($login, $password, $idverify) //ici on va faire une fonction d'insertion dans la bdd
        {
          $request2 = $this->pdo->prepare("UPDATE utilisateurs SET login = ?, password = ?  WHERE id = ? ");
          $request2->bindValue(1, $login);
          $request2->bindValue(2, $password);
          $request2->bindValue(3, $idverify);
          $request2->execute();
         
          return 'Changements effectués';
        }
}
?>


