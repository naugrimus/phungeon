<?php

namespace Engine\States;

use App\enums\Elements;
use Engine\Core\GameData;
use Engine\Handlers\InputHandler;
use Engine\Interfaces\StateInterface;

class DungeoneeringState extends AbstractState implements StateInterface
{
    const NAME = 'Dungeoneering';

    protected ?GameData $gameData;

    protected ?InputHandler $inputHandler;

    public function handle(GameData $gameData, InputHandler $inputHandler): void
    {
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
            $this->movement($x, $y);
        }

        $this->detectCombat();

    }

    protected function detectCombat() {
        
        $room = $this->gameData->getCurrentRoom();
        $player = $this->gameData->getPlayer();
        $pPosition = $player->getPosition();
        foreach($room->getEnemies() as $key => $e) {
            $ePosition = $e->getPosition();
            if($ePosition->getX() == $pPosition->getX() && $ePosition->getY() == $pPosition->getY()){
                $player->isAttackingEnemy($e);
                $dmg = $player->attack();
                $player->damage($dmg);

                $dmg = $player->attack();
                $e->damage($dmg);
                if($e->isDeath()){
                    $room->removeEnemy($key);
                }

                if($player->isDeath()) {
                    $this->gameData->setState(new GameOverState);

                }


            }

        }
    }
    protected function movement($x, $y): void
    {
        if (! $this->detectBlocking($x, $y)) {
            $this->gameData->getPlayer()->getPosition()->setY($y);
            $this->gameData->getPlayer()->getPosition()->setX($x);

            // now move the enemies
            $this->moveEnemies();
            $this->gameData->updateTurns();
        }
    }

    protected function moveEnemies(): void
    {
        $room = $this->gameData->getCurrentRoom();

        $player = $this->gameData->getPlayer();
        foreach ($room->getEnemies() as $enemy) {

            $enemyPosition = $enemy->getPosition();
            // check if the horizontal position of the enemy should be moved

            $eDiff = $this->checkRelativePosition($player->getPosition()->getX(), $enemyPosition->getX());
            $ex = $enemyPosition->getX() + $eDiff;

            if ($this->isPlayerPosition($ex, $enemyPosition->getY())) {
                continue;
            } else {
                $player->noAttack();
            }

            if ($this->canMoveEnemy($ex, $enemyPosition->getY())) {
                $enemyPosition->setX($ex);
            } else {
                $eDiff = $this->checkRelativePosition($player->getPosition()->getY(), $enemyPosition->getY());
                $ey = $enemyPosition->getY() + $eDiff;
                if ($this->isPlayerPosition($enemyPosition->getX(), $ey)) {
                    continue;
                } else {
                    $player->noAttack();

                }
                if ($this->canMoveEnemy($enemyPosition->getX(), $ey)) {
                    $enemyPosition->setY($ey);
                }

            }

        }

    }

    protected function isEnemyPosition($x, $y): bool
    {
        $room = $this->gameData->getCurrentRoom();

        foreach ($room->getEnemies() as $enemy) {
            $position = $enemy->getPosition();
            if ($position->getX() === $x && $position->getY() === $y) {

                return true;
            }
        }

        return false;

    }

    protected function canMoveEnemy($x, $y): bool
    {

        if ($this->detectBlocking($x, $y)) {
            return false;
        }
        if ($this->isEnemyPosition($x, $y)) {
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

    protected function detectBlocking($x, $y): bool
    {
        $room = $this->gameData->getCurrentRoom();
        $map = $room->getMap();

        foreach ($map as $row => $value) {
            foreach ($value as $col => $char) {
                if ($row == $y && $char == Elements::WALL && $col == $x) {
                    return true;
                }
            }
        }

        return false;
    }
}
