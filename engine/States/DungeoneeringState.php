<?php

namespace Engine\States;

use Engine\Core\GameData;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

class DungeoneeringState  extends AbstractState implements StateInterface
{

    const NAME = 'Dungeoneering';

    public function handle(GameData $gameState, InputHandler $inputHandler)
    {
        // TODO: Implement handle() method.
    }
}