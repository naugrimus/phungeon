<?php

namespace App\Renderers;

use App\enums\Elements;
use Engine\Core\GameData;
use App\enums\AnsiiConstants;

class Dungeoneering
{
    protected GameData $gameData;

    public function render(GameData $gameData): void
    {
        $this->gameData = $gameData;
        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);
        fwrite(STDOUT, AnsiiConstants::HIDECURSOR);

        fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);
        $room = $gameData->getCurrentRoom();

        // player status bar
        $this->createStatusBar();

        foreach ($room->getmap() as $y => $row) {
            // $rowData = str_split($row);
            foreach ($row as $x => $value) {
                $elementRendered = false;
                if ($x == $gameData->getPlayer()->getPosition()->getX() &&
                    $y == $gameData->getPlayer()->getPosition()->getY()) {
                    fwrite(STDOUT, "\033[32m" . Elements::PLAYER . "\033[37m");
                    $elementRendered = true;
                }

                foreach ($room->getEnemies() as $enemy) {
                    if ($x == $enemy->getPosition()->getX() &&
                        $y == $enemy->getPosition()->getY()) {
                        if ($gameData->getPlayer()->getPosition()->getX() != $enemy->getPosition()->getX() ||
                            $gameData->getPlayer()->getPosition()->getY() != $enemy->getPosition()->getY()) {
                            fwrite(STDOUT, "\033[91m" . Elements::ENEMY .  "\033[37m");
                            $elementRendered = true;

                        } else {
                            $elementRendered = false;
                        }
                    }
                }

                foreach($room->getItems() as $item) {
                    if ($x == $item->getPosition()->getX() &&
                        $y == $item->getPosition()->getY()) {
                        if ($gameData->getPlayer()->getPosition()->getX() != $item->getPosition()->getX() ||
                            $gameData->getPlayer()->getPosition()->getY() != $item->getPosition()->getY()) {
                            fwrite(STDOUT, "\033[93m" . Elements::HEALTHPOTION . "\033[37m");
                            $elementRendered = true;

                        } else {
                            $elementRendered = false;
                        }
                    }
                }
                if (! $elementRendered) {
                    fwrite(STDOUT, $value);
                }


            }
            if ($x != count($row)) {
                fwrite(STDOUT, PHP_EOL);
            }

        }
        fwrite(STDOUT, 'playerX:' . $gameData->getPlayer()->getPosition()->getX() . PHP_EOL);
        fwrite(STDOUT, 'room posX:' . $gameData->getPlayer()->getPosition()->getX() . PHP_EOL);
        fwrite(STDOUT, 'room posY:' . $gameData->getPlayer()->getPosition()->getY() . PHP_EOL);

        fwrite(STDOUT, 'room char under player:' . $room->getmap()[$gameData->getPlayer()->getPosition()->getY() + 1][$gameData->getPlayer()->getPosition()->getX()] . PHP_EOL);
        fwrite(STDOUT, 'room char left player:' . $room->getmap()[$gameData->getPlayer()->getPosition()->getY()][$gameData->getPlayer()->getPosition()->getX() - 1] . PHP_EOL);

    }

    protected function createStatusBar()
    {

        $player = $this->gameData->getPlayer();
        $map = $this->gameData->getCurrentRoom()->getMap();
        $row = $map[0];
        $length = count($row);

        $max = $player->getMaxHealth();
        fwrite(STDOUT, 'Player');
        if ($player->getAttackingEnemy()) {

            fwrite(STDOUT, str_repeat(' ', intval($length / 2)) . '|');
            fwrite(STDOUT, 'Enemy');
        }
        fwrite(STDOUT, PHP_EOL);

        fwrite(STDOUT, 'Health: ');
        fwrite(STDOUT, $this->drawHealthBar($player->getHealth(), $max));

        if ($player->getAttackingEnemy()) {

            fwrite(STDOUT, str_repeat(' ', intval($length / 2) - 22). '|');
            fwrite(STDOUT, $this->drawHealthBar($player->getAttackingEnemy()->getHealth(), $player->getAttackingEnemy()->getMaxHealth()));
        }
        fwrite(STDOUT, PHP_EOL);

    }

    function drawHealthBar(int $current, int $max, int $width = 20): string
    {
        $ratio = $current / $max;
        $filled = (int) round($ratio * $width);
        $empty  = $width - $filled;

        if ($ratio > 0.6) {
            $color = "\033[32m"; // green
        } elseif ($ratio > 0.3) {
            $color = "\033[33m"; // yellow
        } else {
            $color = "\033[31m"; // red
        }

        $reset = "\033[0m";

        return sprintf(
            "%s%s%s%s",
            $color,
            str_repeat("█", $filled),
            $reset,
            str_repeat("░", $empty)
        );
    }
}
