<?php

namespace Engine\States;

use Engine\Core\GameData;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

class GameOverState extends AbstractState implements StateInterface
{
    const NAME = 'GameOver';

    protected bool $success = false;

    public function handle(GameData $gameData, InputHandler $inputHandler)
    {
        $gameData->removeRooms();
        $gameData->setExit(false);

        if ($inputHandler::read() != ' ') {
            $gameData->setState(new IntroState);
        }
    }
}
