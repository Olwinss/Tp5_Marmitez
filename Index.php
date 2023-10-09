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
        //echo "Connexion réussie YOUHOUUUUUUU !! ";
    }
    catch(PDOException $e) 
    {
        echo "ECHEC de la connexion :( " . $e->getMessage();
    }

    // vérifier la connexion connect_errno renvoie un numéro d'erreur , 0 si aucune erreur

    // On récupère tous les status disponibles dans la base (ici, Standard, VIP et Chef)
    try 
    {
        $resultat = $connect->prepare("SELECT DISTINCT statuts.ID_Statut, statuts.Nom_Statut FROM statuts");
        $resultat->execute();   
    }
    catch(PDOException $e) 
    {
        echo "Impossible de récupérer les statuts : " . $e->getMessage();
    }
    if (!$resultat) 
    {
        echo "<BR>Pas de statuts trouvés" . $status . " <BR>";
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
    
else            
    {
        try 
        {
            $resultat2 = $connect->prepare("SELECT DISTINCT utilisateurs.ID_User, utilisateurs.Username FROM utilisateurs WHERE utilisateurs.Statut = ". $_POST['Statut']);
            $resultat2->execute();
        }
        catch(PDOException $e) 
        {
            echo "Impossible de récupérer les users : " . $e->getMessage();
        }
        if (!$resultat2) 
        {
            echo "<BR>Aucun profil correspondant" . $status . " <BR>";
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
    if (isset($_GET["IdUser"]))
    {
        {
        $resultatuser = $connect->prepare("SELECT * FROM utilisateurs WHERE utilisateurs.ID_User = ".$_GET["IdUser"]);
        $resultatuser->execute();
        $row = $resultatuser->fetch(PDO::FETCH_NUM);

        session_start();
        $_SESSION["Id_User"]=$row[0];
        $_SESSION["Username"]=$row[1];
        $_SESSION["Statut"]=$row[2];
        $_SESSION["Date_abo"]=$row[3];
        }

        echo "Vous êtes ".$_SESSION["Username"]." ayant l'id ".$_SESSION["Id_User"]. ". Vous êtes un ";
        {
            try // Récupération et affichage du statut de l'utilisateur (à la place de l'id)
            {
                $Nomstatut = $connect->prepare("SELECT DISTINCT statuts.Nom_Statut FROM statuts WHERE statuts.ID_Statut = ".$_SESSION["Statut"]);
                $Nomstatut->execute();
                echo ($Nomstatut->fetch(PDO::FETCH_NUM))[0];
            }
            catch(PDOException $e) 
            {
                echo "Impossible de récupérer le statut de votre utilisateur : " . $e->getMessage();
            }
        }
        
       echo " et votre abonnement a commencé le ". $_SESSION["Date_abo"];
        echo "<br><a href=\"accueil.php\">Accéder au site</a>";
    }
?>
</body>
</html>