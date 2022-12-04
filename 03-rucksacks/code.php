<?php

$priorities = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

/* PART I */

$result1 = 0;

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    $chars = str_split($line);

    $first = array_slice($chars, 0, count($chars) / 2);
    $second = array_slice($chars, count($chars) / 2);

    $overlap = array_unique(array_intersect($first, $second));
    $sum = array_sum(array_map(fn(string $i) => strpos($priorities, $i) + 1, $overlap));

    $result1 += $sum;
}

echo sprintf("Part I: %d\n", $result1);

/* PART II */

$result2 = 0;

$groups = [];
$group = 0;

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    $chars = str_split($line);

    $groups[$group] ??= [];
    $groups[$group][] = $chars;

    if (count($groups[$group]) === 3) {
        $group += 1;
    }
}

foreach ($groups as $group => $chars) {
    $overlap = array_unique(array_intersect(...$chars));
    $sum = array_sum(array_map(fn(string $i) => strpos($priorities, $i) + 1, $overlap));

    $result2 += $sum;
}

echo sprintf("Part II: %d\n", $result2);
