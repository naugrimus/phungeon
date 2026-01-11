<?php

namespace Engine\Models;

use Engine\Traits\PositionTrait;

abstract class AbstractItem
{
    use PositionTrait;

    protected Position $position;

    public function __construct()
    {
        $this->position = new Position;
    }

    abstract public function useByPlayer(Player $player): void;

    abstract public function getDisplay(): string;
}
