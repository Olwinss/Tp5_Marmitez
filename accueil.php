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
        $connect = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

    {
        //Récupération du nombre de consultations
        $NbConsultationsReq = $connect->prepare("SELECT COUNT(ID_User) FROM consulter WHERE consulter.ID_User = ".$ID);
        $NbConsultationsReq->execute();
        $row = $NbConsultationsReq->fetch(PDO::FETCH_NUM);
        $NbConsultations = $row[0];

        //Récupération du nombre de recettes crées
        $NbRecettesReq = $connect->prepare("SELECT COUNT(ID_User) FROM recettes WHERE recettes.ID_User = $ID");
        $NbRecettesReq->execute();
        $row = $NbRecettesReq->fetch(PDO::FETCH_NUM);
        $NbRecettes = $row[0];   
        
        //Récupération de la date d'expiration d'abonnement
        $ExpirDateReq = $connect->prepare("SELECT Date_abo + interval 1 year FROM utilisateurs WHERE ID_User= ".$ID);
        $ExpirDateReq->execute();
        $row = $ExpirDateReq->fetch(PDO::FETCH_NUM);
        $ExpirDate = $row[0];

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
                        <?php 
                        echo "<p>Vous êtes un : ";
                        
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
                        ?> 
                        </p>
                        <br>
                        <?php echo "<p>Vous avez consulté ". $NbConsultations. " recette(s)</p>"; ?>
                        <br>
                        <?php echo "<p>Vous avez créé ". $NbRecettes ." recette(s)</p>";

                        if ($_SESSION["Statut"] == "VIP")
                        {
                            echo "<br><p>Votre abonnement expire le " .$ExpirDate;
                        }
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