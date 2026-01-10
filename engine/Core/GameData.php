<?php

namespace Engine\Core;

use Engine\Models\Room;
use Engine\Models\Player;
use Engine\Interfaces\StateInterface;
use Engine\Interfaces\BaseGameStateInterface;

class GameData implements BaseGameStateInterface
{
    protected StateInterface $state;

    protected int $turns = 0;

    protected int $currentTurn = 0;

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

    protected ?int $currentRoom = null;

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

    public function getCurrentRoomId(): ?int
    {
        return $this->currentRoom;
    }

    public function setCurrentRoomId(int $roomId): self
    {
        $this->currentRoom = $roomId;

        return $this;
    }

    public function updateTurns(): void
    {
        $this->turns++;
    }

    public function getTurns()
    {
        return $this->turns;
    }

    public function setCurrentTurn(int $turn): self
    {
        $this->currentTurn = $turn;

        return $this;
    }

    public function getCurrentTurn(): int
    {
        return $this->currentTurn;
    }

    public function getCurrentRoom(): ?Room {
        return $this->rooms[$this->currentRoom] ?? null;
    }
}
