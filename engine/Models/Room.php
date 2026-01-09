<?php

namespace Engine\Models;

class Room
{
    protected Position $position;

    protected array $map = [];


    public function setMap(array $map):void {
        $this->map = $map;
    }

    public function getMap(): array {
        return $this->map;
    }
}
