<?php

namespace Engine\Handlers;

class InputHandler
{

    public static function read() {
        return fgetc(STDIN);
    }
}