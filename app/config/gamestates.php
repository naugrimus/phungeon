<?php

use Engine\States\IntroState;
use Engine\States\GameOverState;
use Engine\States\CreateRoomState;
use Engine\States\DungeoneeringState;

return [
    ['Intro' => IntroState::class],
    ['Dungeoneering' => DungeoneeringState::class],
    ['CreateRoom' => CreateRoomState::class],
    ['GameOver' => GameOverState::class],

];
