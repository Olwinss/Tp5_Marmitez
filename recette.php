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
                    $AuthorReq = $connect->prepare("SELECT utilisateurs.Username FROM utilisateurs WHERE utilisateurs.ID_User = " .$row    ["ID_User"]);
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
            $selectUstensiles = $connect->query("SELECT DISTINCT ustensiles.Uste FROM etape_ustensile LEFT JOIN ustensiles ON etape_ustensile.id_ustensile = ustensiles.ID_Uste NATURAL JOIN etape WHERE etape.ID_Recette = " . $row["ID_Recette"]);
            ?>
            <ul id="Ustensiles : ">
            <?php
            foreach ($selectUstensiles as $rowUstensiles) 
            {
                echo "<li>". $rowUstensiles["Uste"];
            }

            ?>
            </ul>
            <h2>Ingrédients : </h2>
            <?php 
            $selectIngredients = $connect->query("SELECT DISTINCT ingredients.Ingr 
            FROM etape_ingredient 
            LEFT JOIN ingredients ON etape_ingredient.id_ingredient = ingredients.ID_Ingr
            NATURAL JOIN etape 
            WHERE etape.ID_Recette =" . $row["ID_Recette"]);
            ?>
            <ul id="Ustensiles : ">
            <?php
            foreach ($selectIngredients as $rowIngredients) 
            {
                echo "<li>". $rowIngredients["Ingr"];
            }

            ?>
            </ul>
            
            <h2>Étapes : </h2>
            <?php 
            $selectEtapes = $connect->query("SELECT etape.description, etape.id_etape  FROM etape WHERE etape.ID_Recette = " .$row["ID_Recette"]);
            ?>
            <ul id="Etapes : ">
            <?php
            foreach ($selectEtapes as $rowEtape) 
            {
                echo "<li>". $rowEtape["description"];
                ?>
                <!--<h2>Ustensiles de l'étape : </h2> -->
                
                <?php 
                $var = "SELECT DISTINCT ustensiles.Uste FROM etape_ustensile LEFT JOIN ustensiles ON etape_ustensile.id_ustensile = ustensiles.ID_Uste NATURAL JOIN etape WHERE etape.ID_Recette = " . $row["ID_Recette"]. " AND etape_ustensile.id_etape =". $rowEtape["id_etape"];

                $select2 = $connect->query($var);
                
                
                echo "<ul id=\"Ustensiles etape: \">";
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