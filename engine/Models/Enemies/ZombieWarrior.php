<?php

namespace Engine\Models\Enemies;

use Engine\Models\AbstractEnemy;

class ZombieWarrior extends AbstractEnemy
{
    public function __construct(int $health)
    {
        parent::__construct();
        $this->health = $health;

        $this->type = 'ZombieWarrior';

        $this->name = 'ZombieWarrior';

    }
}
