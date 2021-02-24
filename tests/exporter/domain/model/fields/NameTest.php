<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\fields;

use App\exporter\domain\model\fields\Name;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testConstructorValidator(): void
    {
        // Empty string
        $this->expectException(InvalidArgumentException::class);
        new Name('');

        // String made of empty chars
        $this->expectException(InvalidArgumentException::class);
        new Name(' ');

        // Invalid chars
        $this->expectException(InvalidArgumentException::class);
        new Name('#*');

        // Valid
        $name = new Name('Max');
        $this->assertEquals('Max', $name->getName());
    }

    public function testExport(): void
    {
        $name = new Name('Max');
        $this->assertEquals('<name>Max</name>', $name->export());

    }
}
