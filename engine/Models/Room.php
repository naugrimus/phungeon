<?php

namespace Engine\Models;

use Engine\Traits\PositionTrait;

class Room
{
    use PositionTrait;

    protected Position $position;

    protected array $map = [];

    protected array $enemies = [];

    protected array $items = [];

    protected ?EndItem $endItem = null;

    public function __construct()
    {
        $this->position = new Position;
    }

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

    public function addEndItem(EndItem $item): self
    {
        $this->endItem = $item;
    }

    public function hasEnd(): bool
    {
        return $this->endItem !== null;
    }

    public function getEnd()
    {
        return $this->endItem;
    }
}
