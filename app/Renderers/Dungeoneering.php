<?php

namespace App\Renderers;

use Engine\Models\Player;
use Engine\Models\Room;
use Engine\Core\GameData;
use App\enums\AnsiiConstants;
use App\Helpers\RoomGenerator;

class Dungeoneering
{
    public function render(GameData $gameData): void
    {
        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);

        if ($gameData->getCurrentRoom() === null) {
            $generator = new RoomGenerator;
            $room = new Room;
            $room->setMap($generator->generate());
            $gameData->addRoom($room);
            $gameData->setCurrentRoom(0);
            // set the player position
            $this->setPlayerPosition($gameData->getPlayer(), $room);
        }

       // fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);
        $room = $gameData->getRooms()[$gameData->getCurrentRoom()];

        foreach ($room->getmap() as $y=>$row) {
            $rowData = str_split($row);
            foreach($rowData as $x=>$value) {
                if($x == $gameData->getPlayer()->getPosition()->getX() &&
                 $y == $gameData->getPlayer()->getPosition()->getY()) {
                    fwrite(STDOUT, '§');
                } else {
                    fwrite(STDOUT, $value);

                }
            }
            }

    }


    protected function setPlayerPosition(Player $player, Room $room): void {
        $map = $room->getMap();
        $mapHeight = count($map);
        $mapWidth = strlen($map[0]);

        $x = intval($mapWidth / 2);
        $y = intval($mapHeight / 2);
        $player->setPlayerPosition($x, $y);
    }
}
