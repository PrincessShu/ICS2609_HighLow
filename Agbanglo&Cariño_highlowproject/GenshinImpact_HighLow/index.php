 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genshin Impact In Between</title>
</head>
<body>
<?php

function play_game() {
    // Initialize player's lives to 3
    $lives = 3;

    echo "Welcome to the Deal or No Deal Number Game!\n";

    while ($lives > 0) {
        // Generate two random numbers between 2 and 12
        $num1 = rand(2, 12);
        $num2 = rand(2, 12);

        echo "\nYour numbers are: $num1 and $num2\n";

        // Ask the player for their decision (deal or no deal)
        echo "Deal or No Deal? (deal/no deal): ";
        $decision = strtolower(trim(fgets(STDIN)));

        // If player chooses deal
        if ($decision == 'deal') {
            // If the numbers are equal, the player wins
            if ($num1 == $num2) {
                echo "Congratulations! You won!\n";
            } else {
                // Generate the third number with 50% chance of being equal to num1 or num2
                $num3 = rand(2, 12);
                echo "The third number is concealed.\n";
                echo "Your numbers are: $num1, $num2, and ?\n";

                // Ask the player to choose high or low
                echo "Choose high or low: ";
                $choice = strtolower(trim(fgets(STDIN)));

                // Generate a random number between 2 and 12
                $revealed_num = rand(2, 12);
                echo "The revealed number is: $revealed_num\n";

                // Determine if the player wins or loses based on their choice and the revealed number
                if (($choice == 'high' && $revealed_num > 6) || ($choice == 'low' && $revealed_num <= 6)) {
                    echo "Congratulations! You won!\n";
                } else {
                    echo "Sorry, you lost.\n";
                    $lives--;
                    echo "You have $lives lives left.\n";
                }
            }
        }
        // If player chooses no deal
        elseif ($decision == 'no deal') {
            // Player loses 1 life point
            $lives--;
            echo "You chose not to deal. You lost 1 life point.\n";
            echo "You have $lives lives left.\n";
        }
        // If input is invalid
        else {
            echo "Invalid input. Please enter 'deal' or 'no deal'.\n";
        }
    }

    // If player runs out of lives, end the game
    if ($lives == 0) {
        echo "Sorry, you've run out of lives. Game over.\n";
    }
}

// Call the function to start the game
play_game();

?>

</body>
</html>
