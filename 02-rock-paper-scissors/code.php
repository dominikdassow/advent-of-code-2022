<?php

enum State: int {

    // 1 for Rock, 2 for Paper, and 3 for Scissors
    case Rock = 1;
    case Paper = 2;
    case Scissors = 3;

    // A for Rock, B for Paper, and C for Scissors
    static function fromOpponentValue(string $s): self {
        return match ($s) {
            "A" => self::Rock,
            "B" => self::Paper,
            "C" => self::Scissors,
        };
    }

    // X for Rock, Y for Paper, and Z for Scissors
    static function fromPlayerValue(string $s): self {
        return match ($s) {
            "X" => self::Rock,
            "Y" => self::Paper,
            "Z" => self::Scissors,
        };
    }

    // X means you need to lose, Y means you need to end the round in a draw, and Z means you need to win.
    static function fromPlayerMove(State $opponent, string $s): self {
        return match ($s) {
            "X" => match ($opponent) {
                self::Rock => self::Scissors,
                self::Paper => self::Rock,
                self::Scissors => self::Paper,
            },
            "Y" => match ($opponent) {
                self::Rock => self::Rock,
                self::Paper => self::Paper,
                self::Scissors => self::Scissors,
            },
            "Z" => match ($opponent) {
                self::Rock => self::Paper,
                self::Paper => self::Scissors,
                self::Scissors => self::Rock,
            },
        };
    }

    // 0 if you lost, 3 if the round was a draw, and 6 if you won
    function pointsAgainst(State $state): int {
        return match ($this) {
            self::Rock => match ($state) {
                self::Rock => 3,
                self::Paper => 0,
                self::Scissors => 6,
            },
            self::Paper => match ($state) {
                self::Rock => 6,
                self::Paper => 3,
                self::Scissors => 0,
            },
            self::Scissors => match ($state) {
                self::Rock => 0,
                self::Paper => 6,
                self::Scissors => 3,
            },
        };
    }
}

/* PART I */

$result1 = 0;

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    [$opponentValue, $playerValue] = explode(" ", $line);

    $opponent = State::fromOpponentValue($opponentValue);
    $player = State::fromPlayerValue($playerValue);

    $points = $player->value + $player->pointsAgainst($opponent);
    $result1 += $points;
}

echo sprintf("Part I: %d\n", $result1);

/* PART II */

$result2 = 0;

foreach (new SplFileObject(__DIR__."/input.txt") as $line) {
    if (empty($line = trim($line))) {
        continue;
    }

    [$opponentValue, $playerMove] = explode(" ", $line);

    $opponent = State::fromOpponentValue($opponentValue);
    $player = State::fromPlayerMove($opponent, $playerMove);

    $points = $player->value + $player->pointsAgainst($opponent);
    $result2 += $points;
}

echo sprintf("Part II: %d\n", $result2);
