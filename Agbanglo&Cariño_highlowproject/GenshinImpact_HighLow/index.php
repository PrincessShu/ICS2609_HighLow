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
    <p>Rounds left: <span id="rounds"><?php echo isset($_SESSION['rounds']) ? $_SESSION['rounds'] : 10; ?></span></p>
    <?php if (isset($_SESSION['number_range'])): ?>
        <p><?php echo $_SESSION['number_range']; ?></p>
    <?php endif; ?>

    <?php
    session_start();

    if (!isset($_SESSION['score']) || isset($_POST['reset'])) {
        $_SESSION['score'] = 0;
        $_SESSION['rounds'] = 10;
        generateRandomNumbers();
    }

    function generateRandomNumbers() {
        $randomNumber1 = mt_rand(1, 15);
        $randomNumber2 = mt_rand(1, 15);
        echo "<p>Random numbers for this round: $randomNumber1, $randomNumber2</p>";
        $_SESSION['random_number1'] = $randomNumber1;
        $_SESSION['random_number2'] = $randomNumber2;
    }

    function playRound($guess) {
        $randomNumber1 = $_SESSION['random_number1'];
        $randomNumber2 = $_SESSION['random_number2'];

        echo "<p>Your guess: $guess</p>";

        if ($randomNumber1 === $randomNumber2) {
            echo "<script>alert('Both numbers are equal. Choose whether you think the next number will be high or low.');</script>";
            return;
        }

        $minNumber = min($randomNumber1, $randomNumber2);
        $maxNumber = max($randomNumber1, $randomNumber2);

        $minNumber = max(1, $minNumber);
        $maxNumber = min(15, $maxNumber);

        $_SESSION['number_range'] = "Choose the numbers between: $minNumber to $maxNumber";

        if ($randomNumber2 > $randomNumber1) {
            $result = 'high';
        } elseif ($randomNumber2 < $randomNumber1) {
            $result = 'low';
        } else {
            $result = 'equal';
        }

        if ($guess === $result) {
            $_SESSION['score']++;
            echo "<script>alert('Congratulations! You guessed right.');</script>";
        } else {
            $_SESSION['score']--;
            echo "<script>alert('Oops! You guessed wrong. The correct answer is $result and the number is $randomNumber2.');</script>";
        }

        $_SESSION['rounds']--;

        echo "<script>document.getElementById('score').textContent = {$_SESSION['score']};</script>";
        echo "<script>document.getElementById('rounds').textContent = {$_SESSION['rounds']};</script>";

        if ($_SESSION['rounds'] === 0) {
            echo "<script>alert('Game over! Your final score is {$_SESSION['score']}.');</script>";
            session_destroy();
        }
    }

    if (isset($_POST['guess'])) {
        playRound($_POST['guess']);
    }
    ?>
    <form method="post">
        <button type="submit" name="guess" value="low">Low</button>
        <button type="submit" name="guess" value="high">High</button>
        <button type="submit" name="reset">Reset Game</button>
    </form>
</body>
</html>
