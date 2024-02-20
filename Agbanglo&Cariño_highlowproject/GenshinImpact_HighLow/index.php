<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High or Low Game</title>
</head>
<body>
    <h1>High or Low Game</h1>
    <p>Guess whether the next number will be high or low.</p>
    <p>Current Score: <span id="score"><?php echo isset($_SESSION['score']) ? $_SESSION['score'] : 0; ?></span></p>
    <p>Choose the numbers between: <span id="number-range"><?php echo isset($_SESSION['number_range']) ? $_SESSION['number_range'] : ''; ?></span></p>
    <p>Rounds left: <span id="rounds"><?php echo isset($_SESSION['rounds']) ? $_SESSION['rounds'] : 10; ?></span></p>
    <form method="post">
        <button type="submit" name="guess" value="low">Low</button>
        <button type="submit" name="guess" value="high">High</button>
    </form>

    <?php
    session_start();

    if (!isset($_SESSION['score'])) {
        $_SESSION['score'] = 0;
        $_SESSION['rounds'] = 10;
    }

    function playRound($guess) {
        $randomNumber = mt_rand(1, 15);
        $nextNumber = mt_rand(1, 15);

        // Display the actual random numbers generated for this round
        echo "<p>Random numbers for this round: $randomNumber, $nextNumber</p>";

        // Adjust the number range for the player to choose from
        $minNumber = min($randomNumber, $nextNumber);
        $maxNumber = max($randomNumber, $nextNumber);

        // If $minNumber or $maxNumber is less than 1 or greater than 15, adjust them
        $minNumber = max(1, $minNumber);
        $maxNumber = min(15, $maxNumber);

        $_SESSION['number_range'] = "Choose the numbers between: $minNumber to $maxNumber";

        if ($nextNumber > $randomNumber) {
            $result = 'high';
        } elseif ($nextNumber < $randomNumber) {
            $result = 'low';
        } else {
            $result = 'equal';
        }

        if ($guess === $result) {
            $_SESSION['score']++;
            echo "<script>alert('Congratulations! You guessed right.');</script>";
        } else {
            $_SESSION['score']--;
            echo "<script>alert('Oops! You guessed wrong.');</script>";
        }

        $_SESSION['rounds']--;

        echo "<script>document.getElementById('score').textContent = {$_SESSION['score']};</script>";
        echo "<script>document.getElementById('rounds').textContent = {$_SESSION['rounds']};</script>";
        echo "<script>document.getElementById('number-range').textContent = '{$_SESSION['number_range']}';</script>";

        if ($_SESSION['rounds'] === 0) {
            echo "<script>alert('Game over! Your final score is {$_SESSION['score']}.');</script>";
            session_destroy();
        }
    }

    if (isset($_POST['guess'])) {
        playRound($_POST['guess']);
    }
    ?>
</body>
</html>
