<?php

namespace App;

use Engine\Core\Engine;
use Engine\Core\GameData;
use Engine\Models\Player;
use App\enums\AnsiiConstants;
use Engine\States\IntroState;
use Engine\Handlers\InputHandler;
use Engine\Factories\StateFactory;
use Engine\Factories\renderFactory;
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

        $gameData->setPlayer(new Player);

        $factory = new StateFactory;

        $inputHandler = new InputHandler;
        foreach ($this->states as $state) {
            $key = array_key_first($state);
            $class = $state[$key];

            $factory->add(array_key_first($state), $class);
        }

        $renderFactory = new renderFactory;
        $engine = new Engine($factory);
        while (true) {
            $renderFactory->create($gameData);

            $engine->run($gameData, $inputHandler);



        }
    }

    protected function fetchStates(): void
    {
        if (! is_file(__DIR__ . '/config/gamestates.php')) {
            throw new FileNotFoudException('gamestates.php not found');
        }
        $this->states = require_once __DIR__ . '/config/gamestates.php';
    }
}
