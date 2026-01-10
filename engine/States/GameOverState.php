<?php

namespace Engine\States;

use Engine\Core\GameData;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

class GameOverState extends AbstractState implements StateInterface
{

    const NAME = 'GameOver';

    public function handle(GameData $gameData, InputHandler $inputHandler)
    {
        if ($inputHandler::read() != ' ') {
            $gameData->setState(new IntroState());
        }
    }
}