<?php

namespace Engine\Core;

use Engine\Models\Room;
use Engine\Models\Player;
use Engine\Interfaces\StateInterface;
use Engine\Interfaces\BaseGameStateInterface;

class GameData implements BaseGameStateInterface
{
    protected StateInterface $state;

    public function getState(): StateInterface
    {
        return $this->state;
    }

    public function setState(StateInterface $state): self
    {
        $this->state = $state;

        return $this;
    }

    protected Player $player;

    protected array $rooms = [];

    public function getRooms(): array
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        $this->rooms[] = $room;

        return $this;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
