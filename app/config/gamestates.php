<?php

use Engine\States\IntroState;
use Engine\States\CreateRoomState;
use Engine\States\DungeoneeringState;

return [
    ['Intro' => IntroState::class],
    ['Dungeoneering' => DungeoneeringState::class],
    ['CreateRoom' => CreateRoomState::class],

];
