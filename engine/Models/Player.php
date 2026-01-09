<?php

namespace Engine\Models;

class Player extends AbstractModel
{
    public function __construct()
    {
        $this->position = new Position;
    }

    public function setPlayerPosition($x, $y)
    {
        $this->position->setX($x);
        $this->position->setY($y);
    }
}
