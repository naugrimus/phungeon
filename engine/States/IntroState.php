<?php

namespace Engine\States;

use Engine\Core\GameData;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

class IntroState extends AbstractState implements StateInterface
{
    const NAME = 'Intro';

    public function handle(GameData $gameData, InputHandler $inputHandler): void
    {

        if ($inputHandler::read() != ' ') {
            $gameData->updateTurns();
            $gameData->setState(new DungeoneeringState);
        }

    }
}
