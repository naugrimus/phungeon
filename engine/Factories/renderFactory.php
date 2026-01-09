<?php

namespace Engine\Factories;

use App\Renderers\CreateRoom;
use App\Renderers\Intro;

class renderFactory
{
    protected string $currentState = '';

    public function create($gameData): void
    {

        $renderer = match ($gameData->getState()->getName()) {
            'Intro' => new Intro(),
            'CreateRoom' => new CreateRoom(),
            'default' => throw new \Exception('Invalid gameState'),
        };
        if ($gameData->getState()->getName() !== $this->currentState) {
            $renderer->render($gameData);

        }

        $this->currentState = $gameData->getState()->getName();

    }
}
