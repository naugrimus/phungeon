<?php

namespace App;

use Engine\Core\State;
use Engine\Core\Engine;
use App\enums\AnsiiConstants;

class Game
{
    public function start()
    {
        fwrite(STDOUT, AnsiiConstants::HIDECURSOR);

        $state = new State;
        $engine = new Engine($state);
        $engine->run();
    }
}
