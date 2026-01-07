<?php

namespace Engine\Factories;

use Engine\Interfaces\StateInterface;
use Engine\Interfaces\StateFactoryInterface;
use App\Exceptions\InvaldiClassNameException;

class StateFactory implements StateFactoryInterface
{
    protected array $states = [];

    public function add(string $name, string $state): void
    {
        $this->states[$name] = $state;
    }

    public function create(string $name): StateInterface
    {
        if (! isset($this->states[$name])) {
            throw new InvaldiClassNameException(sprintf('State %s does not exist', $name));
        }

        return new $this->states[$name];
    }
}
