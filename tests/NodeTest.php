<?php

declare(strict_types=1);

namespace Tests;

use Cambit\SortedLinkedList\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function testGetData(): void
    {
        $node = new Node(1);
        $this->assertSame(1, $node->data);
    }

    public function testGetNext(): void
    {
        $node = new Node(1);
        $this->assertNull($node->next);

        $node = new Node(1, new Node(2));
        $this->assertInstanceOf(Node::class, $node->next);
        $this->assertSame(2, $node->next->data);
    }
}
