<?php

declare(strict_types=1);

namespace Cambit\SortedLinkedList;

use Cambit\SortedLinkedList\Exception\SortedLinkedListException;
use Cambit\SortedLinkedList\Exception\SortedLinkedListRemoveException;
use Cambit\SortedLinkedList\Sort\LinkedListSorterInterface;

class SortedLinkedList
{
    const OUTPUT_SEPARATOR = ' -> ';

    private ?Node $head = null;

    public function __construct(
        private readonly ?LinkedListSorterInterface $sorter = null
    ) {}

    public function add(int|string $item): self
    {
        $head = $this->head;
        if ($head === null) {
            $this->head = new Node($item);

            return $this;
        }

        $this->validate($item, $head);

        if ($this->compare($item, $head->data) < 0) {
            $this->head = new Node($item, $head);

            return $this;
        }

        $tmp = $head;
        while ($tmp->next !== null && ($this->compare($tmp->next->data, $item) < 0)) {
            $tmp = $tmp->next;
        }
        $tmp->next = new Node($item, $tmp->next);

        return $this;
    }

    private function validate(int|string $item, Node $head): void
    {
        if(gettype($item) !== gettype($head->data)) {
            throw new SortedLinkedListException('Sorted link list are able to hold string or int values, but not both at the same time.');
        }
    }

    private function compare(int|string $itemL, int|string $itemR): int
    {
        if ($this->sorter !== null) {
            return $this->sorter->compare($itemL, $itemR);
        }

        return $itemL <=> $itemR;
    }

    public function __toString(): string
    {
        if ($this->head === null) {
            return "\n [Sorted linked list empty]";
        }

        $tmp = $this->head;
        $result = sprintf("\nSorted linked list of type %s\n", gettype($this->head->data));
        while ($tmp !== null) {
            $result .= $tmp->data . self::OUTPUT_SEPARATOR;
            $tmp = $tmp->next;
        }

        return trim($result, self::OUTPUT_SEPARATOR);
    }

    public function getHead(): ?Node
    {
        return $this->head;
    }

    private function skipFromNode(int|string $item, Node $node, ?int $thresholdException = null): ?Node
    {
        $removingCount = 0;
        while ($this->compare($node->data, $item) === 0) {
            $removingCount++;
            if ($node->next === null) {
                $node = null;
                break;
            }
            $node = $node->next;
        }
        if ($thresholdException !== null && $removingCount > $thresholdException) {
            throw new SortedLinkedListRemoveException(sprintf('Removing %d items is above set threshold.', $removingCount));
        }

        return $node;
    }

    public function remove(int|string $item, ?int $thresholdException = null): self
    {
        $head = $this->head;
        if ($head === null) {
            return $this;
        }

        if ($this->compare($head->data, $item) === 0) {
            $this->head = $this->skipFromNode($item, $head, $thresholdException);

            return $this;
        }

        $tmp = $head;
        while ($tmp->next !== null && ($this->compare($tmp->next->data, $item) === -1)) {
            $tmp = $tmp->next;
        }
        if ($tmp->next !== null && $this->compare($tmp->next->data, $item) === 0) {
            $tmp->next = $this->skipFromNode($item, $tmp->next, $thresholdException);
        }

        return $this;
    }
}
