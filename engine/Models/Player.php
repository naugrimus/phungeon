<?php

namespace Engine\Models;

class Player extends AbstractModel
{

    protected ?AbstractEnemy $attackingEnemy = null;
    public function isAttackingEnemy (AbstractEnemy $enemy): void {
        $this->health= 211;
        $this->attackingEnemy = $enemy;
    }

    public function getAttackingEnemy(): ?AbstractEnemy {
        return $this->attackingEnemy;
    }

    public function noAttack() {
        $this->attackingEnemy = null;
    }



}
