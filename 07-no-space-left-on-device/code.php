<?php

$path = [];
$sizes = [];

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    if ($line === "$ ls") {
        continue;
    }

    if (preg_match("/\\\$ cd (\w+|\.\.|\/)/", $line, $matches)) {
        if ($matches[1] === "..") {
            array_pop($path);
        } else {
            $path[] = $matches[1];
        }
    } elseif (preg_match("/(\d+) (.+)/", $line, $matches)) {
        for ($i = count($path); $i > 0; $i--) {
            $dir = implode("/", array_slice($path, 0, $i));
            $sizes[$dir] ??= 0;
            $sizes[$dir] += (int) $matches[1];
        }
    }
}

/* PART I */

$result1 = array_sum(array_values(array_filter($sizes, fn(int $size) => $size <= 100_000)));

/* PART II */

$totalSpace = 70_000_000;
$requiredSpace = 30_000_000;

$usedSpace = $sizes["/"];
$unusedSpace = $totalSpace - $usedSpace;

$requiredUnusedSpace = $requiredSpace - $unusedSpace;

$result2 = min(array_filter($sizes, fn(int $size) => $size >= $requiredUnusedSpace));

echo json_encode([$sizes])."\n";
echo sprintf("Part I: %d\n", $result1);
echo sprintf("Part II: %d\n", $result2);
