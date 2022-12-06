<?php

const NUMBER_OF_STACKS = 9; // 3 for test input, 9 for input

$inputPhase = 'stacks';
$stacks = [];
$moves = [];

$pattern = sprintf("/%s/", implode(" ", array_fill(0, NUMBER_OF_STACKS, "(\[[A-Z]]|\s{3})")));

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    $line = rtrim($line, "\n");

    if (empty($line)) {
        $inputPhase = 'moves';
        continue;
    }

    if ($inputPhase === 'stacks' && preg_match($pattern, $line, $matches)) {
        array_shift($matches);
        $stacks[] = $matches;
    }

    if ($inputPhase === 'moves' && preg_match("/move (\d+) from (\d+) to (\d+)/", $line, $matches)) {
        $moves[] = array_slice($matches, -3, 3);
    }
}

// Transpose
$stacks = array_map(null, ...$stacks);

// Remove empty
array_walk($stacks, function (array &$stack) {
    $stack = array_values(array_filter(array_map(function ($item) {
        return trim($item, "[ ]");
    }, $stack)));
});

/* PART I */

$result1 = "";
$stacks1 = $stacks;
$moves1 = $moves;

foreach ($moves1 as $move) {
    $amount = (int) $move[0];
    $from = (int) $move[1];
    $to = (int) $move[2];

    for ($i = 0; $i < $amount; $i++) {
        array_unshift($stacks1[$to - 1], array_shift($stacks1[$from - 1]));
    }
}

foreach ($stacks1 as $stack) {
    $result1 .= $stack[0];
}

echo sprintf("Part I: %s\n", $result1);


/* PART II */

$result2 = "";
$stacks2 = $stacks;
$moves2 = $moves;

foreach ($moves2 as $move) {
    $amount = (int) $move[0];
    $from = (int) $move[1];
    $to = (int) $move[2];

    $crates = [];

    for ($i = 0; $i < $amount; $i++) {
        $crates[] = array_shift($stacks2[$from - 1]);
    }

    array_unshift($stacks2[$to - 1], ...$crates);
}

foreach ($stacks2 as $stack) {
    $result2 .= $stack[0];
}

echo sprintf("Part II: %s\n", $result2);
