<?php

declare(strict_types=1);

namespace Cambit\SortedLinkedList;

class Node
{
    public function __construct(
        public readonly int|string $data,
        public ?Node $next = null
    ) {}
}
