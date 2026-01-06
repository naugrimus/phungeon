<?php

namespace Engine\Core;

use App\Renderers\Intro;
use App\enums\AnsiiConstants;
use Engine\Interfaces\BaseStateInterface;

class Engine
{
    protected State $state;

    public function __construct(BaseStateInterface $state)
    {
        echo AnsiiConstants::HIDECURSOR;

        $this->state = $state;

    }

    public function run()
    {
        while (true) {
            $this->handleIntro();
            $this->handleMap();
        }

    }

    protected function handleIntro(): void
    {

        if ($this->state->isShowIntro()) {
            fwrite(STDOUT, AnsiiConstants::HIDECURSOR);

            $intro = new Intro;
            $intro->render();
            $key = fgets(STDIN);
            if ($key !== '') {
                fwrite(STDOUT, AnsiiConstants::CLEARSCREEN);
                $this->state->setShowIntro(false);
            }
        }
    }

    protected function handleMap(): void {}
}
