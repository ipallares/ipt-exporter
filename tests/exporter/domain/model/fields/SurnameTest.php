<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\fields;

use App\exporter\domain\model\fields\Surname;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SurnameTest extends TestCase
{
    public function testConstructorValidator(): void
    {
        // Empty string
        $this->expectException(InvalidArgumentException::class);
        new Surname('');

        // String made of empty chars
        $this->expectException(InvalidArgumentException::class);
        new Surname(' ');

        // Invalid chars
        $this->expectException(InvalidArgumentException::class);
        new Surname('#*');

        // Valid
        $surname = new Surname('Mustermann');
        $this->assertEquals('Mustermann', $surname->getSurname());
    }

    public function testExport(): void
    {
        $surname = new Surname('Mustermann');
        $this->assertEquals('<surname>Mustermann</surname>', $surname->export());

    }
}
