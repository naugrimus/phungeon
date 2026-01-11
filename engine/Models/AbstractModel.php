<?php

namespace Engine\Models;

use Engine\Traits\PositionTrait;
use Engine\Models\Weapons\BasicSword;

class AbstractModel
{
    use PositionTrait;

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

    public function getMaxHealth(): int
    {
        return $this->maxHealth;
    }

    public function attack(): ?int
    {
        if (! $this->attackingEnemy) {
            return null;
        }

        if ($this->weapon) {
            $hit = $this->calculateHit($this->weapon->getHitChance());
            if ($hit) {
                return $this->calculateDamage($this->weapon->getMaxDamage());
            }
        }

        return null;
    }

    public function damage($damage)
    {
        $this->health = $this->health - $damage;
        if ($this->health < 0) {
            $this->health = 0;

        }
    }

    public function isDeath()
    {
        return $this->health <= 0;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    protected function calculateHit($hitchange): int
    {

        $change = random_int(0, $hitchange);
        if ($change < $hitchange) {
            return true;
        }

        return false;

    }

    protected function calculateDamage($maxDamge): int
    {
        return random_int(0, $maxDamge);
    }
}
