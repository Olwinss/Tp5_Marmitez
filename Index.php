<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'identification</title>
    <link rel="stylesheet" href="Styles/style.css">
</head>

<body>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "marmitez!";

    try 
    {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $conn‐>setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie YOUHOUUUUUUU !! ";
    } 

    catch(PDOException $e) 
    {
    echo "ECHEC de la connexion :( " . $e‐>getMessage();
    }

    // vérifier la connexion connect_errno renvoie un numéro d'erreur , 0 si aucune erreur

    // On récupère tous les status disponibles dans la base (ici, Standard, VIP et Chef)
    $status = "SELECT DISTINCT utilisateurs.Statut FROM utilisateurs WHERE utilisateurs.Statut IS NOT NULL";
    $resultat = $connect->prepare($status, MYSQLI_STORE_RESULT);
    $resultat->execute();
    if (!$resultat) 
    {
        echo "<BR>Impossible de consulter les différents types de status" . $status . " <BR>";
        exit();
    }
    
    // La page s'appelle elle même …
    echo "<BR><form   action=\" ConsulterRecetteChef.php\"   method=\"POST\">
    <SELECT name=\"ChefId\" size=1>";     // Liste déroulante
    while ($row = $resultat->fetch_row())    // on affiche le nom mais on retourne l'ID
    echo " <OPTION value = ".$row[0].">".$row[1].">".$row[2];  // POURQUOI ?
    // Pour donner l'id comme valeur et écrire le nom
    
    ?>

    <div class="selectTypeOfUser">
        
        </div>
    
        <div class="selectSpecificUser">
    
        </div>
    </body>
    
    </html>