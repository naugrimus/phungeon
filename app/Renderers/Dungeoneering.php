<?php

namespace App\Renderers;

use App\enums\Elements;
use Engine\Models\Room;
use Engine\Core\GameData;
use Engine\Models\Player;
use App\enums\AnsiiConstants;
use App\Helpers\RoomGenerator;

class Dungeoneering
{
    public function render(GameData $gameData): void
    {
        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);
        fwrite(STDOUT, AnsiiConstants::HIDECURSOR);
        if ($gameData->getCurrentRoom() === null) {
            $generator = new RoomGenerator;
            $room = new Room;
            $room->setMap($generator->generate());
            $gameData->addRoom($room);
            $gameData->setCurrentRoom(0);
            // set the player position
            $this->setPlayerPosition($gameData->getPlayer(), $room);
        }

        fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);
        $room = $gameData->getRooms()[$gameData->getCurrentRoom()];

        foreach ($room->getmap() as $y => $row) {
            // $rowData = str_split($row);
            foreach ($row as $x => $value) {
                if ($x == $gameData->getPlayer()->getPosition()->getX() &&
                 $y == $gameData->getPlayer()->getPosition()->getY()) {
                    fwrite(STDOUT, Elements::PLAYER);
                } else {
                    fwrite(STDIN, $value);

                    //            fwrite(STDOUT, $value);

                }

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

    protected function setPlayerPosition(Player $player, Room $room): void
    {
        $map = $room->getMap();
        $mapHeight = count($map);
        $mapWidth = $map[0];

        $x = intval(count($mapWidth) / 2);
        $y = intval($mapHeight / 2);
        $player->setPlayerPosition($x, $y);
    }
}
