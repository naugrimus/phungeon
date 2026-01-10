<?php

namespace Engine\Models;

class Room
{
    protected Position $position;

    protected array $map = [];

    protected array $enemies = [];

    public function setMap(array $map): void
    {
        $this->map = $map;
    }

    public function getMap(): array
    {
        return $this->map;
    }

    public function addEnemny(AbstractEnemy $enemy): self
    {
        $this->enemies[] = $enemy;
        return $this;
    }

    public function getEnemies(): array
    {
        return $this->enemies;
    }
}
