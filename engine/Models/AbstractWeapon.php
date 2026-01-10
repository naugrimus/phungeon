<?php

namespace Engine\Models;

class AbstractWeapon
{
    protected string $type;

    protected string $weaponType;

    protected int $hitChance;

    protected int $maxDamage;


    public function getHitChance() {
        return $this->hitChance;
    }

    public function getMaxDamage():int {
        return $this->maxDamage;
    }
}