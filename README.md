# Tree printer

![](https://github.com/mrsuh/tree-printer/actions/workflows/tests.yml/badge.svg)
![](https://img.shields.io/github/license/mrsuh/tree-printer.svg)
![](https://img.shields.io/github/v/release/mrsuh/tree-printer)


## Installation
```php
composer require mrsuh/tree-printer
```

## Usage
```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Mrsuh\Tree\NodeInterface;
use Mrsuh\Tree\Printer;

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

$tree = new Node('/etc', [
    new Node('adduser.conf'),
    new Node('apt', [
        new Node('apt.conf.d', [
            new Node('01autoremove'),
            new Node('70debconf')
        ]),
        new Node('auth.conf.d'),
        new Node('preferences.d'),
        new Node('trusted.gpg.d', [
            new Node('debian-archive-bullseye-automatic.gpg'),
            new Node('debian-archive-bullseye-security-automatic.gpg'),
            new Node('debian-archive-bullseye-stable.gpg'),
        ]),
    ]),
    new Node('bash.bashrc'),
    new Node('cron.d', [
        new Node('e2scrub_all'),
    ]),
    new Node('cron.daily', [
        new Node('apt-compat'),
        new Node('dpkg'),
    ])
]);

$printer = new Printer();
$printer->print($ast);
```

```bash
.
├── /etc
    ├── adduser.conf
    ├── apt
    │   ├── apt.conf.d
    │   │   ├── 01autoremove
    │   │   └── 70debconf
    │   ├── auth.conf.d
    │   ├── preferences.d
    │   └── trusted.gpg.d
    │       ├── debian-archive-bullseye-automatic.gpg
    │       ├── debian-archive-bullseye-security-automatic.gpg
    │       └── debian-archive-bullseye-stable.gpg
    ├── bash.bashrc
    ├── cron.d
    │   └── e2scrub_all
    └── cron.daily
        ├── apt-compat
        └── dpkg
```
