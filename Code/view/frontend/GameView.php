<?php $title = 'Fishermen Land'; ?>

<?php ob_start();
$SumFishes = 0; //Variable to count the nomber total of fishes
?>


<!-- Show players -->
<h3>Fishermen Land</h3>
<table border='1'>
    <tr>
        <td>id</td>
        <td>Etang</td>
        <td>Poissons pêchés</td>
        <td>Poissons relachés</td>
        <td>Ordre de jeu</td>
        <td>Pseudo</td>
        <td>Classement</td>
        <td>Etat</td>
    </tr>
    <?php foreach($ShowPlayers as $ShowPlayer) //Reading each row of the table
    {
        echo "<tr>";
        foreach ($ShowPlayer as $key => $value)
        {
            echo "<td>".$value."</td>";
            if($key == "PondFishesPlace") //Count the nomber total of fishes
            {
                $SumFishes += $value;
            }
        }
        echo "</tr>";
    } ?>
</table>
<br>

<!-- Show infos of the game -->
<table border='1'>
    <tr>
        <td>id</td>
        <td>Lac</td>
        <td>Reproduction dans le lac</td>
        <td>Reproduction dans le l'étang</td>
        <td>Nourriture nécessaire pour survire</td>
        <td>Premier joueur</td>
        <td>Tour</td>
        <td>Tours totaux</td>
        <td>Joueurs max</td>
        <td>Relâche max</td>
        <td>Type de partie</td>
        <td>Joueurs</td>
        <td>Qui joue</td>
        <td>Action</td>
        <td>Prochain joueur</td>
        <td>Futur premier joueur</td>
    </tr>
    <?php foreach($ShowGameInfos as $ShowGameInfo) //Reading each row of the table
    {
        echo "<tr>";
        foreach ($ShowGameInfo as $key => $value)
        {
            echo "<td>".$value."</td>";
            if($key == "LakeFishesGame") //Count the nomber total of fishes
            {
                $SumFishes += $value;
            }
        }
    } ?>
</table>
<br>

<form method='post'> <!-- Leave the game -->
    <?= "<button type='submit' name='LeaveGame' value=".$idPlace.">Quitter la partie</button>"; ?>
</form>

<!-- Show the statistics -->
<div class='DivForShow'>Voir les scores ? Mets ta souris ici</div>
<div class='HiddenDiv'>
    <h4>Statistiques</h4>
    <?php echo "Saison de pêche ".$ShowGameInfo['TourGame']."/".$ShowGameInfo['SeasonTourGame']."<br>";
    echo "Nombre total de poissons = $SumFishes<br>";
    foreach($ShowPlayers as $ShowPlayer) //Reading each row of the table
    {
        foreach ($ShowPlayer as $key => $value)
        {
            if($key == 'PseudoPlayer' || $key == 'RankingPlayer' || $key == 'PondFishesPlace' || $key == 'FishedFishesPlace' || $key == 'ReleasedFishesPlace')
            {
                switch ($key){ //Select the values needed to show statistics and give a div for each value
                    case 'PseudoPlayer':
                        echo "<div class='StatisticsPseudo'>";
                        break;
                    case 'RankingPlayer':
                        echo "Classement: <div class='StatisticsRank'>";
                        break;
                    case 'PondFishesPlace':
                        echo "Poisson(s) dans l'étang: <div class='StatisticsPond'>";
                        break;
                    case 'FishedFishesPlace':
                        echo "Poisson(s) pêché(s): <div class='StatisticsFished'>";
                        break;
                    case 'ReleasedFishesPlace':
                        echo "Poisson(s) relâché(s): <div class='StatisticsReleased'>";
                        break;
                }
                echo $value."</div><br>";
            }
        }
    }?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
