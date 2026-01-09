<?php

namespace App\Renderers;

use App\enums\AnsiiConstants;
use App\Helpers\RoomGenerator;
use Engine\Core\GameData;
use Engine\Models\Room;

class Dungeoneering
{
    public function render(GameData $gameData): void
    {
        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);
        ;
        if($gameData->getCurrentRoom() === NULL) {
            $generator = new RoomGenerator();
            $room = new Room();
            $room->setMap($generator->generate());
            $gameData->addRoom($room);
            $gameData->setCurrentRoom(0);
        }

    fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);
        $room = $gameData->getRooms()[$gameData->getCurrentRoom()];

        foreach($room->getmap() as $row) {
            fwrite(STDOUT, $row);
        }
    }
}