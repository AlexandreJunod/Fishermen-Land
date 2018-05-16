<?php $title = 'Fishermen Land'; ?>

<?php ob_start(); ?>

    <!-- Show games -->
    <h3>Games</h3>
    <table border='1'>
        <tr>
            <td>idGame</td>
            <td>LakeFishesGame</td>
            <td>LakeReproductionGame</td>
            <td>PondReproductionGame</td>
            <td>EatFishesGame</td>
            <td>FirstPlayerGame</td>
            <td>TourGame</td>
            <td>SeasonTourGame</td>
            <td>MaxPlayersGame</td>
            <td>MaxReleaseGame</td>
            <td>DescriptionType</td>
            <td>OccupedPlaces</td>
            <td>CanJoin</td>
        </tr>

    <?php foreach($ShowGames as $ShowGame) //Reading each row of the table
    { 
        echo "<tr>";
        foreach($ShowGame as $cle=>$valeur) //Reading each data of each row
        { 
            if($cle == 'CanJoin') //Check if the game is joignable
            {
                if($valeur == 'Yes') //The game is joignable, there's a button to join the game
                {
                    echo "<td>Oui</td>";
                }
                elseif($valeur == 'No') //The game isn't joignable, the player can't join this game
                {
                    echo "<td>Non</td>";
                }
            }
        }
        echo "</tr>";
    } ?>
    </table>

<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>