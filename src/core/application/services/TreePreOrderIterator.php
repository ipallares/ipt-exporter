<?php

declare(strict_types=1);

namespace App\core\application\services;

use RecursiveIterator;
use SplStack;

class TreePreOrderIterator implements RecursiveIterator
{
    /** @var array<mixed, string> $items */
    private array $items;

    private $current = null;

    private $initialCurrent = null;

    private $key = null;

    private SplStack $parentsStack;

    /** @var array<int | string , array | string> $currentSiblings  */
    private array $currentSiblings;

    public function __construct(array $items)
    {
        $this->items = $items;
        $this->parentsStack = new SplStack();
        if (0 < count($items)) {
            $this->key = array_key_first($items);
            $this->current = array_shift($items);
            $this->initialCurrent = $this->current;
            $this->parentsStack->push($this->getNewParentItemClass($items, []));
        }
        $this->currentSiblings = $items;
    }

    public function getDepth(): int
    {
        return $this->parentsStack->count() - 1;
    }

    /**
     * @return string | array
     */
    public function current()
    {
        return $this->current;
    }

    public function key()
    {
        return $this->valid() ? $this->key : null;
    }

    public function valid()
    {
        return null !== $this->current;
    }

    public function rewind()
    {
        $this->current = $this->initialCurrent;
    }

    public function hasChildren()
    {
        return is_array($this->current);
    }

    public function getChildren()
    {
        return $this->current;
    }

    public function next(): void
    {
        if ($this->hasChildren()) {
            $this->nextFirstChild();
        } else {
            $this->nextNotChild();
        }
    }

    private function nextFirstChild(): void
    {
        $currentChildren = $this->current;
        $newParentItemClass = $this->getNewParentItemClass($currentChildren, $this->currentSiblings);
        $this->parentsStack->push($newParentItemClass);
        $this->key = array_key_first($currentChildren);
        $this->current = array_shift($currentChildren);
        $this->currentSiblings = $currentChildren;
    }

    private function nextNotChild(): void
    {
        if ($this->hasNextSibling()) {
            $this->nextSibling();
        } else {
            $this->nextAncestor();
        }
    }

    private function nextSibling(): void
    {
        $this->key = array_key_first($this->currentSiblings);
        $this->current = array_shift($this->currentSiblings);
    }

    private function nextAncestor(): void
    {
        while (!$this->parentsStack->isEmpty()) {
            $parent = $this->parentsStack->pop();
            if ($parent->hasSiblings()) {
                $this->nextParentSibling($parent);
                return;
            }
        }

        $this->current = null;
    }

    private function nextParentSibling($parent)
    {
        $this->key = $parent->getNextSiblingKey();
        $this->current = $parent->getNextSibling();
        $this->currentSiblings = $parent->getSiblings();
    }

    private function hasNextSibling(): bool
    {
        return 0 < count($this->currentSiblings);
    }

    private function getNewParentItemClass($children, $siblings)
    {
        return new class($children, $siblings) {
            private array $children;
            private array $siblings;

            public function __construct($children, array $siblings)
            {
                $this->children = $children;
                $this->siblings = $siblings;
            }

            public function getSiblings(): array
            {
                return $this->siblings;
            }

            public function hasSiblings(): bool
            {
                return 0 < count($this->siblings);
            }

            public function getNextSiblingKey()
            {
                return array_key_first($this->siblings);
            }

            public function getNextSibling()
            {
                return array_shift($this->siblings);
            }
        };
    }
}
