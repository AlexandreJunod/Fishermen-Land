<?php $title = 'Accueil'; ?>

<?php ob_start(); ?>

<!-- Show games -->
<script> document.body.style.backgroundImage = "url('./public/images/Water.png')"; </script>
<div class="ContainerCenterHome">
    <div class="Title">Fishermen Land</div>
    <div class="HomeBorder">
        <table border='1'>
            <tr>
                <td>Type de partie</td>
                <td>Joueurs</td>
                <td>Etat</td>
                <td>Boutton</td>
            </tr>
            <tr></tr>
            <form method='post' id='FormJoinGame'></form>

        <?php foreach($ShowGames as $ShowGame) //Reading each row of the table
        {
            echo "<tr>";
            echo "<td>".$ShowGame['DescriptionType']."</td>";
            echo "<td>".$ShowGame['UsedPlaces']."</td>";
            echo "<td>".$ShowGame['Status']."</td>";
            if($ShowGame['CanJoin'] == 'Yes') //The game is joignable, there's a button to join the game
            {
                echo "<td><button type='submit' form='FormJoinGame' name='IdJoinGame' value='$ShowGame[idGame]'>Rejoindre</button></td>";
            }
            elseif($ShowGame['CanJoin'] == 'No') //The game isn't joignable, the player can't join this game
            {
                echo "<td>Injoignable</td>";
            }
            echo "</tr>";
        } ?>
        </table>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
