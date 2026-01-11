<?php

namespace Engine\Models;

use Engine\Traits\PositionTrait;

class EndItem
{
    use PositionTrait;

    protected Position $position;

    public function __construct()
    {
        $this->position = new Position;
    }
}
