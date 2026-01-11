<?php

namespace App\Renderers;

use App\enums\Elements;
use Engine\Models\Room;
use Engine\Core\GameData;
use Engine\Models\Player;
use Engine\Models\Position;
use App\enums\AnsiiConstants;

class Dungeoneering
{
    protected GameData $gameData;

    protected Position $position;

    protected Player $player;

    protected Room $room;

    public function render(GameData $gameData): void
    {
        $this->gameData = $gameData;
        $this->player = $gameData->getPlayer();
        $this->room = $gameData->getCurrentRoom();

        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);
        fwrite(STDOUT, AnsiiConstants::HIDECURSOR);

        fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);

        // player status bar
        $this->createStatusBar();

        foreach ($this->room->getmap() as $y => $row) {
            // $rowData = str_split($row);
            foreach ($row as $x => $value) {
                $elementRendered = false;
                $position = new Position;
                $position->setY($y);
                $position->setX($x);

                $element = $this->renderElement($position);
                if ($element) {
                    fwrite(STDOUT, $element);
                } else {
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

        fwrite(STDOUT, 'room char under player:' . $this->room->getmap()[$gameData->getPlayer()->getPosition()->getY() + 1][$gameData->getPlayer()->getPosition()->getX()] . PHP_EOL);
        fwrite(STDOUT, 'room char left player:' . $this->room->getmap()[$gameData->getPlayer()->getPosition()->getY()][$gameData->getPlayer()->getPosition()->getX() - 1] . PHP_EOL);

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

            fwrite(STDOUT, str_repeat(' ', intval($length / 2) - 22) . '|');
            fwrite(STDOUT, $this->drawHealthBar($player->getAttackingEnemy()->getHealth(), $player->getAttackingEnemy()->getMaxHealth()));
        }
        fwrite(STDOUT, PHP_EOL);

    }

    public function drawHealthBar(int $current, int $max, int $width = 20): string
    {
        $ratio = $current / $max;
        $filled = (int) round($ratio * $width);
        $empty = $width - $filled;

        if ($ratio > 0.6) {
            $color = "\033[32m"; // green
        } elseif ($ratio > 0.3) {
            $color = "\033[33m"; // yellow
        } else {
            $color = "\033[31m"; // red
        }

        $reset = "\033[0m";

        return sprintf(
            '%s%s%s%s',
            $color,
            str_repeat('█', $filled),
            $reset,
            str_repeat('░', $empty)
        );
    }

    protected function renderElement(Position $position): ?string
    {
        if ($this->player->getPosition()->isEqual($position)) {
            return "\033[32m" . Elements::PLAYER . "\033[37m";
        }

        foreach ($this->room->getEnemies() as $enemy) {
            if ($enemy->getPosition()->isEqual($position)) {
                return "\033[91m" . Elements::ENEMY . "\033[37m";
            }
        }

        foreach ($this->room->getItems() as $item) {
            if ($item->getPosition()->isEqual($position)) {
                return "\033[93m" . Elements::HEALTHPOTION . "\033[37m";
            }
        }

        // Nothing special on this tile
        return null;
    }
}
