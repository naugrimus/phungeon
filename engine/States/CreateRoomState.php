<?php

namespace Engine\States;

use Engine\Models\Room;
use Engine\Core\GameData;
use Engine\Models\Player;
use Engine\Traits\MapTrait;
use App\Helpers\RoomGenerator;
use Engine\Handlers\InputHandler;
use Engine\Handlers\ElementCreator;
use Engine\Interfaces\StateInterface;
Use App\enums\Directions;

class CreateRoomState extends AbstractState implements StateInterface
{
    use MapTrait;

    const NAME = 'CreateRoom';

    protected Room $room;

    protected GameData $gameData;

    public function handle(GameData $gameData, InputHandler $inputHandler): void
    {
        $this->gameData = $gameData;

        if (! $gameData->hasRoom()) {
            $this->createNewRoom(0, 0);
        } else {
            $roomId = $this->getVisitedRoom($this->gameData->getCurrentRoom());
            if ($roomId) {
                $gameData->setCurrentRoomId($roomId);
                $this->room = $gameData->getRooms()[$roomId];
                $this->setPlayerPosition($this->gameData->getPlayer());

            } else {
                $directions = $this->getDirections();
                $this->createNewRoom($directions[0], $directions[1]);
            }
        }

        $gameData->setState(new DungeoneeringState);
        $gameData->updateTurns();
    }

    protected function createNewRoom(int $x, int $y): void
    {
        $generator = new RoomGenerator;
        $this->room = new Room;
        $this->room->setMap($generator->generate());
        $this->gameData->addRoom($this->room);
        $this->gameData->setCurrentRoomId(count($this->gameData->getRooms()) - 1);
        $this->room->setPosition($x, $y);

        $creator = new ElementCreator;
        $creator->create($this->room);
        $this->setPlayerPosition($this->gameData->getPlayer());

    }

    protected function getDirections(): array
    {
        $position = $this->gameData->getCurrentRoom()->getPosition();
        $x = $position->getX();
        $y = $position->getY();
        switch ($this->gameData->getExit()) {
            case Directions::NORTH:
                $y++;
                break;
            case Directions::SOUTH:
                $y--;
                break;
            case Directions::WEST:
                $x--;
                break;
            case Directions::EAST:
                $x++;
                break;
        }

        return [$x, $y];
    }

    protected function getVisitedRoom(Room $currentRoom): ?int
    {

        $directions = $this->getDirections();
        $x = $directions[0];
        $y = $directions[1];
        foreach ($this->gameData->getRooms() as $key => $room) {
            if ($room->getPosition()->getX() == $x && $room->getPosition()->getY() == $y) {
                return $key;
            }
        }

        return null;
    }

    protected function setPlayerPosition(Player $player): void
    {

        $mapHeight = $this->getMapHeight();
        $mapWidth = $this->getMapWidth();

        $x = intdiv($mapWidth, 2);
        $y = intdiv($mapHeight, 2);

        switch ($this->gameData->getExit()) {

            case Directions::NORTH:
                $player->setPosition($x, $mapHeight - 1);
                break;

            case Directions::SOUTH:
                $player->setPosition($x, 0);
                break;

            case Directions::EAST:
                $player->setPosition(0, $y);
                break;

            case Directions::WEST:
                $player->setPosition($mapWidth - 1, $y);
                break;

            default:
                $player->setPosition($x, $y);
        }
    }
}
