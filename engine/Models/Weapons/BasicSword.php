<?php

namespace Engine\Models\Weapons;

use App\enums\Weapons;
use Engine\Models\AbstractWeapon;

class BasicSword extends AbstractWeapon
{
    public function __construct()
    {
        $this->type = Weapons::SINGLEHANDED;

        $this->weaponType = Weapons::WEAPONTYPE_SWORD;

        $this->maxDamage = 40;

        $this->hitChance = 30;
    }
}
