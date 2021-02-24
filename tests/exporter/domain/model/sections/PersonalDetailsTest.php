<?php

declare(strict_types=1);

namespace App\Tests\exporter\domain\model\sections;

use App\exporter\domain\model\fields\Email;
use App\exporter\domain\model\fields\Name;
use App\exporter\domain\model\fields\PhoneNumber;
use App\exporter\domain\model\fields\Surname;
use App\exporter\domain\model\sections\PersonalDetails;
use App\Tests\exporter\domain\model\interfaces\MultipleContentLengthExportTestInterface;
use PHPUnit\Framework\TestCase;

class PersonalDetailsTest extends TestCase implements MultipleContentLengthExportTestInterface
{
    public function testCompressedExport(): void
    {
        $expected = '<compressed-personaldetails><name>Max</name><surname>Mustermann</surname></compressed-personaldetails>';

        $name = new Name('Max');
        $surname = new Surname('Mustermann');
        $email = new Email('max@mustermann.com');
        $phoneNumber = new PhoneNumber('555-55-55-55');

        $personalDetails = new PersonalDetails($name, $surname, $email, $phoneNumber);

        $exported = $personalDetails->exportCompressed();

        $this->assertEquals($expected, $exported);
    }

    public function testExtendedExport(): void
    {
        $expected = '<extended-personaldetails><name>Max</name><surname>Mustermann</surname><email>max@mustermann.com</email><phonenumber>555-55-55-55</phonenumber></extended-personaldetails>';

        $name = new Name('Max');
        $surname = new Surname('Mustermann');
        $email = new Email('max@mustermann.com');
        $phoneNumber = new PhoneNumber('555-55-55-55');

        $personalDetails = new PersonalDetails($name, $surname, $email, $phoneNumber);

        $exported = $personalDetails->exportExtended();

        $this->assertEquals($expected, $exported);
    }
}
