<?php
session_start();

if (!isset($_SESSION['lives']) || isset($_POST['reset'])) {
    $_SESSION['lives'] = 3;
    $_SESSION['rounds'] = 10;
    generateRandomNumbers();
}

function generateRandomNumbers() {
    $randomNumber1 = mt_rand(1, 15);
    $randomNumber2 = mt_rand(1, 15);
    $_SESSION['random_number1'] = $randomNumber1;
    $_SESSION['random_number2'] = $randomNumber2;
}

function playRound($decision) {
    $randomNumber1 = $_SESSION['random_number1'];
    $randomNumber2 = $_SESSION['random_number2'];

    if ($decision === 'deal') {
        // Proceed to high or low
        $minNumber = min($randomNumber1, $randomNumber2);
        $maxNumber = max($randomNumber1, $randomNumber2);

        $minNumber = max(1, $minNumber);
        $maxNumber = min(15, $maxNumber);

        $_SESSION['number_range'] = "Random Numbers: $minNumber to $maxNumber";

        if ($randomNumber2 > $randomNumber1) {
            $result = 'high';
        } elseif ($randomNumber2 < $randomNumber1) {
            $result = 'low';
        } else {
            $result = 'equal';
        }

        if ($result === 'high' || $result === 'low') {
            // Display high or low form
            echo "<form method='post'>";
            echo "<button type='submit' name='decision' value='high'>High</button>";
            echo "<button type='submit' name='decision' value='low'>Low</button>";
            echo "</form>";
        } else {
            echo "<script>alert('Error: Unexpected result.');</script>";
        }
    } elseif ($decision === 'no deal') {
        // Lose a life for choosing no deal
        $_SESSION['lives']--;
        echo "<script>alert('You chose no deal. You lost one life.');</script>";
        // Update the displayed lives count
        echo "<script>document.getElementById('lives').textContent = {$_SESSION['lives']};</script>";
    } elseif ($decision === 'high' || $decision === 'low') {
        // Check if the guess matches the direction of the random numbers
        if (($decision === 'high' && $randomNumber2 > $randomNumber1) || ($decision === 'low' && $randomNumber2 < $randomNumber1)) {
            // Correct guess, proceed to next round
            echo "<script>alert('Congratulations! You guessed right.');</script>";
        } else {
            // Incorrect guess, lose a life
            $_SESSION['lives']--;
            echo "<script>alert('Oops! You guessed wrong. You lost one life.');</script>";
            // Update the displayed lives count
            echo "<script>document.getElementById('lives').textContent = {$_SESSION['lives']};</script>";
        }
    } else {
        echo "<script>alert('Error: Invalid decision.');</script>";
    }

    $_SESSION['rounds']--;

    echo "<script>document.getElementById('rounds').textContent = {$_SESSION['rounds']};</script>";

    if ($_SESSION['lives'] === 0 || $_SESSION['rounds'] === 0) {
        echo "<script>alert('Game over!');</script>";
        session_destroy();
    }
}

if (isset($_POST['decision'])) {
    playRound($_POST['decision']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deal or No Deal Number Game</title>
</head>
<body>
    <h1>Deal or No Deal Number Game</h1>
    <p>Choose whether to deal or no deal.</p>
    <p>Lives left: <span id="lives"><?php echo isset($_SESSION['lives']) ? $_SESSION['lives'] : 3; ?></span></p>
    <p>Rounds left: <span id="rounds"><?php echo isset($_SESSION['rounds']) ? $_SESSION['rounds'] : 10; ?></span></p>
    <?php if (isset($_SESSION['number_range'])): ?>
        <p><?php echo $_SESSION['number_range']; ?></p>
    <?php endif; ?>

    <form method="post">
        <button type="submit" name="decision" value="deal">Deal</button>
        <button type="submit" name="decision" value="no deal">No Deal</button>
        <button type="submit" name="reset">Reset Game</button>
    </form>
</body>
</html>
