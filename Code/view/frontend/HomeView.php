<?php $title = 'Accueil'; ?>

<?php ob_start(); ?>

    <!-- Show games -->
    <h3>Fishermen Land</h3>
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
            <td>UsedPlaces</td>
            <td>Status</td>
            <td>CanJoin</td>
        </tr>
        <form method='post' id='FormJoinGame'></form>

    <?php foreach($ShowGames as $ShowGame) //Reading each row of the table
    {
        echo "<tr>";
        foreach($ShowGame as $key=>$value) //Reading each data of each row
        {
            if($key == 'CanJoin') //Check if we are reading the key CanJoin
            {
                if($value == 'Yes') //The game is joignable, there's a button to join the game
                {
                    echo "<td><button type='submit' form='FormJoinGame' name='JoinGame' value='$ShowGame[idGame]'>Rejoindre</button></td>";
                }
                elseif($value == 'No') //The game isn't joignable, the player can't join this game
                {
                    echo "<td>Injoignable</td>";
                }
            }
            else
            {
                echo "<td>".$value."</td>"; //Show the values of the array
            }
        }
        echo "</tr>";
    } ?>
    </table>

<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
