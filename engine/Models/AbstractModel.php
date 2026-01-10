<?php

namespace Engine\Models;

use Engine\Models\Weapons\BasicSword;

class AbstractModel
{
    protected int $health;

    protected int $maxHealth;

    protected AbstractWeapon $weapon;

    public function __construct(int $health)
    {
        $this->health = $health;
        $this->maxHealth = $health;

        $this->position = new Position;

        $this->weapon = new BasicSword;

    }

    protected Position $position;

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($x, $y)
    {
        $this->position->setX($x);
        $this->position->setY($y);
    }

    public function getMaxHealth(): int
    {
        return $this->maxHealth;
    }
}
