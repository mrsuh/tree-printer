<?php

namespace Mrsuh\Tree;

class Printer
{
    protected string $linePrefixEmpty = '    ';
    protected string $linePrefix      = '│   ';
    protected string $textPrefix      = '├── ';
    protected string $textPrefixEnd   = '└── ';

    private $stream;

    public function __construct($stream = STDOUT)
    {
        if (!is_resource($stream)) {
            throw new \RuntimeException('Invalid stream type');
        }

        $this->stream = $stream;
    }

    public function print(NodeInterface $node, array $stack = [], bool $lastChild = false): void
    {
        $line = '';
        if (count($stack) === 0) {
            $line .= sprintf(".%s%s", PHP_EOL, $this->textPrefix);
        }

        if (count($stack) > 0) {
            $line .= $this->linePrefixEmpty;
            foreach ($stack as $index => $val) {
                $lastStackKey = array_key_last($stack);
                if ($lastStackKey === $index) {
                    if ($lastChild) {
                        $line                 .= $this->textPrefixEnd;
                        $stack[$lastStackKey] = false;
                    } else {
                        $line .= $this->textPrefix;
                    }
                    break;
                }

                $line .= $val ? $this->linePrefix : $this->linePrefixEmpty;
            }
        }

        $line .= $node->__toString();
        $line .= PHP_EOL;
        fputs($this->stream, $line);

        $children = $node->getChildren();
        $stack[]  = count($children) > 1;
        foreach ($children as $index => $child) {
            $this->print($child, $stack, $index === array_key_last($children));
        }
    }
}
