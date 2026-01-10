<?php

namespace Engine\Models;

class Player extends AbstractModel
{
    protected ?AbstractEnemy $attackingEnemy = null;

    protected Inventory $inventory;

    protected int $maxInventory = 10;

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

    public function getInventory(): Inventory
    {
        return $this->inventory;
    }

    public function usedMaxInventory(): bool
    {
        if ($this->maxInventory == count($this->inventory->getItems())) {
            return true;
        }

        return false;
    }

    public function useItem(int $itemId): void
    {
        $item = $this->inventory->getItemById($itemId);
        $item->useByPlayer($this);
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function setMaxHealth(int $maxHealth): self
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }
}
