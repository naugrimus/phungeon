<?php

namespace Engine\Traits;

trait MapTrait
{
    protected function getMapHeight(): int
    {
        return count($this->room->getMap());
    }

    protected function getMapWidth(): int
    {
        return count($this->room->getMap()[0]);
    }
}