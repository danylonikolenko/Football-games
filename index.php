<?php
$mysqli = new mysqli("localhost", "root", "123", "footballtest");
/*Danylo Nikolenko*/

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$sqlGames = "SELECT t1.name name1, t2.name name2, g.g1, g.g2, g.done, g.k1, g.k2
             FROM games g
             INNER JOIN teams t1 ON g.k1 = t1.id 
             INNER JOIN teams t2 ON g.k2 = t2.id";

$sqlTeams = "SELECT * FROM `teams` ";

$resultG = $mysqli->query($sqlGames);
$resultT = $mysqli->query($sqlTeams);

$resultArray = array();

while ($team = $resultT->fetch_assoc()) {

    $games = 0;
    $winGames = 0;
    $looseGames = 0;
    $drawGames = 0;
    $concededGoal = 0;
    $goalScore = 0;
    $points = 0;

    foreach ($resultG as $game) {
        if ($game['done'] == 1) {
            if ($game['k1'] == $team['id']) {

                $games++;
                if ($game['g1'] > $game['g2']) {
                    $winGames++;
                    $points += 3;
                    $goalScore += $game['g1'];

                } elseif ($game['g2'] == $game['g1']) {
                    $drawGames++;
                    $points -= 1;

                } else {
                    $looseGames++;
                    $concededGoal += $game['g2'];
                }
            }
            if ($game['k2'] == $team['id']) {

                $games++;
                if ($game['g2'] > $game['g1']) {
                    $winGames++;
                    $goalScore += $game['g1'];

                } elseif ($game['g2'] == $game['g1']) {
                    $drawGames++;
                    $points -= 1;

                } else {
                    $looseGames++;
                    $concededGoal += $game['g2'];
                }
            }
        }
    }

    $tmpArray = [
        'team' => $team['name'],
        'games' => $games,
        'winGames' => $winGames,
        'looseGames' => $looseGames,
        'drawGames' => $drawGames,
        'scored_conceded' => $goalScore . "/" . $concededGoal,
        'points' => $points
    ];
    array_push($resultArray, $tmpArray);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Football</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
            integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf"
            crossorigin="anonymous"></script>
</head>


<body>
<p style="text-align: center; width: 100%; font-size: 18px; margin: 10px">
    Турнирная таблица
</p>
<table class="table table-dark" style="width: 70%; margin: auto;">
    <thead>
    <tr>
        <th>Команда</th>
        <th title="число сыграных командой игр">И</th>
        <th title="сколько игр выиграно">В</th>
        <th title="сколько игр проиграно">П</th>
        <th title="сколько игр сыграно в ничью">Н</th>
        <th title="соотв. число забитых/пропущенных мячей">МЗ, МП</th>
        <th title="очки (за победу - 3 очка, за ничью -1 очко, за поражение — ноль)">О</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($resultArray as $value) {
        ?>
        <tr>
            <td><?= $value['team'] ?></td>
            <td><?= $value['games'] ?></td>
            <td><?= $value['winGames'] ?></td>
            <td><?= $value['looseGames'] ?></td>
            <td><?= $value['drawGames'] ?></td>
            <td><?= $value['scored_conceded'] ?></td>
            <td><?= $value['points'] ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>


<p style="text-align: center; width: 100%; font-size: 18px; margin: 10px">
    Матчи
</p>
<table class="table table-dark" style="width: 70%; margin: auto;">
    <thead>
    <tr>
        <th>Команда 1</th>
        <th>Команда 2</th>
        <th>Счёт</th>

    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($resultG as $game) {
        ?>
        <tr>
            <td><?= $game['name1'] ?></td>
            <td><?= $game['name2'] ?></td>
            <td><?= $game['g1'] . ":" . $game['g2'] ?></td>

        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

</body>
</html>
