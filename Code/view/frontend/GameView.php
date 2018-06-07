<?php $title = 'Fishermen Land'; ?>


<?php ob_start();?>

<script> document.body.style.backgroundImage = "url('./public/images/Sand.png')"; </script>
<div class="ContainerGame" onmouseover="closeDiv()">
    <div class="ContainerLake">
        <?php foreach($ShowGameInfos as $ShowGameInfo) //Reading each row of the table
        {
            echo "<div class='FishesOnLake'>".$ShowGameInfo['LakeFishesGame']."</div>";
            echo "<div class='Lake'></div>";
            $SumFishes = $ShowGameInfo['SumPondFishes'] + $ShowGameInfo['LakeFishesGame'];
        }
        ?>
    </div>

    <?php
    $TotalSeats = 14/$ShowGameInfo['OccupedPlaces']; //There is only 14 divs possible to put players. Count how many seats are free between 2 players
    floor($TotalSeats);
    $Top = 675; //Define the top position of the first player. -225 to go to the top
    $Left = 496; //Define the left poistion of the first player. -248 to go to the left

    foreach($ShowPlayers as $ShowPlayer) //Reading each row of the table
    {
        if($ShowPlayer['DescriptionStatus'] == "Joue" || $ShowPlayer['DescriptionStatus'] == "Relâche des poissons") //Show this is the player who is playing
        {
            echo "<div id=".$ShowPlayer['idPlace']." style='border:solid red' class='ContainerPond'>";
        }

        if($ShowPlayer['DescriptionStatus'] == "En attente" || $ShowPlayer['DescriptionStatus'] == "Eliminé")
        {
            echo "<div id=".$ShowPlayer['idPlace']." class='ContainerPond'>";
        }

        if($ShowPlayer['DescriptionStatus'] == "Eliminé")
        {
            echo "<div class='FishesOnPond'>Eliminé</div>";
        }
        else
        {
            echo "<div class='FishesOnPond'>".$ShowPlayer['PondFishesPlace']."</div>";
        }

            echo "<div class='Pond'></div>";
            echo "<div class='NameOnPond'>".$ShowPlayer['PseudoPlayer']."</div>";
        echo "</div>";

        ?><script>
            var IdDiv = "<?php echo $ShowPlayer['idPlace']; ?>";
            var Left = "<?php echo $Left; ?>";
            var Top = "<?php echo $Top; ?>";
            document.getElementById(IdDiv).style.left = Left;
            document.getElementById(IdDiv).style.top = Top;
        </script>
        <?php
        for($i = 0; $i < $TotalSeats; $i++) //Used for place the divs on the right place
        {
            if($Left != 0 && $Top == 675) //Move on the bottom line, move left
            {
                $Left = $Left - 248;
            }
            else //Move up
            {
                if($Top != 0 && $Left == 0) //Move on the left line, move up
                {
                    $Top = $Top - 225;
                }
                else //Move right
                {
                    if($Left != 1240 && $Top == 0) //Move on the top line, move right
                    {
                        $Left = $Left + 248;
                    }
                    else //Move down
                    {
                        if($Top != 675 && $Left == 1240) //Move on the right line, move down
                        {
                            $Top = $Top + 225;
                        }
                        else //Move left
                        {
                            $Left = $Left - 248;
                        }
                    }
                }
            }
        }
    } ?>
</div>
<div class="ContainerRightButton">
    <form method='post'> <!-- Leave the game -->
        <?= "<button type='submit' name='LeaveGame' value=".$idPlace.">Quitter la partie</button>"; ?>
    </form>
</div>

<div class="DivToHover" onmouseover="showDiv()"></div>
<script>
function showDiv() { //Show the div when the "DivToHover" is hover
    document.getElementById('TheHiddenDiv').style.display = "block";
}
function closeDiv() { //Hide the div when the "DivToHover" is hover
   document.getElementById('TheHiddenDiv').style.display = "none";
}
</script>
<div id='TheHiddenDiv' class="HiddenDiv">
    <h4>Statistiques</h4>
    <?php echo "Saison de pêche : ".$ShowGameInfo['TourGame']."/".$ShowGameInfo['SeasonTourGame']." tours <br>";
    echo "Nombre total de poissons : $SumFishes<br>";
    echo "Nourriture nécessaire pour survire : ".$ShowGameInfo['EatFishesGame']."<br>";
    echo "Reproduction dans le lac : ".$ShowGameInfo['LakeReproductionGame']."<br>";
    echo "Reproduction dans l'étang : ".$ShowGameInfo['PondReproductionGame']."<br>";
    echo "Relâche max (imposition avec forfait) : ".$ShowGameInfo['MaxReleaseGame']."<br><br>";

        foreach($ShowPlayers as $ShowPlayer) //Reading each row of the table
        {
            if($ShowPlayer['DescriptionStatus'] == "Joue" || $ShowPlayer['DescriptionStatus'] == "Relâche des poissons") //Show this is the player who is playing
            {
                echo "<div style='border:solid red' class='ItemHiddenDiv'>";
            }
            else
            {
                echo "<div class='ItemHiddenDiv'>";
            }
                echo $ShowPlayer['PseudoPlayer']."<br><br>";
                echo "Classement : ".$ShowPlayer['RankingPlayer']."<br>";
                echo "Poisson(s) pêché(s) : ".$ShowPlayer['FishedFishesPlace']."<br>";
                echo "Poisson(s) relâché(s) : ".$ShowPlayer['ReleasedFishesPlace']."<br>";
                echo "Poisson(s) dans l'étang : ".$ShowPlayer['PondFishesPlace']."<br>";
            echo "</div>";
        }?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
