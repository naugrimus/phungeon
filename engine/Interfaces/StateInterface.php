<?php

namespace Engine\Interfaces;

use Engine\Core\GameData;
use Engine\Handlers\InputHandler;

interface StateInterface
{
    public function handle(GameData $gameState, InputHandler $inputHandler);

    public function getName(): string;

}