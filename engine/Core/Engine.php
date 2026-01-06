<?php

namespace Engine\Core;

use App\enums\AnsiiConstants;
use App\Renderers\Intro;
use Engine\Handlers\InputHandler;

class Engine
{
    protected State $state;

    public function __construct(State $state)
    {
        $this->state = $state;

    }

    public function run()
    {
        while (true) {
            fwrite(STDOUT, AnsiiConstants::HIDECURSOR);

            $this->handleIntro();

        }

    }

    protected function handleIntro(): void
    {
        if ($this->state->isShowIntro()) {
            echo AnsiiConstants::HIDECURSOR;
            system('stty -echo -icannon');
            stream_set_blocking(STDIN, false);


            echo "033[?25l";

            $intro = new Intro;
            $intro->render();
            $key = InputHandler::read();
            if($key) {
                fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);

                $this->state->setShowIntro(false);
            }
        }
    }
}
