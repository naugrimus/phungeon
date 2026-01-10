<?php

namespace Engine\Models\Items;

use Engine\Interfaces\HealthPotionInterface;
use Engine\Models\AbstractItem;

class HealtPotion extends AbstractItem implements HealthPotionInterface
{

    protected int $amount = 200;


    public function getAmount(): int {
        return $this->amount;
    }
}