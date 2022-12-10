<?php

/* PART I */

$positionHead = $positionTail = [0, 0];

$tailMap = [];

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    [$direction, $steps] = explode(" ", $line);

    [$xDelta, $yDelta] = match ($direction) {
        "U" => [0, 1],
        "D" => [0, -1],
        "R" => [1, 0],
        "L" => [-1, 0],
    };

    for ($step = 0; $step < (int) $steps; $step++) {
        [$xHead, $yHead] = $positionHead;
        [$xTail, $yTail] = $positionTail;

        $xHead = $xHead + $xDelta;
        $yHead = $yHead + $yDelta;

        $xDistance = $xHead - $xTail;
        $yDistance = $yHead - $yTail;

        $xGap = abs($xDistance) > 1;
        $yGap = abs($yDistance) > 1;

        if ($xGap && $yHead === $yTail) {
            // Same row
            $xTail += match (true) {
                $xDistance > 0 => 1,
                $xDistance < 0 => -1,
                default => 0,
            };
        } elseif ($yGap && $xHead === $xTail) {
            // Same column
            $yTail += match (true) {
                $yDistance > 0 => 1,
                $yDistance < 0 => -1,
                default => 0,
            };
        } elseif ($xGap || $yGap) {
            // Diagonal
            $xTail += match (true) {
                $xDistance > 0 => 1,
                $xDistance < 0 => -1,
                default => 0,
            };

            $yTail += match (true) {
                $yDistance > 0 => 1,
                $yDistance < 0 => -1,
                default => 0,
            };
        }

        $positionHead = [$xHead, $yHead];
        $positionTail = [$xTail, $yTail];

        if (!in_array($positionTail, $tailMap)) {
            $tailMap[] = $positionTail;
        }
    }
}

$result1 = count($tailMap);

echo sprintf("Part I: %d\n", $result1);

/* PART II */

// Skipped
