<!DOCTYPE html>
<html lang="fr">
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
    $Statsbase = "marmitez";

    try 
    {
        $connect = new PDO("mysql:host=$servername;dbname=$Statsbase", $username, $password);
        // set the PDO error mode to exception
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) 
    {
        echo "ECHEC de la connexion :( " . $e->getMessage();
    }

    //Récupération de l'ID_User [A FAIRE : VERIFIER QUE L'UTILISATEUR EST ADMIN]
    if (isset($_SESSION['Id_User']))
    {
        $ID = $_SESSION['Id_User'];
    }
    else
    {
        echo "ECHEC de la récupération de votre identifiant.";
    }

    //----------------------------------//

    try //Récupération des statistiques
    {
        $LastStats = $connect->prepare("SELECT * FROM StatsActivite");
        $LastStats->execute();
        $Stats = $LastStats->fetch(PDO::FETCH_ASSOC);

    }
    catch(PDOException $e) 
    {
        echo "Impossible de récupérer les statistiques : " . $e->getMessage();
    }

    echo
    "
        <style>
        table, th, td {
            border: 1px solid;
            text-align : center;
            padding : 10px;
          }

        h1{
            text-align: center;
        }
        </style>
        <h1>Tableau de statistique</h1>
        <table>
            <tr>
                <th>
                    Nombre d'utilisateurs standards et premium
                </th>
                <th>
                    Pourçentage d'utilisateurs premium
                </th>
                <th>
                    Pourçentage d'utilisateurs premium du dernier mois
                </th>
                <th>
                    Nombre de consultations
                </th>
                <th>
                    Nombre de recettes
                </th>
                <th>
                    Note moyenne des recettes    
                </th>
                <th>
                    Date des dernières statistiques
                </th>
            </tr>
    ";

    echo  
    "   <tr>
           <td>
              ". $Stats['Nb_StandardAndPremium_User']."
           </td>
           <td>
               ".  $Stats['Pourcentage_Premium_User']."
           </td>
           <td>
               ".  $Stats['Pourcentage_Premium_LastMonth']."
           </td>
           <td>
               ".  $Stats['Nb_Consultations']."
           </td>
           <td>
               ".  $Stats['Nb_Recettes']."
           </td>
           <td>
               ".  $Stats['Moy_Note_Recettes']."
           </td>
           <td>
               ".  $Stats['dateStats']."
           </td>
        </tr>
    </table>";

    try //Récupération des statistiques
    {
        $LastAbo = $connect->prepare("SELECT * FROM StatsActivite");
        $LastAbo->execute();
        $Stats = $LastAbo->fetch(PDO::FETCH_ASSOC);

    }
    catch(PDOException $e) 
    {
        echo "Impossible de récupérer les statistiques : " . $e->getMessage();
    }

    /*SELECT * 
FROM statsactivite
WHERE DATEDIFF(CURRENT_DATE, statsactivite.dateStats) > 10
LIMIT 1*/

// https://docs.google.com/document/d/1SvrB3Hb1rO-039F9EWXvROy-h-bMaajhOg3v-hrSzYs/edit

?>



</body>

</html>

