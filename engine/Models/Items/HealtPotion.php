<?php

namespace Engine\Models\Items;

use App\enums\Elements;
use Engine\Models\Player;
use Engine\Models\AbstractItem;
use Engine\Interfaces\HealthPotionInterface;

class HealtPotion extends AbstractItem implements HealthPotionInterface
{
    protected int $amount = 200;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function useByPlayer(Player $player): void
    {
        $health = $player->getHealth();
        $health = $health + $this->amount;
        $player->setHealth($health);
        if ($health > $player->getMaxHealth()) {
            $player->setHealth($player->getMaxHealth());
        }

    }

    public function getDisplay(): string
    {
        return Elements::HEALTHPOTION;
    }
}
