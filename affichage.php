<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste recette</title>
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
     echo "ECHEC de la connexion :( " . $e->getMessage();
 }
 $select = $connect->query("SELECT * FROM recettes INNER JOIN utilisateurs ON recettes.ID_User = utilisateurs.ID_User ORDER BY utilisateurs.Statut DESC, recettes.Date_post DESC ");
?>
<h3> Les recettes des Chefs sont affichées en premier, puis viennent les recettes des VIP, et enfin les recettes des utilisateurs standards.</h3>
<ul id="Recettes">
    <?php
    foreach ($select as $row) 
    {
        try 
        {
            $resultatuser = $connect->prepare("SELECT utilisateurs.Statut FROM utilisateurs WHERE utilisateurs. ID_User = ".$row["ID_User"]);
            $resultatuser->execute();
            $StatusCreator = $resultatuser->fetch(PDO::FETCH_NUM);
        }
        catch(PDOException $e) 
        {
            echo "Impossible de récupérer le statut du créateur de la recette :( " . $e->getMessage();
        }        
        if ($StatusCreator[0]==3)
        {
            if ($_SESSION["Statut"]>1) // Si c'est un user (id statut = 1)
            {
                ?>
                    <li class="Affichage_recette">
    	                <div class="Model_recette">
    			                    <div class="titre">
    				                    <h3><a href="recette.php?id=<?php echo $row ['ID_Recette'] ?>"><?php    echo $row ['titre'] ?></a></h3>
                                    </div>
                                    <div class="Divers">
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

                                    </div>
    	                </div>
                    </li>
                    <?php
            }
        }
        else if ($StatusCreator[0]!=3)
        {
    ?>
            <li class="Affichage_recette">
    	        <div class="Model_recette">
    			    <div class="titre">
    				    <h3><a href="recette.php?id=<?php echo $row ['ID_Recette'] ?>"><?php echo $row  ['titre'] ?></a></h3>
                    </div>
                    <div class="Divers">
    				    <p><em>Temps de réalisation : <?php echo $row['Time_realisation'] ?> minutes</em></p>
                        <p><em>Difficulté : <?php echo $row ['Difficulte'] ?> / 5</em><p>
                        <p><em>Coût : <?php echo $row ['cout'] ?> / 5</em></p>
                        <p><em>Note : <?php 
                            if ($row ['Note'])
                                echo $row ['Note'] ."/ 5 </em>";
                            else
                                echo "Pas encore de note </em>";
                        ?>
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
                    </div>
    	        </div>
            </li>  
    <?php
        }
}
?>
</ul>

</body>
</html>