<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\fields;

use App\exporter\domain\model\fields\Email;
use PharIo\Manifest\InvalidEmailException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testConstructorValidator(): void
    {
        // Empty string
        $this->expectException(InvalidEmailException::class);
        new Email('');

        // String made of empty chars
        $this->expectException(InvalidEmailException::class);
        new Email(' ');

        // Invalid chars
        $this->expectException(InvalidEmailException::class);
        new Email('#*');

        // Invalid format
        $this->expectException(InvalidEmailException::class);
        new Email('max@muster@mann.com');

        // Valid
        $email = new Email('max@mustermann.com');
        $this->assertEquals('max@mustermann.com', $email->getEmail());
    }

    public function testExport(): void
    {
        $email = new Email('max@mustermann.com');
        $this->assertEquals('<email>max@mustermann.com</email>', $email->export());
    }
}
