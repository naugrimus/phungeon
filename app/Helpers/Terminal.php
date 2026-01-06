<?php

namespace App\Helpers;

class Terminal
{
    public static function getTerminalWidth()
    {
        return (int) trim(shell_exec('tput cols') ?: 80);

    }

    public static function getTerminalHeight()
    {
        return (int) trim(shell_exec('tput lines') ?: 24);

    }

    public static function calculateTopPadding(int $lentgh): int {
       return  intval((self::getTerminalHeight() - $lentgh) / 2);
    }

    public static function calculateLeftPadding(int $lentgh): int {
        return  intval((self::getTerminalWidth() - $lentgh) / 2);
    }

}
