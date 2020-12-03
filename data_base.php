<?php

      function connect() : PDO
      {
        // variables intermédiaires 
         $DB_DSN = 'mysql:host=localhost;dbname=discussion';
         $DB_USER = 'root';
         $DB_PASS = '';
     
           try
           {
             $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);
             $PDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
           }
           catch(PDOexception $e)
           {
           echo "connexion failed" .$e->getMessage();
           }

           return $PDO;      
      }


?>


