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

                foreach($room->getEnemies() as $enemy) {
                    if ($x == $enemy->getPosition()->getX() &&
                        $y == $enemy->getPosition()->getY()) {
                        if($gameData->getPlayer()->getPosition()->getX() != $enemy->getPosition()->getX() ||
                            $gameData->getPlayer()->getPosition()->getY() != $enemy->getPosition()->getY()) {
                            fwrite(STDOUT, Elements::ENEMY);
                            $elementRendered = true;

                        } else {
                            $elementRendered = true;
                        }
                    }
                }
                if (! $elementRendered) {
                    fwrite(STDOUT, $value);
                }
                //            fwrite(STDOUT, $value);

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

    protected function createStatusBar() {


        $player = $this->gameData->getPlayer();

        $max = $player->getMaxHealth()/100;
        fwrite(STDOUT, 'Player');
        if($player->getAttackingEnemy()) {
            fwrite(STDOUT, str_repeat(' ' , 3));
            fwrite(STDOUT, '|');
            fwrite(STDOUT, 'Enemy');
        }
        fwrite(STDOUT, PHP_EOL);

        fwrite(STDOUT, str_repeat('█', $max));
        fwrite(STDOUT, $player->getHealth());
        fwrite(STDOUT, '/');
        fwrite(STDOUT, $player->getMaxHealth());

        if(!$player->getAttackingEnemy()) {
            fwrite(STDOUT, PHP_EOL);

        }



        if($enemy = $player->getAttackingEnemy()) {
            $eMaxHealth = $enemy->getMaxHealth();
            fwrite(STDOUT, str_repeat('█', $eMaxHealth / 100));
            fwrite(STDOUT, $eMaxHealth . PHP_EOL);

        }

    }
}
