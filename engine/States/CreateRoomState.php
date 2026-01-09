<?php

namespace Engine\States;

use Engine\Core\GameData;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

class CreateRoomState  extends AbstractState implements StateInterface
{

    const NAME = 'CreateRoom';

    public function handle(GameData $gameState, InputHandler $inputHandler)
    {
        // TODO: Implement handle() method.
    }
}