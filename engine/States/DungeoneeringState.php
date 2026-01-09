<?php

namespace Engine\States;

use App\Helpers\RoomGenerator;
use Engine\Core\GameData;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;
use Engine\Models\Room;

class DungeoneeringState  extends AbstractState implements StateInterface
{

    const NAME = 'Dungeoneering';

    public function handle(GameData $gameData, InputHandler $inputHandler)
    {

        // read the input
        switch($inputHandler::read()) {
            case 'w':
                $y = $gameData->getPlayer()->getPosition()->getY();
                $y--;
                $gameData->getPlayer()->getPosition()->setY($y);
                $gameData->updateTurns();
                break;
            case 's':
                $y = $gameData->getPlayer()->getPosition()->getY();
                $y++;
                $gameData->getPlayer()->getPosition()->setY($y);
                $gameData->updateTurns();
                break;
            case 'a':
                $x = $gameData->getPlayer()->getPosition()->getX();
                $x--;
                $gameData->getPlayer()->getPosition()->setX($x);
                $gameData->updateTurns();
                break;
            case 'd':
                $x = $gameData->getPlayer()->getPosition()->getX();
                $x++;
                $gameData->getPlayer()->getPosition()->setX($x);
                $gameData->updateTurns();
                break;
        }

    }
}