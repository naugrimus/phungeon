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

    }
}