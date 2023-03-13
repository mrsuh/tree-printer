<?php declare(strict_types=1);

namespace Tests;

use Mrsuh\Tree\Printer;
use PHPUnit\Framework\TestCase;

class PrinterTest extends TestCase
{

    public function test(): void
    {
        $ast = new Node('/etc', [
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

        $resource = fopen('php://memory', 'w+');

        $printer = new Printer($resource);
        $printer->print($ast);

        fseek($resource, 0);
        $output = stream_get_contents($resource);
        $this->assertIsString($output);

        $this->assertEquals(
".
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
",
            $output
        );
    }
}
