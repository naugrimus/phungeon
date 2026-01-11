<?php

namespace Engine\States;

use App\enums\Elements;
use Engine\Models\Room;
use Engine\Core\GameData;
use Engine\Models\Player;
use Engine\Models\Position;
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
            $generator = new RoomGenerator;
            $this->room = new Room;
            $this->room->setMap($generator->generate());
            $gameData->addRoom($this->room);
            $gameData->setCurrentRoomId(0);
            // set the player position

            $this->setPlayerPosition($gameData->getPlayer());
            $position = new Position;
            $position->setX(0);
            $position->setY(0);

        } else {
            $generator = new RoomGenerator;
            $this->room = new Room;
            $this->room->setMap($generator->generate());
            $gameData->setCurrentRoomId(count($gameData->getRooms()));

            $gameData->addRoom($this->room);

            $this->setPlayerPosition($gameData->getPlayer());

        }
        $this->createMonsters();
        $this->createItems();

        $gameData->setState(new DungeoneeringState);
        $gameData->updateTurns();
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
