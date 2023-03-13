<?php

namespace Mrsuh\Tree;

interface NodeInterface
{
    /**
     * @return NodeInterface[]
     */
    public function getChildren(): array;

    public function __toString(): string;
}
