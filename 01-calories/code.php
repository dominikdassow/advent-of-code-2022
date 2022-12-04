<?php

$calories = [];
$current = 0;

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        $current++;
        continue;
    }

    $calories[$current] ??= 0;
    $calories[$current] = $calories[$current] + intval($line);
}

$result1 = max($calories);
echo sprintf("Part I: %d\n", $result1);

rsort($calories);
$top3 = [$calories[0], $calories[1], $calories[2]];

$result2 = array_sum($top3);
echo sprintf("Part II: %d\n", $result2);
