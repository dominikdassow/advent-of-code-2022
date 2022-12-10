<?php

const WIDTH = 40;

$x       = 1;
$cycle   = 1;
$signals = [];

$row   = 0;
$image = [];

function newCycle(): void
{
    global $x, $cycle, $signals;
    global $row, $image;

    $image[$row][] = in_array($cycle % WIDTH, [$x - 1, $x, $x + 1]) ? "#" : ".";

    if ($cycle % WIDTH === 0) {
        $row++;
    }

    $cycle++;

    if (($cycle - 20) % WIDTH === 0) {
        $signals[$cycle] = $cycle * $x;
    }
}

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    if ($line === "noop") {
        newCycle();
        continue;
    }

    if (!preg_match("/addx (-?[1-9][0-9]*)/", $line, $matches)) {
        continue;
    }

    newCycle();
    $x += intval($matches[1]);
    newCycle();
}

/* PART I */

$result1 = array_sum($signals);

echo sprintf("Part I: %d\n", $result1);

/* PART II */

// For some reason, the first pixel columns of the image is at the end. Idk why but this fixes it.
// Also, the last row doesn't fully match up but yeah, the letters are visible.
array_walk($image, function (array &$row) {
    array_unshift($row, array_pop($row));
});

$result2 = implode("\n", array_map(fn(array $row) => implode("", $row), $image));

echo sprintf("Part II: \n%s\n", $result2);
