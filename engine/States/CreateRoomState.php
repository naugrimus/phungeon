<?php

namespace Engine\States;

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

    public function handle(GameData $gameData, InputHandler $inputHandler): void
    {
        if ($gameData->getCurrentRoom() === null) {
            $generator = new RoomGenerator;
            $this->room = new Room;
            $this->room->setMap($generator->generate());
            $gameData->addRoom($this->room);
            $gameData->setCurrentRoomId(0);
            // set the player position
            $this->setPlayerPosition($gameData->getPlayer(), $this->room);
            $this->createMonsters();
            $this->createItems();
        }
        $gameData->setState(new DungeoneeringState);
        $gameData->updateTurns();
    }

    protected function setPlayerPosition(Player $player, Room $room): void
    {
        $map = $room->getMap();
        $mapHeight = count($map);
        $mapWidth = $map[0];

        $x = intval(count($mapWidth) / 2);
        $y = intval($mapHeight / 2);
        $player->setPosition($x, $y);
    }

    public function createMonsters()
    {
        $map = $this->room->getMap();
        $mapHeight = count($map);
        $mapWidth = count($map[0]);

        for ($num = 1; $num < 7; $num++) {
            $enemy = new ZombieWarrior(100);
            $x = rand(0, $mapWidth);
            $y = rand(0, $mapHeight);
            $enemy->setPosition($x, $y);
            $this->room->addEnemy($enemy);

        }
    }

    protected function createItems()
    {
        $map = $this->room->getMap();
        $mapHeight = count($map);
        $mapWidth = count($map[0]);
        for ($num = 1; $num < 12; $num++) {
            $item = new HealtPotion(100);
            $x = rand(0, $mapWidth);
            $y = rand(0, $mapHeight);
            $item->setPosition($x, $y);
            $this->room->addItem($item);

        }

    }
}
