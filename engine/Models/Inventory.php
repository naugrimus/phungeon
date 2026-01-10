<?php

namespace Engine\Models;

class Inventory
{
    protected array $items = [];
    public function addItem(AbstractItem $item): self {
        $this->items[] = $item;
        return $this;
    }

    public function getItems(): array {
        return $this->items;
    }

    public function getItemById(int $itemId): ?AbstractItem {
        if(isset($this->items[$itemId])) {
            return $this->items[$itemId];
        }
        return null;
    }
}