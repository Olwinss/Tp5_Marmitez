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
    if (isset($_SESSIO))
    $ID = $_SESSION['Id_User'];

    $UserStatut = $conn->prepare("SELECT utilisateurs.Statut FROM utilisateurs WHERE utilisateurs.USER_ID = $ID");
    ?>

    <div class="pageTitle">
        Page d'accueil
    </div>
    <table>
        <tr>
            <td>
                <div class="Vous">
                    <p>
                        Vous
                        <br>
                        <!--INSERER LES LIGNES ICI-->
                    </p>
                </div>
            </td>
            <td>
                <div class="News">
                    <p>
                        News
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
                        Services
                        <!--INSERER LES LIGNES ICI-->
                    </p>
                </div>
            </td>
        </tr>
    </table>


</body>

</html>