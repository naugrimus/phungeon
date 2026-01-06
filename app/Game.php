<?php

namespace App;

use App\enums\AnsiiConstants;
use App\Renderers\Intro;

class Game
{

    public function start() {


        fwrite(STDOUT, AnsiiConstants::HIDECURSOR);
        $intro = new Intro;
        if($intro->render()) {

        };
    }
}