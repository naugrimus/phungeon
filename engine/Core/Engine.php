<?php

namespace Engine\Core;

use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateFactoryInterface;

class Engine
{
    public function __construct(protected readonly StateFactoryInterface $stateFactory) {}

    public function run(GameData $gameData, InputHandler $inputHandler)
    {
        $state = $this->stateFactory->create($gameData->getState()->getName());
        $state->handle($gameData, $inputHandler);
    }
}
