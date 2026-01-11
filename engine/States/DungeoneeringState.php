<?php

namespace Engine\States;

use App\enums\Elements;
use Engine\Models\Player;
use Engine\Models\Room;
use Engine\Core\GameData;
use Engine\Models\Position;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

class DungeoneeringState extends AbstractState implements StateInterface
{
    const NAME = 'Dungeoneering';

    protected ?GameData $gameData;

    protected ?InputHandler $inputHandler;

    protected Room $room;

    protected Player $player;

    public function handle(GameData $gameData, InputHandler $inputHandler): void
    {
        $this->room = $gameData->getCurrentRoom();

        $this->player = $gameData->getPlayer();

        $this->gameData = $gameData;
        $this->inputHandler = $inputHandler;
        $this->detectMovement();

    }

    protected function detectMovement(): void
    {
        // read the input
        $y = $this->gameData->getPlayer()->getPosition()->getY();
        $x = $this->gameData->getPlayer()->getPosition()->getX();

        $input = $this->inputHandler::read();

        $movementInput = ['a', 'w', 's', 'd'];
        switch ($input) {
            case 'w':
                $y--;
                break;
            case 's':
                $y++;
                break;
            case 'a':
                $x--;
                break;
            case 'd':
                $x++;

        }

        if (in_array($input, $movementInput)) {
            $position = new Position;
            $position->setX($x);
            $position->setY($y);
            $this->movement($position);
        }


        if (ctype_digit($input)) {

            $this->useInventoryItem($input);
        }
        $this->detectCombat();
        $this->detectItem();

    }

    protected function detectItem()
    {
        $room = $this->gameData->getCurrentRoom();
        $pPosition = $this->player->getPosition();
        foreach ($room->getItems() as $key => $i) {
            $iPosition = $i->getPosition();
            if ($iPosition->getX() == $pPosition->getX() && $iPosition->getY() == $pPosition->getY()) {
                if (! $this->player->usedMaxInventory()) {
                    $this->player->getInventory()->addItem($i);
                    $room->removeItem($key);
                }
            }
        }
    }

    protected function detectCombat()
    {

        $pPosition = $this->player->getPosition();
        foreach ($this->room->getEnemies() as $key => $e) {
            $ePosition = $e->getPosition();
            if ($this->player->getPosition()->isEqual($ePosition)) {
                $this->player->isAttackingEnemy($e);
                $dmg = $this->player->attack();
                $this->player->damage($dmg);

                $dmg = $this->player->attack();
                $e->damage($dmg);
                if ($e->isDeath()) {
                    $this->room->removeEnemy($key);
                }

                if ($this->player->isDeath()) {
                    $this->gameData->setState(new GameOverState);

                }

            }

        }
    }

    protected function movement(Position $position): void
    {
        if (! $this->detectBlocking($position)) {
            $this->gameData->getPlayer()->getPosition()->setY($position->getY());
            $this->gameData->getPlayer()->getPosition()->setX($position->getX());

            // now move the enemies
            $this->moveEnemies();
            $this->gameData->updateTurns();
        }
    }

    protected function moveEnemies(): void
    {

        foreach ($this->room->getEnemies() as $enemy) {

            $enemyPosition = $enemy->getPosition();
            // check if the horizontal position of the enemy should be moved

            $eDiff = $this->checkRelativePosition($this->player->getPosition()->getX(), $enemyPosition->getX());
            $ex = $enemyPosition->getX() + $eDiff;

            if ($this->isPlayerPosition($ex, $enemyPosition->getY())) {
                continue;
            } else {
                $this->player->noAttack();
            }

            if ($this->canMoveEnemy($ex, $enemyPosition->getY())) {
                $enemyPosition->setX($ex);
            } else {
                $eDiff = $this->checkRelativePosition($this->player->getPosition()->getY(), $enemyPosition->getY());
                $ey = $enemyPosition->getY() + $eDiff;
                if ($this->isPlayerPosition($enemyPosition->getX(), $ey)) {
                    continue;
                } else {
                    $this->player->noAttack();

                }
                if ($this->canMoveEnemy($enemyPosition->getX(), $ey)) {
                    $enemyPosition->setY($ey);
                }

            }

        }

    }

    protected function isEnemyPosition(Position $position): bool
    {

        foreach ($this->room->getEnemies() as $enemy) {
            $eposition = $enemy->getPosition();
            if ($eposition->getX() === $position->getX() && $eposition->getY() === $position->getY()) {

                return true;
            }
        }

        return false;

    }

    protected function canMoveEnemy($x, $y): bool
    {
        $position = new Position;
        $position->setX($x);
        $position->setY($y);
        if ($this->detectBlocking($position)) {
            return false;
        }
        if ($this->isEnemyPosition($position)) {
            return false;
        }

        return true;
    }

    protected function isPlayerPosition($x, $y): bool
    {
        $position = $this->gameData->getPlayer()->getPosition();

        return $position->getX() == $x && $position->getY() == $y;
    }

    protected function checkRelativePosition($first, $second): int
    {
        if ($first === $second) {
            return 0;
        }

        return $first < $second ? -1 : 1;
    }

    protected function detectBlocking(Position $position): bool
    {
        $map = $this->room->getMap();

        foreach ($map as $row => $value) {
            foreach ($value as $col => $char) {
                if ($row == $position->getY() && $char == Elements::WALL && $col == $position->getX()) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function useInventoryItem(int $id): void
    {

        $player = $this->gameData->getPlayer();
        $items = $player->getInventory()->getItems();
        foreach ($items as $key => $item) {

            if ($id == $key + 1) {
                $player->useItem($key);
            }
        }

        $this->gameData->updateTurns();

    }
}
