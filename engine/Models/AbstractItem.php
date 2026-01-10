<?php

namespace Engine\Models;

use Engine\Traits\PositionTrait;

Abstract class AbstractItem
{
    use PositionTrait;
    protected Position $position;
    public function __construct() {
        $this->position = new Position();
    }
}