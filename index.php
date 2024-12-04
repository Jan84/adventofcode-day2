<?php

$safe = 0;
$dampener = 0;
$file = fopen("file.txt", "r");

while (!feof($file)) {
    $line = fgets($file);

    // IMPORTANT (remove space from the end)
    $line = trim(preg_replace('/\s+/', ' ', $line));

    $numbers = explode(' ', $line);
    $increasing = allIncreasingBy1To3($numbers);
    $decreasing = allDecreasingBy1To3($numbers);

    if ($increasing || $decreasing) {
        $safe += 1;
    } else {
        // try Problem Dampener
        $retry = problemDampener($numbers);
        if ($retry) {
            $dampener += 1;
        }
    }
}

fclose($file);

echo 'Part 1:<br>';
echo $safe . ' reports are safe<br><br>';

function allIncreasingBy1To3($numbers) {
    $n = count($numbers);
    for ($i = 0; $i < $n - 1; $i++) {
        $diff = $numbers[$i + 1] - $numbers[$i];
        if (($numbers[$i] >= $numbers[$i + 1]) || $diff > 3) {
            return false;
        }
    }

    return true;
}

function allDecreasingBy1To3($numbers) {
    $n = count($numbers);
    for ($i = 0; $i < $n - 1; $i++) {
        $diff = $numbers[$i] - $numbers[$i + 1];
        if (($numbers[$i] <= $numbers[$i + 1]) || $diff > 3) {
            return false;
        }
    }

    return true;
}

function problemDampener($numbers) {
    $n = count($numbers);
    for ($i = 0; $i < $n; $i++) {
        $new = $numbers;
        array_splice($new, $i, 1);

        $dampIncreasing = allIncreasingBy1To3($new);
        $dampDecreasing = allDecreasingBy1To3($new);

        if ($dampIncreasing || $dampDecreasing) {
            return true;
        }
    }

    return false;
}


echo '<br>';
echo '=========================<br>';
echo '<br>';
echo '<br>';
echo 'Part 2:<br>';
echo 'Thanks to the Problem Dampener, '.($safe + $dampener).' reports are actually safe!<br><br>';