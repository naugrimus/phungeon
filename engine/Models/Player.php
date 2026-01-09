<?php

namespace Engine\Models;

class Player extends AbstractModel {

    public function __construct()
    {
        $this->position = new Position();
    }
}
