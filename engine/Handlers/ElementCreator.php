<?php

namespace Engine\Handlers;

use App\enums\Elements;
use Engine\Models\Room;
use Engine\Models\EndItem;
use Engine\Traits\MapTrait;
use Engine\Models\Items\HealtPotion;
use Engine\Models\Enemies\ZombieWarrior;

class ElementCreator
{
    use MapTrait;

    protected Room $room;

    public function create(Room $room): void
    {

        $this->room = $room;
        $this->createMonsters();
        $this->createItems();
        $this->createEndExit();

    }

    public function createMonsters()
    {

        for ($num = 1; $num < 7; $num++) {
            $enemy = new ZombieWarrior(100);
            [$x, $y] = $this->randomize();

            $enemy->setPosition($x, $y);
            $this->room->addEnemy($enemy);

        }

    }

    protected function createItems(): void
    {
        for ($num = 1; $num < 12; $num++) {
            $item = new HealtPotion;

            [$x, $y] = $this->randomize();

            $item->setPosition($x, $y);
            $this->room->addItem($item);

        }

    }

    protected function createEndExit()
    {
        $change = random_int(0, 20);
        if ($change < 20) {
            $position = $this->randomize();

            [$x, $y] = $position;

            $item = new EndItem;
            $item->setPosition($x, $y);
            $this->room->addEndItem($item);

        }
    }

    protected function randomize(): ?array
    {

        $map = $this->room->getMap();

        for ($i = 0; $i < 20; $i++) {
            $x = rand(0, $this->getMapWidth() - 1);
            $y = rand(0, $this->getMapHeight() - 1);

            if ($map[$y][$x] === Elements::FLOOR) {
                return [$x, $y];
            }
        }

        return null;

    }
}
