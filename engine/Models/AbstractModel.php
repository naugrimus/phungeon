<?php

namespace Engine\Models;

class AbstractModel
{
    public function __construct()
    {
        $this->position = new Position;
    }
    protected int $health;

    protected Position $position;

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($x, $y)
    {
        $this->position->setX($x);
        $this->position->setY($y);
    }
}
