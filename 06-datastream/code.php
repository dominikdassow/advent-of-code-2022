<?php

function run(int $length): array
{
    $result = [];

    foreach (new SplFileObject(__DIR__."/input.txt") as $index => $line) {
        if (empty($line = trim($line))) {
            continue;
        }

        for ($i = 0; $i < strlen($line); $i++) {
            if ($i < $length) {
                continue;
            }

            $bag   = substr($line, $i - $length, $length);
            $chars = str_split($bag);

            if ($chars == array_values(array_unique($chars))) {
                $result[$index] = $i;
                break;
            }
        }
    }

    return $result;
}

echo sprintf("Part I: %s\n", json_encode(run(4)));
echo sprintf("Part II: %s\n", json_encode(run(14)));
