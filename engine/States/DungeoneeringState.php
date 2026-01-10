<?php

namespace Engine\States;

use App\enums\Elements;
use Engine\Core\GameData;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

class DungeoneeringState extends AbstractState implements StateInterface
{
    const NAME = 'Dungeoneering';

    protected ?GameData $gameData;

    protected ?InputHandler $inputHandler;

    public function handle(GameData $gameData, InputHandler $inputHandler)
    {
        $this->gameData = $gameData;
        $this->inputHandler = $inputHandler;
        $this->detectMovement();

    }

    protected function detectMovement(): void
    {
        // read the input
        $y = $this->gameData->getPlayer()->getPosition()->getY();
        $x = $this->gameData->getPlayer()->getPosition()->getX();

        $input = $this->inputHandler::read();

        $movementInput = ['a', 'w', 's', 'd'];
        switch ($input) {
            case 'w':
                $y--;
                break;
            case 's':
                $y++;
                break;
            case 'a':
                $x--;
                break;
            case 'd':
                $x++;

        }

        if (in_array($input, $movementInput)) {
            $this->movement($x, $y);
        }

    }

    protected function movement($x, $y)
    {
        if (! $this->detectBlocking($x, $y)) {
            $this->gameData->getPlayer()->getPosition()->setY($y);
            $this->gameData->getPlayer()->getPosition()->setX($x);

            // now move the enemies
            $this->moveEnemies();
            $this->gameData->updateTurns();
        }
    }

    protected function moveEnemies()
    {
        $room = $this->gameData->getCurrentRoom();

        $player = $this->gameData->getPlayer();
        foreach ($room->getEnemies() as $enemy) {

            $enemyPosition = $enemy->getPosition();
            // check if the horizontal position of the enemie should be moved

            $eDiff = $this->checkRelativePosition($player->getPosition()->getX(), $enemyPosition->getX());
            $ex = $enemyPosition->getX() + $eDiff;

            if($this->isPlayerPosition($ex, $enemyPosition->getY())) {
                echo 'playerpos';
                continue;
            }
            if (! $this->detectBlocking($ex, $enemyPosition->getY())) {
                $enemyPosition->setX($ex);
            } else {
                $eDiff = $this->checkRelativePosition($player->getPosition()->getY(), $enemyPosition->getY());
                $ey = $enemyPosition->getY() + $eDiff;
                if($this->isPlayerPosition($enemyPosition->getX(), $ey)) {
                    continue;
                }
                if (! $this->detectBlocking($enemyPosition->getX(), $ey)) {
                    $enemyPosition->setY($ey);
                }

            }

        }

    }

    protected function isPlayerPosition($x, $y): bool {
        $postion = $this->gameData->getPlayer()->getPosition();
        return $postion->getX() == $x && $postion->getY() == $y;
    }

    protected function checkRelativePosition($first, $second): int
    {
        if ($first === $second) {
            return 0;
        }

        if ($first < $second) {
            return -1;
        }

        if ($first > $second) {
            return 1;
        }
    }

    protected function detectBlocking($x, $y): bool
    {
        $room = $this->gameData->getCurrentRoom();
        $map = $room->getMap();

        foreach ($map as $row => $value) {
            foreach ($value as $col => $char) {
                if ($row == $y && $char == Elements::WALL && $col == $x) {
                    return true;
                }
            }
        }

        return false;
    }
}
