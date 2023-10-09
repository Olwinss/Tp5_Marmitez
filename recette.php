<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recette</title>
</head>
<body>
    



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
    echo "ECHEC de la connexion : " . $e->getMessage();
 }

 try 
 {
    $currentrecette = $connect->prepare("SELECT * FROM recettes WHERE recettes.ID_Recette = ". $_GET['id']);
    $currentrecette->execute();
    $row = $currentrecette->fetch(PDO::FETCH_ASSOC);
 }
 catch(PDOException $e) 
 {
    echo "Impossible de récupérer les informations de la recette : " . $e->getMessage();
 }        
?>
    <div class="Titre">
        <h1> <?php echo $row ['titre']; ?> </a></h1>
    </div>

    <div class = "Divers">
        <div class="Auteur">
            <p><em> Auteur : 
            <?php
                try 
                {
                    $AuthorReq = $connect->prepare("SELECT utilisateurs.Username FROM utilisateurs WHERE utilisateurs.ID_User = " .$row    ["ID_Cult"]);
                    $AuthorReq->execute();
                    echo ($AuthorReq->fetch(PDO::FETCH_NUM))[0]. "</em></p></div> <div = \"datepublication\"> <p><em> Date de publication : ";
                    echo $row["Date_post"];
                }
                catch(PDOException $e) 
                {
                    echo "Impossible de récupérer l'auteur de la recette :   " . $e->getMessage();
                }
            ?>
            </div>
            </em></p>
    	        <p><em>Temps de réalisation : <?php echo $row['Time_realisation'] ?>    minutes</em></p>
                <p><em>Difficulté : <?php echo $row ['Difficulte'] ?> / 5</em><p>
                <p><em>Coût : <?php echo $row ['cout'] ?> / 5</em></p>
                <p><em>Note : <?php 
                if ($row ['Note'])
                    echo $row ['Note'] ." /5</em>";
                else
                    echo "Pas encore de note </em>";
             ?>   
            </p>
                <p><em>Categorie : <?php echo $row ['Categorie'] ?></em></p>
                <p><em>Culture : 
                    <?php
                    try 
                    {
                        $Resultatculture = $connect->prepare(" SELECT cultures.Cult FROM cultures WHERE    cultures.ID_Cult = " .$row    ["ID_Cult"]);
                        $Resultatculture->execute();
                        echo ($Resultatculture->fetch(PDO::FETCH_NUM))[0];
                    }
                    catch(PDOException $e) 
                    {
                        echo "Impossible de récupérer la culture de la recette :(   " . $e->getMessage();
                    }
                ?> </em></p>

            <h2>Ustensiles : </h2>
            <?php 
            $select = $connect->query("SELECT ustensiles.Uste FROM etape_ustensile NATURAL JOIN ustensiles NATURAL JOIN etape WHERE etape.ID_Recette = " . $row["ID_Recette"]);
            ?>
            <ul id="Ustensiles : ">
            <?php
            foreach ($select as $row) 
            {
                echo "<li>". $row["Uste"];
            }

            ?>
            </ul>
            <h2>Ingrédients : </h2>
            <?php 
            $select = $connect->query("SELECT ingredients.Ingr FROM etape_ingredient NATURAL JOIN ingredients NATURAL JOIN etape WHERE etape.ID_Recette =" . $row["ID_Recette"]);
            ?>
            <ul id="Ustensiles : ">
            <?php
            foreach ($select as $row) 
            {
                echo "<li>". $row["Ingr"];
            }

            ?>
            </ul>
            
            <h2>Étapes : </h2>
            <?php 
            $select = $connect->query("SELECT etape.description, etape.id_etape  FROM etape WHERE etape.ID_Recette = " .$row["ID_Recette"]);
            ?>
            <ul id="Etapes : ">
            <?php
            foreach ($select as $row) 
            {
                echo "<li>". $row["description"];
                ?>
                <h2>Ingrédients de l'étape : </h2>
                <?php 
                $select2 = $connect->query("SELECT ustensiles.Uste FROM etape_ustensile NATURAL JOIN ustensiles NATURAL JOIN etape WHERE etape.ID_Recette = " . $row["ID_Recette"]. "AND etape_ustensile.id_etape =". $row["id_etape"]);
                ?>
                <ul id="Ustensiles etape: ">
                <?php
                foreach ($select2 as $row2) 
                {
                    echo "<li>". $row2["Uste"];
                }
            }

            ?>
            </ul>
        </ul>
            
           <?php

            ?>
</body>
</html>