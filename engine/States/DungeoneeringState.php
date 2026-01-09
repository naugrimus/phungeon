<?php

namespace Engine\States;

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
        $this->detectMovemnet();

    }

    protected function detectMovemnet(): void
    {
        // read the input
        $y = $this->gameData->getPlayer()->getPosition()->getY();
        $x = $this->gameData->getPlayer()->getPosition()->getX();

        switch ($this->inputHandler::read()) {
            case 'w':
                $y--;
                if (! $this->detectBlocking($x, $y)) {
                    $this->gameData->getPlayer()->getPosition()->setY($y);
                    $this->gameData->updateTurns();
                }

                break;
            case 's':
                $y++;
                if (! $this->detectBlocking($x, $y+1)) {
                    $this->gameData->getPlayer()->getPosition()->setY($y);
                    $this->gameData->updateTurns();
                }
                break;
            case 'a':
                $x--;
                if (! $this->detectBlocking($x, $y)) {
                    $this->gameData->getPlayer()->getPosition()->setX($x);
                    $this->gameData->updateTurns();
                }
                break;
            case 'd':
                $x++;
                if (! $this->detectBlocking($x, $y)) {
                    $this->gameData->getPlayer()->getPosition()->setX($x);
                    $this->gameData->updateTurns();
                }
                break;
        }
    }

    protected function detectBlocking($playerX, $playerY): bool
    {
        $rooms = $this->gameData->getRooms();
        $room = $rooms[$this->gameData->getCurrentRoom()];
        $map = $room->getMap();
        foreach ($map as $col => $value) {
            $array = str_split($value);
            foreach ($array as $row => $char) {
                if ($row == $playerX && $char == '#' && $col == $playerY) {
                    return true;
                }
            }
        }

        return false;
    }
}
