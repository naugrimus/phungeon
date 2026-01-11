<?php

namespace App\Renderers;

use Engine\Core\GameData;
use App\enums\AnsiiConstants;

class GameOver
{
    public function render(GameData $gameData): void
    {

        fwrite(STDOUT, AnsiiConstants::HIDECURSOR);
        fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);
        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);

        fwrite(STDOUT, str_repeat(PHP_EOL, 10));
        fwrite(STDOUT, str_repeat(' ', 20) . 'You died !!!');
        fwrite(STDOUT, str_repeat(PHP_EOL, 2));
        fwrite(STDOUT, str_repeat(' ', 20) . 'Press any key');

    }
}
