<?php

namespace App\Renderers;

use App\enums\Elements;
use Engine\Core\GameData;
use App\enums\AnsiiConstants;

class Dungeoneering
{
    public function render(GameData $gameData): void
    {
        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);
        fwrite(STDOUT, AnsiiConstants::HIDECURSOR);

        fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);
        $room = $gameData->getCurrentRoom();

        // player status bar

        foreach ($room->getmap() as $y => $row) {
            // $rowData = str_split($row);
            foreach ($row as $x => $value) {
                $elementRendered = false;
                if ($x == $gameData->getPlayer()->getPosition()->getX() &&
                    $y == $gameData->getPlayer()->getPosition()->getY()) {
                    fwrite(STDOUT, Elements::PLAYER);
                    $elementRendered = true;
                }

                foreach($room->getEnemies() as $enemy) {
                    if ($x == $enemy->getPosition()->getX() &&
                        $y == $enemy->getPosition()->getY()) {
                        fwrite(STDOUT, Elements::ENEMY);
                        $elementRendered = true;
                    }
                }
                if (! $elementRendered) {
                    fwrite(STDIN, $value);
                }
                //            fwrite(STDOUT, $value);

            }
            if ($x != count($row)) {
                fwrite(STDIN, PHP_EOL);
            }

        }
        fwrite(STDOUT, 'playerX:' . $gameData->getPlayer()->getPosition()->getX() . PHP_EOL);
        fwrite(STDOUT, 'room posX:' . $gameData->getPlayer()->getPosition()->getX() . PHP_EOL);
        fwrite(STDOUT, 'room posY:' . $gameData->getPlayer()->getPosition()->getY() . PHP_EOL);

        fwrite(STDOUT, 'room char under player:' . $room->getmap()[$gameData->getPlayer()->getPosition()->getY() + 1][$gameData->getPlayer()->getPosition()->getX()] . PHP_EOL);
        fwrite(STDOUT, 'room char left player:' . $room->getmap()[$gameData->getPlayer()->getPosition()->getY()][$gameData->getPlayer()->getPosition()->getX() - 1] . PHP_EOL);

    }
}
