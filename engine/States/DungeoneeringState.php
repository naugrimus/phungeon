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
                if (! $this->detectBlocking($x, $y)) {
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
        $room = $rooms[$this->gameData->getCurrentRoomId()];
        $map = $room->getMap();
        foreach ($map as $row => $value) {
            foreach ($value as $col => $char) {
                if ($row == $playerY && $char == Elements::WALL && $col == $playerX) {
                    return true;
                }
            }
        }

        return false;
    }
}
