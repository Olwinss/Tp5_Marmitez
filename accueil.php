<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Marmitez!</title>
    <link rel="stylesheet" href="Styles/style.css">
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
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie YOUHOUUUUUUU !! ";
    }
    catch(PDOException $e) 
    {
        echo "ECHEC de la connexion :( " . $e->getMessage();
    }

    //Récupération de l'ID_User ?
    if (isset($_SESSION['Id_User']))
    {
        $ID = $_SESSION['Id_User'];
    }
    else
    {
        echo "ECHEC de la récupération de votre identifiant.";
    }

    $NbConsultationsReq = $conn->prepare("SELECT COUNT(ID_User) FROM consulter WHERE consulter.ID_User = $ID");
    $NbRecettesReq = $conn->prepare("SELECT COUNT(ID_User) FROM recettes WHERE recettes.ID_User = 6");
    $NbConsultations = $NbConsultationsReq->execute();
    $NbRecettes = $NbRecettesReq->execute();
    ?>

    <div class="pageTitle">
        Page d'accueil
    </div>
    <table>
        <tr>
            <td>
                <div class="Vous">
                    <p>
                        <h2>Vous</h2>
                        <br>
                        <!--INSERER LES LIGNES ICI-->
                        <?php echo "<p>Bonjour ". $_SESSION["Username"] ." !</p>"; ?>
                        <br>
                        <?php echo "<p>Vous êtes un utilisateur : ". $_SESSION["Statut"] ."</p>"; ?> 
                        <br>
                        <?php echo "<p>Vous avez consulté ". $NbConsultations. " recettes</p>"; ?>
                        <br>
                        <?php echo "<p>Vous avez créé ". $NbRecettes ." recettes</p>";

                        if ($_SESSION["Statut"] == "VIP")
                        {
                            $ExpirDateReq = $conn->prepare();
                            echo "<br><p>Votre abonnement expire le ";
                        }
                        ?>
                    </p>
                </div>
            </td>
            <td>
                <div class="News">
                    <p>
                        <h2>News</h2>
                        <br>
                        <!--INSERER LES LIGNES ICI-->                        
                    </p>
                </div>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
                <div class="Services">
                    <p>
                        <h2>Services</h2>
                        <!--INSERER LES LIGNES ICI-->
                    </p>
                </div>
            </td>
        </tr>
    </table>


</body>

</html>