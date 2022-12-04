<?php

/* PART I */

$result1 = 0;

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    [$left, $right] = explode(",", $line);

    [$leftStart, $leftEnd] = explode("-", $left);
    [$rightStart, $rightEnd] = explode("-", $right);

    /* PART I */
    if ($leftStart >= $rightStart && $leftEnd <= $rightEnd) {
        $result1 += 1;
    } elseif ($leftStart <= $rightStart && $leftEnd >= $rightEnd) {
        $result1 += 1;
    }
}

echo sprintf("Part I: %d\n", $result1);

/* PART II */

$result2 = 0;

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    [$left, $right] = explode(",", $line);

    [$leftStart, $leftEnd] = explode("-", $left);
    [$rightStart, $rightEnd] = explode("-", $right);

    if (! ($leftEnd < $rightStart || $leftStart > $rightEnd)) {
        // $result2 += 1;
    }

    // !(a || b) <=> !a && !b
    // !(a && b) <=> !a || !b

    // !($leftEnd < $rightStart || $leftStart > $rightEnd) <=> !($leftEnd < $rightStart) && !($leftStart > $rightEnd)
    // !($leftEnd < $rightStart) && !($leftStart > $rightEnd) <=> $leftEnd >= $rightStart && $leftStart <= $rightEnd

    if ($leftEnd >= $rightStart && $leftStart <= $rightEnd) {
        $result2 += 1;
    }
}

echo sprintf("Part II: %d\n", $result2);
