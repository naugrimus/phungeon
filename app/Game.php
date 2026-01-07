<?php

namespace App;

use Engine\Core\Engine;
use Engine\Core\GameData;
use App\enums\AnsiiConstants;
use Engine\Handlers\InputHandler;
use Engine\States\IntroState;
use Engine\Factories\StateFactory;
use App\Exceptions\FileNotFoudException;

class Game
{
    protected array $states = [];

    public function __construct()
    {
        $this->fetchStates();
    }

    public function start()
    {
        fwrite(STDOUT, AnsiiConstants::HIDECURSOR);

        $gameData = new GameData;
        $gameData->setState(new IntroState);

        $factory = new StateFactory;

        $inputHandler = new InputHandler;
        foreach ($this->states as $state) {
            $key = array_key_first($state);
            $class = $state[$key];

            $factory->add(array_key_first($state), $class);
        }
        $engine = new Engine($factory);
        $engine->run($gameData, $inputHandler);
    }

    protected function fetchStates(): void
    {
        if (! is_file(__DIR__ . '/config/gamestates.php')) {
            throw new FileNotFoudException('gamestates.php not found');
        }
        $this->states = require_once __DIR__ . '/config/gamestates.php';
    }
}
