<?php

namespace Engine\Traits;

trait PositionTrait
{
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