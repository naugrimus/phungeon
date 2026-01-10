<?php

namespace Engine\Factories;

use App\Renderers\Intro;
use App\Renderers\Dungeoneering;

class renderFactory
{
    protected string $currentState = '';

    public function create($gameData): void
    {

        $renderer = match ($gameData->getState()->getName()) {
            'Intro' => new Intro,
            'Dungeoneering' => new Dungeoneering,
            'CreateRoom' => false
        };

        if ($gameData->getTurns() != $gameData->getCurrentTurn() || $gameData->getTurns() == 0) {
            $gameData->setCurrentTurn($gameData->getTurns());
            $this->currentState = $gameData->getState()->getName();
            if ($renderer) {
                echo $gameData->getState()->getName();
                $renderer->render($gameData);

            } else {
                echo $gameData->getState()->getName();
            }

        }
    }

}
