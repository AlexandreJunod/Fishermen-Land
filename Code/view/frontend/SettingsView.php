<?php $title = 'Paramétres'; ?>

<?php ob_start(); ?>

    <!-- Show games -->
    <h3>Paramétrage du jeu</h3>
    <table border='1'>
        <tr>
            <td>Description</td>
            <td>Valuer</td>
            <td>Valider</td>
        </tr>

    <?php foreach($ShowSettings as $ShowSetting) //Reading each row of the table
    {
        echo "<tr><form method='post'>";
        foreach($ShowSetting as $key=>$value) //Reading each data of each row
        {
            if($key == 'ValueInt') //Check if we are reading the key ValueInt. Put a input type text
            {
                echo "<td><input type='text' name='ValueIntForm' minlength='1' value='$value' required></td>";
            }
            elseif($key == 'idSettings') //Check if we are reading the key idSettings. Put a button with the ID of the row
            {
                echo "<td><button type='submit' name='UpdateSettings' value='$value'>Valider</button></td>"; //Show the values of the array
            }
            else //Show the other values
            {
                echo "<td>".$value."</td>"; //Show the values of the array
            }
        }
        echo "</form></tr>";
    } ?>
    </table>
    <form method='post'><button type='submit' name='GoHomeButton'>Retour à la page d'accueil</button></form> <!-- This button goes on home page without code, because the page index.php redirect home if no actions were done -->

<?php $content = ob_get_clean(); ?>

<?php require('Template.php'); ?>
