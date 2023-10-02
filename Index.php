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
    $database = "marmitez";

    try 
    {
        $connect = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie YOUHOUUUUUUU !! ";
    }
    catch(PDOException $e) 
    {
        echo "ECHEC de la connexion :( " . $e->getMessage();
    }

    // vérifier la connexion connect_errno renvoie un numéro d'erreur , 0 si aucune erreur

    // On récupère tous les status disponibles dans la base (ici, Standard, VIP et Chef)
    $resultat = $connect->prepare("SELECT DISTINCT utilisateurs.Statut, utilisateurs.Statut FROM utilisateurs WHERE utilisateurs.Statut IS NOT NULL");
    $resultat->execute();
    
    if (!$resultat) 
    {
        echo "<BR>Impossible de consulter les différents types de status" . $status . " <BR>";
        exit();
    }

    // La page s'appelle elle même …
    
    echo "<BR><form   action=\"index.php\"   method=\"POST\">
    <SELECT name=\"Statut\" size=1>";     // Liste déroulante
    while ($row = $resultat->fetch(PDO::FETCH_NUM))    // on affiche le nom mais on retourne l'ID
    
    echo " <OPTION value = ".$row[0].">".$row[1]; 
    // Pour donner l'id comme valeur et écrire le nom

    echo "</SELECT>    <p><input type=\"submit\" value=\"Valider le choix\"></p></form>";

    if(empty($_POST))         
    // Tant que l'on a pas valider
    {
        // rien
    }
else             // DANS QUEL CAS ?
    // Lorsque l'on valide
{
    if ($_POST['Statut']>=0 /*&& empty($_CHOICE)*/) {
        $resultat2 = $connect->prepare("SELECT DISTINCT utilisateurs.ID_User, utilisateurs.Username FROM utilisateurs WHERE utilisateurs.Statut = ".$_POST['Statut']);
        $resultat2->execute();
        
        if (!$resultat2) 
        {
            echo "<BR>Impossible de consulter les différents types de status" . $status . " <BR>";
            exit();
        }
    
        // La page s'appelle elle même …
        
        echo "<BR><form   action=\"index.php\"   method=\"CHOICE\">
        <SELECT name=\"IdUser\" size=1>";     // Liste déroulante
        while ($row = $resultat2->fetch(PDO::FETCH_NUM))    // on affiche le nom mais on retourne l'ID
        
        echo " <OPTION value = ".$row[0].">".$row[1]; 
        // Pour donner l'id comme valeur et écrire le nom
    
        echo "</SELECT>    <p><input type=\"submit\" value=\"Valider le choix\"></p></form>";
    }
    else
    {
        $resultatuser = $connect->prepare("SELECT * FROM utilisateurs WHERE utilisateurs.ID_User = ".$_CHOICE['IdUser']);
    }
}


    ?>

    <div class="selectTypeOfUser">
        
        </div>
    
        <div class="selectSpecificUser">
    
        </div>
    </body>
    
    </html>