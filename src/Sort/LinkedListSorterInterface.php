<?php

declare(strict_types=1);

namespace Cambit\SortedLinkedList\Sort;

interface LinkedListSorterInterface
{
    public function compare(int|string $itemL, int|string $itemR): int;
}
