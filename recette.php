<?php
 session_start();
 $servername = "localhost";
 $username = "root";
 $password = "";
 $database = "marmitez";

 try 
 {
     $connect = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
     // set the PDO error mode to exception
     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e) 
 {
     echo "ECHEC de la connexion :( " . $e->getMessage();
 }

 try 
 {
     $currentrecette = $connect->prepare("SELECT * FROM recettes WHERE recettes.ID_Recette = ". $_GET['id']);
     $resultatuser->execute();
     $idCreator = $resultatuser->fetch(PDO::FETCH_NUM);
 }
 catch(PDOException $e) 
 {
     echo "Impossible de récupérer le statut du créateur de la recette :( " . $e->getMessage();
 }        
