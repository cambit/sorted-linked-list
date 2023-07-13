# Sorted linked list 
Sorted linked list with default spaceship compare function. Possible to use custom compare function.

Hold string or int values, but not both!

You can add or remove items.

## Usage

### Default sort function
```php
$sortedLinkedListString = new \Cambit\SortedLinkedList\SortedLinkedList();
echo $sortedLinkedListString;
$sortedLinkedListString->add("3");
$sortedLinkedListString->add("2");
$sortedLinkedListString->add("4");
$sortedLinkedListString->add("aaaa");
$sortedLinkedListString->add("AAAA");
$sortedLinkedListString->add("-400");
echo $sortedLinkedListString;
```

Output:
```
[Sorted linked list empty] 
Sorted linked list of type string -400 -> 2 -> 3 -> 4 -> AAAA -> aaaa
```

### Usage with custom sort function

```php
class customSorter implements \Cambit\SortedLinkedList\Sort\LinkedListSorterInterface
{
    public function compare(int|string $left, int|string $right): int
    {
        return $right <=> $left;
    }
}

$sortedLinkedList = new \Cambit\SortedLinkedList\SortedLinkedList(new customSorter());
echo $sortedLinkedList;
$sortedLinkedList->add(3);
$sortedLinkedList->add(2);
$sortedLinkedList->add(4);
$sortedLinkedList->add(4);
$sortedLinkedList->add(-4);
$sortedLinkedList->add(-400);
echo $sortedLinkedList;
$sortedLinkedList->remove(4);
echo $sortedLinkedList;
```

Output:
```
[Sorted linked list empty] 
Sorted linked list of type integer 4 -> 4 -> 3 -> 2 -> -4 -> -400
Sorted linked list of type integer 3 -> 2 -> -4 -> -400
```


## Contributing

Improvements are welcome! Feel free to submit pull requests.

### Phpstan
```shell
composer phpstan
```

### Phpunit
```shell
composer phpunit
```

### Test coverage
```shell
composer coverage
```

## Licence

MIT

Copyright (c) 2023 Michal Čambor


