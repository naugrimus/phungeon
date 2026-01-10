<?php

namespace Engine\Models;

abstract class AbstractEnemy extends AbstractModel
{
    protected int $health;

    protected string $type;

    protected string $name;
}
