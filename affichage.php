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
$select = $connect->query("SELECT * FROM recettes ORDER BY recettes.Date_post DESC");
?>
<ul id="Recettes">
    <?php
    foreach ($select as $row) 
    {
        try 
        {
            $resultatuser = $connect->prepare("SELECT utilisateurs.Statut FROM utilisateurs WHERE utilisateurs. ID_User = ".$row["ID_User"]);
            $resultatuser->execute();
            $idCreator = $resultatuser->fetch(PDO::FETCH_NUM);
        }
        catch(PDOException $e) 
        {
            echo "Impossible de récupérer le statut du créateur de la recette :( " . $e->getMessage();
        }        

        if ($idCreator[0]==3)
        {
            if ($_SESSION["Id_User"]>1) // Si c'est un user (id statut = 1)
            {
                ?>
                    <li class="Affichage_recette">
    	                <div class="Model_recette">
    			                    <div class="Titre">
    				                    <h3><a href="recette.php?id=<?php echo $row ['ID_Recette'] ?>"><?php    echo $row ['Titre'] ?></a></h3>
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
        else if ($idCreator[0]!=3)
        {
    ?>
            <li class="Affichage_recette">
    	        <div class="Model_recette">
    			    <div class="Titre">
    				    <h3><a href="recette.php?id=<?php echo $row ['ID_Recette'] ?>"><?php echo $row  ['Titre'] ?></a></h3>
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