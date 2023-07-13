<?php

declare(strict_types=1);

namespace Tests;

use Cambit\SortedLinkedList\Exception\SortedLinkedListException;
use Cambit\SortedLinkedList\Exception\SortedLinkedListRemoveException;
use Cambit\SortedLinkedList\Node;
use Cambit\SortedLinkedList\Sort\LinkedListSorterInterface;
use Cambit\SortedLinkedList\SortedLinkedList;
use PHPUnit\Framework\TestCase;

class customSorter implements LinkedListSorterInterface
{
    public function compare(int|string $itemL, int|string $itemR): int
    {
        return $itemR <=> $itemL;
    }
}

class SortedLinkedListTest extends TestCase
{

    public function testEmpty(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $this->assertNull($sortedLinkedList->getHead());
        $this->assertSame("\n [Sorted linked list empty]", (string)$sortedLinkedList);
    }

    public function testAdd(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(1);
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(3);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);

        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame("\nSorted linked list of type integer\n1 -> 2 -> 3", (string)$sortedLinkedList);
    }

    public function testValid(): void
    {
        $this->expectException(SortedLinkedListException::class);
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(1);
        $sortedLinkedList->add("2");
    }

    public function testSortInt(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(3);
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(0);
        $sortedLinkedList->add(1);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);

        $this->assertSame(0, $sortedLinkedList->getHead()->data);
        $this->assertSame(1, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->next->next->data);
    }

    public function testSortString(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add("3");
        $sortedLinkedList->add("2");
        $sortedLinkedList->add("0");
        $sortedLinkedList->add("1");

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);

        $this->assertSame("0", $sortedLinkedList->getHead()->data);
        $this->assertSame("1", $sortedLinkedList->getHead()->next->data);
        $this->assertSame("2", $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame("3", $sortedLinkedList->getHead()->next->next->next->data);
    }

    public function testCustomSortInt(): void
    {
        $sortedLinkedList = new SortedLinkedList(new customSorter());
        $sortedLinkedList->add(3);
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(0);
        $sortedLinkedList->add(1);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);

        $this->assertSame(3, $sortedLinkedList->getHead()->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(1, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(0, $sortedLinkedList->getHead()->next->next->next->data);
    }

    public function testRemoveFromMiddle(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(5);
        $sortedLinkedList->add(4);
        $sortedLinkedList->add(1);
        $sortedLinkedList->add(3);
        $sortedLinkedList->add(5);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next->next->next);

        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(4, $sortedLinkedList->getHead()->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->next->data);

        $sortedLinkedList->remove(2);

        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(4, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->data);
        $this->assertNull($sortedLinkedList->getHead()->next->next->next->next->next);

        $this->assertSame("\nSorted linked list of type integer\n1 -> 3 -> 4 -> 5 -> 5", (string)$sortedLinkedList);
    }

    public function testRemoveFromHead(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(5);
        $sortedLinkedList->add(4);
        $sortedLinkedList->add(1);
        $sortedLinkedList->add(3);
        $sortedLinkedList->add(5);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next->next->next);

        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(4, $sortedLinkedList->getHead()->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->next->data);

        $sortedLinkedList->remove(1);

        $this->assertSame(2, $sortedLinkedList->getHead()->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(4, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->data);
        $this->assertNull($sortedLinkedList->getHead()->next->next->next->next->next);

        $this->assertSame("\nSorted linked list of type integer\n2 -> 3 -> 4 -> 5 -> 5", (string)$sortedLinkedList);
    }

    public function testRemoveMultipleFromEnd(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(5);
        $sortedLinkedList->add(4);
        $sortedLinkedList->add(1);
        $sortedLinkedList->add(3);
        $sortedLinkedList->add(5);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next->next->next);

        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(4, $sortedLinkedList->getHead()->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->next->data);

        $sortedLinkedList->remove(5);

        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(4, $sortedLinkedList->getHead()->next->next->next->data);
        $this->assertNull($sortedLinkedList->getHead()->next->next->next->next);

        $this->assertSame("\nSorted linked list of type integer\n1 -> 2 -> 3 -> 4", (string)$sortedLinkedList);
    }

    public function testRemoveMultipleFromEndException(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(5);
        $sortedLinkedList->add(4);
        $sortedLinkedList->add(1);
        $sortedLinkedList->add(3);
        $sortedLinkedList->add(5);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next->next->next);

        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(3, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(4, $sortedLinkedList->getHead()->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->data);
        $this->assertSame(5, $sortedLinkedList->getHead()->next->next->next->next->next->data);

        $this->expectException(SortedLinkedListRemoveException::class);
        $sortedLinkedList->remove(5, 1);
    }

    public function testRemoveFromEmpty(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $this->assertNull($sortedLinkedList->getHead());
        $this->assertSame("\n [Sorted linked list empty]", (string)$sortedLinkedList);
        $sortedLinkedList->remove(2);
        $this->assertNull($sortedLinkedList->getHead());
        $this->assertSame("\n [Sorted linked list empty]", (string)$sortedLinkedList);
    }

    public function testRemoveFromHeadToEmpty(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(1);
        $sortedLinkedList->add(1);
        $sortedLinkedList->add(1);
        $sortedLinkedList->add(1);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);


        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(1, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(1, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(1, $sortedLinkedList->getHead()->next->next->next->data);


        $sortedLinkedList->remove(1);

        $this->assertNull($sortedLinkedList->getHead());
        $this->assertSame("\n [Sorted linked list empty]", (string)$sortedLinkedList);
    }

    public function testRemoveWholeEnd(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(2);
        $sortedLinkedList->add(1);

        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead());
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next);
        $this->assertInstanceOf(Node::class, $sortedLinkedList->getHead()->next->next->next);


        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->next->data);
        $this->assertSame(2, $sortedLinkedList->getHead()->next->next->next->data);


        $sortedLinkedList->remove(2);

        $this->assertSame(1, $sortedLinkedList->getHead()->data);
        $this->assertNull($sortedLinkedList->getHead()->next);

        $this->assertSame("\nSorted linked list of type integer\n1", (string)$sortedLinkedList);
    }
}
