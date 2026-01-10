<?php

namespace Engine\States;

use Engine\Models\Enemies\ZombieWarrior;
use Engine\Models\Room;
use Engine\Core\GameData;
use Engine\Models\Player;
use App\Helpers\RoomGenerator;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

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
        }
        $gameData->setState(new DungeoneeringState());
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

    public function createMonsters() {
        $map = $this->room->getMap();
        $mapHeight = count($map);
        $mapWidth = count($map[0]);

        for($x=1;$x < 3;$x++) {
            $enemy = new ZombieWarrior(100);
            $x = rand(0, $mapWidth);
            $y = rand(0, $mapHeight);
            $enemy->setPosition($x, $y);
            $this->room->addEnemny($enemy);
        }
    }
}
