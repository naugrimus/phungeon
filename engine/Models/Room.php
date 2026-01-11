<?php

namespace Engine\Models;

class Room
{
    protected Position $position;

    protected array $map = [];

    protected array $enemies = [];

    protected array $items = [];

    public function setMap(array $map): void
    {
        $this->map = $map;
    }

    public function getMap(): array
    {
        return $this->map;
    }

    public function addEnemy(AbstractEnemy $enemy): self
    {
        $this->enemies[] = $enemy;

        return $this;
    }

    public function getEnemies(): array
    {
        return $this->enemies;
    }

    public function removeEnemy(int $enemyId): void
    {
        unset($this->enemies[$enemyId]);
    }

    public function addItem(AbstractItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function removeItem($itemId): void
    {
        unset($this->items[$itemId]);
    }
}
