<?php

$heights = [];
$row = 0;

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    $chars = str_split($line);

    for ($column = 0; $column < count($chars); $column++) {
        $height = (int) $chars[$column];

        $heights[$row] ??= [];
        $heights[$row][$column] = $height;
    }

    $row++;
}

$rows = count($heights);
$columns = count($heights[0]);

/* PART I */

$result1 = 0;

for ($row = 0; $row < $rows; $row++) {
    for ($column = 0; $column < $columns; $column++) {
        $height = $heights[$row][$column];

        if ($row === 0 || $row === ($rows - 1)) {
            $result1++;
            continue;
        } elseif ($column === 0 || $column === ($columns - 1)) {
            $result1++;
            continue;
        }

        $hiddenUp = $hiddenDown = $hiddenLeft = $hiddenRight = false;

        for ($i = ($row - 1); $i >= 0; $i--) {
            if ($heights[$i][$column] >= $height) {
                $hiddenUp = true;
                break;
            }
        }

        for ($i = ($row + 1); $i < $rows; $i++) {
            if ($heights[$i][$column] >= $height) {
                $hiddenDown = true;
                break;
            }
        }

        for ($i = ($column - 1); $i >= 0; $i--) {
            if ($heights[$row][$i] >= $height) {
                $hiddenLeft = true;
                break;
            }
        }

        for ($i = ($column + 1); $i < $columns; $i++) {
            if ($heights[$row][$i] >= $height) {
                $hiddenRight = true;
                break;
            }
        }

        if (!$hiddenUp || !$hiddenDown || !$hiddenLeft || !$hiddenRight) {
            $result1++;
        }
    }
}

echo sprintf("Part I: %d\n", $result1);

/* PART II */

$distances = [];

for ($row = 0; $row < $rows; $row++) {
    for ($column = 0; $column < $columns; $column++) {
        $height = $heights[$row][$column];

        $distanceUp = $distanceDown = $distanceLeft = $distanceRight = 0;

        for ($i = $row; $i >= 0; $i--) {
            $distanceUp++;

            if ($i !== $row && $heights[$i][$column] >= $height) {
                break;
            }
        }

        for ($i = $row; $i < $rows; $i++) {
            $distanceDown++;

            if ($i !== $row && $heights[$i][$column] >= $height) {
                break;
            }
        }

        for ($i = $column; $i >= 0; $i--) {
            $distanceLeft++;

            if ($i !== $column && $heights[$row][$i] >= $height) {
                break;
            }
        }

        for ($i = $column; $i < $columns; $i++) {
            $distanceRight++;

            if ($i !== $column && $heights[$row][$i] >= $height) {
                break;
            }
        }

        $distances["$row/$column"] = ($distanceUp - 1) * ($distanceDown - 1) * ($distanceLeft - 1) * ($distanceRight - 1);
    }
}

$result2 = max($distances);

echo sprintf("Part II: %d\n", $result2);
