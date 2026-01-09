<?php

namespace App\Renderers;

use App\enums\AnsiiConstants;
use App\Helpers\Terminal;

class Dungeoneering
{
    public function render(): void
    {
        $tWidth = Terminal::getTerminalWidth();
        $tHeight = Terminal::getTerminalHeight();

        $room[0] = str_repeat('#', Terminal::getTerminalWidth());
        $room[$tHeight] = str_repeat('#', Terminal::getTerminalWidth());
        for($x = 1; $x <= $tHeight -2 ; $x++) {
            $room[$x] = '#' . str_repeat(' ', Terminal::getTerminalWidth() - 2) . '#';
        }

        
        ksort($room, SORT_NUMERIC);
        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);
        ;
        foreach($room as $key=>$row) {
            fwrite(STDOUT, $room[$key]);
        }

    }
}