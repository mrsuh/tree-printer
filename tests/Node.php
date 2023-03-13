<?php

namespace Tests;

use Mrsuh\Tree\NodeInterface;

class Node implements NodeInterface
{
    private string $name;
    private array  $children;

    public function __construct(string $name, array $children = [])
    {
        $this->name     = $name;
        $this->children = $children;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
