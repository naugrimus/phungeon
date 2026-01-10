<?php

namespace Engine\Models;

class Player extends AbstractModel
{
    protected ?AbstractEnemy $attackingEnemy = null;

    protected Inventory $inventory;

    public function __construct(int $health)
    {
        parent::__construct($health);
        $this->inventory = new Inventory;

    }

    public function isAttackingEnemy(AbstractEnemy $enemy): void
    {
        $this->attackingEnemy = $enemy;
    }

    public function getAttackingEnemy(): ?AbstractEnemy
    {
        return $this->attackingEnemy;
    }

    public function noAttack(): void
    {
        $this->attackingEnemy = null;
    }

    public function getInventory(): Inventory {
        return $this->inventory;
    }
}
