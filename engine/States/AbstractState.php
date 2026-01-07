<?php

namespace Engine\States;

abstract class AbstractState
{
    public function getName(): string
    {
        return static::NAME;
    }
}
