<?php

namespace Engine\Models;

class Inventory
{
    protected array $items = [];
    public function addItem(AbstractItem $item): self {
        $this->items[] = $item;
        return $this;
    }
}