<?php

namespace Engine\States;

use App\enums\Elements;
use Engine\Models\Room;
use Engine\Core\GameData;
use Engine\Models\Player;
use App\Helpers\RoomGenerator;
use Engine\Handlers\InputHandler;
use Engine\Models\Items\HealtPotion;
use Engine\Interfaces\StateInterface;
use Engine\Models\Enemies\ZombieWarrior;

class CreateRoomState extends AbstractState implements StateInterface
{
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

    protected function createNewRoom($x, $y): void
    {
        $generator = new RoomGenerator;
        $this->room = new Room;
        $this->room->setMap($generator->generate());
        $this->gameData->addRoom($this->room);
        $this->gameData->setCurrentRoomId(count($this->gameData->getRooms()) - 1);
        $this->room->setPosition($x, $y);
        $this->createMonsters();
        $this->createItems();
        $this->setPlayerPosition($this->gameData->getPlayer());

    }

    protected function getDirections()
    {
        $position = $this->gameData->getCurrentRoom()->getPosition();
        $x = $position->getX();
        $y = $position->getY();
        switch ($this->gameData->getExit()) {
            case 'north':
                $y++;
                break;
            case 'south':
                $y--;
                break;
            case 'west':
                $x--;
                break;
            case 'east':
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
        $map = $this->room->getMap();

        $mapHeight = count($map);
        $mapWidth = count($map[0]);

        $x = intdiv($mapWidth, 2);
        $y = intdiv($mapHeight, 2);

        switch ($this->gameData->getExit()) {

            case 'north': // exited north → enter from south
                $player->setPosition($x, $mapHeight - 1);
                break;

            case 'south': // exited south → enter from north
                $player->setPosition($x, 0);
                break;

            case 'east': // exited east → enter from west
                $player->setPosition(0, $y);
                break;

            case 'west': // exited west → enter from east
                $player->setPosition($mapWidth - 1, $y);
                break;

            default:
                $player->setPosition($x, $y);
        }
    }

    public function createMonsters()
    {
        $map = $this->room->getMap();
        $mapHeight = count($map);
        $mapWidth = count($map[0]);

        for ($num = 1; $num < 7; $num++) {
            $enemy = new ZombieWarrior(100);
            $x = rand(0, $mapWidth - 1);
            $y = rand(0, $mapHeight - 1);
            if ($map[$y][$x] == Elements::FLOOR) {
                $enemy->setPosition($x, $y);
                $this->room->addEnemy($enemy);

            }

        }
    }

    protected function createItems()
    {
        $map = $this->room->getMap();
        $mapHeight = count($map);
        $mapWidth = count($map[0]);
        for ($num = 1; $num < 12; $num++) {
            $item = new HealtPotion;
            $x = rand(0, $mapWidth - 1);
            $y = rand(0, $mapHeight - 1);

            if ($map[$y][$x] == Elements::FLOOR) {
                $item->setPosition($x, $y);
                $this->room->addItem($item);

            }

        }

    }
}
