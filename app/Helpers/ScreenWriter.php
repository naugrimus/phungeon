<?php

namespace App\Helpers;

class ScreenWriter
{
    protected $handler;

    public function open()
    {
        $this->handler = fopen('php://stdout', 'w');

    }

    public function write(string $message)
    {
        fwrite($this->handler, $message);
    }
}
