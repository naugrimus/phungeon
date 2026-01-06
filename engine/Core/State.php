<?php

namespace Engine\Core;

use Engine\Interfaces\BaseStateInterface;
use Engine\Models\Room;
use Engine\Models\Player;

class State implements BaseStateInterface
{
    protected bool $showIntro = true;

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

    public function isShowIntro(): bool
    {
        return $this->showIntro;
    }

    public function setShowIntro(bool $showIntro): self
    {
        $this->showIntro = $showIntro;

        return $this;
    }
}
