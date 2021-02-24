<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\fields;

use App\exporter\domain\model\fields\PhoneNumber;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    public function testConstructorValidator(): void
    {
        // Empty string
        $this->expectException(InvalidArgumentException::class);
        new PhoneNumber('');

        // Valid
        $phoneNumber = new PhoneNumber('555-55-55-55');
        $this->assertEquals('555-55-55-55', $phoneNumber->getPhoneNumber());
    }

    public function testExport(): void
    {
        $phoneNumber = new PhoneNumber('555-55-55-55');
        $this->assertEquals('<phonenumber>555-55-55-55</phonenumber>', $phoneNumber->export());
    }
}
