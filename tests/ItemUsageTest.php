<?php

namespace tests;

use Engine\Models\Player;
use PHPUnit\Framework\TestCase;
use Engine\Models\Items\HealtPotion;

class ItemUsageTest extends TestCase
{
    public function test_player_can_use_item()
    {

        $player = new Player(500);
        $player->setHealth(200);

        $item = new HealtPotion;
        $this->assertEquals(200, $player->getHealth());

        $player->getInventory()->addItem($item);

        $this->assertCount(1, $player->getInventory()->getItems());

        $item->useByPlayer($player);

        $this->assertEquals(400, $player->getHealth());

        $player->setHealth('400');
        $item->useByPlayer($player);
        $this->assertEquals(500, $player->getHealth());
        $this->assertCount(0, $player->getInventory()->getItems());

    }
}
