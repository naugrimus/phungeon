<?php

namespace Engine\Core;

class Engine
{
    protected State $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function run()
    {

        if ($this->state->isShowIntro()) {
            echo 'show the intro';
        }
    }
}
