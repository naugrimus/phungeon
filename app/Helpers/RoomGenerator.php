<?php

namespace App\Helpers;

class RoomGenerator
{

    public function __construct() {

    }

    public function generate(): array {
        $tWidth = Terminal::getTerminalWidth();
        $tHeight = Terminal::getTerminalHeight();

        $room[0] = str_repeat('#', Terminal::getTerminalWidth());
        $room[$tHeight] = str_repeat('#', Terminal::getTerminalWidth());
        for($x = 1; $x <= $tHeight -2 ; $x++) {
            $room[$x] = '#' . str_repeat(' ', Terminal::getTerminalWidth() - 2) . '#';
        }


        ksort($room, SORT_NUMERIC);

        return $room;
    }
}