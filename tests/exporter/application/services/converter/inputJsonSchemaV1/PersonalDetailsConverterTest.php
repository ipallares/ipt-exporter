<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\converter\inputJsonSchemaV1;

use App\exporter\application\services\converter\inputJsonSchemaV1\jsonToCvPartConverters\PersonalDetailsConverter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonalDetailsConverterTest extends KernelTestCase
{
    private PersonalDetailsConverter $converter;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->converter = self::$kernel->getContainer()->get(PersonalDetailsConverter::class);
    }

    public function testConversion(): void
    {
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $jsonObject = json_decode($inputJson);
        $personalDetails = $this->converter->convert($jsonObject);
        $this->assertEquals('Max', $personalDetails->getName());
        $this->assertEquals('Mustermann', $personalDetails->getSurname());
        $this->assertEquals('max@mustermann.com', $personalDetails->getEmail());
        $this->assertEquals('555-55-55-55', $personalDetails->getPhoneNumber());
    }
}
